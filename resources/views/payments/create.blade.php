@extends('layouts.app')
@section('title', 'Pilih Metode Pembayaran')

@section('content')

<div class="card shadow-sm p-4">
    <h4 class="mb-3">Pilih Metode Pembayaran</h4>

    <form action="{{ route('payments.store', $order->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="method" id="method" class="form-select" onchange="toggleDetails()">
                <option value="COD">Bayar di Tempat (COD)</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="QRIS">QRIS</option>
            </select>
        </div>

        <!-- Transfer Bank -->
        <div id="bankDetails" class="mb-3" style="display:none;">
            <label class="form-label">Pilih Bank</label>
            <select name="details" class="form-select">
                <option value="BNI">BNI - 123456789 a.n Mocha Jane Bakery</option>
                <option value="BRI">BRI - 987654321 a.n Mocha Jane Bakery</option>
                <option value="BCA">BCA - 111222333 a.n Mocha Jane Bakery</option>
                <option value="Mandiri">Mandiri - 444555666 a.n Mocha Jane Bakery</option>
            </select>
        </div>

        <!-- QRIS -->
        <div id="qrisDetails" style="display:none;">
            <p>Scan QRIS untuk melanjutkan pembayaran:</p>
            <img src="/images/qris.png" width="200" class="border rounded">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Konfirmasi Pembayaran</button>
    </form>
</div>

<script>
function toggleDetails() {
    const method = document.getElementById('method').value;
    document.getElementById('bankDetails').style.display = method === 'Transfer Bank' ? 'block' : 'none';
    document.getElementById('qrisDetails').style.display = method === 'QRIS' ? 'block' : 'none';
}
</script>

@endsection
