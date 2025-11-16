@extends('layouts.app')
@section('title', 'Daftar Produk')
@section('content')

<div class="hero-section mb-5">
    <h1 class="text-center fw-bold mb-2">Produk Kami</h1>
    <p class="text-center text-muted">Nikmati kelezatan roti segar setiap hari</p>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
    @foreach($products as $product)
        <div class="col">
            <div class="card product-card h-100 border-0">

                <div class="image-wrapper position-relative overflow-hidden">
                    <img 
                        src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/400x400' }}" 
                        alt="{{ $product->name }}" 
                        class="card-img-top product-image">
                    <div class="image-overlay"></div>
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>

                    <p class="card-price fw-bold text-primary mb-3">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <!-- Quantity Selector -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                        @csrf

                        <div class="d-flex justify-content-center align-items-center mb-3">

                            <button type="button" class="btn btn-sm btn-outline-secondary qty-minus">−</button>

                            <input type="number" 
                                name="qty" 
                                class="form-control mx-2 text-center qty-input" 
                                value="1" 
                                min="1" 
                                style="width: 60px;">

                            <button type="button" class="btn btn-sm btn-outline-secondary qty-plus">+</button>

                        </div>

                        <button type="submit" class="btn btn-add-cart w-100">
                            <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                        </button>
                    </form>

                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection
