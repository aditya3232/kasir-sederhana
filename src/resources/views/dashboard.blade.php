{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Halo, {{ Str::before(auth()->user()->name, ' ') }}</h1>
            <p class="text-sm text-slate-500">Ringkasan penjualan toko hari ini.</p>
        </div>

        {{-- Kartu ringkasan --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">Penjualan hari ini</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">Transaksi hari ini</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($todayCount, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">Barang terjual hari ini</p>
                <p class="mt-2 text-2xl font-bold text-slate-900">{{ number_format($todayItems, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">Penjualan {{ now()->translatedFormat('F Y') }}</p>
                <p class="mt-2 text-2xl font-bold text-indigo-600">Rp {{ number_format($monthSales, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Grafik 7 hari terakhir --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 lg:col-span-2">
                <h2 class="font-semibold text-slate-900">Penjualan 7 hari terakhir</h2>
                <p class="text-xs text-slate-500">Total per hari. Arahkan kursor ke batang untuk melihat nominal.</p>

                <div class="mt-6 flex h-48 items-end gap-3">
                    @foreach ($chart as $day)
                        @php $height = $day['total'] > 0 ? max(4, round($day['total'] / $chartMax * 100)) : 2; @endphp
                        <div class="flex h-full flex-1 flex-col items-center justify-end gap-2"
                            title="{{ $day['date'] }}: Rp {{ number_format($day['total'], 0, ',', '.') }}">
                            <span class="text-[11px] text-slate-400">
                                {{ $day['total'] > 0 ? number_format($day['total'] / 1000, 0, ',', '.') . 'rb' : '' }}
                            </span>
                            <div class="w-full rounded-t-md {{ $day['is_today'] ? 'bg-indigo-600' : 'bg-indigo-200' }}"
                                style="height: {{ $height }}%"></div>
                            <span
                                class="text-xs {{ $day['is_today'] ? 'font-semibold text-slate-900' : 'text-slate-500' }}">{{ $day['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Produk terlaris --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <h2 class="font-semibold text-slate-900">Produk terlaris</h2>
                <p class="text-xs text-slate-500">Bulan {{ now()->translatedFormat('F Y') }}</p>

                <ul class="mt-4 divide-y divide-slate-100">
                    @forelse ($topProducts as $item)
                        <li class="flex items-center justify-between gap-3 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-900">
                                    {{ $item->product->name ?? 'Produk dihapus' }}</p>
                                <p class="text-xs text-slate-500">Rp {{ number_format($item->revenue, 0, ',', '.') }}</p>
                            </div>
                            <span
                                class="shrink-0 rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700">{{ $item->sold }}
                                terjual</span>
                        </li>
                    @empty
                        <li class="py-8 text-center text-sm text-slate-500">Belum ada penjualan bulan ini.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Stok menipis --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-slate-900">Stok menipis</h2>
                    @if ($lowStockCount > 0)
                        <span
                            class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">{{ $lowStockCount }}
                            produk</span>
                    @endif
                </div>
                <p class="text-xs text-slate-500">Produk aktif dengan stok {{ $lowStockLimit }} atau kurang.</p>

                <ul class="mt-4 divide-y divide-slate-100">
                    @forelse ($lowStockProducts as $product)
                        <li class="flex items-center justify-between gap-3 py-3">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-slate-900">{{ $product->name }}</p>
                                <p class="font-mono text-xs text-slate-400">{{ $product->code }}</p>
                            </div>
                            <span
                                class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $product->stock <= 3 ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700' }}">
                                Sisa {{ $product->stock }}
                            </span>
                        </li>
                    @empty
                        <li class="py-8 text-center text-sm text-slate-500">Semua stok aman.</li>
                    @endforelse
                </ul>

                @if (Route::has('product.index') && $lowStockCount > 0)
                    <a href="{{ route('product.index') }}"
                        class="mt-2 inline-block text-xs font-medium text-indigo-600 hover:underline">Kelola produk</a>
                @endif
            </div>

            {{-- Transaksi terbaru --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 lg:col-span-2">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-slate-900">Transaksi terbaru</h2>
                    <a href="{{ route('transactions.index') }}"
                        class="text-xs font-medium text-indigo-600 hover:underline">Lihat semua</a>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentTransactions as $transaction)
                                <tr>
                                    <td class="py-3 pr-4">
                                        <span
                                            class="rounded bg-slate-100 px-2 py-0.5 font-mono text-xs">{{ $transaction->invoice_number }}</span>
                                    </td>
                                    <td class="py-3 pr-4 text-slate-600">
                                        {{ $transaction->created_at->translatedFormat('d M, H:i') }}</td>
                                    <td class="py-3 pr-4 text-slate-600">{{ $transaction->user->name ?? '-' }}</td>
                                    <td class="py-3 pr-4 text-right font-semibold text-slate-900">Rp
                                        {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                    <td class="py-3 text-right">
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="text-xs font-medium text-indigo-600 hover:underline">Struk</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-8 text-center text-slate-500">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
