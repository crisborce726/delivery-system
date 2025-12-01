@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid py-4">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="card-title mb-0" id="totalUsers">{{ $totalUsers }}</h2>
                                <p class="card-text">Total Users</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small><i class="fas fa-arrow-up text-success"></i> 12% increase</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="card-title mb-0" id="verifiedUsers">{{ $verifiedUsers }}</h2>
                                <p class="card-text">Verified Users</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-user-check fa-2x"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small><i class="fas fa-arrow-up text-white"></i> 8% increase</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="card-title mb-0" id="unverifiedUsers">{{ $unverifiedUsers }}</h2>
                                <p class="card-text">Unverified Users</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-user-clock fa-2x"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small><i class="fas fa-arrow-down text-danger"></i> 3% decrease</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="card-title mb-0">{{ $totalDeliveries }}</h2>
                                <p class="card-text">Total Deliveries</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-shipping-fast fa-2x"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small><i class="fas fa-arrow-up text-success"></i> 15% increase</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <!-- Bar Chart -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">User Registration Growth</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                Last 7 Days
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="userGrowthChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Doughnut Chart -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">User Verification Status</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="verificationChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent User Registrations (Last 7 Days)</h5>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @if ($userRegistrations->count() > 0)
                            @foreach ($userRegistrations as $registration)
                                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                            <i class="fas fa-user-plus text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $registration->date }}</h6>
                                            <small class="text-muted">{{ $registration->count }} new users
                                                registered</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $registration->count }} users</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No recent registrations</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Last Updated -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <div class="last-updated">
                    <i class="fas fa-sync-alt me-2"></i>
                    Last updated: <span id="lastUpdated">{{ now()->format('Y-m-d H:i:s') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart data
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            // Bar Chart
            const growthCtx = document.getElementById('userGrowthChart');
            if (growthCtx) {
                new Chart(growthCtx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Users Registered',
                            data: chartData,
                            backgroundColor: 'rgba(115, 103, 240, 0.8)',
                            borderColor: 'rgba(115, 103, 240, 1)',
                            borderWidth: 1,
                            borderRadius: 5,
                            borderSkipped: false
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                },
                                ticks: {
                                    color: document.body.classList.contains('light-mode') ? '#2c3e50' :
                                        '#e4e6eb'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: document.body.classList.contains('light-mode') ? '#2c3e50' :
                                        '#e4e6eb'
                                }
                            }
                        }
                    }
                });
            }

            // Doughnut Chart
            const verificationCtx = document.getElementById('verificationChart');
            if (verificationCtx) {
                new Chart(verificationCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Verified Users', 'Unverified Users'],
                        datasets: [{
                            data: [{{ $verifiedUsers }}, {{ $unverifiedUsers }}],
                            backgroundColor: ['rgba(40, 199, 111, 0.8)', 'rgba(255, 159, 67, 0.8)'],
                            borderColor: ['rgba(40, 199, 111, 1)', 'rgba(255, 159, 67, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: document.body.classList.contains('light-mode') ? '#2c3e50' :
                                        '#e4e6eb',
                                    padding: 20
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Auto-update stats
            setInterval(updateStats, 30000);
        });

        function updateStats() {
            fetch('/admin/stats')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('totalUsers').textContent = data.totalUsers;
                    document.getElementById('verifiedUsers').textContent = data.verifiedUsers;
                    document.getElementById('unverifiedUsers').textContent = data.unverifiedUsers;
                    document.getElementById('lastUpdated').textContent = data.updatedAt;
                });
        }
    </script>
@endpush
