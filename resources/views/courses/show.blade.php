@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <a href="{{ route('courses.index') }}" class="text-indigo-600 hover:underline text-sm font-medium">&larr; Zpět na seznam kurzů</a>
    </div>

    <!-- Hlavička detailu -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="inline-block bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-md mb-2 font-mono">{{ $course->code }}</span>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $course->name }}</h2>
            <p class="text-gray-500 mt-1">Termín konání: <span class="font-medium text-gray-700">{{ $course->starts_at->format('d. m. Y H:i') }}</span></p>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center min-w-[140px]">
            <span class="block text-xs text-gray-500 uppercase tracking-wider font-semibold">Obsazenost</span>
            <span class="text-2xl font-bold text-indigo-600">{{ $course->occupied_seats }}</span>
            <span class="text-gray-400 text-sm">/ {{ $course->capacity }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulář pro přihlášení -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 h-fit">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Přihlásit účastníka</h3>
            @if($course->hasFreeCapacity())
                <form method="POST" action="{{ route('courses.enroll', $course) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vybrat účastníka:</label>
                        <select name="participant_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="">-- Vyberte ze seznamu --</option>
                            @foreach($participants as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg transition shadow-sm">Přihlásit do kurzu</button>
                </form>
            @else
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-sm text-center font-medium">
                    Tento kurz je plně obsazen.
                </div>
            @endif
        </div>

        <!-- Seznam přihlášených -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Seznam přihlášených</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="py-3 px-3">Jméno</th>
                        <th class="py-3 px-3">E-mail</th>
                        <th class="py-3 px-3">Přihlášen</th>
                        <th class="py-3 px-3">Stav</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($course->enrollments as $enr)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-3 font-medium text-gray-900">{{ $enr->participant->name }}</td>
                            <td class="py-3 px-3 text-gray-600">{{ $enr->participant->email }}</td>
                            <td class="py-3 px-3 text-gray-500 text-xs">{{ $enr->enrolled_at->format('d. m. Y H:i') }}</td>
                            <td class="py-3 px-3">
                                <form method="POST" action="{{ route('enrollments.updateStatus', $enr) }}">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-2 py-1 text-xs font-medium focus:ring-2 focus:ring-indigo-500 focus:outline-none
                                        @if($enr->status === 'enrolled') bg-green-50 text-green-700 border-green-300
                                        @elseif($enr->status === 'completed') bg-blue-50 text-blue-700 border-blue-300
                                        @else bg-gray-100 text-gray-600 @endif">
                                        @foreach(\App\Models\Enrollment::STATUSES as $st)
                                            <option value="{{ $st }}" @selected($enr->status === $st)>{{ ucfirst($st) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-500">Zatím zde nejsou žádní účastníci.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
