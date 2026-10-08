<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $category = Category::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('category.index', compact('category'));
    }

    public function show($category_id)
    {
        $category = Category::findOrFail($category_id);

        return view('category.show', compact('category'));
    }

    public function edit($category_id)
    {
        $category = Category::findOrFail($category_id);

        return view('category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $category_id)
    {
        $category = Category::findOrFail($category_id);

        $category->update($request->validated());

        return redirect()->route('category.index')
            ->with('success', 'kategori berhasil diperbarui.'); // dengan flash message
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('category.index')
            ->with('success', 'Kategori berhasil disimpan.');
    }

    public function destroy($category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
