<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Riwayat semua transaksi (terbaru di atas).
     */
    public function index(Request $request): View
    {
        // Filter dipakai bersama oleh daftar dan ringkasan total
        $filtered = Transaction::query()
            ->when($request->q, fn($query, $q) => $query->where('invoice_number', 'like', "%{$q}%"))
            ->when($request->date, fn($query, $date) => $query->whereDate('created_at', $date));

        $transactions = (clone $filtered)
            ->with('user')                                   // nama kasir, hindari N+1
            ->withSum('details as total_items', 'quantity')  // jumlah barang per transaksi
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', [
            'transactions' => $transactions,
            'totalSales' => (clone $filtered)->sum('total_amount'),
        ]);
    }

    /**
     * Struk satu transaksi berdasarkan id.
     */
    public function show(int $id): View
    {
        $transaction = Transaction::with(['user', 'details.product'])->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }
}