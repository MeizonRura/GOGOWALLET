@extends('layouts.app')

@section('title', 'Tambah Tagihan')

@section('content')
<div class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, #7f5af0 0%, #5f4bb6 100%);">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-lg p-8 border border-gray-200">
        <div class="bg-gradient-to-b from-purple-600 to-purple-400 rounded-t-2xl -mx-8 -mt-8 px-8 py-6 text-center mb-8">
            <h2 class="text-3xl font-bold text-white mb-2">Tambah Tagihan</h2>
            <p class="text-white text-lg">Kelola keuangan Anda dengan mudah</p>
        </div>
        <form action="{{ route('tagihan.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="recipient_name">NAMA PELANGGAN:</label>
                <input type="text" name="recipient_name" id="recipient_name" placeholder="Masukkan nama pelanggan" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 bg-gray-50" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="note">DESKRIPSI:</label>
                <textarea name="note" id="note" rows="3" placeholder="Deskripsikan tagihan atau layanan..." class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 bg-gray-50"></textarea>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="amount">JUMLAH (RP):</label>
                <div class="flex items-center">
                    <span class="px-3 py-3 bg-gray-50 border border-gray-200 rounded-l-xl text-gray-500">Rp</span>
                    <input type="number" name="amount" id="amount" min="0" value="0" class="w-full px-4 py-3 border-t border-b border-r border-gray-200 rounded-r-xl focus:outline-none focus:ring-2 focus:ring-purple-400 bg-gray-50" required>
                </div>
            </div>
            <div class="flex gap-4 mt-6">
                <a href="{{ route('tagihan.index') }}" class="w-1/2 text-center py-3 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">Batal</a>
                <button type="submit" class="w-1/2 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-purple-500 text-white font-semibold hover:from-purple-700 hover:to-purple-600 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection