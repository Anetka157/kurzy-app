<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurzy App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'media',
        }
    </script>
</head>
<body class="bg-slate-100 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-sans antialiased min-h-screen flex flex-col transition-colors">
<!-- Horní lišta -->
<header class="bg-white dark:bg-slate-900 shadow-sm border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
            🎓 Kurzy App
        </h1>
        <nav class="space-x-6">
            <a href="{{ route('courses.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition">Kurzy</a>
            <a href="{{ route('participants.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition">Účastníci</a>
        </nav>
    </div>
</header>

<!-- Hlavní obsah -->
<main class="max-w-7xl mx-auto px-6 py-8 flex-grow w-full">
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/50 border-l-4 border-emerald-400 text-emerald-800 dark:text-emerald-200 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/50 border-l-4 border-rose-400 text-rose-800 dark:text-rose-200 rounded-lg shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<!-- Patička -->
<footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-4 text-center text-sm text-slate-500">
    Laravel Aplikace &copy; {{ date('Y') }}
</footer>
</body>
</html>
