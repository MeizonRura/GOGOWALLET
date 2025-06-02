@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Form Transfer Valas</h2>

<form method="POST" action="{{ route('transfer-valas.store') }}" class="space-y-4">
    @csrf

    <div>
        <label>Mata Uang</label>
        <select name="currency" id="currency" class="border p-2 w-full" required>
            <option value="">-- Pilih Mata Uang --</option>
            <option value="SGD">SGD - Dolar Singapura</option>
            <option value="USD">USD - Dolar Amerika</option>
            <option value="JPY">JPY - Yen Jepang</option>
        </select>
    </div>

    <div>
        <label>Jumlah dalam IDR</label>
        <input name="amount_idr" id="amount_idr" type="number" step="1" required class="border p-2 w-full" />
    </div>

    <div>
        <label>Rate Tukar (1 Valas ke IDR)</label>
        <input name="exchange_rate" id="exchange_rate" type="number" step="0.0001" required class="border p-2 w-full" />
    </div>

    <div>
        <label>Jumlah dalam Valas (Otomatis)</label>
        <input type="text" id="converted_amount" class="border p-2 w-full bg-gray-100" readonly />
    </div>

    <input type="hidden" name="amount_foreign" id="amount_foreign" />

    <div>
        <label>No Rekening Tujuan</label>
        <input name="account_number" type="text" required class="border p-2 w-full" />
    </div>

    <div>
        <label>Nama Penerima</label>
        <input name="recipient_name" type="text" required class="border p-2 w-full" />
    </div>

    <div>
        <label>Bank Tujuan</label>
        <input name="recipient_bank" type="text" required class="border p-2 w-full" />
    </div>

    <div>
        <label>Tanggal Transfer</label>
        <input name="transfer_date" type="date" required class="border p-2 w-full" />
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Kirim</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const amountIDR = document.getElementById('amount_idr');
    const exchangeRate = document.getElementById('exchange_rate');
    const convertedAmount = document.getElementById('converted_amount');
    const hiddenAmountForeign = document.getElementById('amount_foreign');

    function calculateConversion() {
        const idr = parseFloat(amountIDR.value);
        const rate = parseFloat(exchangeRate.value);
        if (idr && rate && rate > 0) {
            const result = idr / rate;
            convertedAmount.value = result.toFixed(2);
            hiddenAmountForeign.value = result.toFixed(2);
        } else {
            convertedAmount.value = '';
            hiddenAmountForeign.value = '';
        }
    }

    amountIDR.addEventListener('input', calculateConversion);
    exchangeRate.addEventListener('input', calculateConversion);
});
</script>
@endsection
