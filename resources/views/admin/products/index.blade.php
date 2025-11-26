@extends('layouts.admin')
@section('title', 'Manajemen Produk')
@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Manajemen Produk</h2>
                    <p class="text-muted mb-0">Kelola semua produk Anda di sini</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Produk</p>
                            <h4 class="fw-bold mb-0">{{ $products->count() }}</h4>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-box-seam text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Stok Tersedia</p>
                            <h4 class="fw-bold mb-0">{{ $products->sum('stock') }}</h4>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-stack text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Stok Menipis</p>
                            <h4 class="fw-bold mb-0">{{ $products->where('stock', '<', 10)->count() }}</h4>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total Nilai</p>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($products->sum(function($p) { return $p->price * $p->stock; }), 0, ',', '.') }}</h4>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-cash-stack text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0 fw-bold">Daftar Produk</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" placeholder="Cari produk...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3" width="60">#</th>
                                    <th class="py-3" width="100">Gambar</th>
                                    <th class="py-3">Nama Produk</th>
                                    <th class="py-3">Harga</th>
                                    <th class="py-3">Stok</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-center" width="200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $p)
                                <tr>
                                    <td class="px-4 fw-semibold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        @if($p->image)
                                            <img src="{{ asset('storage/'.$p->image) }}" 
                                                class="rounded shadow-sm" 
                                                width="70" 
                                                height="70"
                                                style="object-fit: cover;"
                                                alt="{{ $p->name }}">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                style="width: 70px; height: 70px;">
                                                <i class="bi bi-image text-muted fs-4"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $p->name }}</div>
                                        @if($p->description)
                                        <small class="text-muted">{{ Str::limit($p->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-primary">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $p->stock > 10 ? 'bg-success' : ($p->stock > 0 ? 'bg-warning' : 'bg-danger') }} bg-opacity-10 text-{{ $p->stock > 10 ? 'success' : ($p->stock > 0 ? 'warning' : 'danger') }} px-3 py-2">
                                            {{ $p->stock }} unit
                                        </span>
                                    </td>
                                    <td>
                                        @if($p->stock > 10)
                                            <span class="badge bg-success-subtle text-success">
                                                <i class="bi bi-check-circle me-1"></i>Tersedia
                                            </span>
                                        @elseif($p->stock > 0)
                                            <span class="badge bg-warning-subtle text-warning">
                                                <i class="bi bi-exclamation-circle me-1"></i>Menipis
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">
                                                <i class="bi bi-x-circle me-1"></i>Habis
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.edit', $p->id) }}" 
                                            class="btn btn-sm btn-outline-warning" 
                                            data-bs-toggle="tooltip" 
                                            title="Edit Produk">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $p->id) }}" 
                                                method="POST" 
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus produk {{ $p->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="tooltip" 
                                                        title="Hapus Produk">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                            <p class="mb-0">Belum ada produk. Silakan tambah produk baru.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($products->count() > 0)
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menampilkan {{ $products->count() }} produk
                        </small>
                        {{-- {{ $products->links() }} --}}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: all 0.2s ease;
    }
    
    .btn-group .btn {
        border-radius: 0;
    }
    
    .btn-group .btn:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    
    .btn-group .btn:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }

    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
</style>

@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush

@endsection