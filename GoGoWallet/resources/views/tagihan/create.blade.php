<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tagihan - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tagihan.css') }}">
</head>
<body>
    <div class="tagihan-container">
        <header class="tagihan-header">
            <a href="{{ route('tagihan.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Buat Tagihan</h1>
        </header>

        <div class="tagihan-card">
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tagihan.store') }}" method="POST" class="tagihan-form">
                @csrf

                <div class="form-group">
                    <label for="nomor_rekening">Nomor Rekening</label>
                    <input 
                        type="text" 
                        id="nomor_rekening" 
                        name="nomor_rekening" 
                        required
                        placeholder="Masukkan nomor rekening"
                        value="{{ old('nomor_rekening') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="nominal_tagihan">Nominal Tagihan</label>
                    <div class="input-group currency">
                        <span class="currency-symbol">Rp</span>
                        <input 
                            type="number" 
                            id="nominal_tagihan" 
                            name="nominal_tagihan" 
                            required
                            placeholder="0"
                            min="1000"
                            step="1000"
                            value="{{ old('nominal_tagihan') }}"
                        >
                    </div>
                </div>

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

                <div class="form-group" style="margin-top: 2rem;">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea 
                        id="deskripsi" 
                        name="deskripsi" 
                        placeholder="Tambahkan deskripsi tagihan"
                        required
                    >{{ old('deskripsi') }}</textarea>
                </div>

                <button type="submit" class="submit-button">
                    <span>Buat Tagihan</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function setAmount(amount) {
            document.getElementById('nominal_tagihan').value = amount;
        }
    </script>
</body>
</html>