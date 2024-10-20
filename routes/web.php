<?php

use Illuminate\Support\Facades\Route;
//use : import file
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;



Route::get('/', [LandingPageController::class, 'index'])->name('landing_page');


// Mengelola data obat
Route::get('/data-obat', [MedicineController::class, 'index'])->name('data_obat');                              

Route::prefix('/obat')->name('obat.')->group(function () {
    // Mengelola data obat
    Route::get('/tambah-obat', [MedicineController::class, 'create'])->name('tambah_obat');  
    Route::post('/tambah-obat', [MedicineController::class, 'store'])->name('tambah_obat.formulir');
    Route::get('/data', [MedicineController::class, 'index'])->name('data');
    Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
    Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('edit.formulir');
    Route::delete('/hapus/{id}', [MedicineController::class, 'destroy'])->name('hapus');   
    Route::patch('/edit/stock/{id}', [MedicineController::class, 'updateStock'])->name('edit.stock');
});
//mengelola akun user
Route::prefix('/user')->name('user.')->group(function () {
    Route::get('/data', [UserController::class, 'index'])->name('data_user');
    Route::get('/data-user', [UserController::class, 'create'])->name('user');
    Route::post('/tambah-user', [UserController::class, 'store'])->name('tambah-formulir');
    Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('hapus');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
    Route::patch('/edit/{id}', [UserController::class, 'update'])->name('edit.formulir');
});
