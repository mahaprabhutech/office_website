<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#111111">
    <title>@yield('title', 'Dashboard') | {{ config('site_admin.brand.name', 'Mahaprabhu Tech') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/admin.css') }}">
    @stack('head')
</head>
<body>
<div class="admin-shell" data-admin-shell>
    @include('admin.partials.sidebar')

    <div class="sidebar-scrim" data-sidebar-close></div>

    <main class="admin-main">
        @include('admin.partials.topbar')

        <div class="admin-content">
            @include('admin.partials.flash')
            @yield('content')
        </div>

        <footer class="admin-footer">
            <span>© {{ date('Y') }} {{ config('site_admin.brand.company') }}</span>
            <span>Secure Website Administration</span>
        </footer>
    </main>
</div>

<script src="{{ asset('admin-assets/js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
