@extends('layouts.app')

@section('title', 'Role Akses : Posyandu TA')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Pengguna Sistem</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Daftar Pengguna</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus"></i> Tambah Pengguna
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>

                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>

                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $user->role == 'kordinator' ? 'primary' : 'success' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>

                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $user->id }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                @if ($user->role !== 'kordinator')
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $user->id }}">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                @endif

                                            </div>
                                        </td>

                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit
                                                        Pengguna</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name{{ $user->id }}">Nama Lengkap</label>
                                                            <input type="text" class="form-control"
                                                                id="name{{ $user->id }}" name="name"
                                                                value="{{ $user->name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email{{ $user->id }}">Email</label>
                                                            <input type="email" class="form-control"
                                                                id="email{{ $user->id }}" name="email"
                                                                value="{{ $user->email }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="phone{{ $user->id }}">No. HP</label>
                                                            <input type="text" class="form-control"
                                                                id="phone{{ $user->id }}" name="phone"
                                                                value="{{ $user->phone }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="role{{ $user->id }}">Role</label>
                                                            <select class="form-control" id="role{{ $user->id }}"
                                                                name="role" required>
                                                                <option value="kader"
                                                                    {{ $user->role === 'kader' ? 'selected' : '' }}>Kader
                                                                </option>
                                                                <option value="kordinator"
                                                                    {{ $user->role === 'kordinator' ? 'selected' : '' }}>
                                                                    Koordinator</option>
                                                            </select>
                                                            <!-- Debugging output -->
                                                            <!-- <p>Current Role: {{ $user->role }}</p> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="password{{ $user->id }}">Password (Kosongkan
                                                                jika tidak ingin
                                                                mengubah)</label>
                                                            <input type="password" class="form-control"
                                                                id="password{{ $user->id }}" name="password">
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="password_confirmation{{ $user->id }}">Konfirmasi
                                                                Password</label>
                                                            <input type="password" class="form-control"
                                                                id="password_confirmation{{ $user->id }}"
                                                                name="password_confirmation">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Hapus
                                                        Pengguna</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus pengguna
                                                            <strong>{{ $user->name }}</strong>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Create Modal -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Pengguna Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nameCreate">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nameCreate" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="emailCreate">Email</label>
                                <input type="email" class="form-control" id="emailCreate" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phoneCreate">No. HP</label>
                                <input type="text" class="form-control" id="phoneCreate" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="roleCreate">Role</label>
                                <select class="form-control" id="roleCreate" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="kader">Kader</option>
                                    <option value="kordinator">Kordinator</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="passwordCreate">Password</label>
                                <input type="password" class="form-control" id="passwordCreate" name="password"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="passwordConfirmationCreate">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="passwordConfirmationCreate"
                                    name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Menyimpan Data',
                    html: 'Sedang memproses data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        this.submit();
                    }
                });
            });
        });

        // Notifikasi
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
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach`,
            });
        @endif
    </script>
@endpush
