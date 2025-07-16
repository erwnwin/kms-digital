@extends('layouts.app')

@section('title', 'Laporan Timbangan Bulanan')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Laporan Timbangan Bulanan</h3>
                    <p class="text-subtitle text-muted">Laporan berdasarkan standar KMS WHO</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Filter Laporan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan') }}" method="GET" class="form-inline">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}"
                                            {{ $month == $selectedMonth ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('laporan.export') }}?tahun={{ $selectedYear }}&bulan={{ $selectedMonth }}"
                                    class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Rekapitulasi Status Gizi</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Status Gizi</th>
                                        <th>Jumlah</th>
                                        <th>Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['statusSummary'] as $status => $count)
                                        <tr>
                                            <td>{{ $status }}</td>
                                            <td>{{ $count }}</td>
                                            <td>{{ $data['totalTimbangan'] > 0 ? round(($count / $data['totalTimbangan']) * 100, 2) : 0 }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-primary">
                                        <td><strong>Total</strong></td>
                                        <td><strong>{{ $data['totalTimbangan'] }}</strong></td>
                                        <td><strong>100%</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <canvas id="nutritionChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Detail Timbangan Per Minggu</h4>
                <p>Periode: {{ $data['startDate']->format('d F Y') }} - {{ $data['endDate']->format('d F Y') }}</p>
            </div>
            <div class="card-body">
                @foreach ($data['timbangan'] as $week => $items)
                    <div class="mb-4">
                        <h5>Minggu ke-{{ $week }}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Anak</th>
                                        <th>Umur (Bulan)</th>
                                        <th>Tanggal Timbang</th>
                                        <th>Berat (kg)</th>
                                        <th>Tinggi (cm)</th>
                                        <th>Lingkar Kepala (cm)</th>
                                        <th>Status Gizi</th>
                                        <th>Kategori Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->anak->nama_lengkap }}</td>
                                            <td>{{ $item->umur_bulan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                            <td>{{ $item->berat }}</td>
                                            <td>{{ $item->tinggi }}</td>
                                            <td>{{ $item->lingkar_kepala }}</td>
                                            <td>
                                                <span
                                                    class="badge 
                                        @if ($item->status_gizi == 'Gizi Baik') bg-success
                                        @elseif($item->status_gizi == 'Gizi Kurang') bg-warning
                                        @elseif($item->status_gizi == 'Gizi Buruk') bg-danger
                                        @else bg-info @endif">
                                                    {{ $item->status_gizi }}
                                                </span>
                                            </td>
                                            <td>{{ $item->kategori_berat }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Nutrition Status Chart
            const nutritionCtx = document.getElementById('nutritionChart').getContext('2d');
            const nutritionChart = new Chart(nutritionCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($data['statusSummary'])) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($data['statusSummary'])) !!},
                        backgroundColor: [
                            '#4CAF50', // Gizi Baik
                            '#FFC107', // Gizi Kurang
                            '#F44336', // Gizi Buruk
                            '#2196F3' // Resiko Gizi Lebih
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.raw;
                                    const percentage = Math.round((value / total) * 100);
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
