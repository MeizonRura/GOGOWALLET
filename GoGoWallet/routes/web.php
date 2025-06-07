<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\ValasController;


// Default route redirecting to register
Route::get('/', function () {
    return redirect('/register');
});

// Guest routes (unprotected)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); 
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/transfer', [TransferController::class, 'show'])->name('transfer');
    Route::post('/transfer/process', [TransferController::class, 'process'])->name('transfer.process');
    Route::get('/topup', [TopUpController::class, 'show'])->name('topup');
    Route::post('/topup/process', [TopUpController::class, 'process'])->name('topup.process');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/transfer-valas', [ValasController::class, 'index'])->name('transfer-valas.index');
    Route::get('/transfer-valas/create', [ValasController::class, 'create'])->name('transfer-valas.create');
    Route::post('/transfer-valas', [ValasController::class, 'store'])->name('transfer-valas.store');
});

use App\Http\Controllers\TagihanController;

Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
Route::get('/tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
Route::post('/tagihan/store', [TagihanController::class, 'store'])->name('tagihan.store');
Route::post('/tagihan/{id}/mark-paid', [TagihanController::class, 'markAsPaid'])->name('tagihan.markAsPaid');



