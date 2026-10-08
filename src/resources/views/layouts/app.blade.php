{{-- resources/views/layouts/app.blade.php --}}
@php
    /*
     * Daftar menu. Sesuaikan nama route di sini saja.
     * Menu otomatis disembunyikan kalau route-nya belum ada,
     * jadi aman dipakai sambil jalan membangun halamannya.
     */
    $navGroups = [
        'Utama' => [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'active' => 'dashboard',
                'icon' =>
                    'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z',
            ],
            [
                'label' => 'Kasir',
                'route' => 'cashier.index',
                'active' => 'cashier.*',
                'icon' =>
                    'M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z',
            ],
        ],
        'Kelola' => [
            [
                'label' => 'Produk',
                'route' => 'product.index',
                'active' => 'product.*',
                'icon' => 'm21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9',
            ],
            [
                'label' => 'Kategori',
                'route' => 'category.index',
                'active' => 'category.*',
                'icon' =>
                    'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z M6 6h.008v.008H6V6Z',
            ],
        ],
        'Laporan' => [
            [
                'label' => 'Transaksi',
                'route' => 'transaction.index',
                'active' => 'transaction.*',
                'icon' =>
                    'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z',
            ],
        ],
    ];

    // Hanya tampilkan menu yang route-nya sudah terdaftar
    $navGroups = collect($navGroups)
        ->map(fn($items) => collect($items)->filter(fn($i) => Route::has($i['route']))->values())
        ->filter(fn($items) => $items->isNotEmpty());

    $currentItem = $navGroups->flatten(1)->first(fn($i) => request()->routeIs($i['active']));
    $pageTitle = $currentItem['label'] ?? config('app.name');
    $user = Auth::user();
    $initials = collect(explode(' ', $user->name ?? 'U'))
        ->take(2)
        ->map(fn($w) => mb_substr($w, 0, 1))
        ->implode('');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title')@else{{ $pageTitle }}
        @endif · {{ config('app.name', 'Kasir') }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="h-full bg-slate-50 font-sans text-slate-700 antialiased" x-data="{
    sidebar: false,
    collapsed: localStorage.getItem('sidebar-collapsed') === '1',
    toggle() {
        if (window.matchMedia('(min-width: 1024px)').matches) {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebar-collapsed', this.collapsed ? '1' : '0');
        } else {
            this.sidebar = !this.sidebar;
        }
    }
}"
    @keydown.escape.window="sidebar = false">

    {{-- Overlay (mobile) --}}
    <div x-show="sidebar" x-cloak x-transition.opacity @click="sidebar = false"
        class="fixed inset-0 z-30 bg-slate-900/40 lg:hidden"></div>

    {{-- Sidebar --}}
    <aside
        :class="[sidebar ? 'translate-x-0' : '-translate-x-full', collapsed ? 'lg:-translate-x-full' : 'lg:translate-x-0']"
        class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col border-r border-slate-200 bg-white transition-transform duration-200">

        {{-- Brand --}}
        <div class="flex h-16 shrink-0 items-center px-6">
            <a href="{{ Route::has('dashboard') ? route('dashboard') : url('/') }}" class="flex items-center gap-3">
                <span
                    class="grid h-9 w-9 place-items-center rounded-xl bg-indigo-600 text-white shadow-sm shadow-indigo-600/30">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </span>
                <span class="text-base font-bold tracking-tight text-slate-900">{{ config('app.name', 'Kasir') }}</span>
            </a>
        </div>

        {{-- Navigasi --}}
        <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-4" aria-label="Navigasi utama">
            @foreach ($navGroups as $group => $items)
                <div>
                    <p class="px-3 pb-2 text-xs font-semibold text-slate-400">{{ $group }}</p>
                    <ul class="space-y-1">
                        @foreach ($items as $item)
                            @php $active = request()->routeIs($item['active']); @endphp
                            <li>
                                <a href="{{ route($item['route']) }}"
                                    @if ($active) aria-current="page" @endif
                                    class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500
                                          {{ $active ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                    <svg class="h-5 w-5 shrink-0 {{ $active ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-600' }}"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                    </svg>
                                    {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </nav>

        {{-- Profil di bawah sidebar --}}
        <div class="shrink-0 border-t border-slate-200 p-3">
            <div class="flex items-center gap-3 rounded-lg px-2 py-2">
                <span
                    class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-indigo-100 text-sm font-semibold uppercase text-indigo-700">{{ $initials }}</span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-900">{{ $user->name ?? 'Pengguna' }}</p>
                    <p class="truncate text-xs text-slate-500">{{ $user->email ?? '' }}</p>
                </div>
                @if (Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Keluar" aria-label="Keluar"
                            class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </aside>

    {{-- Area konten --}}
    <div class="flex min-h-full flex-col transition-[padding] duration-200" :class="collapsed ? 'lg:pl-0' : 'lg:pl-64'">

        {{-- Topbar --}}
        <header
            class="sticky top-0 z-20 flex h-16 shrink-0 items-center gap-4 border-b border-slate-200 bg-white/80 px-4 backdrop-blur sm:px-6 lg:px-8">
            <button type="button" @click="toggle()"
                class="-ml-1 rounded-lg p-2 text-slate-500 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                aria-label="Tampilkan atau sembunyikan menu" title="Tampilkan atau sembunyikan menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
            </button>

            <div class="min-w-0 flex-1">
                @hasSection('header')
                    @yield('header')
                @else
                    <h1 class="truncate text-sm font-semibold text-slate-900">
                        @hasSection('title')
                            @yield('title')@else{{ $pageTitle }}
                        @endif
                    </h1>
                @endif
            </div>

            <time class="hidden text-sm text-slate-500 sm:block" datetime="{{ now()->toDateString() }}">
                {{ now()->translatedFormat('l, d F Y') }}
            </time>

            {{-- Dropdown akun --}}
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
                <button type="button" @click="open = !open" :aria-expanded="open"
                    class="flex items-center gap-2 rounded-full p-1 pr-2 transition hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                    <span
                        class="grid h-8 w-8 place-items-center rounded-full bg-indigo-100 text-xs font-semibold uppercase text-indigo-700">{{ $initials }}</span>
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-56 origin-top-right overflow-hidden rounded-xl border border-slate-200 bg-white py-1 shadow-lg shadow-slate-900/5">
                    <div class="border-b border-slate-100 px-4 py-3">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $user->name ?? 'Pengguna' }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $user->email ?? '' }}</p>
                    </div>
                    @if (Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">Profil
                            saya</a>
                    @endif
                    @if (Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    @endif
                </div>
            </div>
        </header>

        {{-- Konten halaman --}}
        <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                @yield('content')
            </div>
        </main>

        <footer class="px-4 py-4 text-center text-xs text-slate-400 sm:px-6 lg:px-8">
            &copy; {{ date('Y') }} {{ config('app.name', 'Kasir') }}
        </footer>
    </div>

    {{-- Toast notifikasi (session flash) --}}
    @if (session('success') || session('error'))
        @php $isError = session()->has('error'); @endphp
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-cloak
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2" role="status"
            class="fixed bottom-6 right-6 z-50 flex max-w-sm items-start gap-3 rounded-xl border bg-white p-4 shadow-lg shadow-slate-900/10
                    {{ $isError ? 'border-red-200' : 'border-emerald-200' }}">
            <span
                class="mt-0.5 grid h-5 w-5 shrink-0 place-items-center rounded-full text-white {{ $isError ? 'bg-red-500' : 'bg-emerald-500' }}">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="{{ $isError ? 'M6 18 18 6M6 6l12 12' : 'm4.5 12.75 6 6 9-13.5' }}" />
                </svg>
            </span>
            <p class="text-sm text-slate-700">{{ session('success') ?? session('error') }}</p>
            <button type="button" @click="show = false" class="-mr-1 text-slate-400 hover:text-slate-600"
                aria-label="Tutup">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @stack('scripts')
</body>

</html>
