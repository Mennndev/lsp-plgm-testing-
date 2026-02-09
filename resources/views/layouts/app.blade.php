<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation')

<main class="py-4">
    @yield('content')
</main>

@stack('scripts')

<!-- Live Chat Widget Button -->
@auth
<div id="chatWidget" style="position: fixed; bottom: 20px; right: 20px; z-index: 999;">
    <a href="{{ route('chat.index') }}" class="btn btn-primary btn-lg rounded-circle" 
       style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.2);"
       title="Live Chat">
        <i class="bi bi-chat-dots" style="font-size: 24px;"></i>
    </a>
</div>
@endauth

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
