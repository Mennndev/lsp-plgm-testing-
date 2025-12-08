<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
  <title>Tempat Uji Kompetensi – LSP PLGM</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body id="page-top" class="politics_version">
<div class="page-wrapper">

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

  <!-- NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">
          <img class="img-fluid nav-logo" src="{{ asset('images/logo.png') }}" alt="LSP" />
        </a>

        <button class="navbar-toggler navbar-toggler-right" type="button"
                data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
          Menu <i class="fa fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav text-uppercase ms-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="{{ url('/') }}">Beranda</a>
            </li>

            <!-- Dropdown PROFIL -->
            <li class="nav-item dropdown">
              <a href="#" class="nav-link"
                 id="profilDropdown" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">
                Profil <i class="bi dropdown-toggle" data-toggle="dropdown"></i>
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
              <a href="#" class="nav-link"
                 id="sertifikasiDropdown" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">
                Sertifikasi <i class="bi dropdown-toggle" data-toggle="dropdown"></i>
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
              <a class="nav-link js-scroll-trigger" href="{{ url('daftar') }}">Daftar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- END NAVBAR UTAMA -->

  <!-- HEADER -->
  <section class="py-5 mt-5 bg-light">
    <div class="container text-center">
      <h2 class="text-uppercase font-weight-bold">Tempat Uji Kompetensi (TUK)</h2>
      <p class="mt-2">LSP POLITEKNIK LP3I GLOBAL MANDIRI</p>
    </div>
  </section>

  <!-- CONTENT -->
  <section class="py-5">
    <div class="container">

      <div class="row">
        <div class="col-lg-6 mb-4">
          <h3 class="font-weight-bold mb-3">Lokasi TUK</h3>

          <ul class="list-unstyled">
            <li class="mb-2"><i class="bi bi-geo-alt-fill text-primary mr-2"></i>
              <strong>Politeknik LP3I Bandung</strong>
            </li>
            <li class="mb-2 pl-4">Jl. Pahlawan No. 59, Kota Bandung, Jawa Barat</li>

            <li class="mb-2"><i class="bi bi-building text-primary mr-2"></i>
              Gedung Kampus Utama LP3I
            </li>
          </ul>

          <p class="mt-3">
            Tempat Uji Kompetensi ini digunakan untuk pelaksanaan asesmen bagi skema Operator Komputer,
            Administrasi Perkantoran Digital, dan Digital Marketing sesuai standar BNSP.
          </p>
        </div>

        <div class="col-lg-6 mb-4">
          <div class="border rounded shadow-sm">
            <iframe
              width="100%"
              height="360"
              frameborder="0"
              style="border:0"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.793715809385!2d107.634258!3d-6.896772!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7baae81c353%3A0x8e5c17cad77c439d!2sPoliteknik%20LP3I!5e0!3m2!1sid!2sid!4v1763624737774!5m2!1sid!2sid"
              allowfullscreen>
            </iframe>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

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
        <img src="{{ asset('images/logo.png') }}" width="120" class="footer-logo">
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
  <div class="container text-center py-2">
    <p class="m-0">© 2025 LSP PLGM. All Rights Reserved.</p>
  </div>
</div>

<a href="#" id="scroll-to-top" class="dmtop global-radius">
  <i class="fa fa-angle-up"></i>
</a>

<script src="{{ asset('js/all.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

</body>
</html>
