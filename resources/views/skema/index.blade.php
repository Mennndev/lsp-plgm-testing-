{{-- resources/views/skema-sertifikasi.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
  <!-- Basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Site Metas -->
  <title>Skema Sertifikasi - LSP PLGM</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Site Icons -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
  <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
  <script src="{{ asset('js/modernizr.js') }}"></script> <!-- Modernizr -->
</head>

<body id="page-top" class="politics_version">

  <div class="page-wrapper">

    <!-- LOADER -->
    <div id="preloader">
      <div class="loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <!-- END LOADER -->

    <!-- TOP BAR (SOSMED + TEXT) -->
    <nav class="navbar top-navbar py-2">
      <div class="container d-flex justify-content-between align-items-center">

        <!-- Kiri: Sosial Media -->
        <div class="navbar-nav flex-row">
          <a href="#" class="nav-link px-0 pr-3 top-icon">
            <i class="fa fa-facebook"></i>
          </a>
          <a href="#" class="nav-link px-0 pr-3 top-icon">
            <i class="fa fa-instagram"></i>
          </a>
          <a href="#" class="nav-link px-0 top-icon">
            <i class="fa fa-youtube-play"></i>
          </a>
        </div>

        <!-- Kanan: Login -->
        <div class="navbar-nav">
          <a href="{{ url('login') }}" class="nav-link px-0 top-icon">
            Login
          </a>
        </div>

      </div>
    </nav>
    <!-- END TOP BAR -->

    <!-- NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">
          <img class="img-fluid nav-logo" src="{{ asset('images/logo.png') }}" alt="LSP" />
        </a>

        <button class="navbar-toggler navbar-toggler-right" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
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
                <a class="dropdown-item" href="{{ route('skema.index') }}">Skema Sertifikasi</a>
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

    <!-- ======= KONTEN SKEMA SERTIFIKASI ======= -->
    <section class="section lb" style="padding-top: 120px;">
      <div class="container">

        <!-- Header + Search -->
        <div class="row align-items-center mb-4">
          <div class="col-md-6 mb-3 mb-md-0">
            <h2 class="mb-1">Skema Sertifikasi</h2>
            <p class="text-muted mb-0">
              Daftar skema sertifikasi yang diselenggarakan oleh LSP Politeknik LP3I Global Mandiri.
            </p>
          </div>
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-text bg-white border-right-0">
                <i class="fa fa-search text-muted"></i>
              </span>
              <input type="text" class="form-control border-left-0" id="searchSkema"
                     placeholder="Cari nama skema, kode skema, atau bidang...">
            </div>
          </div>
        </div>

        <!-- Filter kategori -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
              <button type="button"
                      class="btn btn-sm btn-outline-primary mr-2 skema-filter active"
                      data-filter="all">
                Semua Bidang
              </button>
              <button type="button"
                      class="btn btn-sm btn-outline-primary mr-2 skema-filter"
                      data-filter="Informasi Dan Komunikasi">
                Informasi &amp; Komunikasi
              </button>
              <button type="button"
                      class="btn btn-sm btn-outline-primary mr-2 skema-filter"
                      data-filter="Perkantoran Digital">
                Administrasi Profesional
              </button>
              <button type="button"
                      class="btn btn-sm btn-outline-primary mr-2 skema-filter"
                      data-filter="Digital Marketing">
                Pemasaran
              </button>
            </div>
          </div>
        </div>

        <!-- GRID POSTER SKEMA -->
        <div class="row g-4" id="daftarSkema">

  @forelse ($programs as $program)
    <div class="col-md-4 col-sm-6 skema-item"
         data-bidang="{{ $program->kategori ?? 'all' }}">
      <div class="card skema-card h-100 shadow-sm border-0">

        {{-- gambar --}}
        @if ($program->gambar)
          <img src="{{ asset('storage/'.$program->gambar) }}"
               class="card-img-top"
               alt="{{ $program->nama }}">
        @else
          <img src="{{ asset('images/default-skema.png') }}"
               class="card-img-top"
               alt="{{ $program->nama }}">
        @endif

        <div class="card-body d-flex flex-column">
          <h5 class="card-title mb-1">{{ $program->nama }}</h5>
          <p class="card-text text-muted small mb-3">
            {{ $program->deskripsi_singkat }}
          </p>

          <a href="{{ route('skema.show', $program->slug) }}"
             class="btn btn-sm btn-primary mt-auto">
            Lihat Skema
          </a>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <p class="text-muted">Belum ada skema sertifikasi yang dipublish.</p>
    </div>
  @endforelse

</div>

      </div>
    </section>
    <!-- ===== END KONTEN SKEMA SERTIFIKASI ===== -->
  </div>

  <!-- FOOTER UTAMA -->
  <footer class="footer-lmc">
    <div class="container">
      <div class="row align-items-center py-4">

        <!-- Kontak -->
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

        <!-- Logo -->
        <div class="col-md-4 text-center mb-3 mb-md-0">
          <img src="{{ asset('images/logo.png') }}" width="120" alt="LSP Logo" class="footer-logo">
        </div>

        <!-- Sosial media -->
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

  <!-- COPYRIGHT -->
  <div class="footer-copy">
    <div class="container text-center py-2">
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
  <!-- ALL JS FILES -->
  <!-- Camera Slider -->
  <script src="{{ asset('js/jquery.mobile.customized.min.js') }}"></script>
  <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('js/parallaxie.js') }}"></script>
  <script src="{{ asset('js/slick.min.js') }}"></script>
  <script src="{{ asset('js/animated-slider.js') }}"></script>
  <!-- Contact form JavaScript -->
  <script src="{{ asset('js/jqBootstrapValidation.js') }}"></script>
  <script src="{{ asset('js/contact_me.js') }}"></script>
  <!-- ALL PLUGINS -->
  <script src="{{ asset('js/custom.js') }}"></script>

  <script>
    // Filter tombol kategori
   const filterButtons = document.querySelectorAll('.skema-filter');
const cards = document.querySelectorAll('.skema-item');
const searchInput = document.getElementById('searchSkema');

function applyFilter() {
  const activeBtn = document.querySelector('.skema-filter.active');
  const filter = activeBtn ? activeBtn.dataset.filter : 'all';
  const keyword = searchInput.value.toLowerCase().trim();

  cards.forEach(card => {
    const bidang = card.dataset.bidang;                    // informasi / perkantoran / marketing
    const text = card.innerText.toLowerCase();             // semua teks di dalam card

    const matchFilter = (filter === 'all') || (bidang === filter);
    const matchSearch = keyword === '' || text.includes(keyword);

    if (matchFilter && matchSearch) {
      card.style.display = '';
    } else {
      card.style.display = 'none';
    }
  });
}

filterButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    filterButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    applyFilter();
  });
});

searchInput.addEventListener('input', applyFilter);
  </script>
</body>

</html>
