<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Default route redirecting to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard route without auth middleware for now
Route::get('/dashboard', [DashboardController::class, 'index']);


