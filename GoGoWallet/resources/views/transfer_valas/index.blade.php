<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Valas - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/transfer-valas.css') }}">
</head>
<body>
    <div class="transfer-container">
        <!-- Header with back button -->
        <header class="transfer-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Transfer Valas</h1>
        </header>

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

        <!-- Error messages -->
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main transfer form -->
        <div class="transfer-card">
            <!-- Transfer form -->
            <form action="{{ route('transfer-valas.store') }}" method="POST" class="transfer-form" id="valasForm">
                @csrf
                <div class="form-group">
                    <label for="currency">Pilih Mata Uang</label>
                    <select name="currency" id="currency" class="form-select" required>
                        <option value="">Pilih mata uang</option>
                        <option value="USD">USD - Dollar Amerika</option>
                        <option value="SGD">SGD - Dollar Singapura</option>
                        <option value="JPY">JPY - Yen Jepang</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount_idr">Jumlah dalam Rupiah</label>
                    <div class="input-group currency">
                        <span class="currency-symbol">Rp</span>
                        <input 
                            type="number" 
                            id="amount_idr" 
                            name="amount_idr" 
                            required
                            placeholder="0"
                            min="10000"
                            step="1000"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="exchange_rate">Rate Tukar (1 Valas = IDR)</label>
                    <div class="input-group currency">
                        <span class="currency-symbol">Rp</span>
                        <input 
                            type="number" 
                            id="exchange_rate" 
                            name="exchange_rate" 
                            required
                            placeholder="0"
                            step="0.01"
                            readonly
                            class="readonly-input"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="amount_valas">Jumlah dalam Valas</label>
                    <div class="input-group currency">
                        <span class="currency-symbol" id="selected-currency-symbol">$</span>
                        <input 
                            type="number" 
                            id="amount_valas" 
                            name="amount_valas" 
                            readonly
                            placeholder="0"
                            step="0.01"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipient_bank">Bank Tujuan</label>
                    <select name="recipient_bank" id="recipient_bank" class="form-select" required>
                        <option value="">Pilih bank tujuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="recipient_account">Nomor Rekening Tujuan</label>
                    <div class="input-group">
                        <input 
                            type="text" 
                            id="recipient_account" 
                            name="account_number" 
                            required
                            placeholder="Masukkan nomor rekening tujuan"
                        >
                    </div>
                </div>

                <div class="quick-amounts">
                    <h3>Transfer Cepat</h3>
                    <div class="amount-grid">
                        <button type="button" class="amount-item" onclick="setAmount(100000)">Rp 100.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(500000)">Rp 500.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(1000000)">Rp 1.000.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(2500000)">Rp 2.500.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(5000000)">Rp 5.000.000</button>
                        <button type="button" class="amount-item" onclick="setAmount(10000000)">Rp 10.000.000</button>
                    </div>
                </div>

                <button type="submit" class="submit-button">
                    <span>Lanjutkan Transfer</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Quick amounts -->
            
        </div>
    </div>

    <script>
        // Exchange rates (in real app, these would come from an API)
        const exchangeRates = {
            'USD': 15500,
            'SGD': 11500,
            'JPY': 105
        };

        // Bank lists per currency
        const banksByCountry = {
            'USD': [
                { code: 'chase', name: 'Chase Bank' },
                { code: 'citi', name: 'Citibank' },
                { code: 'boa', name: 'Bank of America' }
            ],
            'SGD': [
                { code: 'dbs', name: 'DBS Bank' },
                { code: 'ocbc', name: 'OCBC Bank' },
                { code: 'uob', name: 'UOB Bank' }
            ],
            'JPY': [
                { code: 'mufg', name: 'MUFG Bank' },
                { code: 'mizuho', name: 'Mizuho Bank' },
                { code: 'smbc', name: 'SMBC Bank' }
            ]
        };

        // Currency symbols
        const currencySymbols = {
            'USD': '$',
            'SGD': 'S$',
            'JPY': '¥'
        };

        document.getElementById('currency').addEventListener('change', function() {
            const selectedCurrency = this.value;
            if (!selectedCurrency) return;

            // Update exchange rate
            document.getElementById('exchange_rate').value = exchangeRates[selectedCurrency];
            
            // Update currency symbol
            document.getElementById('selected-currency-symbol').textContent = currencySymbols[selectedCurrency];
            
            // Update bank options
            updateBankOptions(selectedCurrency);
            
            // Recalculate amount if IDR is already filled
            calculateConversion();
        });

        document.getElementById('amount_idr').addEventListener('input', calculateConversion);
        document.getElementById('exchange_rate').addEventListener('input', calculateConversion);

        function setAmount(amount) {
            document.getElementById('amount_idr').value = amount;
            calculateConversion();
        }

        function calculateConversion() {
            const amountIDR = parseFloat(document.getElementById('amount_idr').value) || 0;
            const exchangeRate = parseFloat(document.getElementById('exchange_rate').value) || 0;
            
            if (amountIDR && exchangeRate) {
                const amountValas = amountIDR / exchangeRate;
                document.getElementById('amount_valas').value = amountValas.toFixed(2);
            }
        }

        function updateBankOptions(currency) {
            const bankSelect = document.getElementById('recipient_bank');
            const banks = banksByCountry[currency];
            
            // Clear existing options except first one
            bankSelect.innerHTML = '<option value="">Pilih bank tujuan</option>';
            
            // Add new options based on selected currency
            banks.forEach(bank => {
                const option = document.createElement('option');
                option.value = bank.code;
                option.textContent = bank.name;
                bankSelect.appendChild(option);
            });
        }

        document.getElementById('valasForm').addEventListener('submit', function(e) {
            const amount = parseFloat(document.getElementById('amount_idr').value);
            const balance = parseFloat('{{ auth()->user()->balance }}');
            
            if (amount > balance) {
                e.preventDefault();
                alert('Saldo anda tidak mencukupi untuk melakukan transfer ini');
            }
        });
    </script>
</body>
</html>
