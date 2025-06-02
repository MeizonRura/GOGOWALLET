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
        $request->validate([
            'nama_pelanggan' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        Tagihan::create($request->all());
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dibuat.');
    }

    public function markAsPaid($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->status_dibayar = true;
        $tagihan->save();

        return redirect()->route('tagihan.index')->with('success', 'Tagihan telah ditandai sebagai dibayar.');
    }

}
