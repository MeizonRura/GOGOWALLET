<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="dashboard">


<div class="top-header">
    @if(file_exists(public_path('images/logo.png')))
        <img src="{{ asset('images/logo.png') }}" alt="GoWallet" class="logo">
    @else 
        <span class="text-xl font-bold">GoWallet</span>
    @endif
    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit" class="logout-button">
            <i class="fas fa-door-open text-xl"></i>
        </button>
    </form>
</div>

<!-- Main Content -->
<main class="dashboard-content">
    <!-- User Info and Balance Section -->
    <div class="user-balance-section">
        <!-- User Profile Card -->
        <div class="profile-card">
            <div class="profile-wrapper">
                @if(auth()->user()->profile_photo && Storage::disk('public')->exists(auth()->user()->profile_photo))
                    <img src="{{ Storage::url(auth()->user()->profile_photo) }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="profile-image">
                @else
                    <div class="profile-image flex items-center justify-center bg-gray-200">
                        <i class="fas fa-user text-gray-400 text-2xl"></i>
                    </div>
                @endif
                <div class="profile-info">
                    <p class="welcome-text">Hii, {{ auth()->user()->name }}</p>
                    <p class="account-number">{{ auth()->user()->account_number }}</p>
                </div>
            </div>
        </div>
        <div class="balance-card">
            <div class="balance-wrapper">
                <div class="balance-info">
                    <p class="balance-label">Saldo Anda</p>
                    <p class="balance-amount">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
                </div>
                <button onclick="window.location.href='{{ route('topup') }}'" class="topup-button">
                    <i class="fas fa-plus-circle"></i>
                    <span>Top Up Saldo</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions Container -->
    <div class="quick-actions-container">
        <!-- Top Row: Transfer Rupiah, Transfer Valas, and Payment -->
        <div class="quick-actions-row">
            <!-- Transfer Rupiah -->
            <div class="action-card" onclick="window.location.href='{{ route('transfer') }}'">
                <div class="action-icon transfer-icon">
                    <i class="fas fa-paper-plane text-2xl"></i>
                </div>
                <h3 class="action-title">Transfer Rupiah</h3>
                <p class="action-description">Kirim uang dengan cepat</p>
            </div>

            <!-- Transfer Valas -->
            <a href="{{ route('transfer-valas.index') }}" class="action-card hover:shadow-lg transition">
                <div class="action-icon valas-icon">
                    <i class="fas fa-globe-asia text-2xl"></i>
                </div>
                <h3 class="action-title">Transfer Valas</h3>
                <p class="action-description">Kirim mata uang asing</p>
            </a>

            <!-- Payment -->
            <a href="{{ route('pembayaran.va') }}" class="action-card hover:bg-blue-50 transition">
                <div class="action-icon payment-icon">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
                <h3 class="action-title">Pembayaran</h3>
                <p class="action-description">Bayar tagihan & layanan</p>
            </a>
        </div>

        <!-- Bottom Row: Billing and Loan (Centered) -->
        <div class="quick-actions-row-bottom">
            <!-- Billing -->
<a href="{{ route('tagihan.index') }}">
    <div class="action-card">
        <div class="action-icon billing-icon">
            <i class="fas fa-file-invoice text-2xl"></i>
        </div>
        <h3 class="action-title">Tagih Uang</h3>
        <p class="action-description">tagih Uang anda dengan cepat</p>
    </div>
</a>



            <!-- Loan -->
            <div class="action-card">
                <div class="action-icon loan-icon">
                    <i class="fas fa-hand-holding-usd text-2xl"></i>
                </div>
                <h3 class="action-title">Pinjaman</h3>
                <p class="action-description">Pinjaman dana cepat</p>
            </div>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="transactions">
        <h2 class="transactions-title">Transaksi Terakhir</h2>
        
        <!-- Success Notification -->
        @if(session('success'))
            <div class="success-notification">
                <div class="notification-content">
                    <i class="fas fa-check-circle"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Transaction List -->
        @if(count($transactions ?? []) > 0)
            <div class="transaction-list">
                @foreach($transactions as $transaction)
                    @if($transaction instanceof \App\Models\TransferValas)
                    <!-- Valas Transaction -->
                    <div class="transaction-item">
                        <div class="transaction-info">
                            <div class="transaction-icon valas">
                                <i class="fas fa-globe-asia"></i>
                            </div>
                            <div class="transaction-details">
                                <span class="transaction-name">Transfer Valas ke {{ $transaction->recipient_bank }}</span>
                                <span class="transaction-date">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                                <span class="transaction-currency">{{ $transaction->amount_valas }} {{ $transaction->currency }}</span>
                            </div>
                        </div>
                        <span class="transaction-amount amount-debit">-Rp {{ number_format($transaction->amount_idr, 0, ',', '.') }}</span>
                    </div>
                    @else
                    <!-- Regular Transaction -->
                    <div class="transaction-item">
                        <div class="transaction-info">
                            <div class="transaction-icon {{ $transaction->type == 'credit' ? 'credit' : 'debit' }}">
                                <i class="fas fa-{{ $transaction->type == 'credit' ? 'arrow-down' : 'arrow-up' }}"></i>
                            </div>
                            <div class="transaction-details">
                                <span class="transaction-name">{{ $transaction->description }}</span>
                                <span class="transaction-date">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                        <span class="transaction-amount {{ $transaction->type == 'credit' ? 'amount-credit' : 'amount-debit' }}">
                            {{ $transaction->type == 'credit' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </span>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            @if(!session('success'))
            <div class="no-transactions">
                <i class="fas fa-receipt"></i>
                <p>Belum ada transaksi</p>
            </div>
            @endif
        @endif
    </div>
</main>
</body>
</html>
