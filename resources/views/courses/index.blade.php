@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Nabídka kurzů</h2>
        <a href="{{ route('courses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition">+ Vytvořit kurz</a>
    </div>

    <!-- Filtr -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 mb-6">
        <form method="GET" action="{{ route('courses.index') }}" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase mb-1">Od termínu</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase mb-1">Do termínu</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>
            <div class="flex items-center h-10">
                <label class="flex items-center space-x-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                    <input type="checkbox" name="only_available" value="1" @checked(request('only_available')) class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                    <span>Pouze s volnými místy</span>
                </label>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Filtrovat</button>
                <a href="{{ route('courses.index') }}" class="text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 text-sm font-medium px-2 py-2">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabulka -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                <th class="px-6 py-3">Kód</th>
                <th class="px-6 py-3">Název</th>
                <th class="px-6 py-3">Začátek</th>
                <th class="px-6 py-3">Obsazenost</th>
                <th class="px-6 py-3 text-right">Akce</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm">
            @forelse($courses as $course)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                    <td class="px-6 py-4 font-mono text-slate-500 dark:text-slate-400 font-semibold">{{ $course->code }}</td>
                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">
                        <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $course->name }}</a>
                    </td>
                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $course->starts_at->format('d. m. Y H:i') }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course->free_seats > 0 ? 'bg-emerald-100 dark:bg-emerald-950/50 text-emerald-800 dark:text-emerald-300' : 'bg-rose-100 dark:bg-rose-950/50 text-rose-800 dark:text-rose-300' }}">
                            {{ $core->active_enrollments_count ?? $course->active_enrollments_count }} / {{ $course->capacity }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Detail</a>
                        <a href="{{ route('courses.edit', $course) }}" class="text-slate-600 dark:text-slate-400 hover:underline font-medium">Upravit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">Zatím nebyly vytvořeny žádné kurzy.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
