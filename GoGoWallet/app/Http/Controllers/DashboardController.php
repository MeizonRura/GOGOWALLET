<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank' => 'required|string|in:bca,bni,mandiri',
        ]);

        $user = Auth::user();
        
        try {
            DB::beginTransaction();

            // Create topup record
            TopUp::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'status' => 'success',
                'payment_method' => $request->bank
            ]);

            // Update user balance
            $user->balance += $request->amount;
            $user->save();

            // Create transaction record for top up
            Transaction::create([
                'sender_id' => $user->id, // sender is same as recipient for top up
                'recipient_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'topup',
                'note' => 'Top Up via ' . strtoupper($request->bank),
                'status' => 'success'
            ]);

            DB::commit();
            return redirect()->route('dashboard')
                ->with('success', 'Top Up berhasil! Saldo telah ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal melakukan top up']);
        }
    }
}

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all transactions including transfers and payments
        $transactions = Transaction::with(['sender', 'recipient'])
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('recipient_id', $user->id);
            })
            ->latest()
            ->get();

        return view('dashboard', [
            'user' => $user,
            'transactions' => $transactions
        ]);
    }
}