<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $product = Product::query()
            ->with('category') // eager load relasi category, mencegah N+1 query
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

    public function show($product_id)
    {
        $product = Product::with('category')->findOrFail($product_id);

        return view('product.show', compact('product'));
    }

    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id);
        $categories = Category::all();

        return view('product.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $product->update($request->validated());

        return redirect()->route('product.index')
            ->with('success', 'Produk berhasil diperbarui.'); // dengan flash message
    }

    public function create()
    {
        $categories = Category::all();

        return view('product.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('product.index')
            ->with('success', 'Produk berhasil disimpan.');
    }

    public function destroy($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();

        return redirect()->route('product.index')
            ->with('success', 'Produk berhasil dihapus.');
    }


}
