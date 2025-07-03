<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.student_login') }} - {{ config('app.name', 'Akademi') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4F46E5;
            --primary-hover: #3730A3;
            --secondary-color: #10B981;
            --accent-color: #F59E0B;
            --text-dark: #1F2937;
            --text-light: #6B7280;
            --border-color: #E5E7EB;
            --bg-light: #F9FAFB;
            --white: #FFFFFF;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .login-container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            position: relative;
            display: flex;
            min-height: 600px;
        }

        .login-sidebar {
            background: var(--gradient-secondary);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--white);
            position: relative;
            flex: 1;
        }

        .login-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-content {
            position: relative;
            z-index: 2;
        }

        .student-icon {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .sidebar-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .sidebar-subtitle {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .login-form-section {
            padding: 50px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .form-subtitle {
            color: var(--text-light);
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 14px;
            display: block;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--bg-light);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: var(--white);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #EF4444;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            z-index: 2;
        }

        .input-with-icon {
            padding-left: 50px;
        }

        .btn-login {
            background: var(--gradient-secondary);
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            color: var(--white);
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(245, 87, 108, 0.3);
            color: var(--white);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .form-check {
            margin: 25px 0;
        }

        .form-check-input {
            border: 2px solid var(--border-color);
            border-radius: 6px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-light);
            font-size: 14px;
        }

        .forgot-password {
            text-align: center;
            margin-top: 25px;
        }

        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--primary-hover);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .alert-danger {
            background: #FEF2F2;
            color: #DC2626;
            border-left: 4px solid #EF4444;
        }

        .alert-info {
            background: #F0F9FF;
            color: #0C4A6E;
            border-left: 4px solid #0EA5E9;
        }

        .invalid-feedback {
            font-size: 12px;
            color: #EF4444;
            margin-top: 5px;
        }

        .admin-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .admin-link a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .admin-link a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 400px;
            }
            
            .login-sidebar {
                padding: 30px 20px;
            }
            
            .login-form-section {
                padding: 30px 20px;
            }
            
            .student-icon {
                font-size: 60px;
            }
            
            .sidebar-title {
                font-size: 24px;
            }
            
            .form-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-sidebar">
            <div class="sidebar-content">
                <div class="student-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h1 class="sidebar-title">{{ __('app.student_portal') }}</h1>
                <p class="sidebar-subtitle">
                    {{ __('app.student_portal_description') }}
                </p>
            </div>
        </div>
        
        <div class="login-form-section">
            <div class="form-header">
                <h2 class="form-title">{{ __('app.welcome_back') }}</h2>
                <p class="form-subtitle">{{ __('app.student_login_subtitle') }}</p>
            </div>
            
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @if (session('status'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('student.login.post') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('app.email') }}</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email"
                               class="form-control input-with-icon @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               autofocus
                               placeholder="{{ __('app.enter_email') }}">
                    </div>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('app.password') }}</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password"
                               class="form-control input-with-icon @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="{{ __('app.enter_password') }}">
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('app.remember_me') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    {{ __('app.student_login') }}
                </button>
            </form>

            <div class="admin-link">
                <a href="{{ route('login') }}">
                    <i class="fas fa-user-tie me-1"></i>
                    {{ __('app.admin_login') }}
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 