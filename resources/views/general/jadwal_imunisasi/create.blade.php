@extends('layouts.app')

@section('title', 'Tambah Jadwal Imunisasi : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Jadwal Imunisasi</h3>
                </div>

            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Tambah Jadwal</h4>
                </div>
                @include('general.jadwal_imunisasi.form')
            </div>
        </section>
    </div>
@endsection
