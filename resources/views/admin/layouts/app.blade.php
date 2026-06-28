<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - SI-PPDB SD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
    @stack('head')
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

    <nav class="bg-slate-800 text-white px-6 py-4 shadow-md flex justify-between items-center">
        <h1 class="text-lg font-bold">SI-PPDB SD &mdash; Admin</h1>
        <div class="flex items-center gap-5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'text-white font-semibold border-b-2 border-white pb-0.5' : 'text-slate-300 hover:text-white' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.peserta.index') }}"
               class="{{ request()->routeIs('admin.peserta.*') ? 'text-white font-semibold border-b-2 border-white pb-0.5' : 'text-slate-300 hover:text-white' }}">
                Peserta
            </a>
            <span class="text-slate-500">|</span>
            <span class="text-slate-300">{{ Auth::guard('admin')->user()->nama }}</span>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-lg transition text-xs font-semibold">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-6">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
