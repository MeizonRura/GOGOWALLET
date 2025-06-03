@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-12">
    <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-green-400">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Daftar Tagihan</h1>
            <a href="{{ route('tagihan.create') }}" class="px-6 py-2 bg-green-500 text-white rounded-xl shadow hover:bg-green-600 transition font-semibold text-lg">
                Buat Tagihan
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300 text-center font-medium shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full border-separate border-spacing-y-2">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-bold text-gray-700">Nama Rekening</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-700">Nomor Rekening</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-700">Nominal Tagihan</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-700">Deskripsi</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tagihans as $tagihan)
                        <tr class="bg-white hover:bg-green-50 transition rounded-xl shadow-sm border-b border-gray-100">
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $tagihan->nama_rekening }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $tagihan->nomor_rekening }}</td>
                            <td class="px-6 py-4 text-green-700 font-bold">Rp{{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $tagihan->deskripsi }}</td>
                            <td class="px-6 py-4">
                                @if($tagihan->status_dibayar)
                                    <span class="inline-block px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold shadow-sm">Dibayar</span>
                                @else
                                    <span class="inline-block px-4 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold shadow-sm">Belum Dibayar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if (!$tagihan->status_dibayar)
                                    <form action="{{ route('tagihan.markAsPaid', $tagihan->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-5 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600 transition font-semibold shadow">
                                            Tandai Dibayar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-500 text-2xl font-bold">✔</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-400">Belum ada tagihan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection