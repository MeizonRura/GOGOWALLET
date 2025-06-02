@extends('layouts.app')

@section('content')
<h1>Daftar Tagihan</h1>
<a href="{{ route('tagihan.create') }}">+ Tambah Tagihan</a>
<table border="1" cellpadding="10">
    <tr>
        <th>Pelanggan</th>
        <th>Deskripsi</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    @foreach ($tagihans as $tagihan)
        <tr>
            <td>{{ $tagihan->nama_pelanggan }}</td>
            <td>{{ $tagihan->deskripsi }}</td>
            <td>Rp{{ number_format($tagihan->jumlah, 2, ',', '.') }}</td>
            <td>{{ $tagihan->status_dibayar ? 'Dibayar' : 'Belum Dibayar' }}</td>
            <td>
                @if (!$tagihan->status_dibayar)
                    <form action="{{ route('tagihan.markAsPaid', $tagihan->id) }}" method="POST">
                        @csrf
                        <button type="submit">Tandai Dibayar</button>
                    </form>
                @else
                    <span>✔</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>
@endsection
