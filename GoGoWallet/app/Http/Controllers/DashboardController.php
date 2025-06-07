<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\TransferValas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get regular transactions where user is either sender or recipient
        $regularTransactions = Transaction::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('recipient_id', $user->id);
        })
        ->latest()
        ->take(10)
        ->get()
        ->map(function($transaction) use ($user) {
            // Add transaction type based on user's role
            $transaction->type = $transaction->sender_id === $user->id ? 'debit' : 'credit';
            $transaction->description = $transaction->sender_id === $user->id ? 
                'Transfer ke ' . User::find($transaction->recipient_id)->account_number :
                'Terima dari ' . User::find($transaction->sender_id)->account_number;
            return $transaction;
        });

        // Get valas transactions (these are always debit)
        $valasTransactions = TransferValas::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        // Merge and sort transactions by date
        $transactions = $regularTransactions->concat($valasTransactions)
            ->sortByDesc('created_at')
            ->take(10);

        return view('dashboard', compact('transactions')); // Changed 'Dashboard' to 'dashboard'
    }
}