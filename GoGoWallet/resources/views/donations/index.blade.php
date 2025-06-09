<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Donasi.css') }}">
</head>
<body>
    <div class="transfer-container">
        <!-- Header with back button -->
        <header class="transfer-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Donasi</h1>
        </header>

        <div class="transfer-card">
            <!-- Sender info -->
            <div class="sender-info">
                <div class="account-balance">
                    <span class="label">Saldo Tersedia</span>
                    <span class="amount">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
                </div>
                <div class="account-number">
                    <span class="label">Nomor Rekening Anda</span>
                    <span class="number">{{ auth()->user()->account_number }}</span>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <form action="{{ url('/donasi') }}" method="POST" class="transfer-form">
                @csrf
                <div class="form-group">
                    <label for="rekening_tujuan">Rekening Tujuan</label>
                    <select name="rekening_tujuan" id="rekening_tujuan" class="form-select" required>
                        <option value="">-- Pilih Rekening Donasi --</option>
                        <option value="Dompet Yatim">Dompet Yatim</option>
                        <option value="Bencana Alam">Bencana Alam</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount">Jumlah Donasi</label>
                    <div class="input-group currency">
                        <span class="currency-symbol">Rp</span>
                        <input 
                            type="number" 
                            id="amount" 
                            name="amount" 
                            required
                            placeholder="0"
                            min="10000"
                            step="1000"
                        >
                    </div>
                </div>

                <!-- Quick amounts -->
                <div class="quick-amounts">
                    <h3>Donasi Cepat</h3>
                    <div class="amount-grid">
                        <button type="button" class="amount-item" onclick="setAmount(50000)">Rp 50.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(100000)">Rp 100.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(250000)">Rp 250.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(500000)">Rp 500.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(1000000)">Rp 1.000.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(2500000)">Rp 2.500.000</button>
                    </div>
                </div>

                <button type="submit" class="submit-button">
                    <span>Lanjutkan Donasi</span>
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
