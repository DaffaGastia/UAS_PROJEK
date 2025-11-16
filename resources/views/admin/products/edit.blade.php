@extends('layouts.admin')
@section('title', 'Edit Produk')

@section('content')

<h3 class="fw-bold mb-4">Edit Produk</h3>

<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" value="{{ $product->price }}" class="form-control" required min="1">
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required min="0">
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Produk Sekarang</label><br>

                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" width="120" class="rounded mb-2">
                @else
                    <p class="text-muted">Tidak ada gambar</p>
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Gambar Baru (Opsional)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

@endsection
