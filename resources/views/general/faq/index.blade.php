@extends('layouts.app')

@section('title', 'FAQ : Posyandu Ta')

@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>FAQ</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createFaqModal">
                        <i class="fas fa-plus"></i> Tambah FAQ
                    </button>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Pertanyaan</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $faq)
                            <div class="accordion-item" id="faq-{{ $faq->id }}">
                                <h2 class="accordion-header" id="heading-{{ $faq->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="false"
                                        aria-controls="collapse-{{ $faq->id }}">
                                        {{ $faq->question }}
                                        <span class="badge bg-{{ $faq->is_active ? 'success' : 'danger' }} ms-2">
                                            {{ $faq->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $faq->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading-{{ $faq->id }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div>
                                                <span class="text-muted">Urutan: {{ $faq->order }}</span>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editFaqModal{{ $faq->id }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteFaqModal{{ $faq->id }}">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createFaqModal" tabindex="-1" aria-labelledby="createFaqModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFaqModalLabel">Tambah FAQ Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createFaqForm" action="{{ route('faq.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="create_question">Pertanyaan</label>
                            <input type="text" class="form-control" id="create_question" name="question" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="create_answer">Jawaban</label>
                            <textarea class="form-control" id="create_answer" name="answer" rows="5" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="create_order">Urutan</label>
                                    <input type="number" class="form-control" id="create_order" name="order"
                                        min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4 pt-2">
                                    <input class="form-check-input" type="checkbox" id="create_is_active" name="is_active"
                                        value="1" checked>
                                    <label class="form-check-label" for="create_is_active">Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @foreach ($faqs as $faq)
        <!-- Edit Modal -->
        <div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1"
            aria-labelledby="editFaqModalLabel{{ $faq->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFaqModalLabel{{ $faq->id }}">Edit FAQ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editFaqForm{{ $faq->id }}" method="POST"
                        action="{{ route('faq.update', Crypt::encrypt($faq->id)) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="edit_question{{ $faq->id }}">Pertanyaan</label>
                                <input type="text" class="form-control" id="edit_question{{ $faq->id }}"
                                    name="question" value="{{ $faq->question }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="edit_answer{{ $faq->id }}">Jawaban</label>
                                <textarea class="form-control" id="edit_answer{{ $faq->id }}" name="answer" rows="5" required>{{ $faq->answer }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="edit_order{{ $faq->id }}">Urutan</label>
                                        <input type="number" class="form-control" id="edit_order{{ $faq->id }}"
                                            name="order" value="{{ $faq->order }}" min="1" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch mt-4 pt-2">
                                        <input class="form-check-input" type="checkbox"
                                            id="edit_is_active{{ $faq->id }}" name="is_active" value="1"
                                            {{ $faq->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edit_is_active{{ $faq->id }}">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteFaqModal{{ $faq->id }}" tabindex="-1"
            aria-labelledby="deleteFaqModalLabel{{ $faq->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteFaqModalLabel{{ $faq->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus FAQ: <strong>{{ $faq->question }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form id="deleteFaqForm{{ $faq->id }}" method="POST"
                            action="{{ route('faq.destroy', Crypt::encrypt($faq->id)) }}">
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
        $(document).ready(function() {
            // Initialize Summernote for answer textarea
            $('#create_answer, #edit_answer').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview', 'help']]
                ]
            });

            // Handle edit button click
            $('.edit-faq').click(function() {
                const id = $(this).data('id');
                const question = $(this).data('question');
                const answer = $(this).data('answer');
                const order = $(this).data('order');
                const is_active = $(this).data('is_active');

                $('#editFaqForm').attr('action', '/admin/faq/' + id);
                $('#edit_question').val(question);
                $('#edit_answer').summernote('code', answer);
                $('#edit_order').val(order);
                $('#edit_is_active').prop('checked', is_active == 1);

                $('#editFaqModal').modal('show');
            });

            // Handle delete button click
            $('.delete-faq').click(function() {
                const id = $(this).data('id');
                $('#deleteFaqForm').attr('action', '/admin/faq/' + id);
                $('#deleteFaqModal').modal('show');
            });

            // Form submission with SweetAlert for create and edit
            $('#createFaqForm, #editFaqForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Menyimpan Data',
                    html: 'Sedang memproses data...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Show loading state

                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    if (response.redirect) {
                                        window.location.href = response
                                            .redirect;
                                    } else {
                                        window.location.reload();
                                    }
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan'
                                });
                            }
                        });
                    }
                });
            });

            // Delete form submission with SweetAlert
            $('#deleteFaqForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Menghapus Data',
                    html: 'Sedang memproses...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Show loading state

                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan'
                                });
                            }
                        });
                    }
                });
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

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}'
                });
            @endif
        });
    </script>
@endpush
