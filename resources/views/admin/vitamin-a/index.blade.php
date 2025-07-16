@extends('layouts.app')

@section('title', 'Pemberian Vitamin A : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Pemberian Vitamin A</h3>
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
                    <form id="selectAnakForm" method="GET" action="{{ route('vitamin-a.show') }}">
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
                        <h4 class="card-title">Pemberian Vitamin A untuk {{ $anakSelected->nama_lengkap }} - Umur:
                            {{ round($anakSelected->umur_bulan) }} bulan</h4>
                        <div class="d-flex">
                            <a href="{{ route('vitamin-a.pdf', Crypt::encrypt($anakSelected->id)) }}"
                                class="btn btn-sm btn-success ml-2" target="_blank">
                                <i data-feather="download"></i> Export PDF
                            </a>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th rowspan="3" class="align-middle text-center bg-success text-white"
                                            style="width: 25%">Usia</th>
                                        <th colspan="3" class="text-center bg-success text-white">Kapsul Vitamin A</th>
                                        <th rowspan="3" class="align-middle text-center bg-success text-white">Obat
                                            Cacing</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center bg-info">Kapsul Biru<br>(100.000 IU)</th>
                                        <th colspan="2" class="text-center bg-danger text-white">Kapsul Merah<br>(200.000
                                            IU)</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center bg-info">Februari atau Agustus</th>
                                        <th class="text-center bg-danger text-white">Februari</th>
                                        <th class="text-center bg-danger text-white">Agustus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $usiaBulan = $anakSelected->umur_bulan;
                                        $currentMonth = date('n');
                                        $isFeb = $currentMonth == 2; // Februari
                                        $isAug = $currentMonth == 8; // Agustus

                                        // Untuk testing manual (comment saat production)
                                        // $isFeb = true; // Uncomment untuk testing Februari
                                        // $isAug = true; // Uncomment untuk testing Agustus
                                        // $currentMonth = $isFeb ? 2 : ($isAug ? 8 : date('n'));

                                        $ageGroups = [
                                            ['min' => 6, 'max' => 11, 'label' => '6 - 11 bulan'],
                                            ['min' => 12, 'max' => 23, 'label' => '1 - 2 tahun'],
                                            ['min' => 24, 'max' => 35, 'label' => '2 - 3 tahun'],
                                            ['min' => 36, 'max' => 47, 'label' => '3 - 4 tahun'],
                                            ['min' => 48, 'max' => 59, 'label' => '4 - 5 tahun'],
                                            ['min' => 60, 'max' => 71, 'label' => '5 - 6 tahun'],
                                        ];
                                    @endphp

                                    @foreach ($ageGroups as $index => $group)
                                        @php
                                            $isActive = $usiaBulan >= $group['min'] && $usiaBulan <= $group['max'];

                                            // Tentukan eligibility
                                            $eligibleBiru = $group['min'] == 6 && $group['max'] == 11;
                                            $eligibleMerah = $group['min'] >= 12 && $group['max'] <= 59;
                                            $eligibleCacing = $group['min'] >= 12 && $group['max'] <= 71;

                                            // Warna sel
                                            $biruColor = $eligibleBiru ? '#ffffff' : '#aeb3af';
                                            $merahFebColor =
                                                $eligibleMerah && $index != 0 && $index != 5 ? '#ffffff' : '#aeb3af';
                                            $merahAugColor =
                                                $eligibleMerah && $index != 0 && $index != 5 ? '#ffffff' : '#aeb3af';
                                            $cacingColor = $eligibleCacing && $index != 0 ? '#ffffff' : '#aeb3af';

                                            $rowClass = $isActive ? 'table-active' : '';

                                            // Cek data yang sudah ada
                                            $hasBiru = $eligibleBiru
                                                ? $anakSelected->hasVitaminA('biru', $group['min'], $group['max'])
                                                : false;
                                            $hasMerahFeb = $eligibleMerah
                                                ? $anakSelected->hasVitaminA(
                                                    'merah',
                                                    $group['min'],
                                                    $group['max'],
                                                    'feb',
                                                )
                                                : false;
                                            $hasMerahAug = $eligibleMerah
                                                ? $anakSelected->hasVitaminA(
                                                    'merah',
                                                    $group['min'],
                                                    $group['max'],
                                                    'aug',
                                                )
                                                : false;
                                            $hasCacing = $eligibleCacing
                                                ? $anakSelected->hasObatCacing($group['min'], $group['max'])
                                                : false;
                                        @endphp

                                        <tr class="{{ $rowClass }}">
                                            <td>{{ $group['label'] }}</td>

                                            <!-- Kapsul Biru Column -->
                                            <td class="text-center align-middle"
                                                style="background-color: {{ $biruColor }};">
                                                @if ($biruColor == '#ffffff' && ($isFeb || $isAug))
                                                    <input type="checkbox" class="vitamin-checkbox" data-jenis="Vitamin A"
                                                        data-warna="biru" data-bulan="{{ $isFeb ? 'feb' : 'aug' }}"
                                                        data-anak-id="{{ $anakSelected->id }}"
                                                        {{ $hasBiru ? 'checked disabled' : '' }}>
                                                @else
                                                    •
                                                @endif
                                            </td>

                                            <!-- Kapsul Merah Februari Column -->
                                            <td class="text-center align-middle"
                                                style="background-color: {{ $merahFebColor }};">
                                                @if ($merahFebColor == '#ffffff' && $isFeb)
                                                    <input type="checkbox" class="vitamin-checkbox" data-jenis="Vitamin A"
                                                        data-warna="merah" data-bulan="feb"
                                                        data-anak-id="{{ $anakSelected->id }}"
                                                        {{ $hasMerahFeb ? 'checked disabled' : '' }}>
                                                @else
                                                    •
                                                @endif
                                            </td>

                                            <!-- Kapsul Merah Agustus Column -->
                                            <td class="text-center align-middle"
                                                style="background-color: {{ $merahAugColor }};">
                                                @if ($merahAugColor == '#ffffff' && $isAug)
                                                    <input type="checkbox" class="vitamin-checkbox" data-jenis="Vitamin A"
                                                        data-warna="merah" data-bulan="aug"
                                                        data-anak-id="{{ $anakSelected->id }}"
                                                        {{ $hasMerahAug ? 'checked disabled' : '' }}>
                                                @else
                                                    •
                                                @endif
                                            </td>

                                            <!-- Obat Cacing Column -->
                                            <td class="text-center align-middle"
                                                style="background-color: {{ $cacingColor }};">
                                                @if ($cacingColor == '#ffffff' && $isAug)
                                                    <input type="checkbox" class="vitamin-checkbox" data-jenis="Obat Cacing"
                                                        data-anak-id="{{ $anakSelected->id }}"
                                                        {{ $hasCacing ? 'checked disabled' : '' }}>
                                                @else
                                                    •
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                @if (!($isFeb || $isAug))
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i> Pemberian Vitamin A dan Obat Cacing hanya dilakukan bulan
                        Februari dan Agustus.
                        Bulan ini adalah: {{ DateTime::createFromFormat('!m', date('n'))->format('F') }}.
                    </div>
                @endif

                <!-- Keterangan -->
                <div class="alert alert-info">
                    <strong>Keterangan:</strong>
                    <ul class="mb-0">
                        <li>✓ : Sudah diberikan</li>
                        <li>• : Belum diberikan</li>
                    </ul>
                </div>


                <div class="">
                    <h5 class="mb-3">Catatan Pemberian Vitamin A</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="120px"></th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Dosis</th>
                                    <th>Keterangan</th>
                                    <th>Paraf Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anakSelected->vitamin as $vitamin)
                                    @php
                                        $createdAt = \Carbon\Carbon::parse($vitamin->created_at);
                                        $canUndo =
                                            $createdAt->diffInMinutes(now()) <= 20 &&
                                            $vitamin->petugas_id == auth()->id();
                                    @endphp
                                    <tr>
                                        <td>
                                            @if ($canUndo)
                                                <button class="btn btn-sm btn-danger btn-undu-paraf"
                                                    data-pivot-id="{{ $vitamin->id }}" data-jenis="{{ $vitamin->jenis }}"
                                                    data-dosis="{{ $vitamin->dosis }}"
                                                    data-tanggal="{{ \Carbon\Carbon::parse($vitamin->tanggal)->format('d/m/Y') }}">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            @else
                                                <span class="text-muted">
                                                    @if ($vitamin->petugas_id != auth()->id())
                                                        Hanya pembuat paraf yang bisa membatalkan
                                                    @else
                                                        Waktu batalkan habis
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($vitamin->tanggal)->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($vitamin->jenis == 'vitamin_a')
                                                Vitamin A Kapsul {{ ucfirst($vitamin->warna) }}
                                                ({{ $vitamin->warna == 'biru' ? '100.000 IU' : '200.000 IU' }})
                                            @else
                                                Obat Cacing
                                            @endif
                                        </td>
                                        <td>{{ $vitamin->dosis }}</td>
                                        <td>{{ $vitamin->keterangan ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-info">Sudah Paraf</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada catatan pemberian Vitamin A</td>
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
            text-align: center;
        }

        .table-active {
            background-color: rgba(0, 0, 0, 0);
        }

        .vitamin-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .bg-vitamin-biru {
            background-color: #cce5ff;
        }

        .bg-vitamin-merah {
            background-color: #f8d7da;
        }

        .bg-obat-cacing {
            background-color: #dcdfdc;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                            setTimeout(() => {
                                $('#selectAnakForm').submit();
                            }, 800);
                        }
                    });
                }
            });

            // Handle vitamin checkbox click
            $(document).on('change', '.vitamin-checkbox', function() {
                const jenis = $(this).data('jenis');
                const anakId = $(this).data('anak-id');
                const warna = $(this).data('warna') || null;
                const bulan = $(this).data('bulan') || null;
                const isChecked = $(this).is(':checked');

                if (!isChecked) {
                    $(this).prop('checked', false);
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Pemberian',
                    html: `
            <form id="vitaminForm">
                <div class="form-group">
                    <label for="swalTanggal">Tanggal</label>
                    <input type="date" id="swalTanggal" class="form-control" 
                           value="${new Date().toISOString().split('T')[0]}" required>
                </div>
                <div class="form-group">
                    <label for="swalKeterangan">Keterangan (opsional)</label>
                    <textarea id="swalKeterangan" class="form-control" rows="2"></textarea>
                </div>
            </form>
        `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    confirmButtonColor: '#176265',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batal',
                    focusConfirm: false,
                    preConfirm: () => {
                        const tanggal = $('#swalTanggal').val();
                        if (!tanggal) {
                            Swal.showValidationMessage('Tanggal wajib diisi');
                            return false;
                        }
                        return {
                            _token: '{{ csrf_token() }}',
                            anak_id: anakId,
                            jenis: jenis,
                            warna: warna,
                            bulan: bulan,
                            tanggal: tanggal,
                            keterangan: $('#swalKeterangan').val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('vitamin-a.toggle') }}',
                            method: 'POST',
                            data: result.value,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Data berhasil disimpan',
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
                                    title: 'Gagal menyimpan data',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $('.vitamin-checkbox').prop('checked', false);
                            }
                        });
                    } else {
                        $('.vitamin-checkbox').prop('checked', false);
                    }
                });
            });

            // Handle undo paraf
            $(document).on('click', '.btn-undu-paraf', function() {
                const btn = $(this);
                const pivotId = btn.data('pivot-id');
                const jenis = btn.data('jenis');
                const tanggal = btn.data('tanggal');

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

                Swal.fire({
                    title: 'Batalkan Paraf',
                    html: `
                        <p>Anda akan membatalkan paraf untuk:</p>
                        <ul>
                            <li>Jenis: <strong>${jenis === 'vitamin_a' ? 'Vitamin A' : 'Obat Cacing'}</strong></li>
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
                            url: '{{ route('vitamin-a.batalkan-paraf') }}',
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
