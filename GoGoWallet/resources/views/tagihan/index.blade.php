<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tagihan.css') }}">
</head>
<body>
    <div class="tagihan-container">
        <header class="tagihan-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Daftar Tagihan</h1>
        </header>

        <div class="tagihan-card">
            <div class="header-actions">
                <h2>Tagihan Anda</h2>
                <a href="{{ route('tagihan.create') }}" class="create-button">
                    <i class="fas fa-plus"></i>
                    <span>Buat Tagihan</span>
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="tagihan-list">
                @forelse ($tagihans as $tagihan)
                    <div class="tagihan-item">
                        <div class="tagihan-info">
                            <div class="tagihan-details">
                                <h3>{{ $tagihan->nama_rekening }}</h3>
                                <p class="account-number">{{ $tagihan->nomor_rekening }}</p>
                                <p class="description">{{ $tagihan->deskripsi }}</p>
                            </div>
                            <div class="tagihan-amount">
                                <span class="amount">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</span>
                                <span class="status {{ $tagihan->status_dibayar ? 'paid' : 'unpaid' }}">
                                    {{ $tagihan->status_dibayar ? 'Dibayar' : 'Belum Dibayar' }}
                                </span>
                            </div>
                        </div>
                        @if (!$tagihan->status_dibayar)
                            <form action="{{ route('tagihan.markAsPaid', $tagihan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="pay-button">
                                    <span>Tandai Sudah Dibayar</span>
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="no-tagihan">
                        <i class="fas fa-file-invoice"></i>
                        <p>Belum ada tagihan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>