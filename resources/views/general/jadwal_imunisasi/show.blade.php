@extends('layouts.app')

@section('title', 'Detail Jadwal Imunisasi : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Jadwal Imunisasi</h3>
                </div>

            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Jadwal</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Jenis Imunisasi:</h6>
                                <p>{{ $jadwal->type }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Judul Kegiatan:</h6>
                                <p>{{ $jadwal->title }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Tanggal:</h6>
                                <p>
                                    {{ optional($jadwal->start_date)->format('d F Y') ?? 'Tanggal mulai belum tersedia' }}

                                    @if ($jadwal->end_date)
                                        - {{ $jadwal->end_date->format('d F Y') }}
                                    @endif
                                </p>

                            </div>
                            <div class="mb-3">
                                <h6>Waktu:</h6>
                                <p>
                                    {{ $jadwal->start_time }}
                                    @if ($jadwal->end_time)
                                        - {{ $jadwal->end_time }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Kategori:</h6>
                                <p>{{ $jadwal->category }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Lokasi:</h6>
                                <p>{{ $jadwal->location }}</p>
                            </div>
                            <div class="mb-3">
                                <h6>Status:</h6>
                                <span class="badge bg-{{ $jadwal->is_active ? 'success' : 'danger' }}">
                                    {{ $jadwal->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <div class="mb-3">
                                <h6>Deskripsi:</h6>
                                <p>{{ $jadwal->description ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('jadwal-imunisasi') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
