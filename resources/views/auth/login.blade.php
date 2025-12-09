<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - LSP Politeknik LP3I Global Mandiri</title>

    {{-- CSS utama --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    {{-- CSS khusus halaman login --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <img src="{{ asset('images/logo.png') }}" class="login-logo" alt="Logo LSP">

        <div class="login-title">Login Akun</div>
        <div class="login-sub">Masukkan kredensial Anda untuk melanjutkan</div>

        {{-- Alert error global --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3">
                <small>Periksa kembali email dan password Anda.</small>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST" id="loginForm" novalidate>
            @csrf

            {{-- Email --}}
            <div class="form-group mb-3">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group mb-4 position-relative">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
                <span class="password-toggle" id="togglePassword">
                    <i class="fa fa-eye-slash"></i>
                </span>
                @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mb-4">
                 <a href="{{ route('password.request') }}" style="font-size: 13px;">
                    Lupa password?
                 </a>
            </div>

            {{-- Tombol Login --}}
            <button type="submit" class="btn btn-primary btn-block btn-lg w-100">
                Masuk
            </button>

            {{-- Link ke pendaftaran --}}
            <p class="text-center mt-3 mb-0" style="font-size: 14px;">
                Belum punya akun?
                <a href="{{ route('pendaftaran.create') }}">Daftar sekarang</a>
            </p>

        </form>

        <div class="footer-copy-simple">
            © {{ date('Y') }} LSP PLGM. All Rights Reserved.
        </div>

    </div>
</div>

{{-- JS khusus halaman login --}}
<script src="{{ asset('js/login.js') }}"></script>

</body>
</html>
