<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer - GoGoWallet</title>
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
            <h1>Transfer Rupiah</h1>
        </header>

        <!-- Main transfer form -->
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

            <!-- Error messages with margin -->
            @if ($errors->any())
                <div class="alert alert-error" style="margin-bottom: 2rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Transfer form -->
            <form action="{{ route('transfer.process') }}" method="POST" class="transfer-form">
                @csrf
                <div class="form-group">
                    <label for="recipient_account">Nomor Rekening Tujuan</label>
                    <div class="input-group">
                        <input 
                            type="text" 
                            id="recipient_account" 
                            name="recipient_account" 
                            required
                            placeholder="Masukkan nomor rekening tujuan"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="amount">Jumlah Transfer</label>
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

                <!-- Quick amounts moved here -->
                <div class="quick-amounts">
                    <h3>Transfer Cepat</h3>
                    <div class="amount-grid">
                        <button type="button" class="amount-item" onclick="setAmount(50000)">Rp 50.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(100000)">Rp 100.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(250000)">Rp 250.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(500000)">Rp 500.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(1000000)">Rp 1.000.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(2500000)">Rp 2.500.000</button>
                    </div>
                </div>

                <!-- Added margin-top here -->
                <div class="form-group" style="margin-top: 2rem;">
                    <label for="note">Catatan (Opsional)</label>
                    <textarea 
                        id="note" 
                        name="note" 
                        placeholder="Tambahkan catatan untuk penerima"
                        maxlength="100"
                    ></textarea>
                </div>

                <button type="submit" class="submit-button">
                    <span>Lanjutkan Transfer</span>
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