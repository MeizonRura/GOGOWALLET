<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/topup.css') }}">
</head>
<body>
    <div class="topup-container">
        <!-- Header with back button -->
        <header class="topup-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Top Up Saldo</h1>
        </header>

        <!-- Main content -->
        <div class="topup-card">
            <div class="balance-info">
                <span class="balance-label">Saldo Saat Ini</span>
                <span class="balance-amount">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
            </div>

            <form action="{{ route('topup.process') }}" method="POST" class="topup-form">
                @csrf
                <!-- Amount Input -->
                <div class="form-group">
                    <label class="form-label">Nominal Top Up</label>
                    <div class="amount-input">
                        <span class="currency-symbol">Rp</span>
                        <input 
                            type="number" 
                            name="amount" 
                            id="amount" 
                            min="10000" 
                            step="1000"
                            required
                            placeholder="0"
                        >
                    </div>
                </div>

                <!-- Quick Amount Selection -->
                <div class="form-section">
                    <div class="section-label">Top Up Cepat</div>
                    <div class="quick-amounts">
                        <button type="button" class="amount-item" onclick="setAmount(50000)">Rp 50.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(100000)">Rp 100.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(250000)">Rp 250.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(500000)">Rp 500.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(1000000)">Rp 1.000.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(2500000)">Rp 2.500.000</button>
                    </div>
                </div>

                <!-- Bank Selection -->
                <div class="form-section">
                    <div class="section-label">Pilih Metode Pembayaran</div>
                    <div class="bank-options">
                        <label class="bank-option">
                            <input type="radio" name="bank" value="bca" required>
                            <div class="bank-card">
                                <img src="{{ asset('images/bca.jpg') }}" alt="BCA">
                                <span>BCA</span>
                            </div>
                        </label>
                        
                        <label class="bank-option">
                            <input type="radio" name="bank" value="bni" required>
                            <div class="bank-card">
                                <img src="{{ asset('images/bni.png') }}" alt="BNI">
                                <span>BNI</span>
                            </div>
                        </label>
                        
                        <label class="bank-option">
                            <input type="radio" name="bank" value="mandiri" required>
                            <div class="bank-card">
                                <img src="{{ asset('images/mandiri.png') }}" alt="Mandiri">
                                <span>Mandiri</span>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="submit-button">
                    <span>Lanjutkan Top Up</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function setAmount(amount) {
            document.getElementById('amount').value = amount;
        }
    </script>
</body>
</html>