{{-- resources/views/kebijakan-mutu.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
  <!-- Basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Site Metas -->
  <title>Kebijakan &amp; Sasaran Mutu – LSP PLGM</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Site Icons -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
  <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Bootstrap Icon -->
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Fonts & Icons -->
  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
  <!-- Slick Slider CSS -->
  <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
  <!-- PrettyPhoto CSS -->
  <link rel="stylesheet" href="{{ asset('css/prettyPhoto.css') }}">
  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- Responsive CSS -->
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <script src="{{ asset('js/modernizr.js') }}"></script> <!-- Modernizr -->
</head>

<body id="page-top" class="politics_version">
  <div class="page-wrapper">

    <!-- LOADER -->
    <div id="preloader">
      <div class="loader">
        <span></span><span></span><span></span><span></span>
      </div>
    </div>
    <!-- END LOADER -->

    <!-- TOP BAR -->
    <nav class="navbar top-navbar py-2">
      <div class="container d-flex justify-content-between align-items-center">

        <div class="navbar-nav flex-row">
          <a href="#" class="nav-link px-0 pr-3 top-icon"><i class="fa fa-facebook"></i></a>
          <a href="#" class="nav-link px-0 pr-3 top-icon"><i class="fa fa-instagram"></i></a>
          <a href="#" class="nav-link px-0 top-icon"><i class="fa fa-youtube-play"></i></a>
        </div>

        <div class="navbar-nav">
          <a href="{{ url('login') }}" class="nav-link px-0 top-icon">Login</a>
        </div>

      </div>
    </nav>
    <!-- END TOP BAR -->

   <!-- NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <img class="img-fluid nav-logo" src="{{ asset('images/logo.png') }}" alt="LSP" />
            </a>

            <button class="navbar-toggler navbar-toggler-right" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                Menu <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ url('/') }}">Beranda</a>
                    </li>

                    <!-- Dropdown PROFIL -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle"
                           id="profilDropdown" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Profil
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profilDropdown">
                            <a class="dropdown-item" href="{{ url('tentang-kami') }}">Tentang LSP</a>
                            <a class="dropdown-item" href="{{ url('visi-misi') }}">Visi &amp; Misi</a>
                            <a class="dropdown-item" href="{{ url('kebijakan-mutu') }}">Kebijakan &amp; Sasaran Mutu</a>
                            <a class="dropdown-item" href="{{ url('struktur-organisasi') }}">Struktur Organisasi</a>
                        </div>
                    </li>

                    <!-- Dropdown SERTIFIKASI -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle"
                           id="sertifikasiDropdown" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Sertifikasi
                        </a>
                        <div class="dropdown-menu" aria-labelledby="sertifikasiDropdown">
                            <a class="dropdown-item" href="{{ route('Skema.index') }}">Skema Sertifikasi</a>
                            <a class="dropdown-item" href="{{ url('tempat-sertifikasi') }}">Tempat Uji Kompetensi</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ url('berita') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ url('pendaftaran') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR UTAMA -->

    <!-- HEADER PAGE -->
    <section id="kebijakan" class="kebijakan-header-modern kebijakan">
      <div class="container text-center" data-aos="fade-up">
        <h2 class="kebijakan-title">Kebijakan &amp; Sasaran Mutu</h2>
        <div class="kebijakan-underline"></div>
      </div>

      <div class="kebijakan-deco">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="kebijakan-logo-modern">
      </div>
    </section>

    <!-- ====== KEBIJAKAN MUTU ====== -->
    <section class="section wb kebijakan">
      <div class="container">

        <div class="section-title text-center">
          <h3>Kebijakan Mutu</h3>
          <p>Diacu dari dokumen resmi sistem manajemen mutu LSP PLGM.</p>
        </div>

        <div class="row">
          <div class="col-md-12">

            <p>
              LSP POLITEKNIK LP3I GLOBAL MANDIRI bertekad akan selalu mengutamakan mutu dalam
              melaksanakan kegiatan uji kompetensi untuk mencapai kepuasan peserta asesmen dan jejaring kerja
              terkait dengan cara menerapkan sistem manajemen mutu secara konsisten.
            </p>

            <p>
              Sistem manajemen mutu secara berkesinambungan meningkatkan kemampuan sumber daya manusia
              serta teknologi sehingga menghasilkan proses sertifikasi yang berkualitas dan tidak berpihak kepada siapapun.
            </p>

            <h5 class="mt-4"><strong>Untuk mencapai komitmen tersebut, LSP menetapkan:</strong></h5>

            <ol style="list-style: decimal; margin-left: 20px;">
              <li>Mematuhi Pedoman BNSP 201/ISO 17024, Pedoman BNSP 202, 206, 210, serta persyaratan lain terkait mutu.</li>
              <li>Menjamin seluruh asesor &amp; personil memperoleh pelatihan sesuai tugasnya.</li>
              <li>Kebijakan mutu menjadi kerangka acuan dalam penetapan tujuan &amp; sasaran mutu.</li>
              <li>Kebijakan mutu dipahami oleh seluruh asesor, personil, dan pihak terkait.</li>
              <li>Melaksanakan peningkatan berkesinambungan terhadap penerapan sistem manajemen mutu.</li>
              <li>Menjamin kebijakan mutu tersedia bagi publik yang memerlukannya.</li>
            </ol>

          </div>
        </div>

        <hr class="my-5">

        <!-- ====== SASARAN MUTU ====== -->
        <div class="section-title text-center">
          <h3>Sasaran Mutu</h3>
        </div>

        <div class="row">
          <div class="col-md-12">
            <p>
              Sasaran mutu LSP POLITEKNIK LP3I GLOBAL MANDIRI adalah:
            </p>

            <ul style="margin-left: 20px; list-style: square;">
              <li>Memastikan dan memelihara kompetensi peserta didik.</li>
              <li>Menjaga kompetensi sumber daya manusia jejaring kerja LSP secara konsisten.</li>
            </ul>
          </div>
        </div>

      </div>
    </section>
  </div>
  <!-- END SECTION -->

  <!-- FOOTER -->
  <footer class="footer-lmc">
    <div class="container">
      <div class="row align-items-center py-4">

        <div class="col-md-4 mb-3 mb-md-0">
          <h5 class="footer-title">Kontak</h5>
          <p class="footer-item">
            <i class="bi bi-geo-alt-fill me-2"></i>
            <a href="https://maps.app.goo.gl/JRRkSUwuwzCuUWHt6" target="_blank">Politeknik LP3I Bandung</a>
          </p>
          <p class="footer-item">
            <i class="bi bi-whatsapp me-2"></i>
            <a href="https://wa.me/6285220199772" target="_blank">0852-2019-9772</a>
          </p>
        </div>

        <div class="col-md-4 text-center mb-3 mb-md-0">
          <img src="{{ asset('images/logo.png') }}" width="120" alt="LSP" class="footer-logo">
        </div>

        <div class="col-md-4 text-md-right text-center">
          <div class="footer-sosmed">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-youtube"></i></a>
          </div>
        </div>

      </div>
    </div>
  </footer>

  <div class="footer-copy">
    <div class="container-fluid text-center py-2">
      <p class="m-0">© {{ date('Y') }} LSP PLGM. All Rights Reserved.</p>
    </div>
  </div>

  <a href="#" id="scroll-to-top" class="dmtop global-radius">
    <i class="fa fa-angle-up"></i>
  </a>


  <!-- jQuery (for legacy plugins) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <!-- Bootstrap 5 Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  <!-- Other legacy JS plugins -->
  <script src="{{ asset('js/jquery.mobile.customized.min.js') }}"></script>
  <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('js/parallaxie.js') }}"></script>
  <script src="{{ asset('js/slick.min.js') }}"></script>
  <script src="{{ asset('js/animated-slider.js') }}"></script>
  <script src="{{ asset('js/jqBootstrapValidation.js') }}"></script>
  <script src="{{ asset('js/contact_me.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>

</body>
</html>
