<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\ValasController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TagihanController;
use Illuminate\Http\Request;

// Default route redirecting to login
Route::get('/', function () {
    return redirect('/login');
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
    
    // Transfer routes
    Route::get('/transfer', [TransferController::class, 'show'])->name('transfer');
    Route::post('/transfer/process', [TransferController::class, 'process'])->name('transfer.process');
    
    // Top up routes
    Route::get('/topup', [TopUpController::class, 'show'])->name('topup');
    Route::post('/topup/process', [TopUpController::class, 'process'])->name('topup.process');
    
    // Transfer Valas routes
    Route::get('/transfer-valas', [ValasController::class, 'index'])->name('transfer-valas.index');
    Route::get('/transfer-valas/create', [ValasController::class, 'create'])->name('transfer-valas.create');
    Route::post('/transfer-valas', [ValasController::class, 'store'])->name('transfer-valas.store');
    
    // Payment routes
    Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/va', [PaymentController::class, 'vaForm'])->name('pembayaran.va');
    Route::post('/pembayaran/check-va', [PaymentController::class, 'checkVa'])->name('pembayaran.checkVa');
    Route::post('/pembayaran', [PaymentController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/confirm', [PaymentController::class, 'confirm'])->name('pembayaran.confirm');
    Route::get('/pembayaran/sukses', function() {
        return view('payment.sukses');
    })->name('pembayaran.sukses');
    
    // Tagihan routes
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
    Route::get('/tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
    Route::post('/tagihan/store', [TagihanController::class, 'store'])->name('tagihan.store');
    Route::post('/tagihan/{id}/bayar', [TagihanController::class, 'bayar'])->name('tagihan.bayar');
});

// API routes
Route::get('/api/va-info', function(Request $request) {
    $va = $request->query('va');
    $data = [
        '1234567890' => 150000,
        '9876543210' => 250000,
    ];
    if (isset($data[$va])) {
        return response()->json([
            'success' => true,
            'amount' => $data[$va]
        ]);
    }
    return response()->json(['success' => false]);
});



