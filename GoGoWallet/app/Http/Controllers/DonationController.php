<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        //return view('donations.index'); // nanti kita buat
        $donations = Donation::where('user_id', auth()->id())->latest()->get();
        return view('donations.index', compact('donations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rekening_tujuan' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();

        if ($user->balance < $request->amount) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        // Kurangi saldo
        $user->balance -= $request->amount;
        $user->save();

        // Simpan donasi
        Donation::create([
            'user_id' => $user->id,
            'rekening_tujuan' => $request->rekening_tujuan,
            'amount' => $request->amount,
        ]);

        Transaction::create([
            'sender_id' => $user->id,
            'recipient_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'donation',
            'note' => $request->rekening_tujuan, // This will show "Bencana Alam" or "Dompet Yatim"
            'status' => 'success'
        ]);

        return redirect()->route('dashboard')
                ->with('success', 'Donasi berhasil dilakukan');
    }
}
