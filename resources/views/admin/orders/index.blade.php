@extends('layouts.admin')
@section('title', 'Data Pesanan')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-box-seam me-2"></i>Data Pesanan
            </h3>
            <p class="text-muted mb-0">Kelola semua pesanan pelanggan</p>
        </div>
        <div>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">
                <i class="bi bi-graph-up me-2"></i>Lihat Laporan
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <!-- <div class="col-md-4">
                    <label class="form-label">Status Pesanan</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select">
                        <option value="">Semua Pembayaran</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="success" {{ request('payment_status') == 'success' ? 'selected' : '' }}>Sukses</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                    </select>
                </div> -->
                <div class="col-md-4">
                    <label class="form-label">Cari Customer</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Nama customer..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-cart-check text-primary fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Total Pesanan</p>
                            <h4 class="mb-0 fw-bold">{{ $orders->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-hourglass-split text-warning fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Pending</p>
                            <h4 class="mb-0 fw-bold">{{ $orders->where('status', 'pending')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-truck text-info fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Diproses</p>
                            <h4 class="mb-0 fw-bold">{{ $orders->whereIn('status', ['diproses', 'dikirim'])->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-check-circle text-success fs-3"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Selesai</p>
                            <h4 class="mb-0 fw-bold">{{ $orders->where('status', 'selesai')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-list-ul me-2"></i>Daftar Pesanan
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th width="120">ID Order</th>
                            <th width="150">Tanggal</th>
                            <th>Customer</th>
                            <th width="100" class="text-center">Total Item</th>
                            <th width="140" class="text-end">Total Harga</th>
                            <th width="120" class="text-center">Status Order</th>
                            <th width="140" class="text-center">Metode Bayar</th>
                            <th width="120" class="text-center">Status Bayar</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $order->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <strong>{{ $order->user->name }}</strong><br>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">
                                        {{ $order->items->sum('qty') }} item
                                    </span>
                                </td>
                                <td class="text-end">
                                    <strong class="text-primary">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td class="text-center">
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-clock"></i> Pending
                                        </span>
                                    @elseif($order->status == 'diproses')
                                        <span class="badge bg-info">
                                            <i class="bi bi-gear"></i> Diproses
                                        </span>
                                    @elseif($order->status == 'dikirim')
                                        <span class="badge bg-primary">
                                            <i class="bi bi-truck"></i> Dikirim
                                        </span>
                                    @elseif($order->status == 'selesai')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Dibatalkan
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">
                                        {{ $order->payment_method ?? 'COD' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($order->payment_status == 'success')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check2-circle"></i> Lunas
                                        </span>
                                    @elseif($order->payment_status == 'pending')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-hourglass"></i> Pending
                                        </span>
                                    @elseif($order->payment_status == 'failed')
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Gagal
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-dash-circle"></i> Belum
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada pesanan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
    </div>
</div>

@endsection