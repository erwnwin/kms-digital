@extends('layouts.app')

@section('title', 'Jadwal Imunisasi : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Jadwal Imunisasi</h3>
                </div>

            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Daftar Jadwal Imunisasi</h4>
                        <a href="{{ route('jadwal-imunisasi.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Jadwal
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    {{-- <th>No</th> --}}
                                    <th class="text-center">#</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwals as $key => $jadwal)
                                    <tr>
                                        {{-- <td>{{ $key + 1 }}</td> --}}
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('jadwal-imunisasi.show', Crypt::encrypt($jadwal->id)) }}"
                                                    class="btn btn-sm btn-info" title="Detail">
                                                    <i data-feather="info"></i>
                                                </a>
                                                <a href="{{ route('jadwal-imunisasi.edit', Crypt::encrypt($jadwal->id)) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i data-feather="edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('jadwal-imunisasi.destroy', Crypt::encrypt($jadwal->id)) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>{{ $jadwal->title }}</td>
                                        <td>
                                            @if ($jadwal->start_date)
                                                {{ \Carbon\Carbon::parse($jadwal->start_date)->format('d M Y') }}
                                                @if ($jadwal->end_date)
                                                    - {{ \Carbon\Carbon::parse($jadwal->end_date)->format('d M Y') }}
                                                @endif
                                            @else
                                                <em>Belum ditentukan</em>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $jadwal->start_time ?? '-' }}
                                            @if ($jadwal->end_time)
                                                - {{ $jadwal->end_time }}
                                            @endif
                                        </td>

                                        <td>{{ $jadwal->location }}</td>
                                        <td>
                                            <span class="badge bg-{{ $jadwal->is_active ? 'success' : 'danger' }}">
                                                {{ $jadwal->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        // SweetAlert Notifikasi
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
    </script>
@endpush
