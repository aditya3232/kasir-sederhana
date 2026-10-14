<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Halaman publik: arahkan ke dashboard jika sudah login, atau ke login jika belum
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// Semua halaman di bawah ini wajib login.
// Kalau belum login, otomatis diarahkan ke halaman login.
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
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
        Route::post('/add/{id}', [CashierController::class, 'add'])->name('add');
        Route::patch('/update/{id}', [CashierController::class, 'update'])->name('update');
        Route::delete('/remove/{id}', [CashierController::class, 'remove'])->name('remove');
        Route::post('/checkout', [CashierController::class, 'store'])->name('store');
        Route::delete('/clear', [CashierController::class, 'clear'])->name('clear');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
    });
});

require __DIR__ . '/auth.php';