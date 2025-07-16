@extends('layouts.app')

@section('title', 'Tambah Data Anak : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tambah Data Anak</h3>
                </div>

            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Tambah Data Anak</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('anak.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="orang_tua_id">Orang Tua</label>
                                    <select class="form-select @error('orang_tua_id') is-invalid @enderror"
                                        id="orang_tua_id" name="orang_tua_id" required>
                                        <option value="">Pilih Orang Tua</option>
                                        @foreach ($orangTua as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('orang_tua_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->user->name }} <!-- Akses name melalui relasi user -->
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('orang_tua_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                        required>
                                    @error('tanggal_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="berat_lahir">Berat Lahir (kg)</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('berat_lahir') is-invalid @enderror" id="berat_lahir"
                                        name="berat_lahir" value="{{ old('berat_lahir') }}" required>
                                    @error('berat_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="panjang_lahir">Panjang Lahir (cm)</label>
                                    <input type="number" step="0.1"
                                        class="form-control @error('panjang_lahir') is-invalid @enderror" id="panjang_lahir"
                                        name="panjang_lahir" value="{{ old('panjang_lahir') }}" required>
                                    @error('panjang_lahir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="anak_ke">Anak Ke-</label>
                                    <input type="number" class="form-control @error('anak_ke') is-invalid @enderror"
                                        id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" required>
                                    @error('anak_ke')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="golongan_darah">Golongan Darah</label>
                                    <select class="form-select @error('golongan_darah') is-invalid @enderror"
                                        id="golongan_darah" name="golongan_darah">
                                        <option value="">Pilih Golongan Darah</option>
                                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A
                                        </option>
                                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B
                                        </option>
                                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB
                                        </option>
                                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O
                                        </option>
                                    </select>
                                    @error('golongan_darah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a href="{{ route('anak.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const form = this;

                    Swal.fire({
                        title: 'Menyimpan Data',
                        html: 'Sedang memproses data...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        },
                        didOpen: () => {
                            // Submit the form after a small delay to ensure Swal is shown
                            setTimeout(() => {
                                form.submit();
                            }, 100);
                        }
                    });
                });
            });

            // Success notification
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    // Optional: Redirect after success if needed
                    // window.location.href = "{{ route('anak.index') }}";
                });
            @endif

            // Error notification
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                });
            @endif

            // Validation errors
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: `@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach`,
                });
            @endif
        });
    </script>
@endpush
