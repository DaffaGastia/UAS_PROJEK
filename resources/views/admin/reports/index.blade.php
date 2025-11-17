@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('content')

@php
    // total pendapatan
    $grandTotal = $orders->sum('total_price');

    // total semua item terjual
    $totalItems = 0;
    foreach ($orders as $o) {
        $totalItems += $o->items->sum('qty');
    }
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Laporan Penjualan</h3>
    <a href="{{ route('admin.reports.pdf') }}" target="_blank" class="btn btn-danger">
        Download PDF
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Ringkasan Laporan</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="p-3 bg-light border rounded">
                    <h6 class="text-muted">Total Pesanan</h6>
                    <h4 class="fw-bold">{{ $orders->count() }} pesanan</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light border rounded">
                    <h6 class="text-muted">Total Item Terjual</h6>
                    <h4 class="fw-bold">{{ $totalItems }} item</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light border rounded">
                    <h6 class="text-muted">Total Pendapatan</h6>
                    <h4 class="fw-bold text-success">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th width="50px">No</th>
                    <th>Nama Customer</th>
                    <th width="140px">Tanggal Pesanan</th>
                    <th width="130px">Total Item</th>
                    <th>Total Harga</th>
                    <th>Status Pesanan</th>
                    <th>Metode Pembayaran</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td class="text-center">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="text-center fw-bold">
                        {{ $order->items->sum('qty') }} item
                    </td>
                    <td>
                        <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-{{ 
                            $order->status == 'selesai' ? 'success' : 
                            ($order->status == 'diproses' ? 'warning' : 'secondary') 
                        }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        @if($order->payment_method)
                            <span class="badge bg-info">{{ $order->payment_method }}</span>
                        @else
                            <span class="badge bg-secondary">Belum Membayar</span>
                        @endif
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        Belum ada data laporan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
