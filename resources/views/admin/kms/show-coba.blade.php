@extends('layouts.app')

@section('title', 'KMS Digital')

@section('content')
    <div class="container">
        <div class="kms-card">
            <div class="kms-header">
                <div class="kms-title">KMS</div>
                <div class="kms-subtitle">KARTU MENUJU SEHAT - Untuk
                    {{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
            </div>

            <div class="kms-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5>Nama Anak: <span class="text-primary">{{ $anak->nama_lengkap }}</span></h5>
                    </div>
                    <div class="col-md-6">
                        <h5>Posyandu: <span class="text-primary">CEMPAKA</span></h5>
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>Timbanglah Anak Anda Setiap Bulan</strong><br>
                    Anak Sehat, Tambah Umur Tambah Berat, Tambah Pandai
                </div>

                <div class="chart-container">
                    <canvas id="growthChart" height="600"></canvas>
                </div>

                <div class="text-center mb-3">
                    <div class="legend-item"><span class="legend-color" style="background-color: #e74c3c;"></span>Garis
                        Merah (BB sangat rendah)</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #e67e22;"></span>Garis
                        Oranye (BB rendah)</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #2ecc71;"></span>Garis
                        Hijau (BB normal)</div>
                    <div class="legend-item"><span class="legend-color" style="background-color: #3498db;"></span>Garis Biru
                        (BB di atas normal)</div>
                </div>

                <div class="table-title">Pertumbuhan Berat Badan</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>Bulan<br>Penimbangan</th>
                                <th>BB<br>(kg)</th>
                                <th>KBM<br>(gr)</th>
                                <th>N/T</th>
                                <th colspan="2">ASI<br>Eksklusif</th>
                                <th>NAIK<br>(N)</th>
                                <th>TIDAK NAIK<br>(T)</th>
                            </tr>
                            <tr>
                                <th>Umur (Bulan)</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Ya</th>
                                <th>Tidak</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tabelBulanan as $bulan)
                                <tr>
                                    <td>{{ $bulan['bulan'] }}</td>
                                    <td>
                                        @if ($bulan['bulan'] <= ceil($umurBulan))
                                            @if ($bulan['bb'])
                                                <form action="{{ route('kms.update', $anak->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="bulan" value="{{ $bulan['bulan'] }}">
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="bb"
                                                            value="{{ number_format($bulan['bb'], 1) }}"
                                                            class="form-control form-control-sm" step="0.1"
                                                            min="1" max="30"
                                                            {{ !$bulan['editable'] ? 'disabled' : '' }}>
                                                        @if ($bulan['editable'])
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                Update
                                                            </button>
                                                        @endif
                                                    </div>
                                                </form>
                                            @else
                                                <form action="{{ route('kms.store') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="anak_id" value="{{ $anak->id }}">
                                                    <input type="hidden" name="bulan" value="{{ $bulan['bulan'] }}">
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="bb"
                                                            class="form-control form-control-sm" step="0.1"
                                                            min="1" max="30"
                                                            {{ !$bulan['editable'] ? 'disabled' : '' }}>
                                                        @if ($bulan['editable'])
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                Simpan
                                                            </button>
                                                        @endif
                                                    </div>
                                                </form>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $bulan['kbm'] ?? '-' }}</td>
                                    <td>{{ $bulan['status'] ?? '-' }}</td>
                                    <td>
                                        @if ($bulan['asi'] === 1)
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            @if ($bulan['bulan'] <= $umurBulan && is_null($bulan['asi']))
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#inputModal" data-bulan="{{ $bulan['bulan'] }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($bulan['asi'] === 0)
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            @if ($bulan['bulan'] <= $umurBulan && is_null($bulan['asi']))
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#inputModal" data-bulan="{{ $bulan['bulan'] }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($bulan['status'] == 'N')
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            @if ($bulan['bulan'] <= $umurBulan && is_null($bulan['status']))
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#inputModal" data-bulan="{{ $bulan['bulan'] }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($bulan['status'] == 'T')
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            @if ($bulan['bulan'] <= $umurBulan && is_null($bulan['status']))
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                    data-bs-target="#inputModal" data-bulan="{{ $bulan['bulan'] }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="alert alert-warning mt-3">
                    <strong>Interpretasi Grafik:</strong><br>
                    <strong>NAIK (N):</strong> Grafik BB mengikuti garis pertumbuhan atau Berat Badan Sama dengan KBM
                    (Kenaikan Berat Badan Minimal) atau lebih<br>
                    <strong>TIDAK NAIK (T):</strong> Grafik BB mendatar atau menurun memotong garis pertumbuhan di
                    bawahnya atau Berat Badan kurang dari KBM<br>
                    <small>KBM digunakan bila ada keraguan menginterpretasikan arah kurva pertumbuhan</small>
                </div>

                <div class="alert alert-danger">
                    <strong>Rujuk Bila:</strong><br>
                    - Berat Badan Anak Tidak Naik (T)<br>
                    - Di Bawah Garis Merah<br>
                    - Di Atas Garis Oranye
                </div>

                <div class="footer-note">
                    <p>Kader kesehatan melakukan plotting hasil penimbangan, ME kepada ibu dan rujukan ke petugas
                        kesehatan.<br>
                        Petugas kesehatan memastikan plotting hasil penimbangan dan menindaklanjuti segera sesuai
                        Permenkes Standar Antropometri Anak.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .kms-card {
            border: 2px solid #0056b3;
            border-radius: 10px;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .kms-header {
            background-color: #0056b3;
            color: white;
            padding: 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            text-align: center;
        }

        .kms-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .kms-subtitle {
            font-size: 16px;
        }

        .kms-body {
            padding: 20px;
        }

        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 20px;
        }

        .table-title {
            background-color: #f0f8ff;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        .table-custom {
            margin-bottom: 20px;
        }

        .table-custom th {
            background-color: #e9f5ff;
            text-align: center;
            vertical-align: middle;
        }

        .footer-note {
            font-size: 12px;
            margin-top: 20px;
            color: #555;
        }

        .legend-item {
            display: inline-block;
            margin-right: 15px;
            font-size: 12px;
        }

        .legend-color {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
            vertical-align: middle;
        }

        .table-custom td {
            text-align: center;
            vertical-align: middle;
        }

        .table-custom .form-check-input {
            transform: scale(1.2);
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
