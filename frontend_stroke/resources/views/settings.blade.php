@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold text-dark mb-4"><i class="fas fa-cog me-2 text-primary"></i> Pengaturan Sistem & Akun</h3>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="list-group list-group-flush p-2">
                    <a href="#account" class="list-group-item list-group-item-action border-0 rounded-3 active" data-bs-toggle="tab">
                        <i class="fas fa-user-circle me-2"></i> Profil Akun
                    </a>
                    <a href="#security" class="list-group-item list-group-item-action border-0 rounded-3" data-bs-toggle="tab">
                        <i class="fas fa-shield-alt me-2"></i> Keamanan
                    </a>
                    <a href="#hospital" class="list-group-item list-group-item-action border-0 rounded-3" data-bs-toggle="tab">
                        <i class="fas fa-hospital me-2"></i> Info Rumah Sakit
                    </a>
                    <a href="#notif" class="list-group-item list-group-item-action border-0 rounded-3" data-bs-toggle="tab">
                        <i class="fas fa-bell me-2"></i> Notifikasi
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">
                
                <div class="tab-pane fade show active" id="account">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4">Informasi Pribadi</h5>
                        <form action="/settings/update-profile" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Email Medis</label>
                                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Nomor Telepon</label>
                                    <input type="text" class="form-control" value="+62 812 3456 7890">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Spesialisasi</label>
                                    <select class="form-select">
                                        <option selected>Neurologi (Saraf)</option>
                                        <option>Kardiologi (Jantung)</option>
                                        <option>Umum</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="security">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4">Ubah Kata Sandi</h5>
                        <form action="/settings" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Password Lama</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Password Baru</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-danger px-4">Update Password</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="hospital">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4">Konfigurasi Instansi</h5>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Rumah Sakit/Klinik</label>
                            <input type="text" class="form-control" value="RS Pusat Med-Info AI" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Instansi</label>
                            <textarea class="form-control" rows="2" readonly>Jl. Teknologi Kesehatan No. 101, Jakarta Selatan</textarea>
                        </div>
                        <div class="alert alert-warning small border-0 shadow-sm">
                            <i class="fas fa-exclamation-triangle me-2"></i> 
                            Hanya Administrator Utama yang dapat mengubah data instansi.
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="notif">
                    <div class="card-body">
    <h5 class="fw-bold mb-4">Preferensi Notifikasi</h5>

    <form action="{{ route('settings.notifications') }}" method="POST" id="notifForm">
        @csrf
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="mb-0 small fw-bold">Email notifikasi setiap ada diagnosa Risiko Tinggi</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="notif_email" role="switch"
                    {{ Auth::user()->notif_email_risiko_tinggi ? 'checked' : '' }} 
                    onchange="document.getElementById('notifForm').submit()">
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="mb-0 small fw-bold">Suara alarm jika hasil prediksi > 80%</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="notif_alarm" role="switch"
                    {{ Auth::user()->notif_suara_alarm ? 'checked' : '' }}
                    onchange="document.getElementById('notifForm').submit()">
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="mb-0 small fw-bold text-muted">Laporan mingguan otomatis ke email</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="notif_laporan" role="switch"
                    {{ Auth::user()->notif_laporan_mingguan ? 'checked' : '' }}
                    onchange="document.getElementById('notifForm').submit()">
            </div>
        </div>
    </form>
</div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection