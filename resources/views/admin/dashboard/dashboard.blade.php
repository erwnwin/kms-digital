@extends('layouts.app')

@section('title', 'Dashboard : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 class="text-primary">Dashboard {{ Str::title(str_replace('_', ' ', Auth::user()->role)) }}</h3>
                    <p class="text-subtitle text-muted">Sistem Manajemen Posyandu Terpadu</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Content Berdasarkan Role -->
        @if (Auth::user()->isKordinator())
            @include('admin.dashboard.partials.kordinator')
        @elseif(Auth::user()->isKader())
            @include('admin.dashboard.partials.kader')
        @elseif(Auth::user()->isOrangTua())
            @include('admin.dashboard.partials.orang_tua')
        @endif
    </div>
@endsection

@push('styles')
    <style>
        /* Custom Styles */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #32c5bb 0%, #1a858b 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #00bcd4 0%, #008ba3 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #f44336 0%, #c62828 100%);
        }

        .bg-gradient-secondary {
            background: linear-gradient(135deg, #9e9e9e 0%, #616161 100%);
        }

        .stats-icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .card-chart {
            min-height: 300px;
        }

        .recent-activity-item {
            border-left: 3px solid #32c5bb;
            padding-left: 15px;
            margin-bottom: 15px;
        }

        .activity-date {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .activity-content {
            font-size: 0.9rem;
        }

        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi chart untuk dashboard
            @if (Auth::user()->isKordinator() || Auth::user()->isKader())
                initGrowthChart();
                initNutritionStatusChart();
            @endif

            // Tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });

        function initGrowthChart() {
            // Implementasi chart pertumbuhan anak
            const growthChart = new Chart(document.getElementById('growthChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Rata-rata Berat Badan (kg)',
                        data: [7.2, 7.5, 7.8, 8.1, 8.4, 8.7, 9.0, 9.3, 9.6, 9.9, 10.2, 10.5],
                        borderColor: '#32c5bb',
                        backgroundColor: 'rgba(50, 197, 187, 0.1)',
                        tension: 0.3,
                        fill: true
                    }, {
                        label: 'Rata-rata Tinggi Badan (cm)',
                        data: [65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76],
                        borderColor: '#00bcd4',
                        backgroundColor: 'rgba(0, 188, 212, 0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        }

        function initNutritionStatusChart() {
            // Implementasi chart status gizi
            const nutritionChart = new Chart(document.getElementById('nutritionChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Gizi Baik', 'Gizi Kurang', 'Gizi Buruk', 'Resiko Gizi Lebih'],
                    datasets: [{
                        data: [65, 15, 5, 15],
                        backgroundColor: [
                            '#4caf50',
                            '#ff9800',
                            '#f44336',
                            '#00bcd4'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    </script>
@endpush
