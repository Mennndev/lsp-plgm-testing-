<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - LSP PLGM</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Reset Password</h4>

                    <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $email) }}"
                                   required autofocus>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>

                            <!-- Pesan Validasi -->
                            <small id="passwordHelp" class="text-danger d-none">
                                Password tidak sama!
                            </small>
                        </div>

                        <button id="submitBtn" type="submit" class="btn btn-primary w-100">
                            Simpan Password
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

<script>
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const helpText = document.getElementById('passwordHelp');
    const submitBtn = document.getElementById('submitBtn');

    function validatePassword() {
        if (confirmPassword.value === "") {
            helpText.classList.add('d-none');
            submitBtn.disabled = false;
            return;
        }

        if (password.value !== confirmPassword.value) {
            helpText.classList.remove('d-none');
            submitBtn.disabled = true;
        } else {
            helpText.classList.add('d-none');
            submitBtn.disabled = false;
        }
    }

    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);
</script>

</body>
</html>
