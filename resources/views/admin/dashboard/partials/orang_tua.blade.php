<div class="row">
    <!-- Statistik Utama -->
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-gradient-primary">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="stats-icon-circle bg-white text-primary">
                            <i class="fas fa-baby"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Total Anak</h6>
                        <h4 class="font-extrabold mb-0 text-white">{{ $totalAnak }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-gradient-info">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="stats-icon-circle bg-white text-info">
                            <i class="fas fa-weight"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Penimbangan Terakhir</h6>
                        @if ($lastTimbangan)
                            @if (is_string($lastTimbangan))
                                {{ \Carbon\Carbon::parse($lastTimbangan)->format('d M Y') }}
                            @else
                                {{ $lastTimbangan->format('d M Y') }}
                            @endif
                        @else
                            -
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-gradient-success">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="stats-icon-circle bg-white text-success">
                            <i class="fas fa-syringe"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Imunisasi Berikutnya</h6>
                        <h4 class="font-extrabold mb-0 text-white">
                            {{ $nextImunisasi ? $nextImunisasi->format('d M Y') : '-' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-gradient-warning">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="stats-icon-circle bg-white text-warning">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Jadwal Posyandu</h6>
                        <h4 class="font-extrabold mb-0 text-white">
                            {{ $nextPosyandu ? $nextPosyandu->format('d M Y') : '-' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Data Anak -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Data Anak Saya</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Anak</th>
                                <th>Umur</th>
                                <th>Berat Terakhir</th>
                                <th>Tinggi Terakhir</th>
                                <th>Status Gizi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anak as $child)
                                <tr>
                                    <td>{{ $child->nama_lengkap }}</td>
                                    <td>{{ $child->umur_bulan }} bulan</td>
                                    <td>{{ $child->timbangan->last() ? $child->timbangan->last()->berat . ' kg' : '-' }}
                                    </td>
                                    <td>{{ $child->timbangan->last() ? $child->timbangan->last()->tinggi . ' cm' : '-' }}
                                    </td>
                                    <td>
                                        @if ($child->timbangan->last())
                                            <span
                                                class="badge-status bg-{{ $child->timbangan->last()->status_gizi == 'Gizi Baik'
                                                    ? 'success'
                                                    : ($child->timbangan->last()->status_gizi == 'Gizi Kurang'
                                                        ? 'warning'
                                                        : 'danger') }}">
                                                {{ $child->timbangan->last()->status_gizi }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('kms.index', $child->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Grafik Pertumbuhan Anak -->
    <div class="col-md-6">
        <div class="card card-chart">
            <div class="card-header">
                <h4>Grafik Pertumbuhan Berat Badan</h4>
            </div>
            <div class="card-body">
                <canvas id="weightChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Jadwal Imunisasi -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Jadwal Imunisasi Anak</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis Imunisasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalImunisasiAnak as $imunisasi)
                                <tr>
                                    <td>{{ $imunisasi->tanggal->format('d M Y') }}</td>
                                    <td>{{ $imunisasi->jenis_imunisasi->nama }}</td>
                                    <td>
                                        <span
                                            class="badge-status bg-{{ $imunisasi->status == 'selesai' ? 'success' : 'warning' }}">
                                            {{ ucfirst($imunisasi->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
