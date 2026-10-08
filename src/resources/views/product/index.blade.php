@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>
                <p class="text-sm text-gray-500">Kelola semua produk yang tersedia.</p>
            </div>
            <a href="{{ route('product.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
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

        {{-- Card --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            {{-- Toolbar: search --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 border-b border-gray-100">
                <form action="{{ route('product.index') }}" method="GET" class="flex w-full sm:w-80 gap-2">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau kode..."
                            class="w-full rounded-lg border border-gray-300 pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('product.index') }}"
                            class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 transition self-center">
                            Reset
                        </a>
                    @endif
                </form>

                <p class="text-sm text-gray-500">
                    Total <span class="font-semibold text-gray-700">{{ $product->total() }}</span> produk
                </p>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold w-12">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Kode</th>
                            <th class="px-4 py-3 text-left font-semibold">Nama Produk</th>
                            <th class="px-4 py-3 text-right font-semibold">Harga</th>
                            <th class="px-4 py-3 text-center font-semibold">Stok</th>
                            <th class="px-4 py-3 text-center font-semibold">Status</th>
                            <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($product as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $product->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-block rounded bg-gray-100 px-2 py-0.5 font-mono text-xs text-gray-700">
                                        {{ $item->code }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800">{{ $item->name }}</p>
                                    @if ($item->description)
                                        <p class="text-xs text-gray-400">{{ Str::limit($item->description, 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800 whitespace-nowrap">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($item->stock <= 0)
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">Habis</span>
                                    @elseif ($item->stock <= 10)
                                        <span
                                            class="inline-flex rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-700">{{ $item->stock }}</span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">{{ $item->stock }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($item->is_active)
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
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('product.show', $item) }}"
                                            class="rounded-md px-2.5 py-1 text-xs font-medium text-gray-600 hover:bg-gray-100 transition">
                                            Detail
                                        </a>
                                        <a href="{{ route('product.edit', $item) }}"
                                            class="rounded-md px-2.5 py-1 text-xs font-medium text-indigo-600 hover:bg-indigo-50 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('product.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk {{ $item->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-md px-2.5 py-1 text-xs font-medium text-red-600 hover:bg-red-50 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <p class="text-gray-500">
                                        @if (request('search'))
                                            Tidak ada produk yang cocok dengan "<span
                                                class="font-medium">{{ request('search') }}</span>".
                                        @else
                                            Belum ada produk. Silakan tambah produk pertama Anda.
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-4 py-3 border-t border-gray-100 bg-gray-50">
                <p class="text-sm text-gray-500">
                    Menampilkan {{ $product->firstItem() ?? 0 }} - {{ $product->lastItem() ?? 0 }}
                    dari {{ $product->total() }} produk
                </p>

                @if ($product->hasPages())
                    <div>
                        {{ $product->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
