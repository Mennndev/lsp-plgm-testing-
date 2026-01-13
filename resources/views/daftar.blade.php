<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pendaftaran - LSP Politeknik LP3I Global Mandiri</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- CSS khusus halaman daftar -->
    <link rel="stylesheet" href="{{ asset('css/daftar.css') }}">
</head>

<body>

    <!-- LOADER (opsional, kalau nggak mau tinggal hapus blok ini + CSS loader di bawah) -->
    <div id="preloader">
        <div class="loader">
            <span></span><span></span><span></span><span></span>
        </div>
    </div>

    <!-- HEADER -->
    <section id="daftar" class="daftar-header-modern">
        <div class="container">
            <h2 class="daftar-title mb-2">Pendaftaran Asesi</h2>
            <p class="text-muted mb-0" style="font-size:14px;">
                Lengkapi data diri Anda untuk proses registrasi dan asesmen kompetensi.
            </p>
            <div class="daftar-underline"></div>
        </div>

        <div class="daftar-deco">
            <img src="{{ asset('images/logo.png') }}" class="about-logo-modern" alt="Logo LSP">
        </div>
    </section>

    <!-- FORM WRAPPER (BACKGROUND LEMBUT) -->
    <section class="py-5 daftar-wrapper">
        <div class="container form-container">
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-11">
                    <div class="mb-3 text-center">
                        <span class="badge rounded-pill px-3 py-2 daftar-badge-info">
                            <i class="bi bi-shield-check me-1"></i> Data Anda akan dijaga kerahasiaannya
                        </span>
                    </div>

                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-md-5">

                            {{-- ALERT SUKSES --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- ALERT ERROR VALIDASI GLOBAL --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Terdapat beberapa kesalahan input. Silakan periksa kembali formulir Anda.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- HEADER FORM -->
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
                                <div>
                                    <h4 class="mb-1 fw-bold daftar-form-title">
                                        Formulir Pendaftaran Asesi
                                    </h4>
                                    <p class="text-muted mb-0" style="font-size: 13px;">
                                        Pastikan seluruh data yang Anda isi sudah benar sebelum mengirimkan formulir.
                                    </p>
                                </div>
                                <div class="mt-3 mt-md-0 text-md-end">
                            <span class="badge rounded-pill border daftar-badge-info">
                         <i class="bi bi-asterisk text-danger me-1"></i> Wajib diisi
                             </span>
                            </div>

                            </div>

                            <form method="POST"
                                  action="{{ route('pendaftaran.store') }}"
                                  enctype="multipart/form-data"
                                  id="daftarForm"
                                  novalidate>
                                @csrf



                                <!-- A. DATA PRIBADI -->
                                <div class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="section-circle me-2">A</div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Data Pribadi</h6>
                                            <small class="text-muted">Lengkapi identitas utama Anda.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control"
                                                   name="nama"
                                                   value="{{ old('nama') }}"
                                                   required>
                                        </div>
                                        @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   required>
                                        </div>
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">No. Handphone *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                            <input type="text" class="form-control"
                                                   name="no_hp"
                                                   value="{{ old('no_hp') }}"
                                                   placeholder="Contoh: 08xxxxxxxxxx"
                                                   required>
                                        </div>
                                        @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin *</label>
                                        <select class="form-select" name="jenis_kelamin" required>
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir *</label>
                                        <input type="text" class="form-control"
                                               name="tempat_lahir"
                                               value="{{ old('tempat_lahir') }}"
                                               required>
                                        @error('tempat_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir *</label>
                                        <input type="date" class="form-control"
                                               name="tanggal_lahir"
                                               value="{{ old('tanggal_lahir') }}"
                                               required>
                                        @error('tanggal_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">NIK (Nomor Induk Kependudukan) *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-credit-card-2-front"></i></span>
                                        <input type="text"
                                               maxlength="16"
                                               class="form-control"
                                               name="nik"
                                               value="{{ old('nik') }}"
                                               placeholder="16 digit NIK"
                                               required>
                                    </div>
                                    @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- B. AKUN LOGIN -->
                                <div class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="section-circle me-2">B</div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Akun Login</h6>
                                            <small class="text-muted">Akun ini digunakan untuk mengakses portal asesi.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Password *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="col-md-6 position-relative">
                                        <label class="form-label">Konfirmasi Password *</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password"
                                                   class="form-control"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   required>
                                        </div>
                                        <div id="tooltip-password" class="error-tooltip">
                                            Password tidak sama
                                        </div>
                                    </div>
                                </div>

                                <!-- C. TANDA TANGAN -->
                                <div class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="section-circle me-2">C</div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Tanda Tangan Digital</h6>
                                            <small class="text-muted">
                                                Tanda tangan digunakan sebagai persetujuan resmi pada dokumen asesmen.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="ttd_digital" id="ttd_digital">
                                <div id="signature-error" class="signature-error">
                                    Tanda tangan wajib diisi
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                    <button class="btn btn-outline-primary btn-sm" id="open-signature-modal" type="button">
                                        <i class="bi bi-pen"></i> Buat Tanda Tangan
                                    </button>
                                    <small class="text-muted" style="font-size:12px;">
                                        Anda dapat menggambar langsung atau mengunggah gambar tanda tangan.
                                    </small>
                                </div>

                                <div id="signature-preview" class="mt-2" style="display:none;">
                                    <p class="mb-1" style="font-size: 13px;">Preview tanda tangan:</p>
                                    <div class="border rounded p-2 bg-white">
                                        <img id="signature-preview-img" class="img-fluid" alt="Preview TTD">
                                    </div>
                                </div>

                                <!-- D. PERSETUJUAN -->
                                <div class="mb-3 pb-3 border-bottom mt-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="section-circle me-2">D</div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Persetujuan</h6>
                                            <small class="text-muted">Persetujuan syarat dan ketentuan pendaftaran.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mt-4">
                                    <input type="checkbox" class="form-check-input" id="setuju" name="setuju" required>
                                    <label class="form-check-label" for="setuju" style="font-size: 13px;">
                                        Saya menyatakan bahwa seluruh data yang saya isi adalah benar dan saya menyetujui syarat & ketentuan yang berlaku.
                                    </label>
                                </div>

                                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mt-4">
                                    <p class="text-muted mb-3 mb-md-0" style="font-size: 13px;">
                                        Dengan menekan tombol <strong>Daftar Sekarang</strong>, Anda akan mengirimkan data ke sistem LSP.
                                    </p>
                                    <button class="btn btn-primary btn-lg px-4" type="submit">
                                        Daftar Sekarang
                                        <i class="bi bi-arrow-right-short ms-1"></i>
                                    </button>
                                </div>

                                <p class="text-center mt-4 mb-0" style="font-size: 14px;">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}" class="fw-semibold">Login di sini</a>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MODAL TTD -->
    <div class="signature-modal-backdrop" id="signature-modal-backdrop">
        <div class="signature-modal">
            <div class="signature-modal-header">
                <span>Tanda Tangan Digital</span>
                <button type="button" class="close-signature-modal" aria-label="Close">&times;</button>
            </div>

            <div class="signature-modal-body">
                <p class="mb-2" style="font-size:13px;">
                    Gunakan mouse / touchscreen untuk menggambar tanda tangan Anda pada area berikut:
                </p>
                <div class="signature-pad">
                    <canvas id="signature-canvas" width="600" height="200"></canvas>
                </div>
            </div>

            <div class="signature-modal-footer">
                <button class="btn btn-light" id="btn-signature-cancel" type="button">Batal</button>
                <button class="btn btn-danger" id="btn-signature-clear" type="button">Hapus</button>

                <label class="btn btn-success mb-0">
                    Upload Gambar
                    <input type="file" id="signature-upload" accept=".jpg,.jpeg,.png" style="display:none;">
                </label>

                <button class="btn btn-primary" id="btn-signature-save" type="button">
                    Simpan Tanda Tangan
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- JS khusus halaman daftar (validasi + tanda tangan) -->
    <script src="{{ asset('js/daftar.js') }}" defer></script>

    <script>
        // Hilangkan preloader saat halaman selesai dimuat
        window.addEventListener('load', function () {
            const preloader = document.getElementById('preloader');
            if (preloader) preloader.style.display = 'none';
        });
    </script>

</body>
</html>
