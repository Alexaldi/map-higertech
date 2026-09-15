<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Higertech Karya Sinergi | Integrated Telemetry Solution')</title>
    <meta name="description" content="@yield('description', 'Platform akuisisi data lapangan real-time untuk pemantauan muka air banjir, curah hujan otomatis, dan stasiun cuaca.')">

    {{-- Prevent flash of wrong theme: apply dark class BEFORE CSS loads --}}
    <script>
        (function() {
            const saved = localStorage.getItem('higertech_theme');
            const sys = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (saved === null && sys)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="@yield('body_class', 'bg-[#F8FAFC] dark:bg-[#0B1120] text-slate-800 dark:text-slate-100') antialiased selection:bg-cyan-500 selection:text-white transition-colors duration-300">

    @include('partials.header')

    @yield('content')

    @stack('scripts')
</body>
</html>
