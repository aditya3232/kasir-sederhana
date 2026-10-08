@extends('layouts.app')

@section('content')
    <div class="w-full max-w-2xl mx-auto px-4 py-8 text-left">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('produk.show', $produk) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                &larr; Kembali ke detail produk
            </a>
            <h1 class="mt-2 text-2xl font-bold text-gray-800">Edit Produk</h1>
            <p class="text-sm text-gray-500">
                Ubah data produk <span class="font-medium text-gray-700">{{ $produk->nama }}</span>.
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('produk.update', $produk) }}" method="POST"
            class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $produk->nama) }}"
                    placeholder="Contoh: Kopi Arabika 250g" class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }}">
                @error('nama')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kode --}}
            <div>
                <label for="kode" class="block text-sm font-medium text-gray-700 mb-1">
                    Kode Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" id="kode" name="kode" value="{{ old('kode', $produk->kode) }}"
                    placeholder="Contoh: PRD-001" class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  {{ $errors->has('kode') ? 'border-red-500' : 'border-gray-300' }}">
                <p class="mt-1 text-xs text-gray-400">Kode harus unik, tidak boleh sama dengan produk lain.</p>
                @error('kode')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga & Stok --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">Rp</span>
                        <input type="number" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" min="0"
                            placeholder="0" class="w-full rounded-lg border pl-10 pr-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                          {{ $errors->has('harga') ? 'border-red-500' : 'border-gray-300' }}">
                    </div>
                    @error('harga')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                      {{ $errors->has('stok') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('stok')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi singkat produk (opsional)"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                     {{ $errors->has('deskripsi') ? 'border-red-500' : 'border-gray-300' }}">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Catatan --}}
            <div>
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">
                    Catatan Internal
                </label>
                <textarea id="catatan" name="catatan" rows="3" placeholder="Catatan untuk internal (opsional)"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                     {{ $errors->has('catatan') ? 'border-red-500' : 'border-gray-300' }}">{{ old('catatan', $produk->catatan) }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Aktif --}}
            <div class="flex items-start gap-3">
                <input type="hidden" name="aktif" value="0">
                <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif', $produk->aktif) ? 'checked' : '' }}
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <div>
                    <label for="aktif" class="text-sm font-medium text-gray-700">Produk Aktif</label>
                    <p class="text-xs text-gray-400">Produk nonaktif tidak akan ditampilkan atau dijual.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('produk.show', $produk) }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection