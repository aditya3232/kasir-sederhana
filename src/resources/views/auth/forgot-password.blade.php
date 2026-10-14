<x-guest-layout>
    @section('title', 'Lupa Kata Sandi')

    <div class="mb-6">
        <h1 class="text-xl font-bold tracking-tight text-slate-900">Lupa Kata Sandi?</h1>
        <p class="mt-1 text-sm text-slate-500">
            Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                Alamat Email <span class="text-red-500">*</span>
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                placeholder="kasir@toko.com"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('email') ? 'border-red-500' : '' }}">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-indigo-600/30 transition duration-150 hover:bg-indigo-700 active:scale-[0.99] focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                <span>Kirim Tautan Reset</span>
            </button>
        </div>

        <div class="pt-2 text-center text-xs text-slate-500">
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline">
                &larr; Kembali ke halaman Masuk
            </a>
        </div>
    </form>
</x-guest-layout>
