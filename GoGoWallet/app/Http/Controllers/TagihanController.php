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
        // Validasi input
        $validated = $request->validate([
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
            'nominal_tagihan' => 'required|numeric',
            'deskripsi' => 'required',
        ]);

        // Simpan ke database
        Tagihan::create([
            'nama_rekening' => $validated['nama_rekening'],
            'nomor_rekening' => $validated['nomor_rekening'],
            'nominal_tagihan' => $validated['nominal_tagihan'],
            'deskripsi' => $validated['deskripsi'],
            'status_dibayar' => false,
        ]);

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function markAsPaid($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->status_dibayar = true;
        $tagihan->save();

        return redirect()->route('tagihan.index')->with('success', 'Tagihan telah ditandai sebagai dibayar.');
    }
}