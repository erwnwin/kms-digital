@extends('layouts.app')

@section('title', 'Profil Anak : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Profil Anak</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                @foreach ($anak as $child)
                    @php
                        $usiaBulan = $child->umur_bulan;
                        $showKms1 = $usiaBulan <= 24;
                        $showKms2 = $usiaBulan <= 24;
                        // $showKms2 = $usiaBulan > 24 && $usiaBulan <= 60;
                    @endphp

                    <div class="col-lg-12">
                        <div class="card profile-card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title text-white mb-0">{{ $child->nama_lengkap }}</h4>
                                    <span class="badge bg-danger text-white">
                                        {{ $child->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="profile-avatar text-center mb-4">
                                    <div class="avatar-wrapper">
                                        <img src="{{ asset('auth/assets/anak-ico.png') }}" alt="Avatar Anak"
                                            class="rounded-circle">
                                        <span class="age-badge">{{ \Carbon\Carbon::parse($child->tanggal_lahir)->age }}
                                            Tahun</span>
                                    </div>
                                </div>

                                <div class="profile-info">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="info-item">
                                                <div class="info-label">Tanggal Lahir</div>
                                                <div class="info-value">{{ $child->tanggal_lahir->format('d F Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-item">
                                                <div class="info-label">Anak Ke-</div>
                                                <div class="info-value">{{ $child->anak_ke }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <div class="info-item">
                                                <div class="info-label">Berat Lahir</div>
                                                <div class="info-value">{{ $child->berat_lahir }} kg</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="info-item">
                                                <div class="info-label">Panjang Lahir</div>
                                                <div class="info-value">{{ $child->panjang_lahir }} cm</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="info-item">
                                                <div class="info-label">Golongan Darah</div>
                                                <div class="info-value">
                                                    <span
                                                        class="blood-type blood-type-{{ strtolower($child->golongan_darah) }}">
                                                        {{ $child->golongan_darah ?: 'Belum diketahui' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PDF Preview Buttons -->
                                <div class="pdf-preview-buttons mt-4">
                                    <div class="row g-2">
                                        @if ($showKms1)
                                            <div class="col-6 col-md-3">
                                                <a href="{{ route('anak.kms1-pdf', Crypt::encrypt($child->id)) }}"
                                                    class="btn btn-pdf-preview btn-primary w-100" target="_blank">
                                                    <i class="fas fa-file-medical"></i> KMS 1 (0-24 bln)
                                                </a>
                                            </div>
                                        @endif

                                        @if ($showKms2)
                                            <div class="col-6 col-md-3">
                                                <a href="{{ route('anak.kms2-pdf', Crypt::encrypt($child->id)) }}"
                                                    class="btn btn-pdf-preview btn-info w-100" target="_blank">
                                                    <i class="fas fa-file-medical-alt"></i> KMS 2 (25-60 bln)
                                                </a>
                                            </div>
                                        @endif

                                        @if ($usiaBulan >= 6 && $usiaBulan <= 71)
                                            <div class="col-6 col-md-3">
                                                <a href="{{ route('anak.vitamin-a-pdf', Crypt::encrypt($child->id)) }}"
                                                    class="btn btn-pdf-preview btn-warning w-100" target="_blank">
                                                    <i class="fas fa-pills"></i> Vitamin A
                                                </a>
                                            </div>
                                        @endif

                                        <div class="col-6 col-md-3">
                                            <a href="{{ route('anak.imunisasi-pdf', Crypt::encrypt($child->id)) }}"
                                                class="btn btn-pdf-preview btn-success w-100" target="_blank">
                                                <i class="fas fa-syringe"></i> Imunisasi
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex justify-content-between">
                                    <a href="" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($anak->isEmpty())
                    <div class="col-12">
                        <div class="card empty-state">
                            <div class="card-body text-center py-5">
                                <div class="empty-state-icon">
                                    <i class="fas fa-child"></i>
                                </div>
                                <h3 class="mt-3">Belum Ada Data Anak</h3>
                                <p class="text-muted">Anda belum menambahkan data anak. Silakan tambahkan data anak Anda.
                                </p>
                                <a href="{{ route('orangtua.profil_anak.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus"></i> Tambah Anak
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <style>
        /* Profile Card Styles */
        .profile-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 24px;
            border: none;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        /* Avatar Styles */
        .avatar-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }

        .avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .age-badge {
            position: absolute;
            bottom: -10px;
            right: -10px;
            background-color: #4e73df;
            color: white;
            border-radius: 35%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Info Item Styles */
        .info-item {
            margin-bottom: 12px;
        }

        .info-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 600;
            color: #2c3e50;
            margin-top: 2px;
        }

        /* Blood Type Styles */
        .blood-type {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-radius: 50%;
            font-weight: bold;
            color: white;
        }

        .blood-type-a {
            background-color: #e74c3c;
        }

        .blood-type-b {
            background-color: #3498db;
        }

        .blood-type-ab {
            background-color: #9b59b6;
        }

        .blood-type-o {
            background-color: #2ecc71;
        }

        /* Empty State Styles */
        .empty-state {
            border: 2px dashed #e9ecef;
            background-color: #f8f9fa;
        }

        .empty-state-icon {
            font-size: 60px;
            color: #adb5bd;
            margin-bottom: 20px;
        }

        /* PDF Preview Button Styles */
        .btn-pdf-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 10px 5px;
            font-size: 12px;
            text-align: center;
            white-space: normal;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-pdf-preview i {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .btn-pdf-preview:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 767px) {
            .profile-card {
                margin-bottom: 20px;
            }

            .btn-pdf-preview {
                font-size: 11px;
                padding: 8px 3px;
            }

            .btn-pdf-preview i {
                font-size: 16px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert untuk loading PDF
            $('.btn-pdf-preview').on('click', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');

                Swal.fire({
                    title: 'Membuka Dokumen',
                    html: 'Sedang mempersiapkan dokumen...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();

                        // Buka tab baru setelah 1 detik
                        setTimeout(() => {
                            window.open(url, '_blank');
                            Swal.close();
                        }, 1000);
                    }
                });
            });

            // Notifikasi dari session
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}'
                });
            @endif
            rof
        });
    </script>
@endpush
