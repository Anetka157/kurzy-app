<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::withCount(['activeEnrollments'])
            ->filter($request->only(['date_from', 'date_to', 'only_available']))
            ->orderBy('starts_at')
            ->get();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:courses,code'],
            'capacity' => ['required', 'integer', 'min:1'],
            'starts_at' => ['required', 'date'],
        ]);

        $course = Course::create($validated);

        return redirect()->route('courses.show', $course)->with('success', 'Kurz vytvořen.');
    }

    public function show(Course $course)
    {
        $course->load(['enrollments.participant']);
        $participants = Participant::orderBy('name')->get();

        return view('courses.show', compact('course', 'participants'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', Rule::unique('courses', 'code')->ignore($course->id)],
            'capacity' => ['required', 'integer', 'min:' . max(1, $course->occupied_seats)],
            'starts_at' => ['required', 'date'],
        ]);

        $course->update($validated);

        return redirect()->route('courses.show', $course)->with('success', 'Kurz upraven.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Kurz smazán.');
    }
}
