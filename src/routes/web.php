<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
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

Route::prefix('produk')->name('produk.')->group(function () {
    Route::get('/', [ProdukController::class, 'index'])->name('index');
    Route::get('/tambah', [ProdukController::class, 'create'])->name('create');
    Route::post('/', [ProdukController::class, 'store'])->name('store');
    Route::get('/{id}', [ProdukController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ProdukController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProdukController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProdukController::class, 'destroy'])->name('destroy');
});


require __DIR__ . '/auth.php';
