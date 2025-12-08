<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin – LSP PLGM')</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- ADMIN CSS (KHUSUS) -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>

<body class="admin-body">

<div id="wrapper">

    <!-- ✅ SIDEBAR -->
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="LSP PLGM">
        </div>

        <ul class="sidebar-nav">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <li class="{{ request()->is('admin/program-pelatihan*') ? 'active' : '' }}">
                <a href="{{ route('admin.program-pelatihan.index') }}">
                    <i class="bi bi-journal-text"></i> Program Pelatihan
                </a>
            </li>


           <li class="{{ request()->is('admin/asesi*') ? 'active' : '' }}">
                <a href="{{ url('admin/asesi') }}">
                    <i class="bi bi-people"></i> Data Asesi
                </a>
            </li>

             <li class="{{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                <a href="{{ url('admin/pengguna') }}">
                    <i class="bi bi-person-gear"></i> Pengguna & Role
                </a>
            </li>
             <li class="{{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                <a href="{{ url('admin/artikel') }}">
                    <i class="bi bi-newspaper"></i> Berita
                </a>
            </li>
        </ul>
    </aside>

    <!-- ✅ KONTEN -->
    <main id="page-content-wrapper">

        <!-- ✅ NAVBAR ATAS -->
        <nav class="admin-navbar">
            <button id="menu-toggle" class="btn">
                <i class="bi bi-list"></i>
            </button>

            <div class="admin-user">
                <span class="text-muted me-3">Panel Admin LSP PLGM</span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear"></i> Pengaturan Akun
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- ✅ KONTEN DINAMIS -->
        <section class="admin-content">
            @yield('content')
        </section>

    </main>

</div>

<!-- JS -->
<script src="{{ asset('js/all.js') }}"></script>
<script>
    document.getElementById('menu-toggle').onclick = function () {
        document.getElementById('wrapper').classList.toggle('toggled');
    }
</script>

@stack('scripts')
</body>
</html>
