<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckVaController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'virtual_account' => 'required|string'
        ]);

        // Simulasi data VA, ganti dengan API eksternal jika perlu
        $data = [
            '1234567890' => 150000,
            '9876543210' => 250000,
        ];

        $va = $request->virtual_account;
        if (isset($data[$va])) {
            return response()->json([
                'valid' => true,
                'amount' => $data[$va],
                'description' => 'Pembayaran untuk Virtual Account ' . $va
            ]);
        }
        return response()->json([
            'valid' => false,
            'message' => 'Virtual Account tidak ditemukan'
        ]);
    }
}