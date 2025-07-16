@extends('layouts.app')

@section('title', 'KMS Digital : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>KMS Digital</h3>

                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    {{-- <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Table</li>
                        </ol>
                    </nav> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header ">
                    <h4 class="card-title">Data Anak | KMS Digital</h4>
                </div>
                <!-- table with light -->
                <div class="table-responsive">
                    <table class="table table-light mb-0" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Umur</th>
                                <th>Nama Orang Tua</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anak as $key => $item)
                                <tr>
                                    <td class="text-bold-500">{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td class="text-bold-500">
                                        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</td>
                                    <td>{{ floor($item->umur_bulan) }} bln</td>
                                    <td> {{ $item->orangTua->user->name }}
                                        <br>
                                        <small class="text-muted">HP:{{ $item->orangTua->user->phone ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                            <a href="{{ route('kms.show.v1', Crypt::encrypt($item->id)) }}"
                                                class="btn btn-secondary">Show KMS 1</a>
                                            <a href="{{ route('kms.show.v2', Crypt::encrypt($item->id)) }}"
                                                class="btn btn-secondary">Show KMS 2</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- <table class="table table-light mb-0" id="table1">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th>Nama Anak</th>
                                <th width="120" class="text-center">JK</th>
                                <th width="120" class="text-center">Tgl Lahir</th>
                                <th width="100" class="text-center">Umur</th>
                                <th>Orang Tua</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anak as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar-xs bg-soft-primary rounded">
                                                    <span class="avatar-title text-primary">
                                                        {{ substr($item->nama_lengkap, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">{{ $item->nama_lengkap }}</h6>
                                                <small class="text-muted">ID: {{ $item->id }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Jenis Kelamin -->
                                    <td class="text-center">
                                        <span
                                            class="badge bg-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }}-subtle text-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'danger' }} rounded-pill">
                                            {{ $item->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                        </span>
                                    </td>

                                    <!-- Tanggal Lahir -->
                                    <td class="text-center">
                                        <span class="text-muted">
                                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}
                                        </span>
                                    </td>

                                    <!-- Umur -->
                                    <td class="text-center">
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $item->umur_bulan }} bln
                                        </span>
                                    </td>

                                    <td>
                                        @if ($item->orangTua && $item->orangTua->user)
                                            {{ $item->orangTua->user->name }}
                                            <br>
                                            <small class="text-muted">{{ $item->orangTua->user->phone ?? '-' }}</small>
                                        @else
                                            -
                                        @endif
                                    </td>


                                    <!-- Aksi -->
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-soft-primary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="ri-settings-2-line"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if ($item->timbangan->count() > 0)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('kms.show', Crypt::encrypt($item->id)) }}">
                                                            <i class="ri-eye-line me-2"></i> Lihat KMS
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('kms.create', Crypt::encrypt($item->id)) }}">
                                                            <i class="ri-add-line me-2"></i> Input KMS
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="ri-printer-line me-2"></i> Cetak
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}

                </div>
            </div>
        </div>
    </div>


@endsection
