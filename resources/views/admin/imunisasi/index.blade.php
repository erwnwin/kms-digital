@extends('layouts.app')

@section('title', 'Data Imunisasi : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Imunisasi</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h5>Pilih Anak/Balita</h5>
                </div>
                <div class="card-body">
                    <form id="selectAnakForm" method="GET" action="{{ route('imunisasi.show') }}">
                        <div class="form-group">
                            <select class="form-control choices" id="anakSelect" name="anak_id" required>
                                <option value="">-- Pilih Anak --</option>
                                @foreach ($anakList as $anak)
                                    <option value="{{ $anak->id }}"
                                        {{ $anak->id == ($anakSelected->id ?? '') ? 'selected' : '' }}>
                                        {{ $anak->nama_lengkap }} ({{ $anak->umur_bulan }} bulan)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            @if (isset($anakSelected))
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Jadwal Imunisasi untuk {{ $anakSelected->nama_lengkap }} - Umur:
                            {{ round($anakSelected->umur_bulan) }} bulan</h4>
                        <div class="d-flex ">
                            <a href="{{ route('imunisasi.pdf', $anakSelected->id) }}" class="btn btn-sm btn-success ml-2"
                                target="_blank">
                                <i data-feather="download"></i> Export PDF
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm">
                                <!-- Header Usia (Bulan) -->
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="align-middle text-center" style="width: 25%">Jenis Vaksin
                                        </th>
                                        <th colspan="16" class="text-center">Usia (Bulan)</th> <!-- Ubah dari 15 ke 16 -->
                                    </tr>
                                    <tr>
                                        <!-- Kolom 0-12 -->
                                        @for ($i = 0; $i <= 12; $i++)
                                            <th class="text-center {{ $i == ($anakSelected->umur_bulan ?? 0) ? 'bg-warning' : '' }}"
                                                style="width: 4%">
                                                {{ $i }}
                                            </th>
                                        @endfor

                                        <!-- Kolom 18 -->
                                        <th class="text-center {{ 18 == ($anakSelected->umur_bulan ?? 0) ? 'bg-warning' : '' }}"
                                            style="width: 4%">
                                            18
                                        </th>

                                        <!-- Kolom 23 -->
                                        <th class="text-center {{ 23 == ($anakSelected->umur_bulan ?? 0) ? 'bg-warning' : '' }}"
                                            style="width: 4%">
                                            23
                                        </th>

                                        <!-- Kolom 23-39 (ditambahkan di sini) -->
                                        <th class="text-center" style="width: 4%">
                                            23-39
                                        </th>
                                    </tr>
                                </thead>

                                <!-- Daftar Vaksin -->
                                <tbody>
                                    @foreach ($jadwalImunisasi as $imunisasi)
                                        <tr>
                                            <td class="font-weight-bold">{{ $imunisasi->nama }}</td>

                                            <!-- Kolom 0-12 -->
                                            @for ($i = 0; $i <= 12; $i++)
                                                @php
                                                    $cellColor = \App\Helpers\ImunisasiHelper::determineCellColor(
                                                        $imunisasi->kode,
                                                        $i,
                                                    );
                                                    $isAllowed = !in_array($cellColor, ['#c0c0c0', '#f8f9fa']);
                                                    $isCompleted = in_array($i, $imunisasi->completedMonths ?? []);
                                                @endphp
                                                <td class="text-center align-middle"
                                                    style="background-color: {{ $cellColor }};">
                                                    @if ($isAllowed)
                                                        <input type="checkbox" class="imunisasi-checkbox"
                                                            data-imunisasi-id="{{ $imunisasi->id }}"
                                                            data-bulan="{{ $i }}"
                                                            data-anak-id="{{ $anakSelected->id }}"
                                                            data-jenis-imunisasi="{{ $imunisasi->nama }}"
                                                            {{ $isCompleted ? 'checked disabled' : '' }}>
                                                    @elseif ($isCompleted)
                                                        ✓
                                                    @else
                                                        •
                                                    @endif
                                                </td>
                                            @endfor

                                            <!-- Kolom 18 -->
                                            @php
                                                $cellColor18 = \App\Helpers\ImunisasiHelper::determineCellColor(
                                                    $imunisasi->kode,
                                                    18,
                                                );
                                                $isAllowed18 = !in_array($cellColor18, ['#c0c0c0', '#f8f9fa']);
                                                $isCompleted18 = in_array(18, $imunisasi->completedMonths ?? []);
                                            @endphp
                                            <td class="text-center align-middle"
                                                style="background-color: {{ $cellColor18 }};">
                                                @if ($isAllowed18)
                                                    <input type="checkbox" class="imunisasi-checkbox"
                                                        data-imunisasi-id="{{ $imunisasi->id }}" data-bulan="18"
                                                        data-anak-id="{{ $anakSelected->id }}"
                                                        data-jenis-imunisasi="{{ $imunisasi->nama }}"
                                                        {{ $isCompleted18 ? 'checked disabled' : '' }}>
                                                @elseif ($isCompleted18)
                                                    ✓
                                                @else
                                                    •
                                                @endif
                                            </td>

                                            <!-- Kolom 23 -->
                                            @php
                                                $cellColor23 = \App\Helpers\ImunisasiHelper::determineCellColor(
                                                    $imunisasi->kode,
                                                    23,
                                                );
                                                $isAllowed23 = !in_array($cellColor23, ['#c0c0c0', '#f8f9fa']);
                                                $isCompleted23 = in_array(23, $imunisasi->completedMonths ?? []);
                                            @endphp
                                            <td class="text-center align-middle"
                                                style="background-color: {{ $cellColor23 }};">
                                                @if ($isAllowed23)
                                                    <input type="checkbox" class="imunisasi-checkbox"
                                                        data-imunisasi-id="{{ $imunisasi->id }}" data-bulan="23"
                                                        data-anak-id="{{ $anakSelected->id }}"
                                                        data-jenis-imunisasi="{{ $imunisasi->nama }}"
                                                        {{ $isCompleted23 ? 'checked disabled' : '' }}>
                                                @elseif ($isCompleted23)
                                                    ✓
                                                @else
                                                    •
                                                @endif
                                            </td>

                                            <!-- Kolom 23-39 -->
                                            @php
                                                $lastCellColor = \App\Helpers\ImunisasiHelper::determineCellColor(
                                                    $imunisasi->kode,
                                                    24, // Representasi 23-39
                                                );
                                                $isAllowed24 = !in_array($lastCellColor, ['#c0c0c0', '#f8f9fa']);
                                                $isCompleted24 = in_array(24, $imunisasi->completedMonths ?? []);
                                            @endphp
                                            <td class="text-center align-middle"
                                                style="background-color: {{ $lastCellColor }};">
                                                @if ($isAllowed24)
                                                    <input type="checkbox" class="imunisasi-checkbox"
                                                        data-imunisasi-id="{{ $imunisasi->id }}" data-bulan="24"
                                                        data-anak-id="{{ $anakSelected->id }}"
                                                        data-jenis-imunisasi="{{ $imunisasi->nama }}"
                                                        {{ $isCompleted24 ? 'checked disabled' : '' }}>
                                                @elseif ($isCompleted24)
                                                    ✓
                                                @else
                                                    •
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td><span>
                                                <p></p>
                                            </span></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><span>
                                                <p></p>
                                            </span></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tanda Pemberian dan Paraf Petugas</h5>
                        <div class="row">
                            @foreach ($jadwalImunisasi as $imunisasi)
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>{{ $imunisasi->nama }}</span>
                                        <span class="text-muted">No. Reg: ___________</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> --}}

                <!-- Keterangan -->
                <div class="alert alert-info">
                    <strong>Keterangan:</strong>
                    <ul class="mb-0">
                        <li>✓ : Sudah diberikan</li>
                        <li>• : Belum diberikan</li>
                    </ul>
                </div>

                <!-- Referensi Warna -->
                <div class="alert alert-light">
                    <strong>Referensi:</strong>
                    <ul class="mb-0">
                        <li>Usia tepat pemberian imunisasi</li>
                        <li>Usia yang masih diperbolehkan untuk melengkapi imunisasi bayi dan baduta (bawah
                            dua tahun)</li>
                        <li>Usia pemberian imunisasi bayi dan baduta yang belum lengkap (imunisasi kejar)
                        </li>
                        <li>Usia yang tidak diperbolehkan untuk pemberian imunisasi</li>
                    </ul>
                </div>

                <div class="">
                    <h5 class="mb-3">Catatan Imunisasi</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="120px"></th>
                                    <th>Tanggal</th>
                                    <th>Jenis Imunisasi</th>
                                    <th>Dosis</th>
                                    <th>Keterangan</th>
                                    <th>Paraf Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anakSelected->imunisasi as $imunisasi)
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($imunisasi->pivot->created_at);
                                        $canUndo =
                                            $createdAt->diffInMinutes(now()) <= 20 &&
                                            $imunisasi->pivot->petugas_id == 1;
                                    @endphp
                                    <tr>
                                        <td>
                                            @if ($canUndo)
                                                <button class="btn btn-sm btn-danger btn-undu-paraf"
                                                    data-pivot-id="{{ $imunisasi->pivot->id }}"
                                                    data-imunisasi-name="{{ $imunisasi->nama }}"
                                                    data-dosis="{{ $imunisasi->pivot->dosis }}"
                                                    data-tanggal="{{ \Carbon\Carbon::parse($imunisasi->pivot->tanggal)->format('d/m/Y') }}">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            @else
                                                <span class="text-muted">
                                                    @if ($imunisasi->pivot->petugas_id != 1)
                                                        Hanya pembuat paraf yang bisa membatalkan
                                                    @else
                                                        Waktu batalkan habis
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($imunisasi->pivot->tanggal)->format('d/m/Y') }}
                                        </td>
                                        <td>{{ $imunisasi->nama }}</td>
                                        <td>Dosis ke-{{ $imunisasi->pivot->dosis }}</td>
                                        <td>{{ $imunisasi->pivot->keterangan ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-info">Sudah Paraf</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada catatan imunisasi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .btn-imunisasi {
            width: 30px;
            height: 30px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Warna lebih jelas dan kontras */
        .bg-putih {
            background-color: #FFFFFF !important;
            border: 1px solid #ddd !important;
        }

        .bg-kuning {
            background-color: #FFEB3B !important;
            border: 1px solid #ddd !important;
        }

        .bg-merah {
            background-color: #F44336 !important;
            border: 1px solid #ddd !important;
            color: white !important;
        }

        .bg-abu {
            background-color: #9E9E9E !important;
            border: 1px solid #ddd !important;
            color: white !important;
        }

        /* Highlight bulan saat ini */
        .bg-warning {
            background-color: #FFC107 !important;
            font-weight: bold;
            border: 2px solid #FF9800 !important;
        }

        .imunisasi-checkbox {
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .table td {
            position: relative;
        }

        .table td input[type="checkbox"] {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle anak selection change
            $('#anakSelect').change(function() {
                if ($(this).val()) {
                    Swal.fire({
                        title: 'Memuat Data...',
                        text: 'Silakan tunggu sebentar',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                            // Submit setelah delay kecil agar animasi terlihat
                            setTimeout(() => {
                                $('#selectAnakForm').submit();
                            }, 800); // 800ms delay
                        }
                    });
                }
            });


            // Handle imunisasi checkbox click
            $(document).ready(function() {
                // Handle checkbox imunisasi
                $(document).on('change', '.imunisasi-checkbox', function() {
                    const imunisasiId = $(this).data('imunisasi-id');
                    const anakId = $(this).data('anak-id');
                    const bulan = $(this).data('bulan');
                    const jenisImunisasi = $(this).data('jenis-imunisasi');
                    const isChecked = $(this).is(':checked');

                    if (isChecked) {
                        // Tampilkan modal untuk input dosis jika dicentang
                        Swal.fire({
                            title: 'Input Dosis Imunisasi',
                            html: `
                    <form id="dosisForm">
                        <div class="form-group">
                            <label for="swalDosis">Dosis ke-</label>
                            <input type="number" id="swalDosis" class="form-control" min="1" value="1" required>
                        </div>
                        <div class="form-group">
                            <label for="swalTanggal">Tanggal</label>
                            <input type="date" id="swalTanggal" class="form-control" value="${new Date().toISOString().split('T')[0]}" required>
                        </div>
                    </form>
                `,
                            showCancelButton: true,
                            confirmButtonText: 'Simpan',
                            confirmButtonColor: '#176265', // warna tema
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'Batal',
                            focusConfirm: false,
                            preConfirm: () => {
                                const dosis = $('#swalDosis').val();
                                const tanggal = $('#swalTanggal').val();

                                if (!dosis || !tanggal) {
                                    Swal.showValidationMessage('Harap isi semua field');
                                    return false;
                                }

                                return {
                                    dosis,
                                    tanggal
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Kirim request AJAX dengan data dosis
                                $.ajax({
                                    url: '/imunisasi/toggle',
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        anak_id: anakId,
                                        imunisasi_id: imunisasiId,
                                        bulan: bulan,
                                        is_checked: true,
                                        dosis: result.value.dosis,
                                        tanggal: result.value.tanggal
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: 'Imunisasi berhasil disimpan',
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(() => {
                                                location.reload();
                                            });
                                        }
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'error',
                                            title: 'Gagal menyimpan imunisasi',
                                            text: xhr.responseJSON
                                                ?.message ||
                                                'Terjadi kesalahan',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                    }
                                });
                            } else {
                                // Batalkan centang jika user membatalkan
                                $(this).prop('checked', false);
                            }
                        });
                    } else {
                        // Jika dicentang ulang (uncheck)
                        Swal.fire({
                            title: 'Konfirmasi',
                            text: `Apakah Anda yakin ingin menghapus data imunisasi ${jenisImunisasi}?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal',
                            position: 'top'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/imunisasi/toggle',
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        anak_id: anakId,
                                        imunisasi_id: imunisasiId,
                                        bulan: bulan,
                                        is_checked: false
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: 'Imunisasi berhasil dihapus',
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(() => {
                                                location.reload();
                                            });
                                        }
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'error',
                                            title: 'Gagal menghapus imunisasi',
                                            text: xhr.responseJSON
                                                ?.message ||
                                                'Terjadi kesalahan',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                    }
                                });
                            } else {
                                // Batalkan uncheck jika user membatalkan
                                $(this).prop('checked', true);
                            }
                        });
                    }
                });
            });

            // Reset checkbox jika modal ditutup tanpa submit
            $('#imunisasiModal').on('hidden.bs.modal', function() {
                $('.imunisasi-checkbox').prop('checked', false);
            });

            // Handle form submission
            $('#imunisasiForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#imunisasiModal').modal('hide');
                        location.reload(); // Reload halaman untuk update tampilan
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-undu-paraf', function() {
                const btn = $(this);
                const pivotId = btn.data('pivot-id');
                const imunisasiName = btn.data('imunisasi-name');
                const dosis = btn.data('dosis');
                const tanggal = btn.data('tanggal');

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

                Swal.fire({
                    title: 'Batalkan Paraf Imunisasi',
                    html: `
                <p>Anda akan membatalkan paraf untuk:</p>
                <ul>
                    <li>Jenis: <strong>${imunisasiName}</strong></li>
                    <li>Dosis: <strong>ke-${dosis}</strong></li>
                    <li>Tanggal: <strong>${tanggal}</strong></li>
                </ul>
                <p class="text-danger">Aksi ini hanya bisa dilakukan dalam 20 menit setelah paraf!</p>
            `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Tidak',
                    confirmButtonColor: '#d33',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/imunisasi/batalkan-paraf',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                pivot_id: pivotId
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message,
                                        showConfirmButton: true
                                    });
                                    btn.prop('disabled', false).html(
                                        '<i data-feather="trash-2"></i>');
                                }
                            },
                            error: function(xhr) {
                                let message = "Terjadi kesalahan sistem";
                                if (xhr.status === 404 || xhr.status === 400) {
                                    message = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Error',
                                    text: message,
                                    showConfirmButton: true
                                });
                                btn.prop('disabled', false).html(
                                    '<i data-feather="trash-2"></i>');
                            }
                        });
                    } else {
                        btn.prop('disabled', false).html('<i data-feather="trash-2"></i>');
                    }
                });
            });
        });
    </script>
@endpush
