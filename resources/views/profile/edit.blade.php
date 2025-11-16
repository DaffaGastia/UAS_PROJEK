@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
<div class="card shadow-sm">
    <div class="card-body">
    <h4 class="mb-3">Edit Profil</h4>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
        </div>
        <div class="mb-3">
        <label class="form-label">Nomor HP</label>
        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>
        <div class="mb-3">
        <label class="form-label">Alamat</label>
        <input type="text" name="address" class="form-control" value="{{ $user->address }}">
        </div>
        <div class="mb-3">
        <label class="form-label">Password Baru (opsional)</label>
        <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
    </div>
</div>
@endsection
