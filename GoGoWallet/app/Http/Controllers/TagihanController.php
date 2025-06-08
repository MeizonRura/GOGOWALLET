<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    public function index()
    {
        // Get tagihan that I created (sent)
        $tagihanTerkirim = Tagihan::where('user_id', auth()->id())
            ->latest()  // Remove status_dibayar filter
            ->get();

        // Get tagihan addressed to my account number (received)
        $tagihanKepadaSaya = Tagihan::where('nomor_rekening', auth()->user()->account_number)
            ->latest()  // Remove status_dibayar filter
            ->get();
        
        return view('tagihan.index', compact('tagihanKepadaSaya', 'tagihanTerkirim'));
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
            'user_id' => auth()->id(),
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
        $tagihan->status_dibayar = true;
        $tagihan->save();

        return redirect()->route('tagihan.index')
            ->with('success', 'Tagihan telah ditandai sebagai dibayar.');
    }

    public function bayar($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $user = auth()->user();

        // Verify this bill is for current user
        if ($tagihan->nomor_rekening !== $user->account_number) {
            return back()->withErrors([
                'general' => 'Tagihan ini bukan untuk Anda'
            ]);
        }

        // Check if bill is already paid
        if ($tagihan->status_dibayar) {
            return back()->withErrors([
                'general' => 'Tagihan ini sudah dibayar'
            ]);
        }

        // Check if user has sufficient balance
        if ($user->balance < $tagihan->nominal_tagihan) {
            return back()->withErrors([
                'general' => 'Saldo Anda tidak mencukupi untuk membayar tagihan ini'
            ]);
        }

        try {
            DB::beginTransaction();

            // Deduct from payer's balance
            $user->balance -= $tagihan->nominal_tagihan;
            $user->save();

            // Add to biller's balance
            $penagih = User::find($tagihan->user_id);
            $penagih->balance += $tagihan->nominal_tagihan;
            $penagih->save();

            // Mark bill as paid
            $tagihan->status_dibayar = true;
            $tagihan->save();

            DB::commit();
            return redirect()->route('tagihan.index')
                ->with('success', 'Tagihan berhasil dibayar');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'general' => 'Terjadi kesalahan saat memproses pembayaran'
            ]);
        }
    }
    
    public function tolak($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        
        // Verify this bill is for current user
        if ($tagihan->nomor_rekening !== auth()->user()->account_number) {
            return back()->withErrors(['general' => 'Tagihan ini bukan untuk Anda']);
        }

        // Update tagihan status to rejected instead of deleting
        $tagihan->update([
            'status_dibayar' => false,
            'status' => 'ditolak'
        ]);

        return redirect()->route('tagihan.index')
            ->with('success', 'Tagihan berhasil ditolak');
    }
}