<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Asesor - @yield('title', 'Dashboard')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1e293b;
            color: white;
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover {
            background: #334155;
            color: #fff;
        }
        .sidebar .active {
            background: #0d6efd;
            color: white;
        }
    </style>

    @stack('css')
</head>
<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <div class="p-3 border-bottom">
            <strong>LSP Panel Asesor</strong>
            <div class="small text-muted">{{ auth()->user()->nama }}</div>
        </div>

        <div class="mt-3">
            <a href="{{ route('asesor.dashboard') }}" class="{{ request()->routeIs('asesor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="#">
                <i class="bi bi-clipboard-check"></i> Penilaian
            </a>

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="flex-fill">

        {{-- TOPBAR --}}
        <nav class="navbar navbar-light bg-white border-bottom px-4">
            <span class="navbar-brand mb-0 h6">
                @yield('page-title', 'Dashboard Asesor')
            </span>
        </nav>

        {{-- CONTENT --}}
        <div class="p-4">
            @yield('content')
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('js')
</body>
</html>
