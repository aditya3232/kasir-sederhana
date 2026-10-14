<x-guest-layout>
    @section('title', 'Daftar Akun Kasir')

    <div class="mb-6">
        <h1 class="text-xl font-bold tracking-tight text-slate-900">Daftar Akun Baru</h1>
        <p class="mt-1 text-sm text-slate-500">Buat akun untuk kasir atau pengelola toko baru.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                autocomplete="name" placeholder="Nama Kasir"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('name') ? 'border-red-500' : '' }}">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                Alamat Email <span class="text-red-500">*</span>
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                autocomplete="username" placeholder="kasir@toko.com"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('email') ? 'border-red-500' : '' }}">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                Kata Sandi <span class="text-red-500">*</span>
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Minimal 8 karakter"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('password') ? 'border-red-500' : '' }}">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">
                Konfirmasi Kata Sandi <span class="text-red-500">*</span>
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="Ulangi kata sandi"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('password_confirmation') ? 'border-red-500' : '' }}">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-600/30 transition duration-150 hover:bg-indigo-700 active:scale-[0.99] focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                <span>Daftar Akun</span>
            </button>
        </div>

        <div class="pt-2 text-center text-xs text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline">
                Masuk di sini
            </a>
        </div>
    </form>
</x-guest-layout>
