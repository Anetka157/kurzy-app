<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::withCount('enrollments')->orderBy('name')->get();
        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        return view('participants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:participants,email'],
        ]);

        Participant::create($validated);

        return redirect()->route('participants.index')->with('success', 'Účastník vytvořen.');
    }

    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('participants', 'email')->ignore($participant->id)],
        ]);

        $participant->update($validated);

        return redirect()->route('participants.index')->with('success', 'Účastník upraven.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return redirect()->route('participants.index')->with('success', 'Účastník smazán.');
    }
}
