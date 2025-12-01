{{-- resources/views/auth/otp-verification.blade.php --}}
@extends('layouts.app')

@section('title', 'OTP Verification')

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
            text-align: center;
            font-weight: bold;
            letter-spacing: 0.5rem;
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

        @media (max-width: 768px) {
            .user-login-body {
                padding: 1.5rem;
            }

            .user-login-header {
                padding: 1.5rem 1rem;
            }
        }
    </style>

    <div class="user-login-container">
        <div class="user-login-card">
            <div class="card-header user-login-header">
                <h4>OTP Verification</h4>
            </div>
            <div class="card-body user-login-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <p class="text-center text-muted mb-4">
                    We've sent a 6-digit verification code to your email:<br>
                    <strong>{{ Auth::user()->email }}</strong>
                </p>

                <form method="POST" action="{{ route('otp.verify.submit') }}" id="otpForm">
                    @csrf
                    <div class="mb-3">
                        <label for="otp_code" class="form-label user-form-label">Enter OTP Code</label>
                        <input type="text"
                               class="form-control user-form-control @error('otp_code') is-invalid @enderror"
                               id="otp_code"
                               name="otp_code"
                               required
                               maxlength="6"
                               minlength="6"
                               placeholder="000000"
                               pattern="[0-9]{6}"
                               title="Please enter exactly 6 digits">
                        @error('otp_code')
                            <div class="invalid-feedback user-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn user-login-btn" id="otpButton">
                        ✅ Verify OTP
                    </button>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-2 text-muted">Didn't receive the code?</p>
                    <form method="POST" action="{{ route('otp.resend') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            🔄 Resend OTP
                        </button>
                    </form>

                    @if(app()->environment('local'))
                        <div class="mt-3">
                            <form method="POST" action="{{ route('otp.skip') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">
                                    ⚡ Skip Verification (DEV ONLY)
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('otp_code').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 6) {
                document.getElementById('otpForm').submit();
            }
        });

        document.getElementById('otp_code').addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) e.preventDefault();
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('otp_code').focus();
        });
    </script>
@endsection
