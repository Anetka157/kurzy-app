@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Seznam účastníků</h2>
        <a href="{{ route('participants.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm transition">+ Nový účastník</a>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                <th class="px-6 py-3">Jméno</th>
                <th class="px-6 py-3">E-mail</th>
                <th class="px-6 py-3">Aktivní kurzy</th>
                <th class="px-6 py-3 text-right">Akce</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm">
            @forelse($participants as $p)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $p->name }}</td>
                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $p->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300">
                            {{ $p->enrollments_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('participants.edit', $p) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Upravit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">Zatím nebyli zaregistrováni žádní účastníci.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
