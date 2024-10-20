<?php

use App\Http\Controllers\PackagingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('packagings', [PackagingController::class, 'index'])->name('packagings.index');
    Route::get('packagings/create', [PackagingController::class, 'create'])->name('packagings.create');
    Route::post('packagings', [PackagingController::class, 'store'])->name('packagings.store');
    Route::get('packagingss/{packaging}/edit', [PackagingController::class, 'edit'])->name('packagings.edit');
    Route::put('packagings/{packaging}', [PackagingController::class, 'update'])->name('packagings.update');
    Route::delete('packaging/{packaging}', [PackagingController::class, 'destroy'])->name('packagings.destroy');


    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
