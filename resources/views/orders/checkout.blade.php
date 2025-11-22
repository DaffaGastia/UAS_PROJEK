@extends('layouts.app')
@section('title', 'Checkout - Mocha Jane Bakery')

@section('content')
@php
    $customer = session('customer_id') ? \App\Models\User::find(session('customer_id')) : null;
@endphp
<div class="checkout-container">
    <div class="checkout-hero text-center mb-4">
        <div class="hero-icon">
            <i class="bi bi-credit-card-2-front"></i>
        </div>
        <h2 class="fw-bold mb-2">Checkout Pesanan</h2>
        <p class="text-muted">Selesaikan pembayaran dan pesanan Anda</p>
    </div>

    @if(session('cart') && count(session('cart')) > 0)
        @php 
            $total = 0; 
            foreach(session('cart') as $item) {
                $total += $item['price'] * $item['qty'];
            }
        @endphp

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card checkout-card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-bag-check me-2 text-primary"></i>
                            Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach(session('cart') as $id => $item)
                            @php $subtotal = $item['price'] * $item['qty']; @endphp
                            <div class="checkout-item p-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-md-2 col-3">
                                        <div class="item-image-wrapper">
                                            <img 
                                                src="{{ asset($item['image'] ?? 'images/default-product.png') }}" 
                                                alt="{{ $item['name'] }}" 
                                                class="img-fluid rounded">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-5 col-9">
                                        <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                                        <p class="text-muted small mb-0">
                                            Rp {{ number_format($item['price'], 0, ',', '.') }} / item
                                        </p>
                                    </div>
                                    
                                    <div class="col-md-2 col-6">
                                        <div class="qty-display">
                                            <span class="text-muted small">Qty:</span>
                                            <span class="fw-bold">{{ $item['qty'] }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 col-6 text-end">
                                        <p class="fw-bold text-primary mb-0 subtotal-price">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card checkout-card border-0 shadow-sm mt-3">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-geo-alt me-2 text-primary"></i>
                            Informasi Pengiriman
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="shipping-info">
                            <div class="d-flex align-items-start mb-3">
                                <div class="shipping-icon me-3">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold">{{ $customer?->name }}</p>
                                    <p class="mb-0 text-muted small">{{ $customer?->phone ?? 'Tambahkan nomor HP di profil' }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="shipping-icon me-3">
                                    <i class="bi bi-house"></i>
                                </div>
                                <div>
                                    <p class="mb-0">{{ $customer?->address ?? 'Tambahkan alamat di profil Anda' }}</p>
                                </div>
                            </div>
                            
                            @if(!$customer?->address || !$customer?->phone)
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm mt-3">
                                    <i class="bi bi-pencil me-1"></i>Lengkapi Profil
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card payment-card border-0 shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-gradient-blue text-white py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-receipt me-2"></i>
                            Detail Pembayaran
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="price-row d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal ({{ count(session('cart')) }} item)</span>
                            <span class="fw-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="price-row d-flex justify-content-between mb-3">
                            <span class="text-muted">Biaya Pengiriman</span>
                            <span class="fw-semibold text-success">Gratis</span>
                        </div>
                        
                        <div class="price-row d-flex justify-content-between mb-3">
                            <span class="text-muted">Biaya Layanan</span>
                            <span class="fw-semibold text-success">Gratis</span>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="total-row d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total Bayar</span>
                            <span class="fw-bold fs-4 text-primary">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="payment-method mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-wallet2 me-2"></i>Metode Pembayaran
                            </h6>
                            
                            <div class="payment-options">
                                <label class="payment-option">
                                    <input type="radio" name="payment" value="cod" checked>
                                    <span class="option-content">
                                        <i class="bi bi-cash-coin"></i>
                                        <span>Bayar di Tempat (COD)</span>
                                    </span>
                                </label>
                                
                                <label class="payment-option">
                                    <input type="radio" name="payment" value="transfer">
                                    <span class="option-content">
                                        <i class="bi bi-bank"></i>
                                        <span>Transfer Bank</span>
                                    </span>
                                </label>
                                
                                <label class="payment-option">
                                    <input type="radio" name="payment" value="ewallet">
                                    <span class="option-content">
                                        <i class="bi bi-phone"></i>
                                        <span>E-Wallet</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-checkout w-100 mb-2">
                                <i class="bi bi-check-circle me-2"></i>Proses Pembayaran
                            </button>
                        </form>
                        
                        <a href="{{ route('cart.index') }}" class="btn btn-back w-100">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Keranjang
                        </a>
                    </div>
                </div>

                <!-- Trust Badges -->
                <!-- <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body p-3">
                        <div class="trust-badges">
                            <div class="trust-item">
                                <i class="bi bi-shield-check text-success"></i>
                                <span>Transaksi Aman</span>
                            </div>
                            <div class="trust-item">
                                <i class="bi bi-truck text-primary"></i>
                                <span>Pengiriman Cepat</span>
                            </div>
                            <div class="trust-item">
                                <i class="bi bi-award text-warning"></i>
                                <span>Produk Berkualitas</span>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    @else

        <div class="empty-checkout text-center py-5">
            <div class="empty-icon mb-4">
                <i class="bi bi-cart-x"></i>
            </div>
            <h3 class="fw-bold mb-3">Keranjang Belanja Kosong</h3>
            <p class="text-muted mb-4">
                Yuk isi keranjang belanja kamu dengan produk roti favorit!
            </p>
            <a href="{{ route('products.index') }}" class="btn btn-shopping">
                <i class="bi bi-shop me-2"></i>Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection