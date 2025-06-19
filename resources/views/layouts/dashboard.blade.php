<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Akademi') }}</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <!-- Toggle Sidebar Button -->
    <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">A</div>
                <span class="brand-name">Akademi</span>
            </div>
            <ul class="sidebar-nav">
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('students*') ? 'active' : '' }}">
                    <a href="{{ url('/students') }}" class="nav-link">
                        <i class="fas fa-user-graduate"></i>
                        <span>Students</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('teachers*') ? 'active' : '' }}">
                    <a href="{{ url('/teachers') }}" class="nav-link">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Teachers</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('events*') ? 'active' : '' }}">
                    <a href="{{ url('/groups') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Groups</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('departments*') ? 'active' : '' }}">
                    <a href="{{ url('/departments') }}" class="nav-link">
                        <i class="fas fa-building"></i>
                        <span>Departments</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                    <a href="{{ url('/users') }}" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>User</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('roles*') ? 'active' : '' }}">
                    <a href="{{ url('/roles') }}" class="nav-link">
                        <i class="fas fa-shield-alt"></i>
                        <span>Roles</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('courses*') ? 'active' : '' }}">
                    <a href="{{ url('/courses') }}" class="nav-link">
                        <i class="fas fa-book"></i>
                        <span>Courses</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <nav class="top-nav">
                <div class="page-title">
                    @yield('page-title', 'Dashboard')
                </div>
                <div class="nav-actions">
                    <button class="icon-btn">
                        <i class="fas fa-bell"></i>
                    </button>
                    <button class="icon-btn">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="user-profile">
                        <span class="user-name">Nabila A.</span>
                        <div class="avatar">
                            <img src="https://ui-avatars.com/api/?name=Nabila+A&background=7F56D9&color=fff" alt="Profile">
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
    @stack('scripts')
</body>
</html>