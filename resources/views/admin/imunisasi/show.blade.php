@extends('layouts.app')

@section('title', 'Imunisasi : Posyandu Ta')

@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-header">
                        <div class="page-header-title">
                            <h4>Imunisasi</h4>
                        </div>
                        <div class="page-header-breadcrumb">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item">
                                    <a href="#!">
                                        <i class="icofont icofont-home"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="page-body">
                        <div class="row">

                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h3>Imunisasi - {{ $anak->nama_lengkap }}</h3>
                                    <p>Umur: {{ $umurBulan }} bulan</p>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Vaksin</th>
                                                    @for ($i = 0; $i <= 24; $i++)
                                                        <th class="text-center {{ $i == $umurBulan ? 'bg-warning' : '' }}">
                                                            {{ $i }}</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allImunisasi as $imunisasi)
                                                    <tr>
                                                        <td>
                                                            <span class="badge"
                                                                style="background-color: {{ $imunisasi->warna }}">
                                                                {{ $imunisasi->kode }}
                                                            </span>
                                                            {{ $imunisasi->nama }}
                                                        </td>
                                                        @for ($i = 0; $i <= 24; $i++)
                                                            @php
                                                                $isUsiaTepat =
                                                                    $i >= $imunisasi->usia_minimal_bulan &&
                                                                    ($imunisasi->usia_maksimal_bulan === null ||
                                                                        $i <= $imunisasi->usia_maksimal_bulan);
                                                                $isSudahDiberikan = $riwayat->contains(
                                                                    'id',
                                                                    $imunisasi->id,
                                                                );
                                                                $isBulanIni = $i == $umurBulan;
                                                            @endphp
                                                            <td
                                                                class="text-center 
                                                            {{ !$isUsiaTepat ? 'bg-secondary text-white' : '' }}
                                                            {{ $isSudahDiberikan ? 'bg-success text-white' : '' }}
                                                            {{ $isBulanIni && $isUsiaTepat && !$isSudahDiberikan ? 'bg-warning' : '' }}">

                                                                @if ($isBulanIni && $isUsiaTepat && !$isSudahDiberikan)
                                                                    <button type="button" class="btn btn-sm btn-primary"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#imunisasiModal"
                                                                        data-imunisasi-id="{{ $imunisasi->id }}"
                                                                        data-imunisasi-nama="{{ $imunisasi->nama }}">
                                                                        Berikan
                                                                    </button>
                                                                @elseif($isSudahDiberikan)
                                                                    ✔
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Form Input -->
                            <div class="modal fade" id="imunisasiModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('imunisasi.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="anak_id" value="{{ $anak->id }}">
                                            <input type="hidden" id="jenis_imunisasi_id" name="jenis_imunisasi_id">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle">Berikan Imunisasi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Imunisasi</label>
                                                    <input type="text" class="form-control" id="displayImunisasiNama"
                                                        readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label">Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal" required
                                                        value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dosis" class="form-label">Dosis</label>
                                                    <input type="text" class="form-control" name="dosis" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!--<div id="styleSelector">-->

            <!--</div>-->
        </div>
    </div>
    </div>
    </div>
    </div>

    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var imunisasiModal = document.getElementById('imunisasiModal');
            imunisasiModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var imunisasiId = button.getAttribute('data-imunisasi-id');
                var imunisasiNama = button.getAttribute('data-imunisasi-nama');

                document.getElementById('jenis_imunisasi_id').value = imunisasiId;
                document.getElementById('displayImunisasiNama').value = imunisasiNama;
            });
        });
    </script>
@endpush
