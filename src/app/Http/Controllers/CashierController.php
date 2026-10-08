<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class CashierController extends Controller
{
    private const CART_KEY = 'cart';

    /**
     * Halaman kasir: daftar produk (kiri) + keranjang (kanan).
     */
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->when($request->q, function ($query, $q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('code', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $cart = $this->getCart();

        return view('cashier.index', [
            'products' => $products,
            'cart' => $cart,
            'totalItem' => collect($cart)->sum('quantity'),
            'total' => $this->calculateTotal($cart),
        ]);
    }

    /**
     * Tambah produk ke keranjang (session).
     * Kalau produk sudah ada, quantity-nya +1.
     */
    public function add(int $id): RedirectResponse
    {
        $product = Product::where('is_active', true)->findOrFail($id);

        $cart = $this->getCart();
        $currentQty = $cart[$id]['quantity'] ?? 0;

        if ($product->stock < 1) {
            return back()->with('error', "Stok {$product->name} habis.");
        }

        if ($currentQty + 1 > $product->stock) {
            return back()->with('error', "Stok {$product->name} hanya tersisa {$product->stock}.");
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Simpan "snapshot" data produk ke session
            $cart[$id] = [
                'product_id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session([self::CART_KEY => $cart]);

        return back()->with('success', "{$product->name} ditambahkan ke keranjang.");
    }

    /**
     * Ubah jumlah barang di keranjang.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $cart = $this->getCart();

        if (!isset($cart[$id])) {
            return back()->with('error', 'Produk tidak ada di keranjang.');
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        // Ambil stok terbaru dari database, bukan dari session
        $product = Product::findOrFail($id);

        if ($validated['quantity'] > $product->stock) {
            return back()->with('error', "Stok {$product->name} hanya tersisa {$product->stock}.");
        }

        $cart[$id]['quantity'] = $validated['quantity'];
        session([self::CART_KEY => $cart]);

        return back();
    }

    /**
     * Hapus satu produk dari keranjang.
     */
    public function remove(int $id): RedirectResponse
    {
        $cart = $this->getCart();
        unset($cart[$id]);
        session([self::CART_KEY => $cart]);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    /**
     * Kosongkan keranjang.
     */
    public function clear(): RedirectResponse
    {
        session()->forget(self::CART_KEY);

        return back()->with('success', 'Keranjang dikosongkan.');
    }

    /**
     * Bayar: pindahkan isi keranjang (session) menjadi catatan permanen di database.
     * 1 transaksi (induk) + N transaction_details (rincian).
     */
    public function store(Request $request): RedirectResponse
    {
        $cart = $this->getCart();

        // Jangan simpan transaksi kosong
        if (empty($cart)) {
            return redirect()
                ->route('cashier.index')
                ->with('error', 'Keranjang masih kosong. Pilih produk terlebih dahulu.');
        }

        $validated = $request->validate([
            'paid_amount' => ['required', 'integer', 'min:0'],
        ]);

        // Total dihitung ulang di server, tidak percaya angka dari form
        $total = $this->calculateTotal($cart);
        $paid = (int) $validated['paid_amount'];

        if ($paid < $total) {
            return back()
                ->withInput()
                ->with('error', 'Uang yang dibayarkan kurang Rp ' . number_format($total - $paid, 0, ',', '.') . '.');
        }

        try {
            // Semua langkah simpan harus berhasil semua, atau batal semua
            $transaction = DB::transaction(function () use ($cart, $total, $paid) {

                // Kunci baris produk agar stok tidak diambil dua kasir sekaligus
                $products = Product::whereIn('id', array_keys($cart))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                // Cek stok terakhir sebelum menyimpan apa pun
                foreach ($cart as $id => $item) {
                    $product = $products->get($id);

                    if (!$product || !$product->is_active) {
                        throw new RuntimeException("Produk {$item['name']} sudah tidak tersedia.");
                    }

                    if ($item['quantity'] > $product->stock) {
                        throw new RuntimeException("Stok {$product->name} hanya tersisa {$product->stock}.");
                    }
                }

                // 1) Simpan transaksi induk, kasir = user yang sedang login
                $transaction = Transaction::create([
                    'invoice_number' => $this->generateInvoiceNumber(),
                    'user_id' => auth()->id(),
                    'total_amount' => $total,
                    'paid_amount' => $paid,
                    'change_amount' => $paid - $total,
                ]);

                // 2) Simpan rincian lewat relasi details() -> transaction_id terisi otomatis
                foreach ($cart as $id => $item) {
                    $transaction->details()->create([
                        'product_id' => $id,
                        'price' => $item['price'], // harga saat transaksi
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['price'] * $item['quantity'],
                    ]);

                    // 3) Kurangi stok
                    $products[$id]->decrement('stock', $item['quantity']);
                }

                return $transaction;
            });
        } catch (RuntimeException $e) {
            // Masalah bisnis (mis. stok kurang): tampilkan pesannya
            return redirect()->route('cashier.index')->with('error', $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Transaksi gagal disimpan. Silakan coba lagi.');
        }

        // Keranjang sudah selesai tugasnya
        session()->forget(self::CART_KEY);

        return redirect()
            ->route('cashier.index')
            ->with('success', sprintf(
                'Transaksi %s berhasil. Total Rp %s, kembalian Rp %s.',
                $transaction->invoice_number,
                number_format($transaction->total_amount, 0, ',', '.'),
                number_format($transaction->change_amount, 0, ',', '.')
            ));
    }

    private function generateInvoiceNumber(): string
    {
        // Contoh: INV-20261008-A1B2C
        return 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
    }

    private function getCart(): array
    {
        return session(self::CART_KEY, []);
    }

    private function calculateTotal(array $cart): int
    {
        return collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }
}