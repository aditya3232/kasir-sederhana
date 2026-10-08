{{-- resources/views/cashier/index.blade.php --}}
{{-- Sesuaikan @extends / @section dengan layout yang kamu pakai di halaman Produk --}}
@extends('layouts.app')

@section('title', 'Kasir')

@section('content')
    <div class="px-8 py-10 max-w-7xl mx-auto">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Kasir</h1>
            <p class="text-sm text-gray-500">Pilih produk yang dibeli pelanggan.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- ====== KIRI: DAFTAR PRODUK ====== --}}
            <div class="lg:col-span-2 rounded-xl border border-gray-200 bg-white">
                <form method="GET" action="{{ route('cashier.index') }}" class="flex gap-2 p-4 border-b border-gray-100">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau kode..."
                        class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <button
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium hover:bg-gray-50">Cari</button>
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 p-4">
                    @forelse ($products as $product)
                        @php $inCart = $cart[$product->id]['quantity'] ?? 0; @endphp
                        <div class="flex flex-col rounded-lg border border-gray-200 p-4">
                            <span class="mb-2 w-fit rounded-full bg-indigo-50 px-2 py-0.5 text-xs text-indigo-700">
                                {{ $product->category->name ?? '-' }}
                            </span>
                            <h3 class="text-sm font-semibold text-gray-900">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-400 font-mono">{{ $product->code }}</p>

                            <div class="mt-3 flex items-end justify-between">
                                <p class="text-sm font-bold text-gray-900">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs {{ $product->stock <= 10 ? 'text-amber-600' : 'text-gray-500' }}">
                                    Stok {{ $product->stock }}
                                </p>
                            </div>

                            <form method="POST" action="{{ route('cashier.add', $product->id) }}" class="mt-3">
                                @csrf
                                <button type="submit" @disabled($product->stock < 1 || $inCart >= $product->stock)
                                    class="w-full rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:cursor-not-allowed disabled:bg-gray-300">
                                    {{ $product->stock < 1 ? 'Stok habis' : '+ Tambah' }}
                                    @if ($inCart)
                                        ({{ $inCart }})
                                    @endif
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="col-span-full py-10 text-center text-sm text-gray-500">Produk tidak ditemukan.</p>
                    @endforelse
                </div>

                <div class="border-t border-gray-100 p-4">{{ $products->links() }}</div>
            </div>

            {{-- ====== KANAN: KERANJANG ====== --}}
            <div class="rounded-xl border border-gray-200 bg-white lg:sticky lg:top-6">
                <div class="flex items-center justify-between border-b border-gray-100 p-4">
                    <h2 class="font-semibold text-gray-900">Keranjang <span
                            class="text-sm font-normal text-gray-500">({{ $totalItem }} item)</span></h2>

                    @if (count($cart))
                        <form method="POST" action="{{ route('cashier.clear') }}"
                            onsubmit="return confirm('Kosongkan keranjang?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-600 hover:underline">Kosongkan</button>
                        </form>
                    @endif
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($cart as $id => $item)
                        <div class="p-4">
                            <div class="flex justify-between gap-2">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item['name'] }}</p>
                                    <p class="text-xs text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('cashier.remove', $id) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                {{-- Atur jumlah: kurang / input / tambah --}}
                                <div class="flex items-center gap-1">
                                    <form method="POST" action="{{ route('cashier.update', $id) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                        <button class="h-7 w-7 rounded border border-gray-300 text-sm hover:bg-gray-50"
                                            @disabled($item['quantity'] <= 1)>−</button>
                                    </form>

                                    <form method="POST" action="{{ route('cashier.update', $id) }}">
                                        @csrf @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                            min="1" onchange="this.form.submit()"
                                            class="h-7 w-14 rounded border border-gray-300 text-center text-sm">
                                    </form>

                                    <form method="POST" action="{{ route('cashier.update', $id) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button
                                            class="h-7 w-7 rounded border border-gray-300 text-sm hover:bg-gray-50">+</button>
                                    </form>
                                </div>

                                <p class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="p-8 text-center text-sm text-gray-500">Keranjang masih kosong.<br>Klik "Tambah" pada
                            produk.</p>
                    @endforelse
                </div>

                <div class="border-t border-gray-100 bg-gray-50 p-4 rounded-b-xl">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total belanja</span>
                        <span class="text-xl font-bold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    {{-- Tombol bayar akan diaktifkan di lesson berikutnya --}}
                    <button disabled
                        class="mt-3 w-full cursor-not-allowed rounded-lg bg-gray-300 px-4 py-2.5 text-sm font-medium text-white">
                        Bayar (lesson berikutnya)
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
