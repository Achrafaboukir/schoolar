<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Akademi') }} - @yield('page-title', 'Dashboard')</title>
    
    <!-- Preconnect to external domains for better performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <!-- Toggle Sidebar Button -->
    <button class="toggle-sidebar-btn" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
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
                        <span>{{ __('app.dashboard') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('students*') ? 'active' : '' }}">
                    <a href="{{ url('/students') }}" class="nav-link">
                        <i class="fas fa-user-graduate"></i>
                        <span>{{ __('app.students') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('teachers*') ? 'active' : '' }}">
                    <a href="{{ url('/teachers') }}" class="nav-link">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>{{ __('app.teachers') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('groups*') ? 'active' : '' }}">
                    <a href="{{ url('/groups') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>{{ __('app.groups') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('departments*') ? 'active' : '' }}">
                    <a href="{{ url('/departments') }}" class="nav-link">
                        <i class="fas fa-building"></i>
                        <span>{{ __('app.departments') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                    <a href="{{ url('/users') }}" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>{{ __('app.users') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('roles*') ? 'active' : '' }}">
                    <a href="{{ url('/roles') }}" class="nav-link">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ __('app.roles') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('courses*') ? 'active' : '' }}">
                    <a href="{{ url('/courses') }}" class="nav-link">
                        <i class="fas fa-book"></i>
                        <span>{{ __('app.courses') }}</span>
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
                    <button class="icon-btn" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                    </button>
                    
                    <!-- Language Switcher -->
                    <div class="dropdown me-2">
                        <button class="icon-btn dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-globe me-1"></i>
                            <span class="current-lang-flag">
                                @if(app()->getLocale() == 'en')
                                    <span class="flag-icon flag-icon-us"></span>
                                @elseif(app()->getLocale() == 'fr')
                                    <span class="flag-icon flag-icon-fr"></span>
                                @elseif(app()->getLocale() == 'ar')
                                    <span class="flag-icon flag-icon-sa"></span>
                                @endif
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                            <li><h6 class="dropdown-header">{{ __('app.language') }}</h6></li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('language.switch', 'en') }}">
                                    <span class="flag-icon flag-icon-us me-2"></span>{{ __('app.english') }}
                                    @if(app()->getLocale() == 'en')
                                        <i class="fas fa-check ms-auto"></i>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'fr' ? 'active' : '' }}" href="{{ route('language.switch', 'fr') }}">
                                    <span class="flag-icon flag-icon-fr me-2"></span>{{ __('app.french') }}
                                    @if(app()->getLocale() == 'fr')
                                        <i class="fas fa-check ms-auto"></i>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('language.switch', 'ar') }}">
                                    <span class="flag-icon flag-icon-sa me-2"></span>{{ __('app.arabic') }}
                                    @if(app()->getLocale() == 'ar')
                                        <i class="fas fa-check ms-auto"></i>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Settings Dropdown -->
                    <div class="dropdown">
                        <button class="icon-btn dropdown-toggle" type="button" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Settings">
                            <i class="fas fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i>{{ __('app.profile') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('app.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('profile') }}" class="user-profile text-decoration-none">
                        <span class="user-name">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</span>
                        <div class="avatar">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ __('app.profile') }}" loading="lazy">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->firstname }}+{{ auth()->user()->lastname }}&background=7F56D9&color=fff" alt="{{ __('app.profile') }}" loading="lazy">
                            @endif
                        </div>
                    </a>
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
            
            // Only add click-to-close on mobile and when sidebar is active
            if (window.innerWidth < 768 && sidebar.classList.contains('active')) {
                setTimeout(() => {
                    document.addEventListener('click', function closeSidebar(e) {
                        // Prevent closing if clicking inside sidebar or on toggle button
                        if (!sidebar.contains(e.target) && !e.target.closest('.toggle-sidebar-btn')) {
                            sidebar.classList.remove('active');
                        }
                    }, { once: true });
                }, 0);
            }
        }
        
        // Initialize responsive features
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide sidebar on mobile when clicking a link
            const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        document.querySelector('.sidebar').classList.remove('active');
                    }
                });
            });
            // Prevent sidebar click-to-close from interfering with dropdowns
            const dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        });

        // Global fix for stuck modal backdrops and modal-open class
        document.addEventListener('hidden.bs.modal', function () {
            // Remove all modal backdrops
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            // Remove modal-open class from body
            document.body.classList.remove('modal-open');
            // Remove style attribute from body (Bootstrap sometimes adds overflow: hidden)
            document.body.removeAttribute('style');
        });
    </script>
    @stack('scripts')
</body>
</html>