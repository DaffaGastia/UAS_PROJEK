@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->id)
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-receipt me-2"></i>Detail Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            </h3>
            <p class="text-muted mb-0">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>Informasi Customer
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-person me-2"></i>Nama:</strong><br>
                                {{ $order->user->name }}
                            </p>
                            <p class="mb-2">
                                <strong><i class="bi bi-envelope me-2"></i>Email:</strong><br>
                                {{ $order->user->email }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-telephone me-2"></i>Nomor HP:</strong><br>
                                {{ $order->user->phone ?? 'Tidak ada' }}
                            </p>
                            <p class="mb-0">
                                <strong><i class="bi bi-geo-alt me-2"></i>Alamat:</strong><br>
                                {{ $order->user->address ?? 'Tidak ada' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-bag-check me-2"></i>Produk Pesanan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="60" class="text-center">No</th>
                                    <th>Produk</th>
                                    <th width="120" class="text-center">Harga Satuan</th>
                                    <th width="80" class="text-center">Qty</th>
                                    <th width="140" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}" 
                                                        class="rounded me-2"
                                                        width="50" height="50"
                                                        style="object-fit: cover;">
                                                @endif
                                                <strong>{{ $item->product->name ?? 'Produk Dihapus' }}</strong>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $item->qty }}</span>
                                        </td>
                                        <td class="text-end">
                                            <strong>Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Item:</strong></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $order->items->sum('qty') }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-primary fs-5">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Status Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Order:</label>
                        <div>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bi bi-clock"></i> Pending
                                </span>
                            @elseif($order->status == 'diproses')
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-gear"></i> Diproses
                                </span>
                            @elseif($order->status == 'dikirim')
                                <span class="badge bg-primary fs-6">
                                    <i class="bi bi-truck"></i> Dikirim
                                </span>
                            @elseif($order->status == 'selesai')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="bi bi-x-circle"></i> Dibatalkan
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Pembayaran:</label>
                        <div>
                            @if($order->payment_status == 'success')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check2-circle"></i> Lunas
                                </span>
                            @elseif($order->payment_status == 'pending')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bi bi-hourglass"></i> Menunggu Pembayaran
                                </span>
                            @elseif($order->payment_status == 'failed')
                                <span class="badge bg-danger fs-6">
                                    <i class="bi bi-x-circle"></i> Gagal
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6">
                                    <i class="bi bi-dash-circle"></i> Belum Dibayar
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="form-label fw-bold">Metode Pembayaran:</label>
                        <div>
                            <span class="badge bg-light text-dark fs-6">
                                <i class="bi bi-credit-card me-1"></i>
                                {{ $order->payment_method ?? 'COD' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Update Status
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Pesanan</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Pembayaran</label>
                            <select name="payment_status" class="form-select" required>
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="success" {{ $order->payment_status == 'success' ? 'selected' : '' }}>Success</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-receipt me-2"></i>Ringkasan Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal ({{ $order->items->sum('qty') }} item):</span>
                        <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Pengiriman:</span>
                        <strong class="text-success">Gratis</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Admin:</span>
                        <strong class="text-success">Gratis</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong class="fs-5">Total Pembayaran:</strong>
                        <strong class="fs-5 text-primary">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-clock-history me-2"></i>Riwayat Pesanan
            </h5>
        </div>
        <div class="card-body">
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon bg-primary">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="mb-1">Pesanan Dibuat</h6>
                        <p class="text-muted mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                @if($order->status != 'pending')
                <div class="timeline-item">
                    <div class="timeline-icon bg-info">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="mb-1">Pesanan Diproses</h6>
                        <p class="text-muted mb-0">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif

                @if(in_array($order->status, ['dikirim', 'selesai']))
                <div class="timeline-item">
                    <div class="timeline-icon bg-primary">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="mb-1">Pesanan Dikirim</h6>
                        <p class="text-muted mb-0">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif

                @if($order->status == 'selesai')
                <div class="timeline-item">
                    <div class="timeline-icon bg-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="timeline-content">
                        <h6 class="mb-1">Pesanan Selesai</h6>
                        <p class="text-muted mb-0">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 60px;
}

.timeline-item {
    position: relative;
    padding-bottom: 30px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -40px;
    top: 30px;
    width: 2px;
    height: calc(100% - 30px);
    background: #dee2e6;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-icon {
    position: absolute;
    left: -56px;
    top: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}
</style>

@endsection