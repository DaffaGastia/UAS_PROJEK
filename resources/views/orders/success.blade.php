@extends('layouts.app')
@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow-sm p-5 mx-auto" style="max-width: 500px;">
        <h2 class="text-success fw-bold mb-3">✅ Pembayaran Berhasil!</h2>
        <p class="lead">Terima kasih telah berbelanja di <strong>Mocha Jane Bakery</strong>.</p>
        <p>Pesanan kamu sedang diproses dan akan segera dikirimkan.</p>

        <div class="mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-primary">Lihat Pesanan Saya</a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
