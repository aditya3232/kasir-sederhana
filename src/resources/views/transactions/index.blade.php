{{-- resources/views/transactions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Riwayat Transaksi</h1>
            <p class="text-sm text-slate-500">Semua penjualan yang sudah dibayar.</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white">
            {{-- Filter --}}
            <form method="GET" action="{{ route('transactions.index') }}"
                class="flex flex-wrap items-center gap-2 border-b border-slate-100 p-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor invoice..."
                    class="w-64 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <input type="date" name="date" value="{{ request('date') }}"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <button
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-50">Cari</button>

                @if (request()->hasAny(['q', 'date']))
                    <a href="{{ route('transactions.index') }}" class="text-sm text-slate-500 hover:underline">Reset</a>
                @endif

                <div class="ml-auto text-sm text-slate-500">
                    {{ $transactions->total() }} transaksi ·
                    Total <span class="font-semibold text-slate-900">Rp {{ number_format($totalSales, 0, ',', '.') }}</span>
                </div>
            </form>

            {{-- Tabel --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left text-xs font-semibold text-slate-500">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Invoice</th>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Kasir</th>
                            <th class="px-4 py-3 text-right">Item</th>
                            <th class="px-4 py-3 text-right">Total</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transactions as $transaction)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500">{{ $transactions->firstItem() + $loop->index }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="rounded bg-slate-100 px-2 py-0.5 font-mono text-xs">{{ $transaction->invoice_number }}</span>
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    {{ $transaction->created_at->translatedFormat('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $transaction->user->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-right text-slate-600">{{ $transaction->total_items }}</td>
                                <td class="px-4 py-3 text-right font-semibold text-slate-900">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('transactions.show', $transaction->id) }}"
                                        class="text-xs font-medium text-indigo-600 hover:underline">Lihat struk</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                                    Belum ada
                                    transaksi{{ request()->hasAny(['q', 'date']) ? ' yang cocok dengan pencarian.' : '.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between border-t border-slate-100 p-4 text-sm text-slate-500">
                <span>Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari
                    {{ $transactions->total() }} transaksi</span>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection
