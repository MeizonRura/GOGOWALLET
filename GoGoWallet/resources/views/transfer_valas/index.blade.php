<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transfer Valas - GoGoWallet</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/transfer-valas.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-50 font-inter">

<div class="transfer-container">

    <!-- Header dengan tombol kembali -->
    <header class="transfer-header">
        <a href="{{ route('dashboard') }}" class="back-button" title="Kembali ke Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="title">Transfer Valas</h1>
    </header>

    <!-- Form Transfer Valas -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('transfer-valas.store') }}" method="POST" class="transfer-form">
        @csrf
        <div class="form-group">
            <label for="recipient_name">Nama Penerima</label>
            <input type="text" id="recipient_name" name="recipient_name" required value="{{ old('recipient_name') }}">
            @error('recipient_name') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="recipient_bank">Bank</label>
            <input type="text" id="recipient_bank" name="recipient_bank" required value="{{ old('recipient_bank') }}">
            @error('recipient_bank') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="currency">Mata Uang</label>
            <select id="currency" name="currency" required>
                <option value="">-- Pilih Mata Uang --</option>
                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                <option value="SGD" {{ old('currency') == 'SGD' ? 'selected' : '' }}>SGD (Singapore Dollar)</option>
                <option value="JPY" {{ old('currency') == 'JPY' ? 'selected' : '' }}>JPY (Japanese Yen)</option>
            </select>
            @error('currency') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="amount">Jumlah</label>
            <input type="number" step="0.01" id="amount" name="amount" required value="{{ old('amount') }}" min="0">
            @error('amount') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn-submit">
            Transfer
            <i class="fas fa-paper-plane ml-2"></i>
        </button>
    </form>

    <!-- Riwayat Transfer -->
    <h2 class="history-title">Riwayat Transfer Valas</h2>

    @if($transfers->isEmpty())
        <p class="empty-msg">Belum ada riwayat transfer valas.</p>
    @else
        <div class="table-wrapper">
            <table class="transfer-table">
                <thead>
                    <tr>
                        <th class="border px-3 py-2">Nama Penerima</th>
                        <th class="border px-3 py-2">Bank</th>
                        <th class="border px-3 py-2">Mata Uang</th>
                        <th class="border px-3 py-2 text-right">Jumlah</th>
                        <th class="border px-3 py-2 text-right">Rate</th>
                        <th class="border px-3 py-2 text-right">Total (IDR)</th>
                        <th class="border px-3 py-2">Tanggal</th>
                        <th class="border px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transfers as $t)
                    <tr>
                        <td class="border px-3 py-2">{{ $t->recipient_name }}</td>
                        <td class="border px-3 py-2">{{ $t->recipient_bank }}</td>
                        <td class="border px-3 py-2">{{ $t->currency }}</td>
                        <td class="border px-3 py-2 text-right">{{ number_format($t->amount, 2) }}</td>
                        <td class="border px-3 py-2 text-right">{{ number_format($t->exchange_rate, 4) }}</td>
                        <td class="border px-3 py-2 text-right">{{ number_format($t->total_in_local, 2) }}</td>
                        <td class="border px-3 py-2">{{ $t->transfer_date }}</td>
                        <td class="border px-3 py-2">{{ ucfirst($t->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

</body>
</html>
