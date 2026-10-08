<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/halo', function () {
    return 'Halo Laravel';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/add', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product_id}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product_id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product_id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product_id}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::prefix('category')->name('category.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/add', [CategoryController::class, 'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::get('/{category_id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{category_id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{category_id}', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/', [CashierController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CashierController::class, 'add'])->name('add');          // cashier.add
    Route::patch('/update/{id}', [CashierController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CashierController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CashierController::class, 'clear'])->name('clear');
});


require __DIR__ . '/auth.php';
