<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi - GoGoWallet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .card {
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .title {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .btn-submit {
            width: 100%;
            font-weight: bold;
        }
        .history-card {
            margin-top: 40px;
        }
        .history-table th, .history-table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h2 class="title"><i class="fas fa-hand-holding-heart text-danger"></i> Donasi Sekarang</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ url('/donasi') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="rekening_tujuan" class="form-label">Rekening Tujuan</label>
                <select name="rekening_tujuan" id="rekening_tujuan" class="form-select" required>
                    <option value="">-- Pilih Rekening Donasi --</option>
                    <option value="Dompet Yatim">Dompet Yatim</option>
                    <option value="Bencana Alam">Bencana Alam</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah Donasi (Rp)</label>
                <input type="number" name="amount" id="amount" class="form-control" placeholder="Masukkan jumlah" required>
            </div>

            <button type="submit" class="btn btn-success btn-submit"><i class="fas fa-donate"></i> Donasi Sekarang</button>
        </form>
    </div>

    @if(isset($donations) && count($donations) > 0)
    <div class="card history-card mt-4">
        <h4 class="title"><i class="fas fa-history text-secondary"></i> Riwayat Donasi</h4>
        <table class="table table-bordered history-table">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tujuan</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $donation->rekening_tujuan }}</td>
                        <td>Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td>{{ $donation->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="title mb-0">
            <i class="fas fa-hand-holding-heart text-success"></i> Donasi Sekarang
        </h2>
        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
