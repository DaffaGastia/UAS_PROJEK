@extends('layouts.app')
@section('title', 'Daftar Akun')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
    <div class="card shadow-sm">
        <div class="card-body">
        <h4 class="mb-3 text-center">Daftar Akun Customer</h4>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="address" class="form-control" required>
            </div>
            <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
            <p class="mt-3 text-center">Sudah punya akun? <a href="{{ route('login.form') }}">Login di sini</a></p>
        </form>
        </div>
    </div>
    </div>
</div>
@endsection
