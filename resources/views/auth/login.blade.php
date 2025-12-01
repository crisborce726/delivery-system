@extends('layouts.guest')

@section('title', 'User Login')

@section('content')
    <style>
        .user-login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .user-login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
            width: 100%;
            max-width: 400px;
        }

        .user-login-header {
            background: #2c3e50;
            border-bottom: none;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .user-login-header h4 {
            font-weight: 600;
            margin: 0;
            font-size: 1.5rem;
            color: white;
        }

        .user-login-body {
            padding: 2rem;
        }

        .user-form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .user-form-control {
            border: 2px solid #e9ecef;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: #495057;
        }

        .user-form-control:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.1);
            outline: none;
        }

        .user-form-control.is-invalid {
            border-color: #dc3545;
        }

        .user-invalid-feedback {
            font-size: 0.875rem;
            margin-top: 0.25rem;
            color: #dc3545;
        }

        .user-form-check-input:checked {
            background-color: #2c3e50;
            border-color: #2c3e50;
        }

        .user-form-check-label {
            color: #495057;
            font-weight: 500;
        }

        .user-login-btn {
            background: #2c3e50;
            border: none;
            border-radius: 6px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            color: white;
            width: 100%;
        }

        .user-login-btn:hover {
            background: #34495e;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .user-login-btn:active {
            transform: translateY(0);
        }

        .alert {
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: none;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background: #d1edff;
            color: #155724;
        }

        .user-login-link {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .user-login-link:hover {
            color: #34495e;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .user-login-body {
                padding: 1.5rem;
            }

            .user-login-header {
                padding: 1.5rem 1rem;
            }
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="user-login-card">
            <div class="card-header user-login-header">
                <h4>User Login</h4>
            </div>
            <div class="card-body user-login-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" id="userLoginForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label user-form-label">Email Address</label>
                        <input type="email" class="form-control user-form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}" required
                            placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback user-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label user-form-label">Password</label>
                        <input type="password"
                            class="form-control user-form-control @error('password') is-invalid @enderror" id="password"
                            name="password" required placeholder="Enter your password">
                        @error('password')
                            <div class="invalid-feedback user-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label user-form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn user-login-btn" id="loginButton">
                        Login
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('register') }}" class="user-login-link me-3">Sign Up</a>
                        <a href="{{ route('admin.login') }}" class="user-login-link">Admin Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('userLoginForm').addEventListener('submit', function() {
            const button = document.getElementById('loginButton');
            button.disabled = true;
            button.textContent = 'Logging in...';

            // Re-enable button after 5 seconds in case of error
            setTimeout(() => {
                button.disabled = false;
                button.textContent = 'Login';
            }, 5000);
        });
    </script>
@endsection
