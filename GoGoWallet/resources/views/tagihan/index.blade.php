<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tagihan.css') }}">
</head>
<body>
    <div class="tagihan-container">
        <header class="tagihan-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Tagihan</h1>
        </header>

        <div class="tagihan-card">
            <div class="header-actions">
                <div class="tab-container">
                    <button class="tab-button active" onclick="switchTab('buat')">
                        <i class="fas fa-plus"></i>
                        Buat Tagihan
                    </button>
                    <button class="tab-button" onclick="switchTab('terima')">
                        <i class="fas fa-download"></i>
                        Tagihan Masuk
                    </button>
                    <button class="tab-button" onclick="switchTab('kirim')">
                        <i class="fas fa-upload"></i>
                        Tagihan Terkirim
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tab Buat Tagihan -->
            <div id="buat-tab" class="tab-content active">
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
                        <h3>Nominal Cepat</h3>
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

            <!-- Tab Tagihan Masuk -->
            <div id="terima-tab" class="tab-content">
                <div class="tagihan-list">
                    @forelse ($tagihanKepadaSaya as $tagihan)
                        <div class="tagihan-item">
                            <div class="tagihan-info">
                                <div class="tagihan-details">
                                    <h3>Tagihan dari {{ $tagihan->user->name }}</h3>
                                    <p class="description">{{ $tagihan->deskripsi }}</p>
                                    <p class="date">{{ $tagihan->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="tagihan-amount">
                                    <span class="amount">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</span>
                                    <span class="status {{ $tagihan->status_dibayar ? 'paid' : 'unpaid' }}">
                                        {{ $tagihan->status_dibayar ? 'Dibayar' : 'Belum Dibayar' }}
                                    </span>
                                </div>
                            </div>
                            @if (!$tagihan->status_dibayar)
                                <form action="{{ route('tagihan.bayar', $tagihan->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="pay-button">
                                        <span>Bayar Sekarang</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="no-tagihan">
                            <i class="fas fa-inbox"></i>
                            <p>Tidak ada tagihan masuk</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab Tagihan Terkirim -->
            <div id="kirim-tab" class="tab-content">
                <div class="tagihan-list">
                    @forelse ($tagihanTerkirim as $tagihan)
                        <div class="tagihan-item">
                            <div class="tagihan-info">
                                <div class="tagihan-details">
                                    <h3>Tagihan ke {{ $tagihan->nomor_rekening }}</h3>
                                    <p class="description">{{ $tagihan->deskripsi }}</p>
                                    <p class="date">{{ $tagihan->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="tagihan-amount">
                                    <span class="amount">Rp {{ number_format($tagihan->nominal_tagihan, 0, ',', '.') }}</span>
                                    <span class="status {{ $tagihan->status_dibayar ? 'paid' : 'unpaid' }}">
                                        {{ $tagihan->status_dibayar ? 'Dibayar' : 'Belum Dibayar' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-tagihan">
                            <i class="fas fa-paper-plane"></i>
                            <p>Belum ada tagihan terkirim</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Deactivate all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            
            // Show selected tab content and activate button
            document.getElementById(tabName + '-tab').classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>