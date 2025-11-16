@extends('layouts.app')
@section('title', 'Daftar Pesanan')
@section('content')

<div class="container py-4">
    <h3 class="mb-4 text-center fw-bold">Daftar Pesanan Kamu</h3>

    @if($orders->isEmpty())
    <div class="alert alert-warning text-center">
        Belum ada pesanan yang dibuat.
        <a href="{{ route('home') }}" class="text-decoration-none fw-bold">Belanja dulu yuk!</a>
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
        <thead class="table-warning">
            <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Total Harga</th>
            <th>Status Pesanan</th>
            <th>Metode Pembayaran</th>
            <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td>
                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                    {{ ucfirst($order->status) }}
                </span>
                </td>
                <td>{{ $order->payment_method ?? '-' }}</td>
                <td>
                <span class="badge bg-{{ $order->payment_status == 'success' ? 'success' : 'secondary' }}">
                    {{ ucfirst($order->payment_status ?? 'belum dibayar') }}
                </span>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
