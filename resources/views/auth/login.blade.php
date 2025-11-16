@extends('layouts.app')
@section('title', 'Login Customer')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
    <div class="card shadow-sm">
        <div class="card-body">
        <h4 class="mb-3 text-center">Login Customer</h4>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register.form') }}">Daftar di sini</a></p>
        </form>
        </div>
    </div>
    </div>
</div>
@endsection
