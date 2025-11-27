@extends('layouts.app')
@section('title', 'Keranjang Belanja - Mocha Jane Bakery')
@section('content')
<div class="hero-section mb-4">
    <h1 class="text-center fw-bold mb-2">
        <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
    </h1>
    <p class="text-center text-muted">Review pesanan kamu sebelum checkout</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(count($cart) > 0)
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card cart-card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-bag-check me-2 text-primary"></i>
                        Item Pesanan ({{ count($cart) }} produk)
                    </h5>
                </div>
                <div class="card-body p-0">
                    @foreach($cart as $id => $item)
                        <div class="cart-item p-3 border-bottom">
                            <div class="row align-items-center g-3">
                                <div class="col-md-2 col-3">
                                    <div class="cart-image-wrapper">
                                        <img 
                                            src="{{ $item['image'] ? asset('storage/'.str_replace('storage/', '', $item['image'])) : asset('images/default-product.png') }}" 
                                            alt="{{ $item['name'] }}" 
                                            class="img-fluid rounded cart-item-image">
                                    </div>
                                </div>
                                
                                <div class="col-md-4 col-9">
                                    <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-tag me-1"></i>
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <div class="col-md-3 col-6">
                                    <div class="quantity-wrapper d-flex align-items-center">
                                        <span class="quantity-label me-2 text-muted small">Jumlah:</span>
                                        <div class="quantity-badge">
                                            <span class="fw-bold">{{ $item['qty'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 col-6 text-end">
                                    <p class="fw-bold text-primary mb-2">
                                        Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                    </p>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-remove" onclick="return confirm('Hapus item ini dari keranjang?')">
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card summary-card border-0 shadow-sm sticky-top" style="top: 100px;">
                <div class="card-header bg-gradient-blue text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-receipt me-2"></i>Ringkasan Belanja
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="summary-row d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal ({{ count($cart) }} item)</span>
                        <span class="fw-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row d-flex justify-content-between mb-3">
                        <span class="text-muted">Biaya Admin</span>
                        <span class="fw-semibold text-success">Gratis</span>
                    </div>
                    <hr class="my-3">
                    <div class="summary-total d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total Pembayaran</span>
                        <span class="fw-bold fs-4 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.form') }}" class="btn btn-checkout w-100 mb-2">
                        <i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-continue-shopping w-100">
                        <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                    </a>
                </div>
            </div>
            
            <!-- <div class="card border-0 shadow-sm mt-3">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="promo-icon me-3">
                            <i class="bi bi-shield-check text-success fs-3"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Belanja Aman</h6>
                            <p class="text-muted small mb-0">100% produk original & berkualitas</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
@else
    <div class="empty-cart-wrapper">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="empty-cart-icon mb-4">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h3 class="fw-bold mb-3">Keranjang Belanja Kosong</h3>
                <p class="text-muted mb-4">
                    Yuk mulai belanja dan pilih produk roti favorit kamu!
                </p>
                <a href="{{ route('products.index') }}" class="btn btn-shopping">
                    <i class="bi bi-shop me-2"></i>Mulai Belanja
                </a>
            </div>
        </div>
    </div>
@endif
@endsection