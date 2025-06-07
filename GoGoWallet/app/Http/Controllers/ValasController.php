<?php

namespace App\Http\Controllers;

use App\Models\TransferValas;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ValasController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('transfer_valas.index', compact('user'));
    }

    public function store(Request $request)
    {
        $messages = [
            'account_number.required' => 'Nomor rekening tujuan harus diisi',
            'recipient_bank.required' => 'Bank tujuan harus dipilih',
            'currency.required' => 'Mata uang harus dipilih',
            'amount_idr.required' => 'Jumlah transfer harus diisi',
            'amount_idr.numeric' => 'Jumlah transfer harus berupa angka',
            'amount_idr.min' => 'Jumlah transfer minimal Rp 10.000',
        ];

        try {
            $request->validate([
                'account_number' => 'required|string',
                'recipient_bank' => 'required|string',
                'currency' => 'required|in:USD,SGD,JPY',
                'amount_idr' => 'required|numeric|min:10000',
                'exchange_rate' => 'required|numeric',
                'amount_valas' => 'required|numeric'
            ], $messages);

            $sender = Auth::user();
            $amount = $request->amount_idr;

            // Check if sender has sufficient balance
            if ($sender->balance < $amount) {
                return back()->withErrors([
                    'general' => 'Saldo anda tidak mencukupi untuk melakukan transfer ini'
                ])->withInput();
            }

            DB::beginTransaction();

            // Record valas transfer
            $transfer = TransferValas::create([
                'user_id' => $sender->id,
                'account_number' => $request->account_number,
                'recipient_bank' => $request->recipient_bank,
                'currency' => $request->currency,
                'amount_idr' => $amount,
                'exchange_rate' => $request->exchange_rate,
                'amount_valas' => $request->amount_valas
            ]);

            // Deduct from sender's balance
            $sender->balance -= $amount;
            $sender->save();

            // Create transaction record
            Transaction::create([
                'sender_id' => $sender->id,
                'recipient_id' => $sender->id, // Use sender's ID for record keeping
                'amount' => $amount,
                'type' => 'transfer_valas',
                'note' => sprintf(
                    'Transfer %s %.2f ke %s (%s)',
                    $request->currency,
                    $request->amount_valas,
                    $request->account_number,
                    $request->recipient_bank
                ),
                'status' => 'success'
            ]);

            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Transfer valas berhasil dilakukan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'general' => 'Terjadi kesalahan saat memproses transfer'
            ]);
        }
    }
}
