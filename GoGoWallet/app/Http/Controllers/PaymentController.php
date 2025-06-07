<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        // Ambil semua pembayaran milik user yang sedang login
        $payments = Payment::where('user_id', auth()->id())->latest()->get();

        return view('payment.index', compact('payments'));
    }

    public function vaForm()
    {
        $user = Auth::user();
        return view('payment.va', compact('user'));
    }

    public function checkVa(Request $request)
    {
        $request->validate([
            'virtual_account' => 'required|string'
        ]);

        // Simulasi data VA
        $data = [
            '1234567890' => 150000,
            '9876543210' => 250000,
        ];

        $va = $request->virtual_account;
        if (isset($data[$va])) {
            // Tampilkan halaman konfirmasi
            return view('payment.confirm', [
                'virtual_account' => $va,
                'amount' => $data[$va]
            ]);
        } else {
            // Kembali ke form dengan error
            return back()->withInput()->with('error', 'Virtual Account tidak ditemukan!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'virtual_account' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        // Simulasi data VA
        $data = [
            '1234567890' => 150000,
            '9876543210' => 250000,
        ];

        $va = $request->virtual_account;
        $amount = $request->amount;

        // Cek VA valid
        if (!isset($data[$va]) || $data[$va] != $amount) {
            return back()->withInput()->with('error', 'Virtual Account atau nominal tidak valid!');
        }

        // Jika belum konfirmasi, tampilkan halaman konfirmasi
        if (!$request->has('confirm')) {
            return view('payment.confirm', [
                'virtual_account' => $va,
                'amount' => $amount
            ]);
        }

        // Jika sudah konfirmasi, simpan pembayaran
        $user = auth()->user();
        if ($user->balance < $amount) {
            return back()->with('error', 'Saldo tidak cukup!');
        }
        $user->balance -= $amount;
        $user->save();

        \App\Models\Payment::create([
            'user_id' => $user->id,
            'va_number' => $va,
            'amount' => $amount,
            'status' => 'success',
            'description' => 'Pembayaran VA'
        ]);

        return redirect()->route('pembayaran.sukses');
    }

    public function confirm()
    {
        $user = Auth::user();
        return view('payment.confirm', compact('user'));
    }
}