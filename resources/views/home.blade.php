<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Developed by ERWIN, S.KOM - Founder TITIK BALIK TEKNOLOGI">
    <meta name="keywords"
        content="Puskesmas Sehat, login, imunisasi digital, vaksinasi anak, jadwal vaksin, layanan kesehatan">
    <title>Posyandu Cempaka | Layanan Imunisasi Balita</title>
    <link rel="shortcut icon" href="{{ asset('auth/assets/logo-posyandu.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('auth/css/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('auth/assets/logo-posyandu.png') }}" alt="Logo Puskesmas" height="50">
                <span class="ms-2 fw-bold text-primaryku">Posyandu Cempaka</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#jadwal">Jadwal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-primaryku ms-lg-3 px-4">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda"
        style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-white mb-4">Lindungi Buah Hati Anda dengan <span
                            class="text-warningku">Imunisasi Lengkap</span></h1>
                    <p class="lead text-white mb-4">Puskesmas Sehat menyediakan layanan imunisasi balita lengkap sesuai
                        jadwal Kementerian Kesehatan untuk mencegah penyakit berbahaya.</p>
                    <div class="d-flex gap-3">
                        <a href="#jadwal" class="btn btn-vaccine btn-lg px-4 shadow">Lihat Jadwal Imunisasi</a>
                        <!-- <a href="#daftar" class="btn btn-outline-light btn-lg px-4">Daftar Online</a> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-illustration position-relative">
                        <img src="{{ asset('auth/assets/img-front.png') }}" alt="Anak sehat"
                            class="img-fluid d-none d-lg-block">
                        <div class="circle-decoration bg-accent-light"></div>
                        <div class="triangle-decoration bg-secondary-light"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5 animated">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="stat-item shadow">
                        <h3 class="fw-bold display-5">5.000+</h3>
                        <p class="mb-0">Balita Terimunisasi</p>
                        <i class="fas fa-child mt-3"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item shadow">
                        <h3 class="fw-bold display-5">12</h3>
                        <p class="mb-0">Jenis Imunisasi</p>
                        <i class="fas fa-syringe mt-3"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item shadow">
                        <h3 class="fw-bold display-5">98%</h3>
                        <p class="mb-0">Kepuasan Orang Tua</p>
                        <i class="fas fa-smile mt-3"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item shadow">
                        <h3 class="fw-bold display-5">15+</h3>
                        <p class="mb-0">Tenaga Ahli</p>
                        <i class="fas fa-user-md mt-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Section -->
    <section id="layanan" class="py-5" style="background-color: #f8fbfe;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Layanan Imunisasi Kami</h2>
                <p class="section-subtitle">Berbagai jenis imunisasi untuk melindungi buah hati Anda</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="vaccine-service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                <i class="fas fa-syringe"></i>
                                <div class="icon-pulse"></div>
                            </div>
                            <h5 class="card-title mb-3">BCG</h5>
                            <p class="card-text">Untuk mencegah tuberkulosis, diberikan saat bayi baru lahir.</p>
                            <div class="vaccine-badge">Wajib</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="vaccine-service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                <i class="fas fa-virus-slash"></i>
                                <div class="icon-pulse"></div>
                            </div>
                            <h5 class="card-title mb-3">Hepatitis B</h5>
                            <p class="card-text">Mencegah hepatitis B, diberikan dalam 3 dosis.</p>
                            <div class="vaccine-badge">Wajib</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="vaccine-service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                <i class="fas fa-shield-virus"></i>
                                <div class="icon-pulse"></div>
                            </div>
                            <h5 class="card-title mb-3">DPT-HB-Hib</h5>
                            <p class="card-text">Kombinasi untuk difteri, pertusis, tetanus, hepatitis B, dan HiB.</p>
                            <div class="vaccine-badge">Wajib</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="vaccine-service-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="icon-box">
                                <i class="fas fa-bacterium"></i>
                                <div class="icon-pulse"></div>
                            </div>
                            <h5 class="card-title mb-3">Polio</h5>
                            <p class="card-text">Mencegah polio, diberikan dalam 4 dosis.</p>
                            <div class="vaccine-badge">Wajib</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jadwal Section -->
    <section id="jadwal" class="py-5 py-lg-7" style="background-color: #f8fbfe;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Jadwal Imunisasi</h2>
                <p class="section-subtitle">Catat jadwal imunisasi buah hati Anda</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="vaccine-card h-100">
                        <div class="card-header">
                            <div class="header-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h3>Jadwal Rutin</h3>
                            <p>Imunisasi harian di puskesmas</p>
                        </div>
                        <div class="card-body">
                            <div class="schedule-table">
                                <div class="table-header">
                                    <div class="th">Hari</div>
                                    <div class="th">Waktu</div>
                                    <div class="th">Lokasi</div>
                                </div>

                                @foreach ($regularSchedules as $day => $schedules)
                                    @php
                                        // Ambil data pertama dari group (karena waktu dan lokasi sama)
                                        $schedule = $schedules->first();
                                    @endphp
                                    <div class="table-row">
                                        <div class="td">
                                            <i class="fas fa-calendar-day me-2"></i>
                                            {{ $day }}
                                        </div>
                                        <div class="td">{{ $schedule->start_time }} - {{ $schedule->end_time }}
                                        </div>
                                        <div class="td">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            {{ $schedule->location }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="vaccine-card h-100">
                        <div class="card-header">
                            <div class="header-icon">
                                <i class="fas fa-calendar-star"></i>
                            </div>
                            <h3>Jadwal Khusus</h3>
                            <p>Imunisasi bulan ini</p>
                        </div>
                        <div class="card-body">
                            <div class="special-schedule">
                                @foreach ($specialSchedules as $schedule)
                                    <div class="schedule-item">
                                        <div class="date-badge">
                                            <div class="date-day">{{ $schedule->start_date->format('d') }}</div>
                                            <div class="date-month">{{ $schedule->start_date->format('M') }}</div>
                                        </div>
                                        <div class="schedule-details">
                                            <h4>{{ $schedule->title }}</h4>
                                            <div class="schedule-meta">
                                                <span><i class="fas fa-clock me-2"></i>{{ $schedule->start_time }} -
                                                    {{ $schedule->end_time }}</span>
                                                <span><i
                                                        class="fas fa-map-marker-alt me-2"></i>{{ $schedule->location }}</span>
                                            </div>
                                            <div class="badge-vaccine {{ $schedule->category }}">
                                                {{ ucfirst($schedule->category) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Testimoni Section -->
    <section class="py-5 py-lg-7 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Apa Kata Mereka?</h2>
                <p class="section-subtitle">Testimoni dari orang tua yang telah menggunakan layanan kami</p>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="testimonial-slider">
                        <div class="testimonial-item bg-white p-4 p-lg-5 rounded-3 shadow-sm">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('auth/assets/ibu-png.png') }}" alt="Testimoni"
                                    class="rounded-circle me-3" width="60">
                                <div>
                                    <h5 class="mb-0">Ibu Siti</h5>
                                    <span class="text-muted">Ibu dari Aisha (2 tahun)</span>
                                </div>
                            </div>
                            <p class="mb-0">"Pelayanan imunisasi di Puskesmas Sehat sangat ramah anak. Petugasnya
                                sabar dan profesional. Anak saya tidak takut lagi setelah beberapa kali imunisasi di
                                sini."</p>
                        </div>

                        <!-- <div class="testimonial-item bg-white p-4 p-lg-5 rounded-3 shadow-sm">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('auth/ibu-png.png') }}" alt="Testimoni" class="rounded-circle me-3" width="60">
                                <div>
                                    <h5 class="mb-0">Budi Santoso</h5>
                                    <span class="text-muted">Ayah dari Rama (3 tahun)</span>
                                </div>
                            </div>
                            <p class="mb-0">"Sistem pendaftaran online sangat membantu kami yang sibuk bekerja. Tidak perlu antri lama, datang sesuai jadwal dan langsung dilayani."</p>
                        </div> -->

                        <div class="testimonial-item bg-white p-4 p-lg-5 rounded-3 shadow-sm">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('auth/assets/ibu-png.png') }}" alt="Testimoni"
                                    class="rounded-circle me-3" width="60">
                                <div>
                                    <h5 class="mb-0">Dewi Anggraeni</h5>
                                    <span class="text-muted">Ibu dari Bintang (1 tahun)</span>
                                </div>
                            </div>
                            <p class="mb-0">"Informasi jadwal imunisasi sangat jelas dan selalu diupdate. Petugas
                                juga memberikan penjelasan lengkap tentang efek samping dan perawatan setelah
                                imunisasi."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-5 py-lg-7">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Pertanyaan Umum</h2>
                <p class="section-subtitle">Temukan jawaban atas pertanyaan Anda</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $index => $faq)
                            <div class="accordion-item border-0 shadow-sm mb-3 rounded-3">
                                <h3 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button collapsed rounded-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                                        {{ $faq->question }}
                                    </button>
                                </h3>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Kontak Info -->
                <div class="col-lg-5">
                    <h2 class="mb-4">Hubungi Kami</h2>
                    <p class="mb-4">Punya pertanyaan lebih lanjut? Tim kami siap membantu Anda.</p>

                    <div class="contact-info">
                        <!-- Alamat -->
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primaryku">
                                <i class="fas fa-map-marker-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Alamat</h6>
                                <p class="text-muted mb-0">{{ $contactInfo->address }}</p>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primaryku">
                                <i class="fas fa-phone-alt fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Telepon</h6>
                                <p class="text-muted mb-0">{{ $contactInfo->phone }}</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primaryku">
                                <i class="fas fa-envelope fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <p class="text-muted mb-0">{{ $contactInfo->email }}</p>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="d-flex">
                            <div class="me-3 text-primaryku">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Jam Operasional</h6>
                                <p class="text-muted mb-0">
                                    {!! nl2br(e($contactInfo->opening_hours)) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Kontak -->
                <div class="col-lg-7">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Kirim Pesan</h3>
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Subjek</label>
                                        <input type="text" name="subject" class="form-control" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Pesan</label>
                                        <textarea class="form-control" name="message" rows="4" required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primaryku">Kirim Pesan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Welcome Otomatis -->
        <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow-lg rounded-4 border-0">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="welcomeModalLabel">Selamat Datang di Posyandu Cempaka</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p class="lead">
                            Lindungi buah hati Anda dengan layanan imunisasi lengkap sesuai jadwal Kementerian
                            Kesehatan.<br>
                            Puskesmas Sehat memberikan pelayanan imunisasi balita yang ramah dan profesional.
                        </p>
                        <ul>
                            <li>Jadwal imunisasi rutin dan khusus yang selalu diperbarui.</li>
                            <li>Layanan berkualitas dan tenaga ahli yang berpengalaman.</li>
                            <li>Fitur daftar online dan notifikasi jadwal.</li>
                        </ul>
                        <p>Silakan jelajahi website kami untuk informasi lengkap.</p>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-primaryku btn-lg w-100"
                            data-bs-dismiss="modal">Jelajahi
                            Selengkapnya</button>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <img src="{{ asset('auth/assets/logo-posyandu.png') }}" alt="Logo Puskesmas" height="50">
                    <p class="mt-3">Puskesmas Sehat memberikan pelayanan kesehatan prima termasuk imunisasi balita
                        untuk menciptakan generasi sehat dan cerdas.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h5 class="mb-4">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="#layanan" class="text-white text-decoration-none">Layanan</a>
                        </li>
                        <li class="mb-2"><a href="#jadwal" class="text-white text-decoration-none">Jadwal</a></li>
                        <li class="mb-2"><a href="#faq" class="text-white text-decoration-none">FAQ</a></li>
                        <li><a href="#kontak" class="text-white text-decoration-none">Kontak</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h5 class="mb-4">Layanan Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Imunisasi
                                Balita</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Kesehatan Ibu
                                dan Anak</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Pengobatan
                                Dasar</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Pemeriksaan
                                Laboratorium</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Promosi Kesehatan</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h5 class="mb-4">Newsletter</h5>
                    <p>Berlangganan newsletter kami untuk mendapatkan informasi terbaru tentang jadwal imunisasi dan
                        tips kesehatan anak.</p>
                    <form class="mt-4">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email Anda">
                            <button class="btn btn-primaryku" type="button">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="my-4 bg-secondary">

            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2023 Puskesmas Sehat. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Developed with <i class="fas fa-heart text-danger"></i> by Tim Puskesmas</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#" class="back-to-top btn btn-primaryku rounded-circle shadow">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('auth/js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah sudah pernah lihat modal ini selama sesi ini
            if (!sessionStorage.getItem('welcomeModalShown')) {
                const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'), {
                    backdrop: 'static',
                    keyboard: false
                });
                welcomeModal.show();

                // Tandai sudah pernah tampil agar tidak berulang saat refresh
                sessionStorage.setItem('welcomeModalShown', true);
            }
        });
    </script>

</body>

</html>
