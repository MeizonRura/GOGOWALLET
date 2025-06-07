<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran VA | GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    <div class="transfer-container">
        <header class="transfer-header">
            <a href="{{ url('/dashboard') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>
                <i class="fas fa-list-alt text-green-500"></i>
                Riwayat Pembayaran VA
            </h1>
        </header>

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="transfer-card">
            <div class="transfer-card-header">
                <h2 class="text-lg font-semibold">Daftar Pembayaran</h2>
                <a href="{{ route('pembayaran.va') }}" class="submit-button">
                    <i class="fas fa-plus mr-1"></i> Bayar VA Baru
                </a>
            </div>

            @if($payments->count())
                <div class="table-container">
                    <table class="va-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Virtual Account</th>
                                <th class="text-right">Nominal</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $index => $payment)
                                <tr class="{{ $index % 2 == 0 ? 'even-row' : 'odd-row' }}">
                                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $payment->virtual_account }}</td>
                                    <td class="text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if($payment->status === 'pending')
                                            <span class="status pending"><i class="fas fa-clock"></i> Pending</span>
                                        @else
                                            <span class="status success"><i class="fas fa-check-circle"></i> {{ ucfirst($payment->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-data">
                    <i class="fas fa-receipt"></i>
                    Belum ada pembayaran VA.
                </div>
            @endif
        </div>
    </div>
</body>
</html>
