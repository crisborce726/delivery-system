@extends('layouts.guest')

@section('title', 'Admin Login')

@section('content')
    <style>
        .admin-login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
            width: 100%;
            max-width: 400px;
        }

        .admin-login-header {
            background: #2c3e50;
            border-bottom: none;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .admin-login-header h4 {
            font-weight: 600;
            margin: 0;
            font-size: 1.5rem;
            color: white;
        }

        .admin-login-body {
            padding: 2rem;
        }

        .admin-form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .admin-form-control {
            border: 2px solid #e9ecef;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: #495057;
        }

        .admin-form-control:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.1);
            outline: none;
        }

        .admin-form-control.is-invalid {
            border-color: #dc3545;
        }

        .admin-invalid-feedback {
            font-size: 0.875rem;
            margin-top: 0.25rem;
            color: #dc3545;
        }

        .admin-form-check-input:checked {
            background-color: #2c3e50;
            border-color: #2c3e50;
        }

        .admin-form-check-label {
            color: #495057;
            font-weight: 500;
        }

        .admin-login-btn {
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

        .admin-login-btn:hover {
            background: #34495e;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .admin-login-btn:active {
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

        .admin-login-link {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .admin-login-link:hover {
            color: #34495e;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .admin-login-body {
                padding: 1.5rem;
            }

            .admin-login-header {
                padding: 1.5rem 1rem;
            }
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="admin-login-card">
            <div class="card-header admin-login-header">
                <h4>Admin Login</h4>
            </div>
            <div class="card-body admin-login-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" id="adminLoginForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label admin-form-label">Email Address</label>
                        <input type="email" class="form-control admin-form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}" required
                            placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback admin-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label admin-form-label">Password</label>
                        <input type="password"
                            class="form-control admin-form-control @error('password') is-invalid @enderror" id="password"
                            name="password" required placeholder="Enter your password">
                        @error('password')
                            <div class="invalid-feedback admin-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label admin-form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn admin-login-btn" id="loginButton">
                        Login
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="admin-login-link">User Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('adminLoginForm').addEventListener('submit', function() {
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
