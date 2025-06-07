<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferValas;
use Auth;

class ValasController extends Controller
{
    public function index()
    {
        $transfers = TransferValas::where('user_id', Auth::id())->get();
        return view('transfer_valas.index', compact('transfers'));
    }

    public function create()
    {
        return view('transfer_valas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string',
            'recipient_name' => 'required|string',
            'recipient_bank' => 'required|string',
            'currency' => 'required|in:SGD,USD,JPY',
            'amount_idr' => 'required|numeric|min:1',
            'exchange_rate' => 'required|numeric|min:0.0001',
            'amount_foreign' => 'required|numeric|min:0.01',
            'transfer_date' => 'required|date',
        ]);

        TransferValas::create([
            'user_id' => Auth::id(),
            'account_number' => $request->account_number,
            'recipient_name' => $request->recipient_name,
            'recipient_bank' => $request->recipient_bank,
            'currency' => $request->currency,
            'amount' => $request->amount_foreign,
            'exchange_rate' => $request->exchange_rate,
            'total_in_local' => $request->amount_idr,
            'transfer_date' => $request->transfer_date,
            'status' => 'pending'
        ]);

        return redirect()->route('transfer-valas.index')->with('success', 'Transfer valas berhasil ditambahkan.');
    }
}
