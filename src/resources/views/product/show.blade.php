@extends('layouts.app')

@section('content')
    <div class="w-full max-w-3xl mx-auto px-4 py-8 text-left">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('produk.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                &larr; Kembali ke daftar produk
            </a>

            <div class="mt-2 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $produk->nama }}</h1>
                        @if ($produk->aktif)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Aktif
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Nonaktif
                            </span>
                        @endif
                    </div>
                    <span class="mt-2 inline-block rounded bg-gray-100 px-2 py-0.5 font-mono text-xs text-gray-700">
                        {{ $produk->kode }}
                    </span>
                </div>

                {{-- Aksi --}}
                <div class="flex items-center gap-2">
                    <a href="{{ route('produk.edit', $produk) }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Edit
                    </a>
                    <form action="{{ route('produk.destroy', $produk) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus produk {{ $produk->nama }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Flash message --}}
        @if (session('success'))
            <div
                class="mb-4 flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Ringkasan: harga & stok --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Harga</p>
                <p class="mt-2 text-2xl font-bold text-gray-800">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Stok</p>
                <div class="mt-2 flex items-center gap-3">
                    <p class="text-2xl font-bold text-gray-800">{{ $produk->stok }}</p>
                    @if ($produk->stok <= 0)
                        <span
                            class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">Habis</span>
                    @elseif ($produk->stok <= 10)
                        <span
                            class="inline-flex rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-700">Stok
                            menipis</span>
                    @else
                        <span
                            class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">Tersedia</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Detail --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Detail Produk</h2>
            </div>

            <dl class="divide-y divide-gray-100 text-sm">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 px-6 py-4">
                    <dt class="font-medium text-gray-500">Nama Produk</dt>
                    <dd class="sm:col-span-2 text-gray-800">{{ $produk->nama }}</dd>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 px-6 py-4">
                    <dt class="font-medium text-gray-500">Kode Produk</dt>
                    <dd class="sm:col-span-2 text-gray-800 font-mono">{{ $produk->kode }}</dd>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 px-6 py-4">
                    <dt class="font-medium text-gray-500">Deskripsi</dt>
                    <dd class="sm:col-span-2 text-gray-800 whitespace-pre-line">
                        {{ $produk->deskripsi ?: '-' }}
                    </dd>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 px-6 py-4">
                    <dt class="font-medium text-gray-500">Catatan Internal</dt>
                    <dd class="sm:col-span-2 text-gray-800 whitespace-pre-line">
                        {{ $produk->catatan ?: '-' }}
                    </dd>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 px-6 py-4">
                    <dt class="font-medium text-gray-500">Dibuat</dt>
                    <dd class="sm:col-span-2 text-gray-800">
                        {{ $produk->created_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                    </dd>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-4 px-6 py-4">
                    <dt class="font-medium text-gray-500">Terakhir Diperbarui</dt>
                    <dd class="sm:col-span-2 text-gray-800">
                        {{ $produk->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
@endsection