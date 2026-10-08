@extends('layouts.app')

@section('content')
    <div class="w-full max-w-2xl mx-auto px-4 py-8 text-left">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('product.show', $product->id) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                &larr; Kembali ke detail produk
            </a>
            <h1 class="mt-2 text-2xl font-bold text-gray-800">Edit Produk</h1>
            <p class="text-sm text-gray-500">
                Ubah data produk <span class="font-medium text-gray-700">{{ $product->name }}</span>.
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('product.update', $product->id) }}" method="POST"
            class="bg-white shadow-sm rounded-xl border border-gray-200 p-6 space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                    placeholder="Contoh: Kopi Arabika 250g"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                           {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kode --}}
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                    Kode Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" id="code" name="code" value="{{ old('code', $product->code) }}"
                    placeholder="Contoh: PRD-001"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                           {{ $errors->has('code') ? 'border-red-500' : 'border-gray-300' }}">
                <p class="mt-1 text-xs text-gray-400">Kode harus unik, tidak boleh sama dengan produk lain.</p>
                @error('code')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="category_id" name="category_id"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                           {{ $errors->has('category_id') ? 'border-red-500' : 'border-gray-300' }}">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Harga & Stok --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">Rp</span>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                            min="0" placeholder="0"
                            class="w-full rounded-lg border pl-10 pr-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                   {{ $errors->has('price') ? 'border-red-500' : 'border-gray-300' }}">
                    </div>
                    @error('price')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                        min="0"
                        class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                               {{ $errors->has('stock') ? 'border-red-500' : 'border-gray-300' }}">
                    @error('stock')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi
                </label>
                <textarea id="description" name="description" rows="4" placeholder="Deskripsi singkat produk (opsional)"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                           {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }}">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Catatan --}}
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700 mb-1">
                    Catatan Internal
                </label>
                <textarea id="note" name="note" rows="3" placeholder="Catatan untuk internal (opsional)"
                    class="w-full rounded-lg border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                           {{ $errors->has('note') ? 'border-red-500' : 'border-gray-300' }}">{{ old('note', $product->note) }}</textarea>
                @error('note')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Aktif --}}
            <div class="flex items-start gap-3">
                {{-- Hidden input agar nilai 0 tetap terkirim saat checkbox tidak dicentang --}}
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <div>
                    <label for="is_active" class="text-sm font-medium text-gray-700">Produk Aktif</label>
                    <p class="text-xs text-gray-400">Produk nonaktif tidak akan ditampilkan atau dijual.</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('product.show', $product->id) }}"
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
