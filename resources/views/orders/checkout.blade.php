@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="container py-5">

    <!-- Judul -->
    <h3 class="mb-4 text-center fw-bold">Checkout Pesanan</h3>

    @if(session('cart') && count(session('cart')) > 0)
    <div class="card shadow-lg border-0 p-4">
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-warning text-center">
                    <tr>
                        <th>Produk</th>
                        <th width="120px">Jumlah</th>
                        <th width="140px">Harga</th>
                        <th width="150px">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $item)
                    @php
                    $subtotal = $item['price'] * $item['qty'];
                    $total += $subtotal;
                    @endphp
                    <tr class="text-center">
                        <td class="text-start fw-semibold">{{ $item['name'] }}</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end fw-bold fs-4 mt-3">
            Total Pembayaran:
            <span class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
        <div class="mt-4 text-center d-flex justify-content-center gap-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4">
                <i class="bi bi-bag"></i> Belanja Lagi
            </a>
            <!-- <a href="{{ route('orders.index') }}" class="btn btn-prsimary px-4">
                    <i class="bi bi-receipt"></i> Pesanan Saya
                </a> -->
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-credit-card"></i> Proses Pembayaran
                </button>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-warning text-center py-4 fs-5">
        Keranjang kamu masih kosong,
        <a href="{{ route('home') }}" class="fw-bold text-decoration-none">belanja dulu yuk!</a>
    </div>
    @endif
</div>
@endsection