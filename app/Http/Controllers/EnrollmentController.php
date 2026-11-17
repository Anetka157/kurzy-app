<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EnrollmentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'participant_id' => ['required', 'exists:participants,id'],
        ]);

        DB::transaction(function () use ($course, $validated) {
            $lockedCourse = Course::where('id', $course->id)->lockForUpdate()->firstOrFail();

            $existing = Enrollment::where('course_id', $lockedCourse->id)
                ->where('participant_id', $validated['participant_id'])
                ->first();

            if ($existing) {
                throw ValidationException::withMessages([
                    'participant_id' => 'Účastník již v kurzu figuruje (stav: ' . $existing->status . ').',
                ]);
            }

            if (!$lockedCourse->hasFreeCapacity()) {
                throw ValidationException::withMessages([
                    'participant_id' => 'Kapacita kurzu je plná.',
                ]);
            }

            Enrollment::create([
                'course_id' => $lockedCourse->id,
                'participant_id' => $validated['participant_id'],
                'enrolled_at' => now(),
                'status' => Enrollment::STATUS_ENROLLED,
            ]);
        });

        return redirect()->route('courses.show', $course)->with('success', 'Účastník přihlášen.');
    }

    public function updateStatus(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(Enrollment::STATUSES)],
        ]);

        DB::transaction(function () use ($enrollment, $validated) {
            $lockedCourse = Course::where('id', $enrollment->course_id)->lockForUpdate()->firstOrFail();

            $isReactivating = $enrollment->status === Enrollment::STATUS_CANCELLED
                && in_array($validated['status'], [Enrollment::STATUS_ENROLLED, Enrollment::STATUS_COMPLETED], true);

            if ($isReactivating && !$lockedCourse->hasFreeCapacity()) {
                throw ValidationException::withMessages([
                    'status' => 'Nelze aktivovat – kurz je plný.',
                ]);
            }

            $enrollment->update(['status' => $validated['status']]);
        });

        return back()->with('success', 'Stav aktualizován.');
    }
}
