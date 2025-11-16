@extends('layouts.admin')
@section('title', 'Detail Pesanan')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Detail Pesanan</h4>

        <div class="mb-4">
            <strong>Nama Customer:</strong> {{ $order->user->name }} <br>
            <strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }} <br>
            <strong>Status Sekarang:</strong> 
            <span class="badge bg-primary">{{ ucfirst($order->status) }}</span>
        </div>

        <h5>Update Status</h5>
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="mb-4">
            @csrf

            <div class="row g-3">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-success">Update Status</button>
                </div>
            </div>
        </form>

        <h5>Item Pesanan</h5>
        <table class="table table-bordered">
            <thead class="table-warning">
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
