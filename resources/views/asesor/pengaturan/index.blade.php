@extends('layouts.asesor')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('asesor.dashboard') }}" style="color: #233C7E; text-decoration: none;">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengaturan Akun</li>
        </ol>
    </nav>

    <h4 class="mb-4" style="color: #233C7E; font-weight: 600;">Pengaturan Akun</h4>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Section 1: Ubah Password -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background: #233C7E; color: white;">
                    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Ubah Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('asesor.pengaturan.password') }}" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <!-- Password Lama -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">
                                Password Saat Ini <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                                    <i class="bi bi-eye" id="toggleCurrentIcon"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password Baru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       minlength="8">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Minimal 8 karakter</small>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Konfirmasi Password Baru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required
                                       minlength="8">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                    <i class="bi bi-eye" id="togglePasswordConfirmIcon"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small id="passwordMatchHelp" class="form-text text-danger d-none">
                                Password tidak sama!
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn" style="background: #233C7E; color: white;">
                                <i class="bi bi-save me-2"></i>Simpan Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section 2: Preferensi Akun -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background: #D69F3A; color: #111;">
                    <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Preferensi Akun</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('asesor.pengaturan.preferensi') }}" id="preferensiForm">
                        @csrf
                        @method('PUT')

                        <!-- Notifikasi Email -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Notifikasi Email</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="notifikasi_email" 
                                       name="notifikasi_email" 
                                       value="1"
                                       checked>
                                <label class="form-check-label" for="notifikasi_email">
                                    Aktifkan notifikasi email untuk penugasan baru
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Anda akan menerima email saat ada penugasan penilaian baru
                            </small>
                        </div>

                        <!-- Pilihan Bahasa -->
                        <div class="mb-4">
                            <label for="bahasa" class="form-label fw-semibold">Bahasa</label>
                            <select class="form-select" id="bahasa" name="bahasa">
                                <option value="id" selected>Bahasa Indonesia</option>
                                <option value="en">English</option>
                            </select>
                            <small class="form-text text-muted">
                                Pilih bahasa tampilan sistem
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn" style="background: #D69F3A; color: #111;">
                                <i class="bi bi-save me-2"></i>Simpan Preferensi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Akun -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Nama:</strong> {{ auth()->user()->nama ?? auth()->user()->name ?? '-' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong> {{ auth()->user()->email ?? '-' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>No. HP:</strong> {{ auth()->user()->no_hp ?? '-' }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Role:</strong> <span class="badge" style="background: #233C7E;">{{ ucfirst(auth()->user()->role ?? 'asesor') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Configuration
    const AUTO_DISMISS_TIMEOUT = 5000; // Auto-dismiss alerts after 5 seconds

    // Toggle password visibility
    document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('current_password');
        const icon = document.getElementById('toggleCurrentIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
        const icon = document.getElementById('togglePasswordConfirmIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    // Password confirmation validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const helpText = document.getElementById('passwordMatchHelp');

    function validatePassword() {
        if (confirmPassword.value === '') {
            helpText.classList.add('d-none');
            return;
        }

        if (password.value !== confirmPassword.value) {
            helpText.classList.remove('d-none');
            confirmPassword.classList.add('is-invalid');
        } else {
            helpText.classList.add('d-none');
            confirmPassword.classList.remove('is-invalid');
        }
    }

    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);

    // Auto-dismiss alerts after configured timeout
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, AUTO_DISMISS_TIMEOUT);
</script>
@endpush
@endsection
