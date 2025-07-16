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
                        <h6 class="text-white font-semibold">Anak Binaan</h6>
                        <h4 class="font-extrabold mb-0 text-white">{{ $anakBinaan }}</h4>
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
                        <h6 class="text-white font-semibold">Penimbangan Bulan Ini</h6>
                        <h4 class="font-extrabold mb-0 text-white">{{ $penimbanganBulanIni }}</h4>
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
                        <h6 class="text-white font-semibold">Imunisasi Bulan Ini</h6>
                        <h4 class="font-extrabold mb-0 text-white">{{ $imunisasiBulanIni }}</h4>
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
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-white font-semibold">Perlu Tindak Lanjut</h6>
                        <h4 class="font-extrabold mb-0 text-white">{{ $perluTindakLanjut }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Daftar Anak Perlu Timbangan -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>Anak Perlu Penimbangan</h4>
                <a href="{{ route('kms.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Anak</th>
                                <th>Umur</th>
                                <th>Terakhir Timbang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anakPerluTimbang as $anak)
                                <tr>
                                    <td>{{ $anak->nama_lengkap }}</td>
                                    <td>{{ $anak->umur_bulan }} bulan</td>
                                    <td>
                                        @if ($anak->timbangan->last())
                                            @php
                                                $tanggal = $anak->timbangan->last()->tanggal;
                                                $tanggal = \Carbon\Carbon::parse($tanggal); // Konversi ke Carbon
                                            @endphp
                                            {{ $tanggal->format('d M Y') }}
                                        @else
                                            Belum pernah
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Anak Perlu Imunisasi -->

</div>
