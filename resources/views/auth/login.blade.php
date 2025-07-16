<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Developed by ERWIN, S.KOM - Founder TITIK BALIK TEKNOLOGI">
    <meta name="keywords"
        content="Puskesmas Sehat, login, imunisasi digital, vaksinasi anak, jadwal vaksin, layanan kesehatan">
    <title>Login | Puskesmas Sehat</title>
    <link rel="shortcut icon" href="{{ asset('auth/assets/logo-posyandu.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('auth/css/login.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="split-card">
            <!-- Left Panel - Information -->
            <div class="info-panel">
                <h2><i class="fas fa-user-shield"></i> Selamat Datang</h2>
                <p>Layanan imunisasi digital Puskesmas Sehat memberikan kemudahan akses bagi orang tua untuk memantau
                    jadwal vaksinasi anak.</p>
                <ul>
                    <li><span class="info-icon"><i class="fas fa-check-circle"></i></span> Pantau jadwal imunisasi</li>
                    <li><span class="info-icon"><i class="fas fa-check-circle"></i></span> Catatan KMS digital</li>
                    <li><span class="info-icon"><i class="fas fa-check-circle"></i></span> Catatan Riwayat Imunisasi
                    </li>
                    <li><span class="info-icon"><i class="fas fa-check-circle"></i></span> Catatan Pemberian Vitamin
                    </li>
                </ul>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="login-panel">
                <div class="login-header">
                    <h3><i class="fas fa-sign-in-alt"></i>Masuk ke Akun</h3>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach

                    </div>
                @endif

                <form method="POST" action="{{ route('login.action') }}" id="loginForm">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email atau NIK</label>
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control" id="email" name="email"
                            placeholder="Masukkan email atau NIK" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukkan kata sandi" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <div class="show-password">
                            <input type="checkbox" id="showPassword">
                            <label for="showPassword">Tampilkan kata sandi</label>
                        </div>
                        {{-- <a href="#" class="forgot-password">Lupa kata sandi?</a> --}}
                    </div>

                    <button type="submit" class="btn btn-login btn-primary btn-loading" id="submitBtn">
                        <span><i class="fas fa-sign-in-alt"></i> Masuk</span>
                        <div class="spinner"></div>
                    </button>

                    <a href="/home" class="back-to-home">
                        <i class="fas fa-arrow-left"></i>Kembali ke Beranda
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle show password
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = this.checked ? 'text' : 'password';
        });

        // Form submission with loading effect
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Simple validation
            if (!email || !password) {
                e.preventDefault();
                return;
            }

            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;

            // You can optionally add a timeout to prevent very fast submissions
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }, 5000); // 5 seconds timeout as fallback
        });

        // Add animation to invalid fields on page load
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.style.animation = 'shake 0.5s';
        });

        // Shake animation for invalid fields
        const shakeKeyframes = [{
                transform: 'translateX(0)'
            },
            {
                transform: 'translateX(-5px)'
            },
            {
                transform: 'translateX(5px)'
            },
            {
                transform: 'translateX(0)'
            }
        ];

        const shakeTiming = {
            duration: 500,
            iterations: 1
        };

        document.querySelectorAll('.is-invalid').forEach(el => {
            el.animate(shakeKeyframes, shakeTiming);
        });
    </script>
</body>

</html>
