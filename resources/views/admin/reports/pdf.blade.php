<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #ddd; font-weight: bold; }
        h3 { text-align: center; }
    </style>
</head>
<body>

<h3>LAPORAN PENJUALAN MOCHA JANE</h3>

<p><strong>Total Pesanan:</strong> {{ $summary['total_orders'] }}</p>
<p><strong>Total Item Terjual:</strong> {{ $summary['total_items'] }}</p>
<p><strong>Total Pendapatan:</strong> Rp {{ number_format($summary['total_income'], 0, ',', '.') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Customer</th>
            <th>Jumlah Item</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Metode Bayar</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->user->name }}</td>
            <td>{{ $order->items->sum('qty') }}</td>
            <td>Rp {{ number_format($order->total_price,0,',','.') }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->payment_method ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
