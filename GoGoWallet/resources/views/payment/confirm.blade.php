<!-- filepath: resources/views/payment/confirm.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran VA - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>
<body>
    <div class="transfer-container">
        <header class="transfer-header">
            <a href="{{ route('pembayaran.va') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>
                <i class="fas fa-credit-card text-green-500"></i>
                Konfirmasi Pembayaran
            </h1>
        </header>
        <div class="transfer-card">
            <div class="sender-info mb-6">
                <div class="account-balance">
                    <span class="label">Saldo Tersedia</span>
                    <span class="amount">Rp {{ number_format($user->balance, 0, ',', '.') }}</span>
                </div>
                <div class="account-number">
                    <span class="label">No. Akun Anda</span>
                    <span class="number">{{ auth()->user()->account_number ?? '-' }}</span>
                </div>
            </div>
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-center">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            @if($user->balance < session('payment_amount'))
                <div class="alert alert-error">
                    Saldo Anda tidak mencukupi untuk melakukan pembayaran ini
                </div>
            @endif
            <form action="{{ route('pembayaran.store') }}" method="POST" class="transfer-form">
                @csrf
                <input type="hidden" name="virtual_account" value="{{ $virtual_account }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <div class="form-group">
                    <label>Virtual Account Tujuan</label>
                    <div class="input-group">
                        <input type="text" value="{{ $virtual_account }}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nominal Pembayaran</label>
                    <div class="input-group currency">
                        <span class="currency-symbol">Rp</span>
                        <input type="text" value="{{ number_format($amount,0,',','.') }}" disabled>
                    </div>
                </div>
                <button type="submit" class="submit-button">
                    <span>Bayar Sekarang</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>