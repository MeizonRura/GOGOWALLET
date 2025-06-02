<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoGoWallet Dashboard</title>
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
    <button class="logout-button">
        <i class="fas fa-door-open text-xl"></i>
    </button>
</div>

<!-- Main Content -->
<main class="dashboard-content">
    <!-- User Info and Balance Section -->
    <div class="user-balance-section">
        <!-- User Profile Card -->
        <div class="profile-card">
            <div class="profile-wrapper">
                @if(file_exists(public_path('images/default-avatar.png')))
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Profile" class="profile-image">
                @else
                    <div class="profile-image flex items-center justify-center bg-gray-200">
                        <i class="fas fa-user text-gray-400 text-2xl"></i>
                    </div>
                @endif
                <div class="profile-info">
                    <p class="welcome-text">Hi, User Name</p>
                    <p class="account-number">1234 5678 9012 3456</p>
                </div>
            </div>
        </div>
        <div class="balance-card">
            <div class="balance-wrapper">
                <p class="balance-label">Saldo Anda</p>
                <p class="balance-amount">Rp 5,000,000</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions Container -->
    <div class="quick-actions-container">
        <!-- Top Row: Transfer Rupiah, Transfer Valas, and Payment -->
        <div class="quick-actions-row">
            <!-- Transfer Rupiah -->
            <div class="action-card">
                <div class="action-icon transfer-icon">
                    <i class="fas fa-paper-plane text-2xl"></i>
                </div>
                <h3 class="action-title">Transfer Rupiah</h3>
                <p class="action-description">Kirim uang dengan cepat</p>
            </div>

            <!-- Transfer Valas -->
            <div class="action-card">
                <div class="action-icon valas-icon">
                    <i class="fas fa-globe-asia text-2xl"></i>
                </div>
                <h3 class="action-title">Transfer Valas</h3>
                <p class="action-description">Kirim mata uang asing</p>
            </div>

            <!-- Payment -->
            <div class="action-card">
                <div class="action-icon payment-icon">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
                <h3 class="action-title">Pembayaran</h3>
                <p class="action-description">Bayar tagihan & layanan</p>
            </div>
        </div>

        <!-- Bottom Row: Billing and Loan (Centered) -->
        <div class="quick-actions-row-bottom">
            <!-- Billing -->
            <div class="action-card">
                <div class="action-icon billing-icon">
                    <i class="fas fa-file-invoice text-2xl"></i>
                </div>
                <h3 class="action-title">Tagih Uang</h3>
                <p class="action-description">tagih Uang anda dengan cepat</p>
            </div>

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
        <div class="transaction-list">
            <div class="transaction-item">
                <div class="transaction-info">
                    <div class="transaction-icon bg-blue-100">
                        <i class="fas fa-arrow-right text-blue-600"></i>
                    </div>
                    <div class="transaction-details">
                        <span class="transaction-name">Transfer ke Budi Santoso</span>
                        <span class="transaction-date">Hari ini, 14:30</span>
                    </div>
                </div>
                <span class="transaction-amount amount-debit">-Rp 500.000</span>
            </div>
        </div>
    </div>
</main>
</body>
</html>
