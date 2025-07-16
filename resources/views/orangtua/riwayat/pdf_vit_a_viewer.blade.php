@extends('layouts.app')

@section('title', 'Rekam Medis Vitamin A - ' . $anak->nama_lengkap)

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Rekam Medis Vitamin A</h3>
                    <p class="text-subtitle text-muted">
                        {{ $anak->nama_lengkap }} |
                        {{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} |
                        {{ $anak->tanggal_lahir->format('d/m/Y') }} |
                        Usia: {{ floor($usiaBulan / 12) }} tahun {{ $usiaBulan % 12 }} bulan
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('anak.index') }}">Data Anak</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Rekam Medis</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Data Vitamin A</h4>
                        <div>
                            <a href="{{ route('anak.export-pdf', $anak->id) }}" class="btn btn-primary"
                                download="rekam-medis-{{ Str::slug($anak->nama_lengkap) }}.pdf">
                                <i class="fas fa-download"></i> Unduh PDF
                            </a>
                            <button class="btn btn-info" onclick="printPDF()">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="{{ $pdfUrl }}" class="embed-responsive-item"
                            style="width: 100%; height: 70vh; border: none;"></iframe>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Keterangan Vitamin A</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kelompok Umur</th>
                                    <th>Warna Kapsul</th>
                                    <th>Dosis</th>
                                    <th>Frekuensi Pemberian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ageGroups as $group)
                                    <tr
                                        class="{{ $usiaBulan >= $group['min'] && $usiaBulan <= $group['max'] ? 'table-info' : '' }}">
                                        <td>{{ $group['label'] }}</td>
                                        <td>{{ $group['min'] < 12 ? 'Biru' : 'Merah' }}</td>
                                        <td>{{ $group['min'] < 12 ? '100.000 IU' : '200.000 IU' }}</td>
                                        <td>Setiap 6 bulan</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-info mt-3">
                        <strong>Catatan:</strong> Pemberian vitamin A dianjurkan setiap bulan Februari dan Agustus.
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        function printPDF() {
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = "{{ $pdfUrl }}";

            document.body.appendChild(iframe);

            iframe.onload = function() {
                setTimeout(function() {
                    iframe.contentWindow.print();
                    document.body.removeChild(iframe);
                }, 1000);
            };
        }

        // SweetAlert untuk loading
        document.addEventListener('DOMContentLoaded', function() {
            const iframe = document.querySelector('iframe');

            iframe.addEventListener('load', function() {
                // Sembunyikan loading jika ada
                const loadingElement = document.getElementById('loading-spinner');
                if (loadingElement) {
                    loadingElement.style.display = 'none';
                }
            });

            // Tampilkan loading saat pertama kali
            iframe.addEventListener('loadstart', function() {
                const loadingElement = document.getElementById('loading-spinner') || document.createElement(
                    'div');
                loadingElement.id = 'loading-spinner';
                loadingElement.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat dokumen...</p>
            </div>
        `;
                iframe.parentNode.insertBefore(loadingElement, iframe);
            });
        });
    </script>
@endpush
