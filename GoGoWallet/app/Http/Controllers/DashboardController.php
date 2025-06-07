<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransferValas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get regular transactions
        $regularTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        // Get valas transactions 
        $valasTransactions = TransferValas::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        // Merge and sort transactions by date
        $transactions = $regularTransactions->concat($valasTransactions)
            ->sortByDesc('created_at')
            ->take(10);

        return view('Dashboard', compact('transactions'));
    }
}