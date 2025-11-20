@extends('layouts.app')
@section('title', 'Profil Saya - Mocha Jane Bakery')

@section('content')
<div class="profile-container">
    <div class="profile-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content text-center">
            <div class="profile-avatar">
                <div class="avatar-circle">
                    <i class="bi bi-person-fill"></i>
                </div>
                <button class="avatar-edit-btn" title="Ganti Foto">
                    <i class="bi bi-camera-fill"></i>
                </button>
            </div>
            <h2 class="fw-bold text-white mt-3 mb-1">{{ $user->name }}</h2>
            <p class="text-white-50 mb-0">
                <i class="bi bi-envelope me-2"></i>{{ $user->email }}
            </p>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-lg-4">
            <div class="card profile-info-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-info-circle me-2 text-primary"></i>Informasi Akun
                    </h5>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="info-content">
                            <p class="info-label">Nama Lengkap</p>
                            <p class="info-value">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="info-content">
                            <p class="info-label">Email</p>
                            <p class="info-value">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="info-content">
                            <p class="info-label">Nomor HP</p>
                            <p class="info-value">{{ $user->phone ?? 'Belum diisi' }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="info-content">
                            <p class="info-label">Alamat</p>
                            <p class="info-value">{{ $user->address ?? 'Belum diisi' }}</p>
                        </div>
                    </div>

                    <div class="info-item border-0 pb-0">
                        <div class="info-icon">
                            <i class="bi bi-calendar"></i>
                        </div>
                        <div class="info-content">
                            <p class="info-label">Bergabung Sejak</p>
                            <p class="info-value">{{ $user->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card stats-card border-0 shadow-sm mt-3">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-graph-up me-2 text-primary"></i>Statistik Belanja
                    </h6>
                    
                    <div class="stat-item">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="bi bi-cart-check text-primary"></i>
                        </div>
                        <div class="stat-content">
                            <p class="stat-value">{{ $user->orders->count() ?? 0 }}</p>
                            <p class="stat-label">Total Pesanan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card edit-form-card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Profil
                    </h4>
                    <p class="text-muted mb-0 mt-1">Perbarui informasi profil Anda</p>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        name="name" 
                                        class="form-control custom-input" 
                                        id="name"
                                        value="{{ old('name', $user->name) }}"
                                        placeholder="Nama Lengkap"
                                        required>
                                    <label for="name">
                                        <i class="bi bi-person me-2"></i>Nama Lengkap
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="email" 
                                        class="form-control custom-input" 
                                        id="email_display"
                                        value="{{ $user->email }}"
                                        placeholder="Email"
                                        readonly>
                                    <input 
                                        type="hidden"
                                        name="email"
                                        value="{{ $user->email }}">
                                    <label for="email_display">
                                        <i class="bi bi-envelope me-2"></i>Email
                                    </label>
                                    <small class="text-muted">Email tidak dapat diubah</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        name="phone" 
                                        class="form-control custom-input" 
                                        id="phone"
                                        value="{{ old('phone', $user->phone) }}"
                                        placeholder="Nomor HP">
                                    <label for="phone">
                                        <i class="bi bi-telephone me-2"></i>Nomor HP
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        name="address" 
                                        class="form-control custom-input" 
                                        id="address"
                                        value="{{ old('address', $user->address) }}"
                                        placeholder="Alamat Lengkap">
                                    <label for="address">
                                        <i class="bi bi-geo-alt me-2"></i>Alamat Lengkap
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-shield-lock me-2 text-primary"></i>Ubah Password
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="password" 
                                        name="password" 
                                        class="form-control custom-input" 
                                        id="password"
                                        placeholder="Password Baru">
                                    <label for="password">
                                        <i class="bi bi-lock me-2"></i>Password Baru
                                    </label>
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="password" 
                                        name="password_confirmation" 
                                        class="form-control custom-input" 
                                        id="password_confirmation"
                                        placeholder="Konfirmasi Password">
                                    <label for="password_confirmation">
                                        <i class="bi bi-lock-fill me-2"></i>Konfirmasi Password
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-save flex-grow-1">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-cancel">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection