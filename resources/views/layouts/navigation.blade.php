<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Schoolar') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
                    </li>
                    @if(Auth::user()->role && Auth::user()->role->is_teacher)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teachers.courses.index') }}">{{ __('app.my_courses') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/assignments') }}">{{ __('app.assignments') }}</a>
                        </li>
                    @elseif(Auth::user()->role && Auth::user()->role->is_student)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/courses/browse') }}">{{ __('app.browse_courses') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/assignments') }}">{{ __('app.my_assignments') }}</a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Language Switcher: Always visible -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center language-switcher-btn" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe me-2"></i>
                        <span class="current-lang-text">{{ __('app.language') }}</span>
                        <span class="current-lang-flag ms-1">
                            @if(app()->getLocale() == 'en')
                                <span class="flag-icon flag-icon-us"></span>
                            @elseif(app()->getLocale() == 'fr')
                                <span class="flag-icon flag-icon-fr"></span>
                            @elseif(app()->getLocale() == 'ar')
                                <span class="flag-icon flag-icon-sa"></span>
                            @endif
                        </span>
                    </a>
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
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('app.login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('app.register') }}</a>
                    </li>
                @else
                    <!-- User Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i>{{ __('app.profile') }}
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('app.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav> 