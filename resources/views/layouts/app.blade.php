<!doctype html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title ?? (config('app.name') ?? 'TaxiYa') }}
    </title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @php
        $hasViteBuild = file_exists(public_path('build/manifest.json'));
    @endphp

    @if ($hasViteBuild)
        {{-- Vite build (prod) --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Dev / No-Vite fallback (works immediately) --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                        colors: {
                            brand: {
                                50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',
                                400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',
                                800:'#3730a3',900:'#312e81'
                            }
                        }
                    }
                }
            }
        </script>

        {{-- Your custom styles/scripts from public/ --}}
        <link rel="stylesheet" href="{{ asset('css/taxiya.css') }}">
        <script defer src="{{ asset('js/taxiya.js') }}"></script>
    @endif

    {{-- Optional libs used by template (safe to include) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">

    {{-- Navbar --}}
    <x-navbar />

    {{-- Flash messages (optional component) --}}
    @if (view()->exists('components.flash'))
        <x-flash />
    @endif

    {{-- Main content --}}
    <main class="mx-auto w-full max-w-7xl px-4 pb-16 pt-6 sm:px-6 lg:px-8">
        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Lucide icons init --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide && window.lucide.createIcons) {
                window.lucide.createIcons();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
