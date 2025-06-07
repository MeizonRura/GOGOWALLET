<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferValas;
use Illuminate\Support\Facades\Auth;

class ValasController extends Controller
{
    public function index()
    {
        return view('transfer_valas.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string',
            'recipient_bank' => 'required|string',
            'currency' => 'required|in:USD,SGD,JPY',
            'amount_idr' => 'required|numeric|min:10000',
            'exchange_rate' => 'required|numeric',
            'amount_valas' => 'required|numeric'
        ]);

        TransferValas::create([
            'user_id' => Auth::id(),
            'account_number' => $request->account_number,
            'recipient_bank' => $request->recipient_bank,
            'currency' => $request->currency,
            'amount_idr' => $request->amount_idr,
            'exchange_rate' => $request->exchange_rate,
            'amount_valas' => $request->amount_valas
        ]);

        $user = Auth::user();
        $user->balance -= $request->amount_idr;
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', 'Transfer valas berhasil dilakukan sebesar ' . 
                $request->amount_valas . ' ' . $request->currency);
    }
}
