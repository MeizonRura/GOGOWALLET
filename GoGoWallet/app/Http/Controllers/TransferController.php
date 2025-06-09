<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index()
    {
        $transfers = Transaction::where('type', 'transfer')->get();
        return view('transfer.index', compact('transfers'));
    }

    public function show()
    {
        $user = Auth::user();
        return view('transfer', ['user' => $user]);
    }

    public function process(Request $request)
    {
        $messages = [
            'recipient_account.required' => 'Nomor rekening tujuan harus diisi',
            'recipient_account.size' => 'Nomor rekening tujuan harus 16 digit',
            'recipient_account.exists' => 'Nomor rekening tujuan tidak ditemukan',
            'amount.required' => 'Jumlah transfer harus diisi',
            'amount.numeric' => 'Jumlah transfer harus berupa angka',
            'amount.min' => 'Jumlah transfer minimal Rp 10.000',
            'note.max' => 'Catatan tidak boleh lebih dari 100 karakter'
        ];

        $request->validate([
            'recipient_account' => 'required|string|size:16|exists:users,account_number',
            'amount' => 'required|numeric|min:10000',
            'note' => 'nullable|string|max:100'
        ], $messages);

        $sender = Auth::user();
        $amount = $request->amount;

        // Check if sender has sufficient balance
        if ($sender->balance < $amount) {
            return back()->withErrors([
                'amount' => 'Saldo tidak mencukupi untuk melakukan transfer ini'
            ]);
        }

        // Get recipient user
        $recipient = User::where('account_number', $request->recipient_account)->first();
        
        // Check if recipient exists
        if (!$recipient) {
            return back()->withErrors([
                'recipient_account' => 'Nomor rekening tujuan tidak ditemukan'
            ]);
        }

        // Check if trying to transfer to self
        if ($recipient->id === $sender->id) {
            return back()->withErrors([
                'recipient_account' => 'Tidak dapat transfer ke rekening sendiri'
            ]);
        }

        try {
            DB::beginTransaction();

            // Deduct from sender's balance
            $sender->balance -= $amount;
            $sender->save();

            // Add to recipient's balance
            $recipient->balance += $amount;
            $recipient->save();

            // Create transaction record
            Transaction::create([
                'sender_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'amount' => $amount,
                'type' => 'transfer',
                'note' => $request->note ?? 'Transfer dana',
                'status' => 'success'
            ]);

            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Transfer berhasil dilakukan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'general' => 'Terjadi kesalahan saat memproses transfer'
            ]);
        }
    }
}