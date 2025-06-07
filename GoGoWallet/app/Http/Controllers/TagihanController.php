<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::all();
        return view('tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        return view('tagihan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_rekening' => 'required|string',
            'nominal_tagihan' => 'required|numeric|min:1000',
            'deskripsi' => 'required|string',
        ]);

        Tagihan::create([
            'nomor_rekening' => $validated['nomor_rekening'],
            'nominal_tagihan' => $validated['nominal_tagihan'],
            'deskripsi' => $validated['deskripsi'],
            'status_dibayar' => false,
        ]);

        return redirect()->route('tagihan.index')
            ->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function markAsPaid($id)
    {
        $tagihan = Tagihan::findOrFail($id);
    if (!$tagihan->status_dibayar) {
        $tagihan->status_dibayar = true;
        $tagihan->save();

        // Tambahkan saldo ke user yang sedang login
        $user = auth()->user();
        $user->saldo += $tagihan->nominal_tagihan;
        $user->save();
    }

    return redirect()->route('tagihan.index')
        ->with('success', 'Tagihan telah ditandai sebagai dibayar dan saldo bertambah.');
}

}