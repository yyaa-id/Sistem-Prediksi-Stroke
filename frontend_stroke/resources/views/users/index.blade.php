@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    @if(session('success'))
    <div class="alert alert-success small py-2 border-0 mb-3">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger small py-2 border-0 mb-3">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h6 class="fw-bold mb-4"><i class="fas fa-user-plus text-primary me-2"></i>Tambah Admin Baru</h6>
                    <h6 class="fw-bold mb-4"><i class="fas fa-user-plus text-primary me-2"></i>Tambah Admin Baru</h6>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small fw-bold text-muted">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Dr. Andi" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="admin@rsud.com" required>
                        </div>
                        <div class="mb-4">
    <label class="small fw-bold text-muted">Password</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" 
               placeholder="Minimal 8 karakter" required 
               style="border-radius: 10px 0 0 10px; border-right: none;">
        <button class="btn btn-outline-secondary" type="button" id="btnToggle" 
                style="border-radius: 0 10px 10px 0; background: white; border-left: none; color: #64748b;">
            <i class="bi bi-eye" id="eyeIcon"></i>
        </button>
    </div>
</div>
<div class="mb-4">
    <label class="small fw-bold text-muted">Akses Level (Role)</label>
    <select name="role" class="form-control" required>
        <option value="" disabled selected>Pilih Role...</option>
        <option value="admin_utama">Admin Utama (Akses Penuh)</option>
        <option value="staf">Staf Medis (Skrining & Pasien)</option>
    </select>
</div>                        
<button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="border-radius: 10px;">
                            Simpan Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4"><i class="fas fa-users text-primary me-2"></i>Daftar Pengelola Sistem</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr style="font-size: 12px;" class="text-muted text-uppercase">
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Terdaftar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-soft-primary p-2 rounded-circle text-primary">
                                                <i class="fas fa-user-circle"></i>
                                            </div>
                                            <span class="fw-bold small">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="small text-muted">{{ $user->email }}</td>
                                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        @if(auth()->id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus admin ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-light text-danger border-0">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @else
                                        <span class="badge bg-soft-success text-success px-3">Anda</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(14, 165, 233, 0.1); }
    .bg-soft-success { background: rgba(34, 197, 94, 0.1); }
    .form-control { border-radius: 10px; border: 1px solid #e2e8f0; padding: 10px 15px; font-size: 13px; }
    .form-control:focus { box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1); border-color: var(--rs-primary); }

    .input-group .btn {
    background-color: #fff;
    color: #64748b;
}

.input-group .form-control {
    border-radius: 10px 0 0 10px !important;
}

.input-group .btn:hover {
    background-color: #f8fafc;
    color: var(--rs-primary);
}

</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnToggle = document.querySelector('#btnToggle');
        const passwordField = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        if (btnToggle) {
            btnToggle.addEventListener('click', function () {
                // Ubah Tipe Input
                const isPassword = passwordField.getAttribute('type') === 'password';
                passwordField.setAttribute('type', isPassword ? 'text' : 'password');
                
                // Ubah Ikon (bi-eye ke bi-eye-slash)
                if (isPassword) {
                    eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });
        }
    });
</script>
@endsection