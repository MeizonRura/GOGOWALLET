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
        $user = Auth::user();
        return view('payment.index', compact('user'));
    }

    public function vaForm()
    {
        $user = Auth::user();
        return view('payment.va', compact('user'));
    }

    public function checkVa(Request $request)
    {
        $request->validate([
            'va_number' => 'required|string|size:16'
        ]);

        // Simulate VA number validation
        // In real application, this would check against a VA database
        $amount = mt_rand(10000, 1000000); // Example amount
        
        return response()->json([
            'valid' => true,
            'amount' => $amount,
            'description' => 'Payment for Virtual Account ' . $request->va_number
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'va_number' => 'required|string|size:16',
            'amount' => 'required|numeric|min:1000'
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // Check if user has sufficient balance
        if ($user->balance < $amount) {
            return back()->withErrors([
                'amount' => 'Saldo tidak mencukupi untuk melakukan pembayaran ini'
            ]);
        }

        try {
            DB::beginTransaction();

            // Deduct user's balance
            $user->balance -= $amount;
            $user->save();

            // Create payment record
            Payment::create([
                'user_id' => $user->id,
                'va_number' => $request->va_number,
                'amount' => $amount,
                'status' => 'success',
                'description' => 'Payment for VA ' . $request->va_number
            ]);

            DB::commit();

            return redirect()->route('pembayaran.sukses')
                ->with('success', 'Pembayaran berhasil dilakukan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'general' => 'Terjadi kesalahan saat memproses pembayaran'
            ]);
        }
    }

    public function confirm()
    {
        $user = Auth::user();
        return view('payment.confirm', compact('user'));
    }
}