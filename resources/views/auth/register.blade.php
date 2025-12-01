@extends('layouts.guest')

@section('title', 'User Signup')

@section('content')
    <style>
        .user-login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .user-login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
            width: 100%;
            max-width: 450px;
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
            display: block;
        }

        .user-form-control {
            display: block;
            width: 100%;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: #495057;
            box-sizing: border-box;
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

        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 0.5rem;
            background: #e9ecef;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-weak {
            background: #dc3545;
            width: 25%;
        }

        .strength-fair {
            background: #f59e0b;
            width: 50%;
        }

        .strength-good {
            background: #10b981;
            width: 75%;
        }

        .strength-strong {
            background: #059669;
            width: 100%;
        }

        .password-requirements {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 1rem;
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .requirement-met {
            color: #10b981;
        }

        .requirement-not-met {
            color: #6c757d;
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="user-login-card">
            <div class="user-login-header">
                <h4>User Registration</h4>
            </div>
            <div class="user-login-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="user-form-label">Full Name</label>
                        <input type="text" class="user-form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                        @error('name')
                            <div class="user-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="user-form-label">Email Address</label>
                        <input type="email" class="user-form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="Enter email" required>
                        @error('email')
                            <div class="user-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="user-form-label">Phone Number</label>
                        <input type="text" class="user-form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required>
                        @error('phone')
                            <div class="user-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="user-form-label">Password</label>
                        <input type="password" class="user-form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Enter password" required>
                        <div class="password-strength mt-2">
                            <div class="password-strength-bar" id="passwordStrength"></div>
                        </div>
                        <div class="password-requirements mt-2">
                            <ul>
                                <li id="req-length" class="requirement-not-met">At least 8 characters</li>
                                <li id="req-uppercase" class="requirement-not-met">One uppercase letter</li>
                                <li id="req-lowercase" class="requirement-not-met">One lowercase letter</li>
                                <li id="req-number" class="requirement-not-met">One number</li>
                                <li id="req-special" class="requirement-not-met">One special character</li>
                            </ul>
                        </div>
                        @error('password')
                            <div class="user-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="user-form-label">Confirm Password</label>
                        <input type="password"
                            class="user-form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                        @error('password_confirmation')
                            <div class="user-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ✅ reCAPTCHA v2 Widget -->
                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <div class="user-invalid-feedback mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="user-login-btn" id="submitBtn">Create Account</button>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="user-login-link me-3">Already have an account? Login</a>
                        <a href="{{ route('admin.login') }}" class="user-login-link">Admin Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ✅ reCAPTCHA v2 Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');

            const hasLength = password.length >= 8;
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[^A-Za-z0-9]/.test(password);

            document.getElementById('req-length').className = hasLength ? 'requirement-met' : 'requirement-not-met';
            document.getElementById('req-uppercase').className = hasUpper ? 'requirement-met' :
                'requirement-not-met';
            document.getElementById('req-lowercase').className = hasLower ? 'requirement-met' :
                'requirement-not-met';
            document.getElementById('req-number').className = hasNumber ? 'requirement-met' : 'requirement-not-met';
            document.getElementById('req-special').className = hasSpecial ? 'requirement-met' :
                'requirement-not-met';

            let strength = 0;
            if (hasLength) strength += 20;
            if (hasUpper) strength += 20;
            if (hasLower) strength += 20;
            if (hasNumber) strength += 20;
            if (hasSpecial) strength += 20;

            strengthBar.className = 'password-strength-bar';
            if (strength <= 20) strengthBar.classList.add('strength-weak');
            else if (strength <= 40) strengthBar.classList.add('strength-fair');
            else if (strength <= 60) strengthBar.classList.add('strength-good');
            else strengthBar.classList.add('strength-strong');
        });

        // Form loading state
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerText = 'Creating Account...';
            setTimeout(() => {
                btn.disabled = false;
                btn.innerText = 'Create Account';
            }, 5000);
        });
    </script>
@endsection
