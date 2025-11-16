<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>Laporan Penjualan Mocha Jane Bakery</h2>
<p><strong>Tanggal Dicetak:</strong> {{ date('d M Y H:i') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Customer</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Metode Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->user->name }}</td>
            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->payment_method }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
