<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran VA | GoGoWallet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif']
                    },
                    colors: {
                        gogogreen: '#009d5c',
                        softgreen: '#ecfdf5',
                        lightgreen: '#d1fae5'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-white to-green-50 min-h-screen py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-6">
        <header class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ url('/dashboard') }}" class="text-gogogreen hover:text-emerald-800 transition text-lg">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-list-alt text-gogogreen mr-2"></i>
                    Riwayat Pembayaran Virtual Account
                </h1>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow transition text-sm">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
        </header>

        @if(session('success'))
            <div class="mb-4 bg-lightgreen border border-emerald-300 text-emerald-800 px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">Daftar Pembayaran</h2>
            <a href="{{ route('pembayaran.va') }}"
               class="inline-flex items-center bg-gogogreen hover:bg-emerald-700 text-white px-4 py-2 rounded-lg shadow-md text-sm font-medium transition">
                <i class="fas fa-plus mr-1"></i> Bayar VA Baru
            </a>
        </div>

        @if($payments->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-sm">
                    <thead>
                        <tr class="bg-softgreen text-gogogreen text-sm uppercase text-left">
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3 text-center">Virtual Account</th>
                            <th class="px-4 py-3 text-right">Nominal</th>
                            <th class="px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($payments as $index => $payment)
                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-green-50' }} hover:bg-emerald-50 transition">
                                <td class="px-4 py-3 text-sm">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-block bg-white px-3 py-1 border border-emerald-200 text-gogogreen font-semibold rounded-full text-sm tracking-wide shadow-sm">
                                        {{ $payment->va_number }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-emerald-600">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($payment->status === 'pending')
                                        <span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                            <i class="fas fa-check-circle mr-1"></i> {{ ucfirst($payment->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-10 text-gray-500">
                <i class="fas fa-receipt text-3xl text-emerald-300 mb-2"></i>
                <p class="text-sm">Belum ada pembayaran VA yang tercatat.</p>
            </div>
        @endif
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
