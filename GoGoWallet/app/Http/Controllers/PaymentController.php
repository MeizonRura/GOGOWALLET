<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::orderBy('created_at', 'desc')->get();
        return view('payment.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'virtual_account' => [
                'required',
                'string',
                // Rule::unique('payments', 'virtual_account')->where(fn($q) => $q->where('status', 'pending')),
            ],
        ]);

        Payment::create([
            'amount' => $request->amount,
            'virtual_account' => $request->virtual_account,
            'status' => 'pending',
        ]);

        session()->forget(['virtual_account', 'amount']);

        // Ubah redirect ke dashboard
        return redirect()->route('pembayaran.sukses')->with('success', 'Pembayaran berhasil dibuat!');
    }

    public function vaForm()
    {
        return view('payment.va');
    }

    public function checkVa(Request $request)
    {
        $request->validate([
            'virtual_account' => 'required|string'
        ]);
        $va = $request->virtual_account;

        // Simulasi API/DB
        $data = [
            '1234567890' => 150000,
            '9876543210' => 250000,
        ];
        if (!isset($data[$va])) {
            return redirect()->back()->with('error', 'Virtual Account tidak ditemukan!');
        }
        $amount = $data[$va];

        // Simpan ke session biasa agar tidak hilang saat refresh
        session([
            'virtual_account' => $va,
            'amount' => $amount
        ]);
        return redirect()->route('pembayaran.confirm');
    }

    // Tambahkan route GET untuk konfirmasi
    public function confirm(Request $request)
    {
        $virtual_account = session('virtual_account');
        $amount = session('amount');
        if (!$virtual_account || !$amount) {
            return redirect()->route('pembayaran.va')->with('error', 'Data tidak valid!');
        }
        return view('payment.confirm', compact('virtual_account', 'amount'));
    }
}