@extends('layouts.app')

@section('title', 'KMS Digital - ' . $anak->nama_lengkap)

@section('content')

    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>KMS Digital - {{ $anak->nama_lengkap }}</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('kms.index') }}"
                                    class="btn btn-sm btn-secondary">Kembali</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card-header text-white"
                style="background-color: {{ $anak->jenis_kelamin == 'L' ? 'rgba(13, 110, 253, 0.5)' : 'rgba(220, 53, 69, 0.5)' }}">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-white">
                        <i class="fas fa-child"></i> KMS Digital - {{ $anak->nama_lengkap }}
                    </h4>
                    <a href="{{ route('kms.pdf.v1', Crypt::encrypt($anak->id)) }}" class="btn btn-danger btn-sm"
                        target="_blank">
                        <i data-feather="download"></i> Export PDF
                    </a>
                </div>
            </div>


            <!-- Info Anak -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="alert alert-light-primary color-info text-secondary">Nama Anak : {{ $anak->nama_lengkap }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-light-primary color-info text-secondary">Umur : : {{ $umurBulan }} bulan
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="card mb-4 mt-2">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line"></i> Grafik Pertumbuhan Berat Badan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 400px;">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>


            <div class="card ">
                <div class="card-header text-white bg-info">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Keterangan Status Gizi Berdasarkan Grafik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-square" style="color: #e74c3c"></i> Garis Merah (Sangat
                                        Rendah)</span>
                                    <span class="badge bg-danger">Gizi Buruk</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-square" style="color: #e67e22"></i> Garis Oranye (Rendah)</span>
                                    <span class="badge bg-warning text-dark">Gizi Kurang</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-square" style="color: #2ecc71"></i> Antara Batas Bawah - Batas
                                        Atas Normal</span>
                                    <span class="badge bg-success">Normal (Gizi Baik)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-square" style="color: #3498db"></i> Garis Biru (Tinggi)</span>
                                    <span class="badge bg-primary">Overweight</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-square" style="color: #3498db"></i> Garis Paling Atas (Sangat
                                        Tinggi)</span>
                                    <span class="badge bg-danger">Obesitas</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Nutritional Status -->
            @if (count($tabelBulanan) > 0 && ($latestBb = collect($tabelBulanan)->where('bb', '!=', null)->last()))
                <div class="card">
                    <div
                        class="card-header text-white 
                        @if ($latestBb['status_gizi'] == 'Sangat Kurang') bg-danger
                        @elseif($latestBb['status_gizi'] == 'Kurang') bg-warning text-dark
                        @elseif($latestBb['status_gizi'] == 'Normal') bg-success
                        @elseif($latestBb['status_gizi'] == 'Lebih') bg-primary
                        @else bg-danger @endif">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clipboard-check"></i> Status Gizi Terakhir
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-light">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Bulan ke:</strong> {{ $latestBb['bulan'] }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Berat Badan:</strong> {{ $latestBb['bb'] }} kg</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Status Gizi:</strong>
                                        <span
                                            class="badge 
                                            @if ($latestBb['status_gizi'] == 'Sangat Kurang') bg-danger
                                            @elseif($latestBb['status_gizi'] == 'Kurang') bg-warning text-dark
                                            @elseif($latestBb['status_gizi'] == 'Normal') bg-success
                                            @elseif($latestBb['status_gizi'] == 'Lebih') bg-primary
                                            @else bg-danger @endif">
                                            {{ $latestBb['status_gizi'] }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div
                                        class="callout 
                                        @if ($latestBb['status_gizi'] == 'Sangat Kurang') callout-danger
                                        @elseif($latestBb['status_gizi'] == 'Kurang') callout-warning
                                        @elseif($latestBb['status_gizi'] == 'Normal') callout-success
                                        @elseif($latestBb['status_gizi'] == 'Lebih') callout-primary
                                        @else callout-danger @endif">
                                        <h5><i class="fas fa-info-circle"></i> Keterangan:</h5>
                                        <p>
                                            @if ($latestBb['status_gizi'] == 'Sangat Kurang')
                                                Berat badan anak berada di bawah garis merah (Sangat Rendah), menunjukkan
                                                <strong>Gizi Buruk</strong>. Segera konsultasikan dengan tenaga kesehatan
                                                untuk penanganan lebih lanjut.
                                            @elseif($latestBb['status_gizi'] == 'Kurang')
                                                Berat badan anak berada di antara garis merah dan oranye, menunjukkan
                                                <strong>Gizi Kurang</strong>. Perhatikan asupan gizi anak dan konsultasikan
                                                dengan tenaga kesehatan.
                                            @elseif($latestBb['status_gizi'] == 'Normal')
                                                Berat badan anak berada dalam kisaran normal (antara batas bawah dan atas
                                                normal), menunjukkan <strong>Gizi Baik</strong>. Pertahankan pola makan dan
                                                asupan gizi yang seimbang.
                                            @elseif($latestBb['status_gizi'] == 'Lebih')
                                                Berat badan anak berada di atas batas normal, menunjukkan
                                                <strong>Overweight</strong>. Perhatikan pola makan dan aktivitas fisik anak
                                                untuk mencegah obesitas.
                                            @else
                                                Berat badan anak berada di atas garis biru (Sangat Tinggi), menunjukkan
                                                <strong>Obesitas</strong>. Segera konsultasikan dengan tenaga kesehatan
                                                untuk penanganan lebih lanjut.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table"></i> Data Penimbangan Bulanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm custom-table">
                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="2" class="align-middle">Bulan</th>
                                    <th rowspan="2" class="align-middle">BB (kg)</th>
                                    <th rowspan="2" class="align-middle">KBM (gr)</th>
                                    {{-- <th rowspan="2" class="align-middle">Status</th>
                                    <th colspan="2" class="text-center">ASI Eksklusif
                                    </th>
                                    <th colspan="2" class="text-center">Kenaikan BB</th> --}}
                                </tr>
                                {{-- <tr>
                                    <th class="text-center">Ya</th>
                                    <th class="text-center">Tidak</th>
                                    <th class="text-center">Naik (N)</th>
                                    <th class="text-center">Tidak (T)</th>
                                </tr> --}}
                            </thead>
                            <tbody>
                                @foreach ($tabelBulanan as $bulan)
                                    <tr>
                                        <td>{{ $bulan['bulan'] }}</td>
                                        <td>
                                            @if ($bulan['bulan'] <= ceil($umurBulan))
                                                @if ($bulan['bb'])
                                                    <form action="{{ route('kms.update.v1', Crypt::encrypt($anak->id)) }}"
                                                        method="POST">
                                                        @csrf @method('PUT')
                                                        <div class="input-group input-group-sm">
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $bulan['bulan'] }}">
                                                            <input type="number" name="bb"
                                                                value="{{ number_format($bulan['bb'], 1, '.', '') }}"
                                                                class="form-control" step="0.1" min="1"
                                                                max="30"
                                                                {{ !$bulan['editable'] ? 'disabled' : '' }}>
                                                            @if ($bulan['editable'])
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-primary" type="submit">
                                                                        <i class="fas fa-save"></i> Update
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        {{-- <small class="text-muted">Status:
                                                            {{ $bulan['status_gizi'] ?? '-' }}</small> --}}
                                                    </form>
                                                @else
                                                    <form action="{{ route('kms.store.v1') }}" method="POST">
                                                        @csrf
                                                        <div class="input-group input-group-sm">
                                                            <input type="hidden" name="anak_id"
                                                                value="{{ Crypt::encrypt($anak->id) }}">
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $bulan['bulan'] }}">
                                                            <input type="number" name="bb" class="form-control"
                                                                step="0.1" min="1" max="30"
                                                                {{ !$bulan['editable'] ? 'disabled' : '' }}>
                                                            @if ($bulan['editable'])
                                                                <div class="input-group-append">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary" type="submit">
                                                                            <i class="fas fa-save"></i> Simpan
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </form>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $bulan['kbm'] ?? '-' }}</td>
                                        {{-- <td>{{ $bulan['status'] ?? '-' }}</td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection

@push('styles')
    <style>
        table.custom-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            overflow: hidden;
        }

        table.custom-table thead {
            background-color: #338c85;
            color: #fff;
            text-align: center;
        }

        table.custom-table th,
        table.custom-table td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: center;
        }

        table.custom-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table.custom-table tbody tr:hover {
            background-color: #eef3f7;
        }

        table.custom-table th {
            font-weight: 600;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {


            // Chart configuration
            const ctx = document.getElementById('growthChart').getContext('2d');

            const standarData = {!! json_encode($standarPertumbuhan) !!};

            // Data aktual anak
            const anakData = {!! json_encode($tabelBulanan) !!};
            const bbAnak = anakData.map(item => item.bb);

            const growthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: standarData.umur_bulan,
                    datasets: [
                        // Garis -3SD (Merah)
                        {
                            label: 'Sangat Rendah (Garis Merah)',
                            data: standarData.veryLow,
                            borderColor: '#e74c3c',
                            backgroundColor: 'rgba(231, 76, 60, 0.1)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                        },
                        {
                            label: 'Rendah (Garis Oranye)',
                            data: standarData.low,
                            borderColor: '#e67e22',
                            backgroundColor: 'rgba(230, 126, 34, 0.1)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                        },
                        {
                            label: 'Batas Bawah Normal',
                            data: standarData.normalLow,
                            borderColor: '#2ecc71',
                            backgroundColor: 'rgba(46, 204, 113, 0.1)',
                            borderWidth: 1,
                            borderDash: [3, 3],
                            fill: false,
                            pointRadius: 0
                        },
                        {
                            label: 'Median WHO',
                            data: standarData.median,
                            borderColor: '#2ecc71',
                            backgroundColor: 'rgba(46, 204, 113, 0.1)',
                            borderWidth: 2,
                            fill: false,
                            pointRadius: 0
                        },
                        {
                            label: 'Batas Atas Normal',
                            data: standarData.normalHigh,
                            borderColor: '#2ecc71',
                            backgroundColor: 'rgba(46, 204, 113, 0.1)',
                            borderWidth: 1,
                            borderDash: [3, 3],
                            fill: false,
                            pointRadius: 0
                        },
                        {
                            label: 'Tinggi (Garis Biru)',
                            data: standarData.high,
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                        },
                        {
                            label: 'Sangat Tinggi',
                            data: standarData.veryHigh,
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                        },
                        // Data aktual anak
                        {
                            label: 'Berat Badan Anak',
                            data: bbAnak,
                            borderColor: '#000000',
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            borderWidth: 3,
                            pointRadius: 5,
                            pointBackgroundColor: '#000000',
                            pointHoverRadius: 7,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Umur (Bulan)',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: true
                            },
                            ticks: {
                                stepSize: 1,
                                autoSkip: false
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Berat Badan (kg)',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            min: 0,
                            max: 18,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : '';
                                },
                                autoSkip: false,
                                maxTicksLimit: 20,
                                font: {
                                    size: 10
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                lineWidth: 1,
                                drawBorder: true
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 20,
                                font: {
                                    size: 10
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toFixed(1) +
                                        ' kg';
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });
        });
    </script>
@endpush
