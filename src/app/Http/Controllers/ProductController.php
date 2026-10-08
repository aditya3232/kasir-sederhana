<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $product = Product::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // supaya keyword search tidak hilang saat pindah halaman

        return view('product.index', compact('product'));
    }

    // public function show($produk_id)
    // {
    //     $produk = Produk::findOrFail($produk_id);

    //     return view('produk.show', compact('produk'));
    // }

    // public function edit($produk_id)
    // {
    //     $produk = Produk::findOrFail($produk_id);

    //     return view('produk.edit', compact('produk'));
    // }

    // public function update(UpdateProdukRequest $request, $produk_id)
    // {
    //     $produk = Produk::findOrFail($produk_id);

    //     $produk->update($request->validated());

    //     return redirect()->route('produk.index')
    //         ->with('success', 'Produk berhasil diperbarui.'); // dengan flash message
    // }

    // public function create()
    // {
    //     return view('produk.create');
    // }

    // public function store(StoreProdukRequest $request)
    // {
    //     Produk::create($request->validated());

    //     return redirect()->route('produk.index')
    //         ->with('success', 'Produk berhasil disimpan.');
    // }

    // public function destroy($produk_id)
    // {
    //     $produk = Produk::findOrFail($produk_id);
    //     $produk->delete();

    //     return redirect()->route('produk.index')
    //         ->with('success', 'Produk berhasil dihapus.');
    // }


}
