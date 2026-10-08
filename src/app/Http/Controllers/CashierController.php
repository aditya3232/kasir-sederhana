<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    private function getCart(): array
    {
        return session(self::CART_KEY, []);
    }

    private function calculateTotal(array $cart): int
    {
        return collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }
}