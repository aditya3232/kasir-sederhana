<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();

        return view('produk.index', compact('produk'));
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);

        return view('produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        return view('produk.edit', compact('produk'));
    }

    public function update(UpdateProdukRequest $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $produk->update($request->validated());

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(StoreProdukRequest $request)
    {
        Produk::create($request->validated());

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil disimpan.');
    }

    public function destroy($id)
    {
        Produk::destroy($id);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }


}
