<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const LOW_STOCK_LIMIT = 10;

    public function index(): View
    {
        $chart = $this->weeklyChart();

        return view('dashboard', [
            ...$this->summary(),
            ...$this->lowStock(),
            'chart' => $chart,
            'chartMax' => max(1, (int) $chart->max('total')),
            'topProducts' => $this->topProducts(),
            'lowStockLimit' => self::LOW_STOCK_LIMIT,
            'recentTransactions' => $this->recentTransactions(),
        ]);
    }

    /**
     * Kartu ringkasan: hari ini dan bulan ini.
     *
     * @return array{todaySales: int, todayCount: int, todayItems: int, monthSales: int}
     */
    private function summary(): array
    {
        $today = Transaction::whereDate('created_at', today());

        return [
            'todaySales' => (int) (clone $today)->sum('total_amount'),
            'todayCount' => (clone $today)->count(),
            'todayItems' => (int) TransactionDetail::whereDate('created_at', today())->sum('quantity'),
            'monthSales' => (int) Transaction::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])->sum('total_amount'),
        ];
    }

    /**
     * Penjualan 7 hari terakhir (dikelompokkan di PHP agar aman di semua database).
     *
     * @return Collection<int, array{label: string, date: string, total: int, is_today: bool}>
     */
    private function weeklyChart(): Collection
    {
        $start = CarbonImmutable::today()->subDays(6);

        $salesPerDay = Transaction::where('created_at', '>=', $start)
            ->get(['total_amount', 'created_at'])
            ->groupBy(fn(Transaction $t) => $t->created_at->toDateString())
            ->map(fn(Collection $group) => (int) $group->sum('total_amount'));

        return collect(range(0, 6))->map(function (int $i) use ($start, $salesPerDay) {
            $date = $start->addDays($i);

            return [
                'label' => $date->translatedFormat('D'),
                'date' => $date->translatedFormat('d M'),
                'total' => $salesPerDay->get($date->toDateString(), 0),
                'is_today' => $date->isToday(),
            ];
        });
    }

    /**
     * Produk terlaris bulan ini (5 teratas).
     *
     * @return EloquentCollection<int, TransactionDetail>
     */
    private function topProducts(): EloquentCollection
    {
        return TransactionDetail::select(
            'product_id',
            DB::raw('SUM(quantity) as sold'),
            DB::raw('SUM(subtotal) as revenue')
        )
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->groupBy('product_id')
            ->orderByDesc('sold')
            ->with('product')
            ->limit(5)
            ->get();
    }

    /**
     * Produk aktif dengan stok menipis.
     *
     * @return array{lowStockCount: int, lowStockProducts: EloquentCollection<int, Product>}
     */
    private function lowStock(): array
    {
        $query = Product::where('is_active', true)->where('stock', '<=', self::LOW_STOCK_LIMIT);

        return [
            'lowStockCount' => (clone $query)->count(),
            'lowStockProducts' => (clone $query)->orderBy('stock')->limit(5)->get(),
        ];
    }

    /**
     * @return EloquentCollection<int, Transaction>
     */
    private function recentTransactions(): EloquentCollection
    {
        return Transaction::with('user')->latest()->limit(5)->get();
    }
}