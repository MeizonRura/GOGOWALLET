<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran VA - GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <div class="transfer-container">
        <!-- Header with back button -->
        <header class="transfer-header">
            <a href="{{ route('dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Riwayat Pembayaran Virtual Account</h1>
        </header>

        <div class="transfer-card">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="header-actions">
                <div class="header-title">Daftar Pembayaran</div>
                <a href="{{ route('pembayaran.va') }}" class="create-button">
                    <i class="fas fa-plus"></i>
                    <span>Bayar VA Baru</span>
                </a>
            </div>

            @if($payments->count())
                <div class="payment-list">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th class="text-center">Virtual Account</th>
                                <th class="text-right">Nominal</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <span class="va-number">
                                            {{ $payment->va_number }}
                                        </span>
                                    </td>
                                    <td class="text-right amount">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge {{ $payment->status === 'pending' ? 'pending' : 'success' }}">
                                            <i class="fas {{ $payment->status === 'pending' ? 'fa-clock' : 'fa-check-circle' }}"></i>
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-data">
                    <i class="fas fa-receipt"></i>
                    <p>Belum ada pembayaran VA yang tercatat.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
