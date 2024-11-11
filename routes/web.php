<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::middleware(['isGuest'])->group(function () {
    Route::get('/', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.proses');
});

Route::middleware(['isLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/landing', [LandingPageController::class, 'index'])->name('landing_page');

    Route::middleware(['role:admin'])->group(function () {
        // Mengelola data obat
        Route::get('/data-obat', [MedicineController::class, 'index'])->name('data_obat');

        Route::prefix('/obat')->name('obat.')->group(function () {
            Route::get('/tambah-obat', [MedicineController::class, 'create'])->name('tambah_obat');
            Route::post('/tambah-obat', [MedicineController::class, 'store'])->name('tambah_obat.formulir');
            Route::get('/data', [MedicineController::class, 'index'])->name('data');
            Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('edit.formulir');
            Route::delete('/hapus/{id}', [MedicineController::class, 'destroy'])->name('hapus');
            Route::patch('/edit/stock/{id}', [MedicineController::class, 'updateStock'])->name('edit.stock');
        });

        // Mengelola akun user
        Route::prefix('/user')->name('user.')->group(function () {
            Route::get('/data', [UserController::class, 'index'])->name('data_user');
            Route::get('/data-user', [UserController::class, 'create'])->name('user');
            Route::post('/tambah-user', [UserController::class, 'store'])->name('tambah-formulir');
            Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('hapus');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [UserController::class, 'update'])->name('edit.formulir');
        });
    });

    // Mengelola pembelian (hanya untuk user dan admin)
    Route::middleware(['role:user'])->group(function () {
        Route::prefix('/pembelian')->name('pembelian.')->group(function () {
            Route::get('/order', [OrderController::class, 'index'])->name('order');
            Route::get('/formulir', [OrderController::class, 'create'])->name('formulir');
            Route::post('/formulir', [OrderController::class, 'store'])->name('proses');
            Route::get('/cetak{id}', [OrderController::class, 'show'])->name('print');
        });
    });

    // Route::group([
    //     'prefix' => 'pembelian',
    //     'as' => 'pembelian.',
    //     'middleware' => ['role:user']
    // ], function () {
    //     Route::get('/order', [OrderController::class, 'index'])->name('order');
    //     Route::get('/formulir', [OrderController::class, 'create'])->name('formulir');
    // });
});
