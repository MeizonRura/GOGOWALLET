<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil | GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/paysuccess.css') }}">
</head>
<body>
    <div class="transfer-container">
        <div class="success-bg">
            <div class="success-anim">
                <i class="fas fa-check-circle success-icon"></i>
            </div>
            <h2>Pembayaran Berhasil!</h2>
            <p>
                Transaksi Virtual Account kamu telah <strong>berhasil diproses</strong>.<br>
                Terima kasih sudah menggunakan <strong>GoGoWallet</strong>.<br>
                Kamu bisa cek detail transaksi di halaman riwayat pembayaran.
            </p>
            <div class="success-btn-group">
                <a href="{{ route('dashboard') }}" class="submit-button primary">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('pembayaran.index') }}" class="submit-button secondary">
                    <i class="fas fa-receipt"></i> Lihat Riwayat Pembayaran
                </a>
            </div>
        </div>
    </div>
</body>
</html>
