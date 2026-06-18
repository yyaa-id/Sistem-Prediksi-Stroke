<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM-SARAF | RSUD BHAKTI NUSANTARA</title>
    <link rel="icon" type="image/png" href="{{ asset('img/Logo_RS.png') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --rs-primary: #0ea5e9;
            --rs-secondary: #6366f1;
            --rs-dark: #0f172a;
            --rs-bg: #f8fafc;
        }

        body {
            background-color: var(--rs-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            color: #1e293b;
        }

        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: white;
            position: fixed;
            width: 280px;
            z-index: 1050;
            box-shadow: 4px 0 24px rgba(0,0,0,0.15);
        }

        .sidebar-link {
            font-size: 13px;
            padding: 10px 20px;
        }
        .brand-box h6 { font-size: 14px; }
        .top-bar h5 { font-size: 16px; }

        .brand-box {
            padding: 35px 25px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .logo-img {
            width: 55px;
            filter: drop-shadow(0 0 8px rgba(14, 165, 233, 0.5));
            margin-bottom: 15px;
        }

        .nav-label {
            padding: 20px 28px 10px;
            font-size: 0.7rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .sidebar-link {
            padding: 14px 28px;
            color: #94a3b8;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.3s;
            margin: 4px 15px;
            border-radius: 12px;
        }

        .sidebar-link:hover {
            background: rgba(255,255,255,0.05);
            color: var(--rs-primary);
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, var(--rs-primary), var(--rs-secondary));
            color: white;
            box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.3);
        }

        .main-content { margin-left: 280px; padding: 0; }

        .top-bar {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            padding: 15px 40px;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .user-nav-btn {
            background: #ffffff;
            padding: 6px 16px;
            border-radius: 50px;
            border: 1px solid #edf2f7;
            transition: all 0.25s ease;
        }

        .user-avatar-wrapper {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .role-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 2px 10px;
            border-radius: 50px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .dropdown-item { font-size: 13px; padding: 10px 15px; }
    </style>
</head>

<body>
    <div class="sidebar ">
        <div style="color: yellow; background: black; font-size: 10px; padding: 10px; border-bottom: 1px solid yellow;">
            DEBUG: Role Anda adalah "{{ Auth::user()->role }}"
        </div>
        <div class="brand-box">
            <img src="{{ asset('img/Logo_RS.png') }}" class="logo-img" alt="Logo">
            <h6 class="fw-bold mb-0 text-white">RSUD BHAKTI</h6>
            <small style="color: var(--rs-primary); font-size: 10px; letter-spacing: 2px;">SIM-SARAF</small>
        </div>

        <div class="nav-label">Utama</div>
        <a href="/dashboard" class="sidebar-link {{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> <span>Home Dashboard</span>
        </a>

        <div class="nav-label">Layanan Medis</div>
        <a href="/predict" class="sidebar-link {{ Request::is('predict*') ? 'active' : '' }}">
            <i class="fas fa-stethoscope"></i> <span>Skrining Stroke</span>
        </a>

        <div class="nav-label">Laporan & Data</div>
        <a href="/pasien" class="sidebar-link {{ Request::is('pasien*') ? 'active' : '' }}">
            <i class="fas fa-folder-medical"></i> <span>Manajemen Pasien</span>
        </a>
        <a href="/statistik" class="sidebar-link {{ Request::is('statistik*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> <span>Surveilans Stroke</span>
        </a>
        
        @if(Auth::check() && strtolower(Auth::user()->role) == 'admin_utama')
        <div class="nav-label text-uppercase small opacity-50">Konfigurasi</div>
        <a href="{{ route('users.index') }}" class="sidebar-link {{ Request::is('users*') ? 'active' : '' }}">
            <i class="fas fa-users-cog"></i> <span>Manajemen Admin</span>
        </a>
        @endif
    </div> 
    
    <div class="main-content">
        <div class="top-bar d-flex justify-content-between align-items-center no-print">
            <div>
                <h5 class="fw-bold mb-0"><i class="fas fa-notes-medical text-primary me-2"></i> Sistem RS Pusat</h5>
                <p class="text-muted small mb-0">Unit Pelayanan Neurologi Terpadu</p>
            </div>

            <div class="dropdown">
                <button class="user-nav-btn dropdown-toggle d-flex align-items-center gap-3 border-0 shadow-sm" type="button" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-md-block">
                        <span class="role-badge d-inline-block mb-1">System Access</span>
                        <span class="fw-bold small text-dark d-block">Administrator</span>
                    </div>
                    <div class="user-avatar-wrapper">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </button>
                
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2 mt-2" style="border-radius: 15px; min-width: 240px;">
                    <li class="px-3 py-3 mb-2 bg-light rounded-4 d-flex align-items-center gap-3">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 35px; height: 35px;">
                            <i class="fas fa-check-double fa-xs"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 10px;">Status Login</small>
                            <span class="fw-bold text-dark small">Sistem Admin Aktif</span>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 rounded-3" href="/settings">
                            <i class="fas fa-sliders-h me-3 text-primary" style="width: 20px;"></i>
                            <span>Konfigurasi Sistem</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider opacity-50"></li>
                    <li>
                        <a class="dropdown-item py-2 rounded-3 text-danger fw-bold" href="/logout">
                            <i class="fas fa-sign-out-alt me-3" style="width: 20px;"></i>
                            <span>Keluar Sistem</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>