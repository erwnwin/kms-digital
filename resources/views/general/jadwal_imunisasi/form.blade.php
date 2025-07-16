<div class="card-body">
    <form
        action="{{ isset($jadwal) ? route('jadwal-imunisasi.update', Crypt::encrypt($jadwal->id)) : route('jadwal-imunisasi.store') }}"
        method="POST" id="jadwalForm">
        @csrf
        @if (isset($jadwal))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Jenis Imunisasi</label>
                    <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                        name="type" value="{{ old('type', $jadwal->type ?? '') }}" required>
                    @error('type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title">Judul Kegiatan</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $jadwal->title ?? '') }}" required>
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                        name="start_date"
                        value="{{ old('start_date', isset($jadwal) && $jadwal->start_date ? $jadwal->start_date->format('Y-m-d') : '') }}">
                    @error('start_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="start_time">Waktu Mulai</label>
                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                        name="start_time" value="{{ old('start_time', $jadwal->start_time ?? '') }}" required>
                    @error('start_time')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category"
                        required>
                        <option value="">Pilih Kategori</option>
                        <option value="wajib"
                            {{ old('category', $jadwal->category ?? '') == 'wajib' ? 'selected' : '' }}>Wajib</option>
                        <option value="tambahan"
                            {{ old('category', $jadwal->category ?? '') == 'tambahan' ? 'selected' : '' }}>Tambahan
                        </option>
                        <option value="nasional"
                            {{ old('category', $jadwal->category ?? '') == 'nasional' ? 'selected' : '' }}>Nasional
                        </option>
                    </select>
                    @error('category')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">Tanggal Selesai (Opsional)</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                        name="end_date"
                        value="{{ old('end_date', isset($jadwal) ? ($jadwal->end_date ? $jadwal->end_date->format('Y-m-d') : '') : '') }}">
                    @error('end_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_time">Waktu Selesai (Opsional)</label>
                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                        name="end_time" value="{{ old('end_time', $jadwal->end_time ?? '') }}">
                    @error('end_time')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location">Lokasi</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                        name="location" value="{{ old('location', $jadwal->location ?? '') }}" required>
                    @error('location')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi (Opsional)</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="3">{{ old('description', $jadwal->description ?? '') }}</textarea>
            @error('description')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                {{ old('is_active', isset($jadwal) ? $jadwal->is_active : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">
                Jadwal Aktif
            </label>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary me-2">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('jadwal-imunisasi') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission with SweetAlert
            const form = document.getElementById('jadwalForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Menyimpan Data',
                    html: 'Sedang memproses data...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                        setTimeout(() => {
                            form.submit();
                        }, 100);
                    }
                });
            });

            // Date validation
            document.getElementById('end_date').addEventListener('change', function() {
                const startDate = new Date(document.getElementById('start_date').value);
                const endDate = new Date(this.value);

                if (endDate < startDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanggal tidak valid',
                        text: 'Tanggal selesai harus setelah tanggal mulai'
                    });
                    this.value = '';
                }
            });

            // Time validation
            document.getElementById('end_time').addEventListener('change', function() {
                const startTime = document.getElementById('start_time').value;
                const endTime = this.value;

                if (endTime && startTime && endTime <= startTime) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Waktu tidak valid',
                        text: 'Waktu selesai harus setelah waktu mulai'
                    });
                    this.value = '';
                }
            });
        });
    </script>
@endpush
