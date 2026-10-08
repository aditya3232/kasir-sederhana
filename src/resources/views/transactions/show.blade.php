{{-- resources/views/transactions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Struk ' . $transaction->invoice_number)

@push('styles')
    <style>
        /* Saat dicetak: sembunyikan semua kecuali struk */
        @media print {
            @page {
                margin: 5mm;
            }

            body * {
                visibility: hidden;
            }

            #receipt,
            #receipt * {
                visibility: visible;
            }

            #receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 80mm;
                border: 0 !important;
                box-shadow: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="mx-auto max-w-sm">

        {{-- Tombol aksi (tidak ikut tercetak) --}}
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('transactions.index') }}" class="text-sm text-slate-500 hover:underline">← Riwayat</a>
            <div class="flex gap-2">
                <a href="{{ route('cashier.index') }}"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium hover:bg-slate-50">Transaksi
                    baru</a>
                <button type="button" onclick="window.print()"
                    class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">Cetak
                    struk</button>
            </div>
        </div>

        {{-- STRUK --}}
        <div id="receipt" class="rounded-xl border border-slate-200 bg-white p-6 text-sm text-slate-800">
            <div class="text-center">
                <h2 class="text-base font-bold text-slate-900">{{ config('app.name', 'Kasir') }}</h2>
                <p class="text-xs text-slate-500">Struk Penjualan</p>
            </div>

            <dl class="mt-4 space-y-1 border-y border-dashed border-slate-300 py-3 text-xs">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Invoice</dt>
                    <dd class="font-mono">{{ $transaction->invoice_number }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Tanggal</dt>
                    <dd>{{ $transaction->created_at->translatedFormat('d M Y, H:i') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Kasir</dt>
                    <dd>{{ $transaction->user->name ?? '-' }}</dd>
                </div>
            </dl>

            {{-- Rincian barang --}}
            <ul class="divide-y divide-dashed divide-slate-200 py-1">
                @foreach ($transaction->details as $detail)
                    <li class="py-2">
                        <p class="font-medium">{{ $detail->product->name ?? 'Produk dihapus' }}</p>
                        <div class="flex justify-between text-xs text-slate-500">
                            <span>{{ $detail->quantity }} × Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                            <span class="font-medium text-slate-800">Rp
                                {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- Ringkasan pembayaran --}}
            <dl class="space-y-1 border-t border-dashed border-slate-300 pt-3">
                <div class="flex justify-between text-xs text-slate-500">
                    <dt>Jumlah item</dt>
                    <dd>{{ $transaction->details->sum('quantity') }}</dd>
                </div>
                <div class="flex justify-between text-base font-bold text-slate-900">
                    <dt>Total</dt>
                    <dd>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Dibayar</dt>
                    <dd>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Kembalian</dt>
                    <dd>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</dd>
                </div>
            </dl>

            <p class="mt-5 text-center text-xs text-slate-400">Terima kasih sudah berbelanja!</p>
        </div>
    </div>
@endsection
