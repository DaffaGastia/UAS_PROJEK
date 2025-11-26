@extends('layouts.admin')
@section('title', 'Tambah Produk')
@section('content')

<h3 class="fw-bold mb-4">Tambah Produk Baru</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" required min="1">
            </div>
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stock" class="form-control" required min="0">
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                <input type="file" name="image" class="form-control">
                <small class="text-muted">Opsional</small>
            </div>
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

@endsection
