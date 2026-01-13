<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Secure Medical Login - RSUD BHAKTI</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <style>
            :root {
                --rs-primary: #0ea5e9;
                --rs-secondary: #6366f1;
                --glass-bg: rgba(255, 255, 255, 0.95);
            }

            body {
                /* Background diperbagus dengan gradasi radial yang mewah */
                background: radial-gradient(circle at 0% 0%, #1e293b 0%, #0f172a 100%);
                font-family: 'Plus Jakarta Sans', sans-serif;
                height: 100vh;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden; /* Mencegah scroll agar pas 100% layar */
            }

            /* Ukuran Card disesuaikan agar tidak terlalu besar */
            .login-card {
                background: var(--glass-bg);
                backdrop-filter: blur(20px);
                border-radius: 24px;
                padding: 35px; /* Padding dikurangi biar compact */
                width: 100%;
                max-width: 380px; /* Lebar diperkecil agar pas 100% halaman */
                border: 1px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.5);
                animation: fadeIn 0.6s ease-out;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }

            .logo-box img {
                width: 65px; /* Ukuran logo disesuaikan */
                filter: drop-shadow(0 8px 15px rgba(14, 165, 233, 0.3));
                margin-bottom: 15px;
            }

            h4 { 
                color: #0f172a; 
                font-weight: 800; 
                font-size: 1.25rem; /* Font diperkecil agar seimbang */
                letter-spacing: -0.5px;
            }

            .form-label { 
                font-size: 0.7rem; 
                font-weight: 700; 
                text-transform: uppercase; 
                color: #64748b;
                letter-spacing: 0.5px;
            }

            .form-control {
                border-radius: 10px;
                padding: 10px 14px;
                font-size: 0.85rem;
                border: 1.5px solid #e2e8f0;
                background: #f8fafc;
            }

            .form-control:focus {
                border-color: var(--rs-primary);
                box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
            }

            /* Captcha Box yang Lebih Bagus */
            .captcha-area {
                background: #f1f5f9;
                border-radius: 12px;
                border: 1px dashed #cbd5e1;
            }

            .captcha-code {
                font-size: 1.4rem;
                font-weight: 800;
                color: var(--rs-primary);
                letter-spacing: 6px;
                font-family: 'Monaco', monospace;
            }

            .btn-login {
                background: linear-gradient(90deg, var(--rs-primary), var(--rs-secondary));
                border: none;
                border-radius: 12px;
                padding: 12px;
                color: white;
                font-weight: 700;
                font-size: 0.85rem;
                transition: 0.3s;
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px -5px rgba(14, 165, 233, 0.4);
                filter: brightness(1.05);
            }
        </style>
    </head>
    <body>
        <div class="login-card">
            <div class="text-center">
                <div class="logo-box">
                    <img src="{{ asset('img/Logo_RS.png') }}" alt="Logo RS">
                </div>
                <h4>Login Tenaga Medis</h4>
                <p class="text-muted small mb-4">Silakan masuk untuk akses sistem</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger py-2 small border-0 mb-3" role="alert">
                    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Institusi</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="dokter@hospital.com" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input id="password" type="password" name="password" class="form-control" style="border-radius: 10px 0 0 10px; border-right: none;" required>
                        <button class="btn border" type="button" id="toggleLoginPassword" style="border-radius: 0 10px 10px 0; background: #f8fafc; border-left: none; color: #94a3b8; border-color: #e2e8f0;">
                            <i class="bi bi-eye" id="eyeIconLogin"></i>
                        </button>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-muted" for="remember" style="font-size: 0.7rem;">Ingat Saya</label>
                        </div>
                        <a class="small text-decoration-none fw-bold" href="https://wa.me/6282178253252" target="_blank" style="color: var(--rs-primary); font-size: 0.7rem;">
                            Lupa Password?
                        </a>
                    </div>
                </div>

                <div class="captcha-area p-3 mb-4 text-center">
                    <label class="form-label d-block mb-2">Verifikasi Manusia</label>
                    <div class="captcha-code mb-2">{{ $captcha }}</div>
                    <input type="text" name="captcha_input" class="form-control text-center text-uppercase fw-bold" placeholder="Ketik Kode" required>
                </div>
                
                <button type="submit" class="btn-login w-100 shadow-sm">
                    MASUK KE DASHBOARD <i class="fas fa-chevron-right ms-2 small"></i>
                </button>
            </form>
        </div>
        <script>
            // Script Mata Password tetap bekerja
            document.addEventListener('DOMContentLoaded', function () {
                const toggleBtn = document.querySelector('#toggleLoginPassword');
                const passwordInput = document.querySelector('#password');
                const eyeIcon = document.querySelector('#eyeIconLogin');

                if (toggleBtn) {
                    toggleBtn.addEventListener('click', function () {
                        const isPassword = passwordInput.getAttribute('type') === 'password';
                        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                        eyeIcon.classList.toggle('bi-eye');
                        eyeIcon.classList.toggle('bi-eye-slash');
                    });
                }
            });
        </script>
    </body>
</html>