<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get latest transactions for current user (either as sender or recipient)
        $transactions = Transaction::where('sender_id', $user->id)
            ->orWhere('recipient_id', $user->id)
            ->with(['sender', 'recipient'])
            ->latest()
            ->take(5)
            ->get();

        return view('Dashboard', compact('transactions'));
    }
}