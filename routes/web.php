<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === ROUTE KHUSUS ADMIN === //
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('barang', BarangController::class);
    Route::resource('supplier', SupplierController::class);
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// === ROUTE KHUSUS KASIR === //
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');
});

// === ROUTE KHUSUS SUPPLIER === //
Route::middleware(['auth', 'role:supplier'])->group(function () {
    Route::get('/supplier', function () {
        return view('supplier.dashboard');
    })->name('supplier.dashboard');
});

require __DIR__.'/auth.php';
