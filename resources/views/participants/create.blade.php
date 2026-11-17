@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('participants.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">&larr; Zpět na seznam účastníků</a>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 md:p-8">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Nový účastník</h2>

            <form method="POST" action="{{ route('participants.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Celé jméno</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="např. Jan Novák">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">E-mailová adresa</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="jan.novak@example.com">
                </div>

                <div class="pt-4 flex items-center justify-end space-x-3">
                    <a href="{{ route('participants.index') }}" class="px-4 py-2.5 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Zrušit</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-lg text-sm transition shadow-sm">Uložit účastníka</button>
                </div>
            </form>
        </div>
    </div>
@endsection
