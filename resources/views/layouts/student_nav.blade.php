<style>
    img{
        width: 100px;
        filter:brightness(0) invert(1);
    }
</style>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('student.dashboard') }}">
            <span class="brand-name"><img src="{{ asset('storage/logo.png') }}" alt="Akademi" class="logo-img"></span>
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link me-3" href="{{ route('student.dashboard') }}">
                <i class="fas fa-home me-1"></i>
                {{ __('app.dashboard') }}
            </a>
            <a class="nav-link me-3" href="{{ route('student.courses') }}">
                <i class="fas fa-book me-1"></i>
                {{ __('app.courses') }}
            </a>
            <a class="nav-link me-3" href="{{ route('student.profile') }}">
                <i class="fas fa-user me-1"></i>
                {{ __('app.profile') }}
            </a>
            <form method="POST" action="{{ route('student.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-1"></i>
                    {{ __('app.logout') }}
                </button>
            </form>
        </div>
    </div>
</nav> 