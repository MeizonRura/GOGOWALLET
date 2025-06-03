@extends('layouts.app')

@section('title', 'Buat Tagihan')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 border-2 border-green-400">
        <h2 class="text-2xl font-bold text-gray-800 mb-1 text-center">Buat Tagihan</h2>
        <p class="text-gray-500 text-center mb-8">Kelola keuangan Anda dengan mudah</p>

        {{-- Tampilkan error validasi jika ada --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tagihan.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="nama_rekening">Nama Rekening</label>
                <input type="text" name="nama_rekening" id="nama_rekening" placeholder="Masukkan nama rekening"
                    value="{{ old('nama_rekening') }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 bg-gray-50" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="nomor_rekening">Nomor Rekening</label>
                <input type="text" name="nomor_rekening" id="nomor_rekening" placeholder="Masukkan nomor rekening"
                    value="{{ old('nomor_rekening') }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 bg-gray-50" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="nominal_tagihan">Nominal Tagihan (Rp)</label>
                <div class="flex items-center">
                    <span class="px-3 py-3 bg-gray-50 border border-gray-200 rounded-l-xl text-gray-500">Rp</span>
                    <input type="number" name="nominal_tagihan" id="nominal_tagihan" min="0"
                        value="{{ old('nominal_tagihan', 0) }}"
                        class="w-full px-4 py-3 border-t border-b border-r border-gray-200 rounded-r-xl focus:outline-none focus:ring-2 focus:ring-green-400 bg-gray-50" required>
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Deskripsikan tagihan atau layanan..."
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-400 bg-gray-50">{{ old('deskripsi') }}</textarea>
            </div>
            
            <div class="flex gap-4 mt-6">
                <a href="{{ route('tagihan.index') }}"
                    class="w-1/2 text-center py-3 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">Batal</a>
                <button type="submit"
                    class="w-1/2 py-3 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection