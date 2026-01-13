@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-3 p-3 me-3 shadow-sm">
                    <i class="fas fa-user-plus fa-lg"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-0">Pendaftaran Pasien Baru</h4>
                    <p class="text-muted small mb-0">Input data medis untuk memulai analisis prediksi stroke oleh AI.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <form action="{{ route('pasien.store') }}" method="POST">
                        @csrf
                        
                        <h6 class="fw-bold mb-3 text-primary border-bottom pb-2">Identitas Dasar</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold">Nama Lengkap Pasien</label>
                                <input type="text" name="patient_name" class="form-control rounded-3" placeholder="Contoh: Budi Santoso" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Usia</label>
                                <div class="input-group">
                                    <input type="number" name="age" class="form-control rounded-3" placeholder="0" required>
                                    <span class="input-group-text bg-light small">Tahun</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Jenis Kelamin</label>
                                <select name="gender" class="form-select rounded-3" required>
                                    <option value="" selected disabled>Pilih Gender</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Status Pernikahan</label>
                                <select name="ever_married" class="form-select rounded-3">
                                    <option value="Yes">Sudah Menikah</option>
                                    <option value="No">Belum Menikah</option>
                                </select>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3 text-primary border-bottom pb-2">Parameter Medis (AI Input)</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Riwayat Hipertensi</label>
                                <select name="hypertension" class="form-select rounded-3">
                                    <option value="0">Tidak Ada</option>
                                    <option value="1">Ada Riwayat</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Penyakit Jantung</label>
                                <select name="heart_disease" class="form-select rounded-3">
                                    <option value="0">Tidak Ada</option>
                                    <option value="1">Ada Riwayat</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Rata-rata Kadar Glukosa</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="avg_glucose_level" class="form-control rounded-3" placeholder="0.00">
                                    <span class="input-group-text bg-light small">mg/dL</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">BMI (Body Mass Index)</label>
                                <input type="number" step="0.1" name="bmi" class="form-control rounded-3" placeholder="0.0">
                            </div>
                        </div>

                        <div class="mt-5 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Simpan & Jalankan AI
                            </button>
                            <a href="{{ route('pasien.index') }}" class="btn btn-light px-4 py-2 rounded-pill fw-bold">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .card {
        border: 1px solid #f0f0f0;
    }
</style>
@endsection