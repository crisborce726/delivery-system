@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    <div class="container-fluid py-4">
        
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="card-title mb-0" id="totalDeliveries">{{ $totalDeliveries }}</h2>
                                <p class="card-text">Total Deliveries</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-shipping-fast fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card stat-card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="card-title mb-0" id="pendingDeliveries">{{ $pendingDeliveries }}</h2>
                                <p class="card-text">Pending Deliveries</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="card-title mb-0" id="completedDeliveries">{{ $completedDeliveries }}</h2>
                                <p class="card-text">Completed Deliveries</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Deliveries in Last 7 Days</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="deliveryChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Deliveries -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Deliveries</h5>
                    </div>
                    <div class="card-body">
                        @if ($recentDeliveries->count() > 0)
                            @foreach ($recentDeliveries as $delivery)
                                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                    <div>
                                        <h6 class="mb-0">{{ $delivery->created_at->format('Y-m-d H:i') }}</h6>
                                        <small class="text-muted">Status: {{ ucfirst($delivery->status) }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">ID: {{ $delivery->id }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No recent deliveries</p>
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
            // Theme toggle
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = themeToggle.querySelector('i');
            const currentTheme = localStorage.getItem('theme') || 'dark';
            document.body.classList.toggle('light-mode', currentTheme === 'light');
            themeIcon.className = currentTheme === 'light' ? 'fas fa-sun' : 'fas fa-moon';

            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('light-mode');
                themeIcon.className = document.body.classList.contains('light-mode') ? 'fas fa-sun' :
                    'fas fa-moon';
                localStorage.setItem('theme', document.body.classList.contains('light-mode') ? 'light' :
                    'dark');
            });

            // Chart
            const ctx = document.getElementById('deliveryChart').getContext('2d');
            const deliveryChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Deliveries',
                        data: @json($chartData),
                        backgroundColor: 'rgba(115, 103, 240, 0.8)',
                        borderColor: 'rgba(115, 103, 240, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
