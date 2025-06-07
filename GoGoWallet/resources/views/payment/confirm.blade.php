<!-- filepath: resources/views/payment/confirm.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran - GoGoWallet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a2e0da3f3b.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-green-50 to-white min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl p-8 space-y-8 transition-all duration-300">
        <div class="text-center space-y-2">
            <div class="text-green-500 text-4xl">
                <i class="fas fa-money-check-alt"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Konfirmasi Pembayaran</h2>
            <p class="text-sm text-gray-500">Mohon periksa kembali informasi pembayaran Anda.</p>
        </div>

        <div class="bg-gray-50 rounded-xl p-4 space-y-3 border border-gray-200">
            <div class="flex justify-between text-sm text-gray-600">
                <span>Virtual Account</span>
                <span class="font-medium text-gray-900">{{ $virtual_account }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Nominal</span>
                <span class="font-semibold text-green-600">Rp {{ number_format($amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <form action="{{ route('pembayaran.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="virtual_account" value="{{ $virtual_account }}">
            <input type="hidden" name="amount" value="{{ $amount }}">
            <input type="hidden" name="confirm" value="1">
            
            <div class="flex flex-col space-y-2">
                <button type="submit" 
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg shadow-md transition">
                    Bayar Sekarang
                </button>
                
                <a href="{{ route('pembayaran.va') }}"
                   class="inline-flex items-center justify-center text-sm text-green-600 hover:text-green-800 transition py-1">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</body>
</html>
