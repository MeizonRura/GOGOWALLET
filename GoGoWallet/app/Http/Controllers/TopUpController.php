<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function show()
    {
        return view('topup');
    }

    public function process(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank' => 'required|string|in:bca,bni,mandiri',
        ]);

        $user = Auth::user();
        
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

        return redirect()->route('dashboard')
            ->with('success', 'Top Up berhasil! Saldo telah ditambahkan.');
    }
}