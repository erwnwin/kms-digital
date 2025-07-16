<div class="row">
    <!-- Statistik Utama -->
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-gradient-primary">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="stats-icon-circle bg-white text-primary">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Total Pengguna</h6>
                        <h4 class="font-extrabold mb-0 text-white">{{ $totalUsers }}</h4>
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
        <div class="card bg-gradient-success">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="stats-icon-circle bg-white text-success">
                            <i class="fas fa-user-nurse"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Total Kader</h6>
                        <h4 class="font-extrabold mb-0 text-white">{{ $totalKader }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card bg-gradient-danger">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="stats-icon-circle bg-white text-danger">
                            <i class="fas fa-home"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Total Posyandu</h6>
                        <h4 class="font-extrabold mb-0 text-white">{{ $totalPosyandu }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Chart Pertumbuhan Anak -->
    <div class="col-md-8">
        <div class="card card-chart">
            <div class="card-header">
                <h4>Grafik Pertumbuhan Anak</h4>
            </div>
            <div class="card-body">
                <canvas id="growthChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Status Gizi -->
    <div class="col-md-4">
        <div class="card card-chart">
            <div class="card-header">
                <h4>Status Gizi Anak</h4>
            </div>
            <div class="card-body">
                <canvas id="nutritionChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Jadwal Imunisasi Terdekat -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>Jadwal Imunisasi Terdekat</h4>
                <a href="{{ route('jadwal-imunisasi') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalImunisasi as $jadwal)
                                <tr>
                                    <td>{{ $jadwal->start_date->format('d M Y') }}</td>
                                    <td>{{ $jadwal->title }}</td>
                                    <td>{{ $jadwal->location }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terkini -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Aktivitas Terkini</h4>
            </div>
            <div class="card-body">
                @foreach ($recentActivities as $activity)
                    <div class="recent-activity-item">
                        <div class="activity-date">{{ $activity->created_at->diffForHumans() }}</div>
                        <div class="activity-content">{{ $activity->description }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
