{{-- resources/views/berita/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
  <!-- Basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="edge">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Site Metas -->
  <title>{{ $berita->judul }} - Berita LSP PLGM</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Site Icons -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
  <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!--Bootstrap Icon-->
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Site Fonts -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
  <!-- Slick Slider CSS -->
  <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
  <!-- PrettyPhoto CSS -->
  <link rel="stylesheet" href="{{ asset('css/prettyPhoto.css') }}">
  <!-- Site CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- Responsive CSS -->
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <script src="{{ asset('js/modernizr.js') }}"></script>
</head>

<body id="page-top" class="politics_version">
<div class="page-wrapper">

  <!-- LOADER -->
  <div id="preloader">
    <div class="loader">
      <span></span><span></span><span></span><span></span>
    </div>
  </div>

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
              data-toggle="collapse" data-target="#navbarResponsive"
              aria-controls="navbarResponsive" aria-expanded="false"
              aria-label="Toggle navigation">
        Menu <i class="fa fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ms-auto">
          <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('/') }}">Beranda</a></li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link" id="profilDropdown" role="button" data-toggle="dropdown"
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

          <li class="nav-item dropdown">
            <a href="#" class="nav-link" id="sertifikasiDropdown" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
              Sertifikasi <i class="bi dropdown-toggle" data-toggle="dropdown"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="sertifikasiDropdown">
              <a class="dropdown-item" href="{{ route('Skema.index') }}">Skema Sertifikasi</a>
              <a class="dropdown-item" href="{{ url('tempat-sertifikasi') }}">Tempat Uji Kompetensi</a>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link js-scroll-trigger active" href="{{ url('berita') }}">Berita</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="{{ url('daftar') }}">Daftar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END NAVBAR UTAMA -->

  <!-- ======= DETAIL BERITA ======= -->
  <section class="section lb" style="padding-top: 120px;">
    <div class="container">

      <!-- Breadcrumb & Title -->
      <div class="row mb-4">
        <div class="col-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-2">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
              <li class="breadcrumb-item"><a href="{{ url('berita') }}">Berita</a></li>
              <li class="breadcrumb-item active" aria-current="page">
                {{ \Illuminate\Support\Str::limit($berita->judul, 60) }}
              </li>
            </ol>
          </nav>

          <h2 class="mb-1">{{ $berita->judul }}</h2>
          <p class="text-muted mb-0">
            <i class="bi bi-calendar-event"></i>
            {{ \Carbon\Carbon::parse($berita->tanggal_terbit ?? $berita->created_at)->translatedFormat('d F Y') }}
          </p>
        </div>
      </div>

      <div class="row g-4">
        <!-- KONTEN UTAMA -->
        <div class="col-lg-8">
          <div class="card shadow-sm border-0 mb-4">
            @if($berita->gambar)
              <img src="{{ asset('storage/'.$berita->gambar) }}"
                   class="card-img-top"
                   alt="{{ $berita->judul }}"
                   style="max-height:380px;object-fit:cover;">
            @endif

            <div class="card-body">
              @if($berita->ringkasan)
                <p class="text-muted" style="font-size:0.95rem;">
                  {!! $berita->ringkasan !!}
                </p>
                <hr>
              @endif

              <div class="berita-konten" style="font-size:0.98rem;line-height:1.7;">
                {!! $berita->konten !!}
              </div>
            </div>
          </div>

          <a href="{{ url('berita') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke daftar berita
          </a>
        </div>

        <!-- SIDEBAR: BERITA LAINNYA -->
        <div class="col-lg-4">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <h5 class="mb-3">Berita Lainnya</h5>

              @forelse($beritaLain as $b)
                <div class="d-flex mb-3">
                  @if($b->gambar)
                    <img src="{{ asset('storage/'.$b->gambar) }}"
                         alt="{{ $b->judul }}"
                         style="width:70px;height:70px;object-fit:cover;border-radius:6px;"
                         class="me-2">
                  @endif
                  <div>
                    <a href="{{ route('berita.show', $b->slug ?? $b->id) }}"
                       class="text-decoration-none text-dark fw-semibold d-block"
                       style="font-size:0.9rem;">
                      {{ \Illuminate\Support\Str::limit($b->judul, 60) }}
                    </a>
                    <small class="text-muted d-block">
                      {{ \Carbon\Carbon::parse($b->tanggal_terbit ?? $b->created_at)->translatedFormat('d M Y') }}
                    </small>
                  </div>
                </div>
              @empty
                <p class="text-muted mb-0" style="font-size:0.9rem;">
                  Belum ada berita lainnya.
                </p>
              @endforelse
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- ===== END DETAIL BERITA ===== -->

</div>

<!-- FOOTER -->
<footer class="footer-lmc">
  <div class="container">
    <div class="row align-items-center py-4">
      <div class="col-md-4 mb-3 mb-md-0">
        <h5 class="footer-title">Kontak</h5>
        <p class="footer-item">
          <i class="bi bi-geo-alt-fill me-2"></i>
          <a href="https://maps.app.goo.gl/JRRkSUwuwzCuUWHt6" target="_blank">
            Politeknik LP3I Bandung
          </a>
        </p>
        <p class="footer-item">
          <i class="bi bi-whatsapp me-2"></i>
          <a href="https://wa.me/6285220199772" target="_blank">
            0852-2019-9772
          </a>
        </p>
      </div>

      <div class="col-md-4 text-center mb-3 mb-md-0">
        <img src="{{ asset('images/logo.png') }}" width="120" alt="LSP Logo" class="footer-logo">
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
    <p class="m-0">© {{ date('Y') }} LSP PLGM. All Rights Reserved.</p>
  </div>
</div>

<a href="#" id="scroll-to-top" class="dmtop global-radius">
  <i class="fa fa-angle-up"></i>
</a>

<!-- JS -->
<script src="{{ asset('js/all.js') }}"></script>
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
