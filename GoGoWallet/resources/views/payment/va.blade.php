<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Virtual Account Payment - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/va.css') }}" />
</head>
<body>

    <div class="va-container">
        <header class="va-header">
            <a href="{{ url('/dashboard') }}" aria-label="Back to dashboard">
                <i class="fas fa-arrow-left fa-lg"></i>
            </a>
            <h1>
                <i class="fas fa-credit-card text-green-500"></i>
                Virtual Account Payment
            </h1>
        </header>

        <div class="balance-box" role="region" aria-label="Saldo Anda">
            <span class="balance-label">Saldo Anda</span>
            <span class="balance-amount">
                Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
            </span>
        </div>

        <form id="vaForm" action="{{ route('pembayaran.store') }}" method="POST" autocomplete="off" novalidate>
            @csrf

            <div class="form-group">
                <label for="virtual_account">Virtual Account Number</label>
                <input type="text" id="virtual_account" name="virtual_account" required
                    value="{{ old('virtual_account') }}" aria-describedby="va-error" />
                @error('virtual_account')
                    <p id="va-error" class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-4">
                <label for="amount">Amount</label>
                <input type="text" id="amount" name="amount" readonly aria-live="polite" />
                <p id="va-message" class="error-text" aria-live="assertive"></p>
            </div>

            <button type="submit">Lanjut</button>

            @if(session('error'))
                <p class="session-error">{{ session('error') }}</p>
            @endif
        </form>
    </div>

    <script>
        const vaInput = document.getElementById('virtual_account');
        const amountInput = document.getElementById('amount');
        const vaMessage = document.getElementById('va-message');
        const form = document.getElementById('vaForm');

        vaInput.addEventListener('blur', function () {
            const va = this.value.trim();
            if (va.length > 0) {
                fetch(`/api/va-info?va=${encodeURIComponent(va)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            amountInput.value = data.amount;
                            vaMessage.textContent = '';
                        } else {
                            amountInput.value = '';
                            vaMessage.textContent = data.message;
                        }
                    })
                    .catch(() => {
                        amountInput.value = '';
                        vaMessage.textContent = 'Gagal mengambil info VA. Coba lagi.';
                    });
            } else {
                amountInput.value = '';
                vaMessage.textContent = '';
            }
        });

        form.addEventListener('submit', function (e) {
            if (!amountInput.value) {
                e.preventDefault();
                vaMessage.textContent = 'Silakan masukkan VA yang valid!';
                vaInput.focus();
            }
        });
    </script>

</body>
</html>
