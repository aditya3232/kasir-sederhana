@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('category.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                &larr; Kembali ke daftar kategori
            </a>
            <h1 class="mt-2 text-2xl font-bold text-gray-800">Tambah Kategori</h1>
            <p class="text-sm text-gray-500">Isi data kategori baru di bawah ini.</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('category.store') }}" method="POST"
            class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 space-y-6">
            @csrf

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Contoh: Minuman" autofocus
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('category.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
