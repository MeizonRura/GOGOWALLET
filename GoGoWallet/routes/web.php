<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;



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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/pembayaran', [PaymentController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/va', [PaymentController::class, 'vaForm'])->name('pembayaran.va');
    Route::post('/pembayaran/check-va', [PaymentController::class, 'checkVa'])->name('pembayaran.checkVa');
    Route::post('/pembayaran', [PaymentController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/confirm', [PaymentController::class, 'confirm'])->name('pembayaran.confirm');
    Route::get('/pembayaran/sukses', function() {
        return view('payment.sukses');
    })->name('pembayaran.sukses');
});

Route::get('/api/va-info', function(Request $request) {
    $va = $request->query('va');
    // Contoh: Query ke database atau ke API eksternal
    // Misal: Cek VA dan ambil nominalnya
    $data = [
        '1234567890' => 150000,
        '9876543210' => 250000,
        // dst...
    ];
    if (isset($data[$va])) {
        return response()->json([
            'success' => true,
            'amount' => $data[$va]
        ]);
    }
    return response()->json(['success' => false]);
});



