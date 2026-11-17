<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_creation_and_persistence(): void
    {
        $response = $this->post(route('courses.store'), [
            'name' => 'Laravel kurz',
            'code' => 'LAR-101',
            'capacity' => 5,
            'starts_at' => '2026-12-01 10:00:00',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('courses', ['code' => 'LAR-101']);
    }

    public function test_capacity_and_duplicates(): void
    {
        $course = Course::create(['name' => 'Test', 'code' => 'T1', 'capacity' => 1, 'starts_at' => now()->addDay()]);
        $p1 = Participant::create(['name' => 'Jan', 'email' => 'jan@test.cz']);
        $p2 = Participant::create(['name' => 'Petr', 'email' => 'petr@test.cz']);

        // Úspěšné přihlášení
        $this->post(route('courses.enroll', $course), ['participant_id' => $p1->id])->assertRedirect();

        // Duplicita neprojde
        $this->post(route('courses.enroll', $course), ['participant_id' => $p1->id])->assertSessionHasErrors();

        // Překročení kapacity neprojde
        $this->post(route('courses.enroll', $course), ['participant_id' => $p2->id])->assertSessionHasErrors();
    }
}
