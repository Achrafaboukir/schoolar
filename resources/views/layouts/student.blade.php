<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('app.student_dashboard')) - {{ config('app.name', 'Akademi') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo.png') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1E3A8A;
            --primary-hover: #1E40AF;
            --secondary-color: #2DD4BF;
            --accent-color: #F472B6;
            --text-dark: #111827;
            --text-light: #6B7280;
            --border-color: #E2E8F0;
            --bg-light: #F9FAFB;
            --white: #FFFFFF;
            --gradient-primary: linear-gradient(135deg, #1E3A8A 0%, #2DD4BF 100%);
            --gradient-secondary: linear-gradient(135deg, #F472B6 0%, #F9A8D4 100%);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.5;
        }
        .navbar {
            background: var(--primary-color);
            padding: 1rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--white) !important;
            display: flex;
            align-items: center;
        }
        .nav-link {
            color: var(--white) !important;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            transform: translateY(-2px);
        }
        .logout-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }
        .main-content {
            padding: 2rem 0;
        }
        @media (max-width: 768px) {
            .main-content { padding: 1.5rem 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    @include('layouts.student_nav')
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 