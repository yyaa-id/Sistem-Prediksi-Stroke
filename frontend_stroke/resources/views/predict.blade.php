@extends('layouts.app')

@section('content')
    <div class="container py-2">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden d-print-none">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary-subtle p-3 rounded-3 me-3">
                        <i class="fas fa-stethoscope text-primary fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Skrining Stroke Klinis</h5>
                        <p class="text-muted small mb-0">Masukkan parameter pasien untuk analisis risiko serebrovaskular.</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4" style="background-color: #fff9db; color: #856404;">
                    <i class="fas fa-keyboard me-3 fa-lg"></i>
                    <div style="font-size: 0.8rem;">
                        <strong>Petunjuk:</strong> Gunakan data dari rekam medis fisik atau hasil laboratorium terbaru. Contoh: Gula Darah <strong>120</strong>, BMI <strong>24.5</strong>.
                    </div>
                </div>

                <form action="/predict" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="p-2 bg-light rounded-2 mb-2">
                                <small class="fw-bold text-primary text-uppercase px-2" style="font-size: 10px; letter-spacing: 1px;">Identitas Dasar</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">Nama Lengkap Pasien</label>
                            <input type="text" name="patient_name" class="form-control form-control-sm py-2 shadow-none border-secondary-subtle" placeholder="Contoh: Tn. Ahmad Subarjo" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Jenis Kelamin</label>
                            <select name="gender" class="form-select form-select-sm py-2 shadow-none border-secondary-subtle">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Umur Pasien (Tahun)</label>
                            <input type="number" name="age" class="form-control form-control-sm py-2 shadow-none border-secondary-subtle" placeholder="Contoh: 45" required>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="p-2 bg-light rounded-2 mb-2">
                                <small class="fw-bold text-primary text-uppercase px-2" style="font-size: 10px; letter-spacing: 1px;">Riwayat Penyakit Penyerta (Komorbid)</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Riwayat Hipertensi</label>
                            <select name="hypertension" class="form-select form-select-sm py-2 shadow-none border-secondary-subtle">
                                <option value="0.0">Tidak Ada Riwayat</option>
                                <option value="1.0">Memiliki Hipertensi</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Riwayat Jantung</label>
                            <select name="heart_disease" class="form-select form-select-sm py-2 shadow-none border-secondary-subtle">
                                <option value="0.0">Tidak Ada Riwayat</option>
                                <option value="1.0">Memiliki Penyakit Jantung</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="p-2 bg-light rounded-2 mb-2">
                                <small class="fw-bold text-primary text-uppercase px-2" style="font-size: 10px; letter-spacing: 1px;">Hasil Pemeriksaan Lab & Fisik</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Rata-rata Gula Darah (mg/dL)</label>
                            <div class="input-group input-group-sm">
                                <input type="number" step="any" name="avg_glucose_level" class="form-control shadow-none border-secondary-subtle" placeholder="Contoh: 105.5" required>
                                <span class="input-group-text bg-white">mg/dL</span>
                            </div>
                            <div class="form-text text-muted" style="font-size: 10px;">Normal: 70-140 mg/dL</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Indeks Massa Tubuh (BMI)</label>
                            <div class="input-group input-group-sm">
                                <input type="number" step="any" name="bmi" class="form-control shadow-none border-secondary-subtle" placeholder="Contoh: 23.4" required>
                                <span class="input-group-text bg-white">kg/m²</span>
                            </div>
                            <div class="form-text text-muted" style="font-size: 10px;">Normal: 18.5 - 25.0</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Status Pernikahan</label>
                            <select name="ever_married" class="form-select form-select-sm py-2 shadow-none border-secondary-subtle">
                                <option value="Ya">Menikah / Pernah Menikah</option>
                                <option value="Tidak">Belum Menikah</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kategori Paparan Asap Rokok</label>
                            <select name="smoking_status" class="form-select form-select-sm py-2 shadow-none border-secondary-subtle">
                                <option value="Tidak Pernah">Bukan Perokok (Tidak Pernah)</option>
                                <option value="Pasif">Perokok Pasif</option>
                                <option value="Aktif">Perokok Aktif</option>
                                <option value="Berhenti">Mantan Perokok (Berhenti)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-5 mb-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" style="background: linear-gradient(90deg, #0ea5e9, #6366f1); border: none; border-radius: 12px; font-size: 1rem;">
                            <i class="fas fa-brain me-2"></i> ANALISIS RISIKO STROKE
                        </button>
                        <p class="text-center text-muted mt-3 mb-0" style="font-size: 11px;">
                            <i class="fas fa-lock me-1"></i> Data yang Anda masukkan diproses secara aman dalam sistem rumah sakit.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(isset($pasien))
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 850px; font-family: 'Times New Roman', serif;">
            <div class="card-body p-5">
                <div class="row border-bottom border-3 border-dark pb-3 mb-4">
                    <div class="col-2 text-center">
                        <img src="/logo-rs.png" style="width: 80px;"> </div>
                    <div class="col-10 text-center">
                        <h4 class="fw-bold mb-0">INSTALASI REHABILITASI NEUROLOGI</h4>
                        <h3 class="fw-bold mb-0">RUMAH SAKIT PUSAT MED-INFO AI</h3>
                        <p class="mb-0 small">Jl. Teknologi Kesehatan No. 101, Jakarta | Telp: (021) 555-1234</p>
                    </div>
                </div>

                <h5 class="text-center fw-bold text-decoration-underline mb-4">HASIL EVALUASI KLINIS SISTEM PREDIKSI VASKULAR</h5>

                <div class="row mb-4 small">
                    <div class="col-6">
                        <table>
                            <tr><td width="150px">Nama Pasien</td><td>: {{ $pasien->patient_name }}</td></tr>
                            <tr><td>Umur / Gender</td><td>: {{ $pasien->age }} Th / {{ $pasien->gender }}</td></tr>
                        </table>
                    </div>
                    <div class="col-6 text-end">
                        <p>No. Dokumen: {{ $pasien->id }}/RAD/{{ date('m/Y') }}<br>Tanggal: {{ date('d F Y') }}</p>
                    </div>
                </div>

                <h6 class="fw-bold border-bottom pb-1">I. DATA PARAMETER FISIOLOGIS</h6>
                <table class="table table-bordered table-sm mb-4 small">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Indikator</th>
                            <th>Nilai</th>
                            <th>Status Klinis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Indeks Massa Tubuh (BMI)</td>
                            <td class="text-center">{{ $pasien->bmi }}</td>
                            <td>{{ $pasien->bmi >= 27 ? 'Obesitas (High Risk)' : 'Normal' }}</td>
                        </tr>
                        <tr>
                            <td>Kadar Gula Darah Puasa</td>
                            <td class="text-center">{{ $pasien->avg_glucose_level }} mg/dL</td>
                            <td>{{ $pasien->avg_glucose_level >= 140 ? 'Hiperglikemia' : 'Normal' }}</td>
                        </tr>
                        <tr>
                            <td>Riwayat Hipertensi / Jantung</td>
                            <td class="text-center">{{ ($pasien->hypertension || $pasien->heart_disease) ? 'Ada' : 'Tidak' }}</td>
                            <td>{{ ($pasien->hypertension || $pasien->heart_disease) ? 'Patologis Vaskular' : 'Normal' }}</td>
                        </tr>
                    </tbody>
                </table>

                <h6 class="fw-bold border-bottom pb-1">II. KESIMPULAN MODEL</h6>
                <div class="p-3 my-3 text-center border bg-light">
                    <p class="mb-1">Berdasarkan hasil analisis model terhadap parameter di atas, pasien dinyatakan:</p>
                    <h2 class="fw-bold {{ in_array($pasien->status_label, ['TERINDIKASI STROKE', 'RISIKO TINGGI']) ? 'text-danger' : 'text-success' }}">
                        {{ $pasien->status_label }}
                    </h2>
                </div>

                <h6 class="fw-bold border-bottom pb-1">III. ANALISIS & REKOMENDASI MEDIS</h6>
                <div class="small text-justify" style="line-height: 1.6;">
                    @if($pasien->status_label == 'TERINDIKASI STROKE' || $pasien->status_label == 'RISIKO TINGGI')
                        <p>Pasien menunjukkan profil klinis yang kritis dengan akumulasi faktor risiko vaskular yang signifikan. Ditemukan adanya korelasi kuat antara riwayat penyakit penyerta (comorbidity) dengan potensi gangguan aliran darah serebral. <strong>Saran:</strong> Segera lakukan pemeriksaan CT-Scan kepala dan konsultasi tatap muka dengan Dokter Spesialis Saraf. Batasi asupan natrium dan lakukan monitoring tekanan darah berkala.</p>
                        @else
                        <p>Kondisi klinis pasien saat ini berada dalam batas normal sistem prediksi. Namun, tetap disarankan untuk menjaga pola hidup sehat, melakukan aktivitas fisik minimal 150 menit per minggu, dan melakukan medical check-up rutin setiap 6 bulan sekali untuk memantau variabel biometrik.</p>
                    @endif
                </div>

                <div class="row mt-5">
                    <div class="col-8 small italic">Dicetak secara elektronik oleh Sistem Integrasi RS Med-Info.</div>
                    <div class="col-4 text-center small">
                        <p>Dokter Pemeriksa,</p>
                        <div style="height: 60px;"></div>
                        <p class="fw-bold mb-0">({{ Auth::user()->name }})</p>
                        <p>NIP: 19800522 201001 1 003</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Fokus pada border saat input diklik agar lebih soft */
        .form-control:focus, .form-select:focus {
            border-color: #0ea5e9 !important;
            box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.1) !important;
        }
        
        .input-group-text {
            color: #94a3b8;
            font-size: 11px;
            font-weight: bold;
        }

        @media print {
            /* Sembunyikan SEMUA elemen navigasi dan form */
            .sidebar, 
            .navbar, 
            nav, 
            #layoutSidenav_nav, 
            .d-print-none, 
            form, 
            .btn, 
            footer {
                display: none !important;
            }

            /* Paksa konten utama ke pojok kiri atas dan hilangkan margin template */
            body, html {
                background-color: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Ini kunci supaya container kamu nggak kepentok bekas area sidebar */
            #layoutSidenav_content, 
            .main-content, 
            main, 
            .container, 
            .container-fluid {
                margin: 0 !important;
                padding: 0 !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                position: relative !important;
                display: block !important;
            }

            /* Hilangkan shadow biar suratnya bersih */
            .card {
                border: none !important;
                box-shadow: none !important;
                transform: none !important;
            }
        }   
    </style>
@endsection