<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#20B2AA">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SiAPPMan">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icon-192x192.png">

    <title>@yield('title', 'SiAPPMan - QR Scanner')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Toastify.js assets -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        :root {
            --primary-color: #20B2AA;
            --primary-light: #40E0D0;
            --primary-dark: #008B8B;
            --white: #FFFFFF;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            --success: #10B981;
            --error: #EF4444;
            --warning: #F59E0B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: var(--white);
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .btn-secondary:hover {
            background-color: var(--gray-50);
        }

        .card {
            background: var(--white);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background-color: var(--gray-50);
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.1);
        }

        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .sidebar {
            background: var(--white);
            border-right: 1px solid var(--gray-200);
            height: calc(100vh - 73px);
            position: fixed;
            left: 0;
            top: 73px;
            width: 280px;
            padding: 1.5rem 0;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            margin-bottom: 1rem;
        }

        .sidebar-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            color: var(--gray-600);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .sidebar-menu a:hover {
            background-color: var(--gray-50);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: var(--white);
            box-shadow: 0 4px 12px rgba(32, 178, 170, 0.3);
        }

        .sidebar-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background-color: var(--white);
            border-radius: 0 2px 2px 0;
        }

        .sidebar-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .sidebar-text {
            flex: 1;
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: calc(100vh - 73px);
            opacity: 0;
            animation: fadeIn 0.3s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #D1FAE5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-error {
            background-color: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: block;
            }
        }

        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--gray-600);
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>
<body>
    @if(request()->routeIs('dashboard*') || request()->routeIs('scanner'))
        <nav class="navbar">
            <div class="container">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
                    <a href="{{ route('dashboard') }}" class="navbar-brand">SiAPPMan</a>
                </div>
                <div>
                    <!-- Logout button removed from navbar -->
                </div>
            </div>
        </nav>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3 class="sidebar-title">Navigasi</h3>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <div class="sidebar-icon">🏠</div>
                        <span class="sidebar-text">Dasbor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                        <div class="sidebar-icon">⚙️</div>
                        <span class="sidebar-text">Admin</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.instrument-sets.index') }}" class="{{ request()->routeIs('dashboard.instrument-sets*') ? 'active' : '' }}">
                        <div class="sidebar-icon">-</div>
                        <span class="sidebar-text">Instrument Sets</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.qr-codes') }}" class="{{ request()->routeIs('dashboard.qr-codes*') ? 'active' : '' }}">
                        <div class="sidebar-icon">📱</div>
                        <span class="sidebar-text">Kode QR</span>
                    </a>
                </li>
                <li style="padding: 0.5rem 1rem; color: var(--gray-400); font-size: 0.875rem; font-weight: 600;">Master Data</li>
                <li>
                    <a href="{{ route('dashboard.instrument-types.index') }}" class="{{ request()->routeIs('dashboard.instrument-types*') ? 'active' : '' }}">
                        <div class="sidebar-icon">-</div>
                        <span class="sidebar-text">Instrument Types</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.units.index') }}" class="{{ request()->routeIs('dashboard.units*') ? 'active' : '' }}">
                        <div class="sidebar-icon">-</div>
                        <span class="sidebar-text">Units</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.locations.index') }}" class="{{ request()->routeIs('dashboard.locations*') ? 'active' : '' }}">
                        <div class="sidebar-icon">-</div>
                        <span class="sidebar-text">Locations</span>
                    </a>
                </li>
                <li style="padding: 0.5rem 1rem; color: var(--gray-400); font-size: 0.875rem; font-weight: 600;">Asset Management</li>
                <li>
                    <a href="{{ route('dashboard.assets.index') }}" class="{{ request()->routeIs('dashboard.assets*') ? 'active' : '' }}">
                        <div class="sidebar-icon">📦</div>
                        <span class="sidebar-text">Aset</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.scan-history') }}" class="{{ request()->routeIs('dashboard.scan-history') ? 'active' : '' }}">
                        <div class="sidebar-icon">📊</div>
                        <span class="sidebar-text">Riwayat Pemindaian</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.profile') }}" class="{{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                        <div class="sidebar-icon">👤</div>
                        <span class="sidebar-text">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('scanner') }}" class="{{ request()->routeIs('scanner') ? 'active' : '' }}">
                        <div class="sidebar-icon">📷</div>
                        <span class="sidebar-text">Pemindai</span>
                    </a>
                </li>
                <li style="margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--gray-200);">
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="width: 100%; justify-content: flex-start; background: none; border: none; color: var(--gray-600); padding: 0.875rem 1rem; font-weight: 500;">
                            <div class="sidebar-icon">🚪</div>
                            <span class="sidebar-text">Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>
    @endif

    <main class="{{ request()->routeIs('dashboard*') || request()->routeIs('scanner') ? 'main-content' : '' }}">
        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Register Service Worker for PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(registration => {
                        console.log('Service Worker registered successfully:', registration);
                    })
                    .catch(error => {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }
    </script>

    @vite(['resources/js/app.js'])
    @stack('scripts')

    <!-- Toastify.js assets -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                }).showToast();
            @endif

            @if(session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    stopOnFocus: true,
                }).showToast();
            @endif
        });
    </script>
</body>
</html>
