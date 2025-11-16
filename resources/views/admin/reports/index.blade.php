@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Laporan Penjualan</h3>
    <a href="{{ route('admin.reports.pdf') }}" target="_blank" class="btn btn-danger">
        📄 Download PDF
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th width="50px">No</th>
                    <th>Nama Customer</th>
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
                    <td>
                        <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        <span class="badge bg-{{ $order->status == 'selesai' ? 'success' : ($order->status == 'diproses' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        {{ $order->payment_method ?? '-' }}
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        Belum ada data laporan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection