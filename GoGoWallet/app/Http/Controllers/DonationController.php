<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
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

        return back()->with('success', 'Donasi berhasil!');
    }
}
