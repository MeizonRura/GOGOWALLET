
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Account Payment - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/transfer.css') }}">
</head>
<body>
    <div class="transfer-container">
        <!-- Header with back button -->
        <header class="transfer-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Virtual Account Payment</h1>
        </header>

        <div class="transfer-card">
            <!-- Sender info -->
            <div class="sender-info">
                <div class="account-balance">
                    <span class="label">Saldo Tersedia</span>
                    <span class="amount">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</span>
                </div>
                <div class="account-number">
                    <span class="label">Nomor Rekening Anda</span>
                    <span class="number">{{ Auth::user()->account_number }}</span>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="vaForm" action="{{ route('pembayaran.checkVa') }}" method="POST" class="transfer-form">
                @csrf
                <div class="form-group">
                    <label for="virtual_account">Virtual Account Number</label>
                    <div class="input-group">
                        <input type="text" 
                               id="virtual_account" 
                               name="virtual_account" 
                               required
                               value="{{ old('virtual_account') }}" 
                               placeholder="Masukkan nomor Virtual Account"/>
                    </div>
                    @error('virtual_account')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="submit-button">
                    <span>Lanjut</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

                @if(session('error'))
                    <p class="error-text">{{ session('error') }}</p>
                @endif
            </form>
        </div>
    </div>
</body>
</html>
