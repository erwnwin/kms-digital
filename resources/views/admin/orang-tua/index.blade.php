@extends('layouts.app')

@section('title', 'Data Orang Tua : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Orang Tua</h3>
                </div>

            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Daftar Data Orang Tua</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus"></i> Tambah Data
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
                                    <th>Alamat</th>
                                    <th>Jumlah Anak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orangTua as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->email }}</td>
                                        <td>
                                            {{ $item->alamat }}, RT {{ $item->rt }}/RW {{ $item->rw }}<br>
                                            {{ $item->desa_kelurahan }}, {{ $item->kecamatan }}<br>
                                            {{ $item->kabupaten_kota }}, {{ $item->provinsi }}
                                        </td>
                                        <td>{{ $item->anak->count() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->id }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $item->id }}">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </div>
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

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Data Orang Tua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('orang-tua.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rt">RT</label>
                                    <input type="text" class="form-control" id="rt" name="rt" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rw">RW</label>
                                    <input type="text" class="form-control" id="rw" name="rw" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desa_kelurahan">Provinsi</label>
                                    <select class="form-control wilayah-select" id="provinsi" name="provinsi" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kecamatan">Kabupaten/Kota</label>
                                    <select class="form-control wilayah-select" id="kabupaten_kota" name="kabupaten_kota"
                                        required disabled>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kabupaten_kota">Kecamatan</label>
                                    <select class="form-control wilayah-select" id="kecamatan" name="kecamatan" required
                                        disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="provinsi">Desa/Kelurahan</label>
                            <select class="form-control wilayah-select" id="desa_kelurahan" name="desa_kelurahan"
                                required disabled>
                                <option value="">Pilih Desa/Kelurahan</option>
                            </select>
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

    <!-- Edit Modals -->
    @foreach ($orangTua as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data Orang Tua</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('orang-tua.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $item->user->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $item->user->email }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $item->alamat }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control" id="rt" name="rt"
                                            value="{{ $item->rt }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control" id="rw" name="rw"
                                            value="{{ $item->rw }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="provinsi_edit{{ $item->id }}">Provinsi</label>
                                        <select id="provinsi_edit{{ $item->id }}" name="provinsi"
                                            class="form-control select2-wilayah">
                                            {{-- <option value="{{ $item->provinsi }}" selected>{{ $item->provinsi }}
                                            </option> --}}
                                        </select>
                                        {{-- <select class="form-control select2-wilayah"
                                            id="provinsi_edit{{ $item->id }}" name="provinsi" required>

                                        </select> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="kabupaten_kota_edit{{ $item->id }}">Kabupaten/Kota</label>
                                    {{-- <select id="kabupaten_kota_edit{{ $item->id }}" name="kabupaten_kota"
                                        class="form-control select2-wilayah"
                                        data-parent="provinsi_edit{{ $item->id }}"></select> --}}
                                    <select class="form-control select2-wilayah"
                                        id="kabupaten_kota_edit{{ $item->id }}" name="kabupaten_kota"
                                        data-parent="provinsi_edit{{ $item->id }}" required>
                                        {{-- <option value="{{ $item->kabupaten_kota }}" selected>
                                            {{ $item->kabupaten_kota }}</option> --}}
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan_edit{{ $item->id }}">Kecamatan</label>
                                        {{-- <select id="kecamatan_edit{{ $item->id }}" name="kecamatan"
                                            class="form-control"
                                            data-parent="kabupaten_kota_edit{{ $item->id }}"></select> --}}

                                        <select class="form-control select2-wilayah"
                                            id="kecamatan_edit{{ $item->id }}" name="kecamatan"
                                            data-parent="kabupaten_kota_edit{{ $item->id }}" required>
                                            {{-- <option value="{{ $item->kecamatan }}" selected>{{ $item->kecamatan }}
                                            </option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="desa_kelurahan_edit{{ $item->id }}">Desa/Kelurahan</label>
                                {{-- <select id="desa_kelurahan_edit{{ $item->id }}" name="desa_kelurahan"
                                    class="form-control" data-parent="kecamatan_edit{{ $item->id }}">
                                    <option value="{{ $item->desa_kelurahan }}" selected>{{ $item->desa_kelurahan }}
                                    </option>
                                </select> --}}
                                <select class="form-control select2-wilayah" id="desa_kelurahan_edit{{ $item->id }}"
                                    name="desa_kelurahan" data-parent="kecamatan_edit{{ $item->id }}" required>
                                    {{-- <option value="{{ $item->desa_kelurahan }}" selected>{{ $item->desa_kelurahan }}
                                    </option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete Modals -->
    @foreach ($orangTua as $item)
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data orang tua <strong>{{ $item->user->name }}</strong>?
                        </p>
                        <p class="text-danger">*Data anak yang terkait juga akan dihapus</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('orang-tua.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi TomSelect untuk Provinsi
            const provinsiSelect = new TomSelect('#provinsi', {
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',
                load: function(query, callback) {
                    // Jika mengetik "sulawesi", cari semua provinsi Sulawesi
                    const searchTerm = query.toLowerCase().includes('sulawesi') ?
                        'sulawesi' :
                        query;

                    fetch(`/wilayah?type=provinsi&search=${encodeURIComponent(searchTerm)}`)
                        .then(response => response.json())
                        .then(data => {
                            // Filter untuk provinsi Sulawesi jika mengetik "sulawesi"
                            if (query.toLowerCase().includes('sulawesi')) {
                                data = data.filter(item =>
                                    item.text.toLowerCase().includes('sulawesi')
                                );
                            }
                            callback(data);
                        })
                        .catch(() => callback());
                },
                onChange: function(provinsi) {
                    updateKabupaten(provinsi);
                }
            });

            // Inisialisasi TomSelect untuk Kabupaten
            const kabupatenSelect = new TomSelect('#kabupaten_kota', {
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',
                disabled: true,
                load: function(query, callback) {
                    const provinsi = provinsiSelect.getValue();
                    if (!provinsi) return callback();

                    fetch(
                            `/wilayah?type=kabupaten&parent=${encodeURIComponent(provinsi)}&search=${encodeURIComponent(query)}`
                        )
                        .then(response => response.json())
                        .then(data => callback(data))
                        .catch(() => callback());
                },
                onChange: function(kabupaten) {
                    updateKecamatan(kabupaten);
                }
            });

            // Inisialisasi TomSelect untuk Kecamatan
            const kecamatanSelect = new TomSelect('#kecamatan', {
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',
                disabled: true,
                load: function(query, callback) {
                    const kabupaten = kabupatenSelect.getValue();
                    if (!kabupaten) return callback();

                    fetch(
                            `/wilayah?type=kecamatan&parent=${encodeURIComponent(kabupaten)}&search=${encodeURIComponent(query)}`
                        )
                        .then(response => response.json())
                        .then(data => callback(data))
                        .catch(() => callback());
                },
                onChange: function(kecamatan) {
                    updateDesa(kecamatan);
                }
            });

            // Inisialisasi TomSelect untuk Desa
            const desaSelect = new TomSelect('#desa_kelurahan', {
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',
                disabled: true,
                load: function(query, callback) {
                    const kecamatan = kecamatanSelect.getValue();
                    if (!kecamatan) return callback();

                    fetch(
                            `/wilayah?type=kelurahan&parent=${encodeURIComponent(kecamatan)}&search=${encodeURIComponent(query)}`
                        )
                        .then(response => response.json())
                        .then(data => callback(data))
                        .catch(() => callback());
                }
            });

            // Fungsi untuk update kabupaten
            function updateKabupaten(provinsi) {
                kabupatenSelect.clear();
                kabupatenSelect.clearOptions();
                kabupatenSelect.disable();

                kecamatanSelect.clear();
                kecamatanSelect.clearOptions();
                kecamatanSelect.disable();

                desaSelect.clear();
                desaSelect.clearOptions();
                desaSelect.disable();

                if (provinsi) {
                    kabupatenSelect.enable();
                    // Load kabupaten tanpa filter search awal
                    fetch(`/wilayah?type=kabupaten&parent=${encodeURIComponent(provinsi)}`)
                        .then(response => response.json())
                        .then(data => {
                            kabupatenSelect.addOptions(data);
                        });
                }
            }

            // Fungsi untuk update kecamatan
            function updateKecamatan(kabupaten) {
                kecamatanSelect.clear();
                kecamatanSelect.clearOptions();
                kecamatanSelect.disable();

                desaSelect.clear();
                desaSelect.clearOptions();
                desaSelect.disable();

                if (kabupaten) {
                    kecamatanSelect.enable();
                    // Load kecamatan tanpa filter search awal
                    fetch(`/wilayah?type=kecamatan&parent=${encodeURIComponent(kabupaten)}`)
                        .then(response => response.json())
                        .then(data => {
                            kecamatanSelect.addOptions(data);
                        });
                }
            }

            // Fungsi untuk update desa
            function updateDesa(kecamatan) {
                desaSelect.clear();
                desaSelect.clearOptions();
                desaSelect.disable();

                if (kecamatan) {
                    desaSelect.enable();
                    // Load desa tanpa filter search awal
                    fetch(`/wilayah?type=kelurahan&parent=${encodeURIComponent(kecamatan)}`)
                        .then(response => response.json())
                        .then(data => {
                            desaSelect.addOptions(data);
                        });
                }
            }

            // Form submission dengan SweetAlert
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
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // When any edit modal is shown, initialize selects for that modal
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    const modalId = this.id; // e.g. editModal123
                    if (!modalId.startsWith('editModal')) return; // Only for edit modals

                    const itemId = modalId.replace('editModal', ''); // get ID number, e.g. 123

                    // Initialize cascading selects for this modal
                    initProvinsiSelect(itemId);
                });
            });

            // Initialize Provinsi select with Tom Select and load data
            function initProvinsiSelect(itemId) {
                const provinsiId = `provinsi_edit${itemId}`;
                const kabupatenId = `kabupaten_kota_edit${itemId}`;
                const kecamatanId = `kecamatan_edit${itemId}`;
                const desaId = `desa_kelurahan_edit${itemId}`;

                const $provinsiEl = document.getElementById(provinsiId);
                if (!$provinsiEl || $provinsiEl._tomselect) return; // already initialized

                const provinsiSelect = new TomSelect($provinsiEl, {
                    valueField: 'id',
                    labelField: 'text',
                    searchField: 'text',
                    preload: true,
                    create: false,
                    load: function(query, callback) {
                        fetch(`/wilayah?type=provinsi&search=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => callback(data))
                            .catch(() => callback());
                    },
                    onChange: function(value) {
                        if (value) {
                            enableAndLoadKabupaten(kabupatenId, value, kecamatanId, desaId);
                        } else {
                            disableSelect(kabupatenId);
                            disableSelect(kecamatanId);
                            disableSelect(desaId);
                        }
                    }
                });

                // Load Kabupaten if there's a pre-selected provinsi
                if ($provinsiEl.value) {
                    enableAndLoadKabupaten(kabupatenId, $provinsiEl.value, kecamatanId, desaId);
                }
            }

            function enableAndLoadKabupaten(kabupatenId, provinsiValue, kecamatanId, desaId) {
                const $kabupatenEl = document.getElementById(kabupatenId);
                if (!$kabupatenEl) return;

                if (!$kabupatenEl._tomselect) {
                    const kabupatenSelect = new TomSelect($kabupatenEl, {
                        valueField: 'id',
                        labelField: 'text',
                        searchField: 'text',
                        preload: true,
                        create: false,
                        load: function(query, callback) {
                            fetch(
                                    `/wilayah?type=kabupaten&parent=${encodeURIComponent(provinsiValue)}&search=${encodeURIComponent(query)}`
                                )
                                .then(res => res.json())
                                .then(data => callback(data))
                                .catch(() => callback());
                        },
                        onChange: function(value) {
                            if (value) {
                                enableAndLoadKecamatan(kecamatanId, value, desaId);
                            } else {
                                disableSelect(kecamatanId);
                                disableSelect(desaId);
                            }
                        }
                    });
                } else {
                    // Refresh options if already initialized
                    const kabupatenSelect = $kabupatenEl._tomselect;
                    kabupatenSelect.clear();
                    kabupatenSelect.clearOptions();
                    kabupatenSelect.load(function(callback) {
                        fetch(`/wilayah?type=kabupaten&parent=${encodeURIComponent(provinsiValue)}`)
                            .then(res => res.json())
                            .then(data => callback(data))
                            .catch(() => callback());
                    });
                    kabupatenSelect.enable();
                }

                enableSelect(kabupatenId);

                // Load Kecamatan for pre-selected kabupaten if already selected
                const $kabupatenInput = document.getElementById(kabupatenId);
                if ($kabupatenInput && $kabupatenInput.value) {
                    enableAndLoadKecamatan(kecamatanId, $kabupatenInput.value, desaId);
                } else {
                    disableSelect(kecamatanId);
                    disableSelect(desaId);
                }
            }

            function enableAndLoadKecamatan(kecamatanId, kabupatenValue, desaId) {
                const $kecamatanEl = document.getElementById(kecamatanId);
                if (!$kecamatanEl) return;

                if (!$kecamatanEl._tomselect) {
                    const kecamatanSelect = new TomSelect($kecamatanEl, {
                        valueField: 'id',
                        labelField: 'text',
                        searchField: 'text',
                        preload: true,
                        create: false,
                        load: function(query, callback) {
                            fetch(
                                    `/wilayah?type=kecamatan&parent=${encodeURIComponent(kabupatenValue)}&search=${encodeURIComponent(query)}`
                                )
                                .then(res => res.json())
                                .then(data => callback(data))
                                .catch(() => callback());
                        },
                        onChange: function(value) {
                            if (value) {
                                enableAndLoadDesa(desaId, value);
                            } else {
                                disableSelect(desaId);
                            }
                        }
                    });
                } else {
                    const kecamatanSelect = $kecamatanEl._tomselect;
                    kecamatanSelect.clear();
                    kecamatanSelect.clearOptions();
                    kecamatanSelect.load(function(callback) {
                        fetch(`/wilayah?type=kecamatan&parent=${encodeURIComponent(kabupatenValue)}`)
                            .then(res => res.json())
                            .then(data => callback(data))
                            .catch(() => callback());
                    });
                    kecamatanSelect.enable();
                }

                enableSelect(kecamatanId);

                // Load Desa for pre-selected kecamatan if selected
                const $kecamatanInput = document.getElementById(kecamatanId);
                if ($kecamatanInput && $kecamatanInput.value) {
                    enableAndLoadDesa(desaId, $kecamatanInput.value);
                } else {
                    disableSelect(desaId);
                }
            }

            function enableAndLoadDesa(desaId, kecamatanValue) {
                const $desaEl = document.getElementById(desaId);
                if (!$desaEl) return;

                if (!$desaEl._tomselect) {
                    const desaSelect = new TomSelect($desaEl, {
                        valueField: 'id',
                        labelField: 'text',
                        searchField: 'text',
                        preload: true,
                        create: false,
                        load: function(query, callback) {
                            fetch(
                                    `/wilayah?type=kelurahan&parent=${encodeURIComponent(kecamatanValue)}&search=${encodeURIComponent(query)}`
                                )
                                .then(res => res.json())
                                .then(data => callback(data))
                                .catch(() => callback());
                        }
                    });
                } else {
                    const desaSelect = $desaEl._tomselect;
                    desaSelect.clear();
                    desaSelect.clearOptions();
                    desaSelect.load(function(callback) {
                        fetch(`/wilayah?type=kelurahan&parent=${encodeURIComponent(kecamatanValue)}`)
                            .then(res => res.json())
                            .then(data => callback(data))
                            .catch(() => callback());
                    });
                    desaSelect.enable();
                }

                enableSelect(desaId);
            }

            // Helper functions
            function disableSelect(id) {
                const el = document.getElementById(id);
                if (el && el._tomselect) {
                    el._tomselect.disable();
                    el._tomselect.clear();
                    el._tomselect.clearOptions();
                }
            }

            function enableSelect(id) {
                const el = document.getElementById(id);
                if (el && el._tomselect) {
                    el._tomselect.enable();
                }
            }
        });
    </script>
@endpush
