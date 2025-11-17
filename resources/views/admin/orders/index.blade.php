@extends('layouts.admin')
@section('title', 'Data Pesanan')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Data Pesanan</h3>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-dark">
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal Pesanan</th>
                    <th>Nama Customer</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $order->status == 'selesai' ? 'success' : ($order->status == 'diproses' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.orders.show', $order->id ?? $order->id) }}" class="btn btn-sm btn-primary">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Belum ada pesanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
