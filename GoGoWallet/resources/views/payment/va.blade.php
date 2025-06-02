<!-- filepath: resources/views/payment/va.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Virtual Account - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>
<body>
    <div class="transfer-container">
        <header class="transfer-header">
            <a href="{{ url('/dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>
                <i class="fas fa-credit-card text-green-500"></i>
                Pembayaran Virtual Account
            </h1>
        </header>
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-center">
                <i class="fas fa-times-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif
        <div class="transfer-card">
            <form action="{{ route('pembayaran.checkVa') }}" method="POST" class="transfer-form">
                @csrf
                <div class="form-group">
                    <label for="virtual_account">Virtual Account Tujuan</label>
                    <div class="input-group">
                        <input 
                            type="text" 
                            id="virtual_account" 
                            name="virtual_account" 
                            required
                            placeholder="Masukkan nomor virtual account"
                            class="@error('virtual_account') border-red-500 @enderror"
                        >
                    </div>
                    @error('virtual_account')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="submit-button">
                    <span>Lanjut</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</body>
</html>