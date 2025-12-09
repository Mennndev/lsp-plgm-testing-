{{-- resources/views/auth/passwords/email.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - LSP PLGM</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-2">Lupa Password</h4>
                    <p class="text-muted" style="font-size: 14px;">
                        Masukkan email yang terdaftar. Kami akan mengirimkan link
                        untuk mengatur ulang password Anda.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success py-2">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   required autofocus>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Kirim Link Reset Password
                        </button>

                        <a href="{{ route('login') }}" class="btn btn-link w-100 mt-2">
                            &larr; Kembali ke login
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
