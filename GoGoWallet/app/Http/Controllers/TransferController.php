<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('transfer', [
            'user' => $user
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'recipient_account' => 'required|string|size:16|exists:users,account_number',
            'amount' => 'required|numeric|min:10000',
            'note' => 'nullable|string|max:100'
        ]);

        // Get recipient user
        $recipient = User::where('account_number', $request->recipient_account)->first();
        
        if ($recipient->id === Auth::id()) {
            return back()->withErrors([
                'recipient_account' => 'Tidak dapat transfer ke rekening sendiri'
            ]);
        }

        // Here you would typically:
        // 1. Check if sender has sufficient balance
        // 2. Create transaction records
        // 3. Update balances for both sender and recipient
        // 4. Send notifications
        
        // For now, just redirect back with success message
        return redirect()->route('dashboard')->with('success', 'Transfer berhasil dilakukan');
    }
}