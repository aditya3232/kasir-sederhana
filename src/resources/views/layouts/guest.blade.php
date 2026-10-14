<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') ·
        @endif
        {{ config('app.name', 'Kasir Sederhana') }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-full flex-col justify-between bg-slate-50 font-sans text-slate-700 antialiased selection:bg-indigo-500 selection:text-white">
    {{-- Ambient Background Glow --}}
    <div class="pointer-events-none fixed inset-0 -z-10 flex justify-center overflow-hidden">
        <div class="absolute -top-40 h-[500px] w-[700px] rounded-full bg-gradient-to-tr from-indigo-200/40 to-blue-200/20 blur-3xl"></div>
    </div>

    {{-- Main Container --}}
    <div class="flex flex-1 flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        {{-- Brand Header --}}
        <div class="mb-8 flex flex-col items-center text-center">
            <a href="{{ route('login') }}" class="group flex items-center gap-3 transition hover:opacity-90">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 transition group-hover:scale-105">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </span>
                <div class="text-left">
                    <span class="block text-xl font-bold tracking-tight text-slate-900 leading-tight">
                        {{ config('app.name', 'Kasir Sederhana') }}
                    </span>
                    <span class="block text-xs font-medium text-slate-400">
                        Point of Sale & Inventory
                    </span>
                </div>
            </a>
        </div>

        {{-- Auth Card --}}
        <div class="w-full sm:max-w-md">
            <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-xl shadow-slate-900/5 sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} {{ config('app.name', 'Kasir Sederhana') }}. Hak cipta dilindungi.
    </footer>
</body>

</html>
