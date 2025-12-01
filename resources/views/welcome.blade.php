@extends('layouts.guest')

@section('title', 'Welcome')

@section('content')
    <style>
        /* Dark Mode Welcome Page Styles */
        .welcome-dark-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }

        .welcome-dark-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.05) 0%, transparent 50%);
            animation: welcome-dark-glow 8s ease-in-out infinite alternate;
        }

        @keyframes welcome-dark-glow {
            0% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .welcome-dark-content {
            position: relative;
            z-index: 2;
            padding: 4rem 2rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .welcome-dark-title {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #a8b9ff 50%, #7e69ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 30px rgba(126, 105, 255, 0.3);
            letter-spacing: -1px;
        }

        .welcome-dark-subtitle {
            font-size: 1.4rem;
            color: #94a3b8;
            margin-bottom: 4rem;
            font-weight: 300;
            line-height: 1.6;
        }

        .welcome-dark-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .welcome-dark-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            transition: left 0.6s ease;
        }

        .welcome-dark-card:hover::before {
            left: 100%;
        }

        .welcome-dark-card:hover {
            transform: translateY(-8px);
            border-color: rgba(126, 105, 255, 0.3);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(126, 105, 255, 0.1),
                0 0 50px rgba(126, 105, 255, 0.1);
        }

        .welcome-dark-card-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .welcome-dark-card-text {
            color: #94a3b8;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .welcome-dark-btn {
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .welcome-dark-btn-primary {
            background: linear-gradient(135deg, #7e69ff 0%, #5e45ff 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(126, 105, 255, 0.3);
        }

        .welcome-dark-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(126, 105, 255, 0.4);
            color: white;
        }

        .welcome-dark-btn-outline {
            background: transparent;
            border: 2px solid #7e69ff;
            color: #7e69ff;
            box-shadow: 0 4px 15px rgba(126, 105, 255, 0.2);
        }

        .welcome-dark-btn-outline:hover {
            background: rgba(126, 105, 255, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(126, 105, 255, 0.3);
            color: #a8b9ff;
        }

        .welcome-dark-btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .welcome-dark-btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
            color: white;
        }

        /* Floating particles */
        .welcome-dark-particle {
            position: absolute;
            background: rgba(126, 105, 255, 0.1);
            border-radius: 50%;
            animation: welcome-dark-float 6s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes welcome-dark-float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.7;
            }

            33% {
                transform: translateY(-20px) rotate(120deg);
                opacity: 1;
            }

            66% {
                transform: translateY(10px) rotate(240deg);
                opacity: 0.5;
            }
        }

        /* Glowing orb */
        .welcome-dark-orb {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(126, 105, 255, 0.15) 0%, transparent 70%);
            filter: blur(40px);
            animation: welcome-dark-orb-move 15s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes welcome-dark-orb-move {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.5;
            }

            25% {
                transform: translate(100px, -50px) scale(1.2);
                opacity: 0.7;
            }

            50% {
                transform: translate(-50px, 100px) scale(0.8);
                opacity: 0.3;
            }

            75% {
                transform: translate(-100px, -100px) scale(1.1);
                opacity: 0.6;
            }
        }

        /* Icon styles */
        .welcome-dark-icon {
            font-size: 2rem;
            background: linear-gradient(135deg, #7e69ff 0%, #a8b9ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Stats section */
        .welcome-dark-stats {
            margin-top: 4rem;
            padding: 2rem;
            background: rgba(15, 23, 42, 0.5);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .welcome-dark-stat {
            text-align: center;
            padding: 1rem;
        }

        .welcome-dark-stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #7e69ff 0%, #a8b9ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .welcome-dark-stat-label {
            color: #94a3b8;
            font-size: 1rem;
            font-weight: 500;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .welcome-dark-title {
                font-size: 2.5rem;
            }

            .welcome-dark-subtitle {
                font-size: 1.1rem;
            }

            .welcome-dark-content {
                padding: 2rem 1rem;
            }

            .welcome-dark-card {
                padding: 2rem 1.5rem;
            }

            .welcome-dark-card-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .welcome-dark-title {
                font-size: 2rem;
            }

            .welcome-dark-btn {
                padding: 0.875rem 1.5rem;
                font-size: 1rem;
            }

            .welcome-dark-card {
                padding: 1.5rem 1rem;
            }
        }

        /* Button group spacing */
        .welcome-dark-btn-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        @media (max-width: 576px) {
            .welcome-dark-btn-group {
                flex-direction: column;
            }

            .welcome-dark-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="welcome-dark-container">
        <!-- Floating Particles -->
        <div class="welcome-dark-particle" style="top: 20%; left: 10%; width: 8px; height: 8px; animation-delay: 0s;"></div>
        <div class="welcome-dark-particle" style="top: 60%; left: 80%; width: 12px; height: 12px; animation-delay: 2s;"></div>
        <div class="welcome-dark-particle" style="top: 80%; left: 20%; width: 6px; height: 6px; animation-delay: 4s;"></div>
        <div class="welcome-dark-particle" style="top: 40%; left: 90%; width: 10px; height: 10px; animation-delay: 1s;"></div>
        <div class="welcome-dark-particle" style="top: 10%; left: 50%; width: 14px; height: 14px; animation-delay: 3s;">
        </div>

        <!-- Glowing Orbs -->
        <div class="welcome-dark-orb" style="top: -150px; left: -150px;"></div>
        <div class="welcome-dark-orb" style="bottom: -150px; right: -150px; animation-delay: 7s;"></div>

        <div class="welcome-dark-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- Main Title -->
                        <div class="text-center mb-5">
                            <h1 class="welcome-dark-title">
                                Delivery Confirmation System
                            </h1>
                            <p class="welcome-dark-subtitle">
                                Experience next-generation delivery management with real-time tracking,<br>
                                automated confirmations, and seamless logistics coordination.
                            </p>
                        </div>

                        <!-- Access Cards -->
                        <div class="row justify-content-center">

                            {{-- USER ACCESS CARD --}}
                            @if (Auth::check() && Auth::user()->role === 'user')
                                <div class="col-lg-5 col-md-6 mb-4">
                                    <div class="welcome-dark-card h-100">
                                        <h3 class="welcome-dark-card-title">
                                            <i class="fas fa-user welcome-dark-icon"></i>
                                            User Access
                                        </h3>

                                        <p class="welcome-dark-card-text">
                                            Track your deliveries in real-time, receive instant confirmation emails,
                                            and manage your shipments with our intuitive user portal.
                                        </p>

                                        <div class="welcome-dark-btn-group">
                                            <a href="{{ route('user.dashboard') }}"
                                                class="welcome-dark-btn welcome-dark-btn-primary">
                                                <i class="fas fa-tachometer-alt me-2"></i>User Dashboard
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- ADMIN ACCESS CARD --}}
                            @if (auth('admin')->check())
                                <div class="col-lg-5 col-md-6 mb-4">
                                    <div class="welcome-dark-card h-100">
                                        <h3 class="welcome-dark-card-title">
                                            <i class="fas fa-cog welcome-dark-icon"></i>
                                            Admin Access
                                        </h3>

                                        <p class="welcome-dark-card-text">
                                            Manage delivery operations, view comprehensive analytics,
                                            and oversee system performance with powerful admin tools.
                                        </p>

                                        <div class="welcome-dark-btn-group">
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="welcome-dark-btn welcome-dark-btn-success">
                                                <i class="fas fa-tools me-2"></i>Admin Dashboard
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- GUEST ACCESS CARD (if no one is logged in) --}}
                            @if (!Auth::check() && !auth('admin')->check())
                                <div class="col-lg-5 col-md-6 mb-4">
                                    <div class="welcome-dark-card h-100">
                                        <h3 class="welcome-dark-card-title">
                                            <i class="fas fa-user welcome-dark-icon"></i>
                                            User Access
                                        </h3>

                                        <p class="welcome-dark-card-text">
                                            Track your deliveries in real-time, receive instant confirmation emails,
                                            and manage your shipments with our intuitive user portal.
                                        </p>

                                        <div class="welcome-dark-btn-group">
                                            <a href="/login" class="welcome-dark-btn welcome-dark-btn-primary">
                                                <i class="fas fa-sign-in-alt me-2"></i>Login
                                            </a>
                                            <a href="/register" class="welcome-dark-btn welcome-dark-btn-outline">
                                                <i class="fas fa-user-plus me-2"></i>Register
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5 col-md-6 mb-4">
                                    <div class="welcome-dark-card h-100">
                                        <h3 class="welcome-dark-card-title">
                                            <i class="fas fa-cog welcome-dark-icon"></i>
                                            Admin Access
                                        </h3>

                                        <p class="welcome-dark-card-text">
                                            Manage delivery operations, view comprehensive analytics,
                                            and oversee system performance with powerful admin tools.
                                        </p>

                                        <div class="welcome-dark-btn-group">
                                            <a href="/admin/login" class="welcome-dark-btn welcome-dark-btn-success">
                                                <i class="fas fa-lock me-2"></i>Admin Login
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>


                        <!-- Statistics -->
                        <div class="welcome-dark-stats">
                            <div class="row justify-content-center">
                                <div class="col-md-3 col-6 welcome-dark-stat">
                                    <div class="welcome-dark-stat-number">10K+</div>
                                    <div class="welcome-dark-stat-label">Deliveries</div>
                                </div>
                                <div class="col-md-3 col-6 welcome-dark-stat">
                                    <div class="welcome-dark-stat-number">99.8%</div>
                                    <div class="welcome-dark-stat-label">Success Rate</div>
                                </div>
                                <div class="col-md-3 col-6 welcome-dark-stat">
                                    <div class="welcome-dark-stat-number">24/7</div>
                                    <div class="welcome-dark-stat-label">Support</div>
                                </div>
                                <div class="col-md-3 col-6 welcome-dark-stat">
                                    <div class="welcome-dark-stat-number">1Hr</div>
                                    <div class="welcome-dark-stat-label">Avg. Response</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create additional floating particles dynamically
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.welcome-dark-container');
            for (let i = 0; i < 8; i++) {
                const particle = document.createElement('div');
                particle.className = 'welcome-dark-particle';
                const size = Math.random() * 8 + 4;
                const top = Math.random() * 100;
                const left = Math.random() * 100;
                const delay = Math.random() * 6;

                particle.style.cssText = `
                top: ${top}%;
                left: ${left}%;
                width: ${size}px;
                height: ${size}px;
                animation-delay: ${delay}s;
            `;

                container.appendChild(particle);
            }
        });

        // Add interactive mouse move effect
        document.addEventListener('mousemove', function(e) {
            const orb = document.querySelector('.welcome-dark-orb');
            const x = (e.clientX / window.innerWidth) * 50;
            const y = (e.clientY / window.innerHeight) * 50;
            orb.style.transform = `translate(${x}px, ${y}px)`;
        });

        // Add click effects to buttons
        document.querySelectorAll('.welcome-dark-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.5);
                transform: scale(0);
                animation: ripple-animation 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
            `;

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
        document.head.appendChild(style);
    </script>
@endsection
