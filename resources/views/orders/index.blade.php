@extends('layouts.app')
@section('title', 'Pesanan Saya - Mocha Jane Bakery')

@section('content')
<div class="orders-container">
    <div class="orders-hero text-center mb-4">
        <div class="hero-icon">
            <i class="bi bi-receipt-cutoff"></i>
        </div>
        <h2 class="fw-bold mb-2">Pesanan Saya</h2>
        <p class="text-muted">Lacak dan kelola semua pesanan Anda</p>
    </div>

    @if($orders->isEmpty())

        <div class="empty-orders text-center py-5">
            <div class="empty-icon mb-4">
                <i class="bi bi-bag-x"></i>
            </div>
            <h3 class="fw-bold mb-3">Belum Ada Pesanan</h3>
            <p class="text-muted mb-4">
                Anda belum memiliki pesanan. Yuk mulai belanja produk roti favorit!
            </p>
            <a href="{{ route('products.index') }}" class="btn btn-shopping">
                <i class="bi bi-shop me-2"></i>Mulai Belanja
            </a>
        </div>
    @else

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="bi bi-box-seam text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <p class="stat-label mb-0">Total Pesanan</p>
                            <h4 class="stat-value mb-0">{{ $orders->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="bi bi-hourglass-split text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <p class="stat-label mb-0">Sedang Diproses</p>
                            <h4 class="stat-value mb-0">{{ $orders->whereIn('status', ['pending', 'diproses'])->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="bi bi-check-circle text-success"></i>
                        </div>
                        <div class="ms-3">
                            <p class="stat-label mb-0">Selesai</p>
                            <h4 class="stat-value mb-0">{{ $orders->where('status', 'selesai')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="orders-list">
            @foreach($orders as $order)
                <div class="card order-card border-0 shadow-sm mb-3">

                    <div class="card-header order-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="order-number">
                                    <span class="order-badge">
                                        <i class="bi bi-hash"></i>{{ $order->id }}
                                    </span>
                                </div>
                                <div class="order-date">
                                    <i class="bi bi-calendar3 text-muted me-1"></i>
                                    <span class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <!-- Order Status -->
                                <span class="badge status-badge status-{{ $order->status }}">
                                    @if($order->status == 'pending')
                                        <i class="bi bi-clock me-1"></i>Pending
                                    @elseif($order->status == 'diproses')
                                        <i class="bi bi-gear me-1"></i>Diproses
                                    @elseif($order->status == 'dikirim')
                                        <i class="bi bi-truck me-1"></i>Dikirim
                                    @elseif($order->status == 'selesai')
                                        <i class="bi bi-check-circle me-1"></i>Selesai
                                    @elseif($order->status == 'dibatalkan')
                                        <i class="bi bi-x-circle me-1"></i>Dibatalkan
                                    @else
                                        <i class="bi bi-x-circle me-1"></i>{{ ucfirst($order->status) }}
                                    @endif
                                </span>
                                
                                <!-- Payment Status -->
                                <span class="badge payment-badge payment-{{ $order->payment_status ?? 'pending' }}">
                                    @if($order->payment_status == 'success')
                                        <i class="bi bi-check2-circle me-1"></i>Lunas
                                    @elseif($order->payment_status == 'pending')
                                        <i class="bi bi-hourglass me-1"></i>Menunggu
                                    @else
                                        <i class="bi bi-exclamation-circle me-1"></i>Belum Bayar
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="order-items-preview d-flex align-items-center gap-3">
                                    <div class="items-images d-flex">
                                        @foreach($order->items->take(3) as $item)
                                            <div class="item-thumb" title="{{ $item->product->name ?? 'Produk' }}">
                                                <img 
                                                    src="{{ $item->product->image 
                                                        ? asset('storage/'.$item->product->image) 
                                                        : asset('images/default-product.png') }}"
                                                    alt="{{ $item->product->name ?? 'Produk' }}">
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 3)
                                            <div class="item-thumb more-items">
                                                <span>+{{ $order->items->count() - 3 }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="items-info">
                                        <p class="mb-0 fw-semibold">{{ $order->items->count() }} Produk</p>
                                        <p class="mb-0 text-muted small">
                                            {{ $order->items->sum('qty') }} item total
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="payment-method-info">
                                    <p class="text-muted small mb-1">Metode Pembayaran</p>
                                    <p class="fw-semibold mb-0">
                                        <i class="bi bi-credit-card me-1 text-primary"></i>
                                        {{ $order->payment_method ?? 'COD' }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-3 text-md-end">
                                <div class="order-total">
                                    <p class="text-muted small mb-1">Total Pembayaran</p>
                                    <p class="total-price mb-0">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer order-footer bg-white border-top py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="order-timeline d-flex align-items-center gap-2">
                                <div class="timeline-step completed">
                                    <i class="bi bi-bag-check"></i>
                                </div>
                                <div class="timeline-line {{ in_array($order->status, ['diproses', 'dikirim', 'selesai']) ? 'completed' : '' }}"></div>
                                <div class="timeline-step {{ in_array($order->status, ['diproses', 'dikirim', 'selesai']) ? 'completed' : '' }}">
                                    <i class="bi bi-gear"></i>
                                </div>
                                <div class="timeline-line {{ in_array($order->status, ['dikirim', 'selesai']) ? 'completed' : '' }}"></div>
                                <div class="timeline-step {{ in_array($order->status, ['dikirim', 'selesai']) ? 'completed' : '' }}">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <div class="timeline-line {{ $order->status == 'selesai' ? 'completed' : '' }}"></div>
                                <div class="timeline-step {{ $order->status == 'selesai' ? 'completed' : '' }}">
                                    <i class="bi bi-house-check"></i>
                                </div>
                            </div>

                            <!-- Actions -->
                            <!-- <div class="order-actions d-flex gap-2">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-detail btn-sm">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                                @if($order->status == 'selesai')
                                    <button class="btn btn-review btn-sm">
                                        <i class="bi bi-star me-1"></i>Beri Ulasan
                                    </button>
                                @endif
                            </div> -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if($orders->hasPages())
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                    </small>
                    <div>
                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection