@extends('layouts.app')

@section('title', 'Profil Akun : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Profil Akun</h3>
                </div>

            </div>
        </div>

        <section class="section">
            <div class="row">



                <div class="col-md-4">

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif --}}

                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar avatar-xl bg-primary me-3 mb-3">
                                <img src="{{ asset('assets/images/faces/1.jpg') }}" alt="" srcset="">
                            </div>
                            <h4 class="card-title">{{ $user->name }}</h4>
                            <p class="card-subtitle">
                                <span
                                    class="badge bg-{{ $role === 'kader' ? 'info' : ($role === 'koordinator' ? 'warning' : 'success') }}">
                                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                                </span>
                            </p>
                            <p class="text-muted">{{ $user->email }}</p>
                            <p><i class="fas fa-phone"></i> {{ $user->phone ?? 'Belum diisi' }}</p>

                            <button class="btn btn-primary btn-block mt-3" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">
                                <i class="fas fa-edit"></i> Edit Profil
                            </button>
                            <button class="btn btn-outline-secondary btn-block mt-2" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal">
                                <i class="fas fa-lock"></i> Ganti Password
                            </button>
                        </div>
                    </div>

                    @if ($role === 'orang_tua')
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Anak Terdaftar</h4>
                            </div>
                            <div class="card-body">
                                @if ($user->orangTua && $user->orangTua->anak->count() > 0)
                                    <div class="list-group">
                                        @foreach ($user->orangTua->anak as $anak)
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{ $anak->nama_lengkap }}</h5>
                                                    <small>{{ $anak->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                                                </div>
                                                <p class="mb-1">Lahir: {{ $anak->tanggal_lahir->format('d M Y') }}</p>
                                                <small>Anak ke-{{ $anak->anak_ke }}</small>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        Belum ada anak terdaftar
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Informasi Profil</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6>Nama Lengkap:</h6>
                                        <p>{{ $user->name }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Email:</h6>
                                        <p>{{ $user->email }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Nomor Telepon:</h6>
                                        <p>{{ $user->phone ?? 'Belum diisi' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6>Role:</h6>
                                        <p>
                                            <span
                                                class="badge bg-{{ $role === 'kader' ? 'info' : ($role === 'koordinator' ? 'warning' : 'success') }}">
                                                {{ ucfirst(str_replace('_', ' ', $role)) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <h6>Bergabung Pada:</h6>
                                        <p>{{ $user->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            @if ($role === 'orang_tua' && !empty($profileData))
                                <hr>
                                <h5 class="mb-3">Data Orang Tua</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6>Alamat:</h6>
                                            <p>{{ $profileData['alamat'] }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6>RT/RW:</h6>
                                            <p>{{ $profileData['rt'] }}/{{ $profileData['rw'] }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6>Desa/Kelurahan:</h6>
                                            <p>{{ $profileData['desa_kelurahan'] }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6>Kecamatan:</h6>
                                            <p>{{ $profileData['kecamatan'] }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6>Kabupaten/Kota:</h6>
                                            <p>{{ $profileData['kabupaten_kota'] }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6>Provinsi:</h6>
                                            <p>{{ $profileData['provinsi'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($role === 'kader' || $role === 'koordinator')
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Aktivitas Terakhir</h4>
                            </div>
                            <div class="card-body">
                                <ul class="timeline">
                                    <li class="timeline-item">
                                        <span class="timeline-point"></span>
                                        <div class="timeline-event">
                                            <div class="d-flex justify-content-between">
                                                <h6>Login terakhir</h6>
                                                <small class="text-muted">Hari ini, 08:30</small>
                                            </div>
                                            <p>Anda berhasil login ke sistem</p>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span class="timeline-point"></span>
                                        <div class="timeline-event">
                                            <div class="d-flex justify-content-between">
                                                <h6>Memperbarui data anak</h6>
                                                <small class="text-muted">Kemarin, 14:45</small>
                                            </div>
                                            <p>Data pertumbuhan anak atas nama Budi</p>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span class="timeline-point"></span>
                                        <div class="timeline-event">
                                            <div class="d-flex justify-content-between">
                                                <h6>Menambahkan jadwal imunisasi</h6>
                                                <small class="text-muted">2 hari lalu</small>
                                            </div>
                                            <p>Jadwal imunisasi campak bulan ini</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                value="{{ $user->phone }}">
                        </div>
                        @if ($role === 'orang_tua')
                            <hr>
                            <h5 class="mb-3">Data Orang Tua</h5>
                            <div class="form-group mb-3">
                                <label for="alamat">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $profileData['alamat'] ?? '' }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="rt">RT</label>
                                <input type="text" class="form-control" id="rt" name="rt"
                                    value="{{ $profileData['rt'] ?? '' }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="rw">RW</label>
                                <input type="text" class="form-control" id="rw" name="rw"
                                    value="{{ $profileData['rw'] ?? '' }}">
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changePasswordForm" action="{{ route('profile.change-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="new_password">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ganti Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission with SweetAlert
            const forms = ['editProfileForm', 'changePasswordForm'];

            forms.forEach(formId => {
                const form = document.getElementById(formId);
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Menyimpan Data',
                            html: 'Sedang memproses...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                                form.submit();
                            }
                        });
                    });
                }
            });

            // Notification from session
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if ($errors->any())
                let errorMessages = '';
                @foreach ($errors->all() as $error)
                    errorMessages += '{{ $error }}\n'; // Menggabungkan semua pesan error
                @endforeach
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: errorMessages
                });
            @endif
        });
    </script>
@endpush
