<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil | GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .transfer-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .success-bg {
            background: linear-gradient(135deg, #00bd6f 0%, #009d5c 100%);
            color: #fff;
            border-radius: 20px;
            padding: 2.5rem 2rem 2rem 2rem;
            box-shadow: 0 8px 32px rgba(0, 189, 111, 0.10);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .success-anim {
            animation: pop 0.6s cubic-bezier(.68, -0.55, .27, 1.55);
            margin-bottom: 1rem;
        }

        .success-icon {
            font-size: 4rem;
            color: #fff;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            padding: 0.5rem;
            box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.15);
        }

        @keyframes pop {
            0% { transform: scale(0.5); opacity: 0; }
            80% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); }
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }

        p {
            font-size: 1.1rem;
            line-height: 1.7;
            opacity: 0.97;
            margin-bottom: 2rem;
        }

        .success-btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .submit-button {
            min-width: 180px;
            font-size: 1rem;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 10px;
            text-decoration: none !important;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-button i {
            margin-right: 8px;
        }

        .submit-button.primary {
            background: linear-gradient(90deg, #00e676 0%, #00c853 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(0, 189, 111, 0.15);
        }

        .submit-button.primary:hover {
            background: linear-gradient(90deg, #00c853 0%, #00e676 100%);
            box-shadow: 0 4px 16px rgba(0, 189, 111, 0.18);
        }

        .submit-button.secondary {
            background: #fff;
            color: #00bd6f;
            border: 2px solid #00bd6f;
        }

        .submit-button.secondary:hover {
            background: #f0fdf4;
            color: #009d5c;
            border-color: #009d5c;
        }

        @media (max-width: 480px) {
            .success-bg { padding: 2rem 1rem; }
            .success-btn-group { flex-direction: column; gap: 0.75rem; }
        }
    </style>
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
