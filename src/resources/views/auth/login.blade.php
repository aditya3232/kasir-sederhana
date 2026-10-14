<x-guest-layout>
    @section('title', 'Masuk')

    <div class="mb-6">
        <h1 class="text-xl font-bold tracking-tight text-slate-900">Masuk ke Sistem</h1>
        <p class="mt-1 text-sm text-slate-500">Silakan masukkan akun kasir Anda untuk memulai transaksi.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                Alamat Email <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username" placeholder="kasir@toko.com"
                    class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '' }}">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-slate-700">
                    Kata Sandi <span class="text-red-500">*</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-xs font-medium text-indigo-600 hover:text-indigo-500 hover:underline">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>

            <div class="relative">
                <input id="password" :type="show ? 'text' : 'password'" name="password" required
                    autocomplete="current-password" placeholder="••••••••"
                    class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 pr-10 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '' }}">

                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none"
                    title="Tampilkan / Sembunyikan Kata Sandi">
                    <svg x-show="!show" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg x-show="show" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center pt-1">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-4 w-4 rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0">
                <span class="text-sm text-slate-600">Ingat sesi saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-600/30 transition duration-150 hover:bg-indigo-700 active:scale-[0.99] focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                <span>Masuk Sekarang</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </form>

    <!-- Quick Demo Helper -->
    <div class="mt-6 rounded-xl border border-slate-200/80 bg-slate-50/80 p-3.5 text-xs text-slate-500"
        x-data="{
            fillDemo() {
                const emailEl = document.getElementById('email');
                const passEl = document.getElementById('password');
                if (emailEl) emailEl.value = 'test@example.com';
                if (passEl) passEl.value = 'password';
            }
        }">
        <div class="flex items-center justify-between font-medium text-slate-700">
            <span class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                Akun Demo / Uji Coba:
            </span>
            <button type="button" @click="fillDemo()"
                class="font-semibold text-indigo-600 hover:text-indigo-800 underline underline-offset-2">
                Isi Otomatis
            </button>
        </div>
        <p class="mt-1 text-slate-500">Email: <span class="font-mono text-slate-700">test@example.com</span> &bull; Pass: <span class="font-mono text-slate-700">password</span></p>
    </div>

    <!-- Register Link -->
    @if (Route::has('register'))
        <p class="mt-6 text-center text-xs text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline">
                Daftar akun kasir baru
            </a>
        </p>
    @endif
</x-guest-layout>
