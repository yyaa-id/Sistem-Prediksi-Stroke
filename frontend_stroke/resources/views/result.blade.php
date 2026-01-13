@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-print-none mb-4 d-flex justify-content-between">
            <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-chevron-left me-2"></i> Kembali ke Database
            </a>
            <button onclick="window.print()" class="btn btn-dark btn-sm">
                <i class="fas fa-print me-2"></i> Cetak Laporan Resume Medis
            </button>
        </div>

        <div class="card shadow-sm border-0 p-5 mx-auto" style="max-width: 850px; background: white; color: black; font-family: 'Times New Roman', serif;">
            <div class="row align-items-center border-bottom border-3 border-dark pb-2 mb-1">
                <div class="col-2 text-center">
                    <img src="{{ asset('img/Logo_RS.png') }}" style="width: 100px; height: auto;">
                </div>
                <div class="col-10 text-center">
                    <h5 class="fw-bold mb-0">PEMERINTAH PROVINSI DKI JAKARTA</h5>
                    <h3 class="fw-bold mb-0">RSUD BHAKTI NUSANTARA</h3>
                    <p class="mb-0 small">Jl. Dr. Sahardjo No.12, Tebet, Jakarta Selatan | Telp: (021) 1234567</p>
                    <p class="mb-0 small text-decoration-underline">Email: tatausaha@rsud-bhaktinusantara.go.id</p>
                </div>
            </div>
            <div class="border-bottom border-1 border-dark mb-4" style="margin-top: 2px;"></div>

            <div class="text-center mb-5">
                <h5 class="fw-bold text-decoration-underline mb-1">RESUME KLINIS DAN SKRINING VASKULAR</h5>
                <p class="small">Nomor Dokumen: {{ $pasien->created_at->format('Y') }}/RM-NEURO/{{ str_pad($pasien->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-uppercase border-bottom pb-1 mb-3" style="font-size: 14px;">I. Identitas Pasien</h6>
                <table class="table table-sm table-borderless ms-3">
                    <tr><td width="200">Nama Lengkap Pasien</td><td>: <strong>{{ $pasien->patient_name }}</strong></td></tr>
                    <tr><td>Nomor Rekam Medis</td><td>: #{{ str_pad($pasien->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                    <tr><td>Usia / Jenis Kelamin</td><td>: {{ $pasien->age }} Tahun / {{ $pasien->gender }}</td></tr>
                    <tr><td>Tanggal Pemeriksaan</td><td>: {{ $pasien->created_at->format('d F Y, H:i') }} WIB</td></tr>
                </table>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-uppercase border-bottom pb-1 mb-3" style="font-size: 14px;">II. Parameter Klinis</h6>
                <div class="row ms-2">
                    <div class="col-6">
                        <p class="mb-1 small">Rata-rata Gula Darah: <strong>{{ $pasien->avg_glucose_level }} mg/dL</strong></p>
                        <p class="mb-1 small">Indeks Massa Tubuh (BMI): <strong>{{ $pasien->bmi }}</strong></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 small">Riwayat Hipertensi: <strong>{{ $pasien->hypertension ? 'Ada' : 'Tidak Ada' }}</strong></p>
                        <p class="mb-1 small">Riwayat Penyakit Jantung: <strong>{{ $pasien->heart_disease ? 'Ada' : 'Tidak Ada' }}</strong></p>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <h6 class="fw-bold text-uppercase border-bottom pb-1 mb-3" style="font-size: 14px;">III. Kesimpulan & Rencana Tindak Lanjut</h6>
                <div class="p-3 border border-2 {{ $pasien->status_label == 'TERINDIKASI STROKE' ? 'border-danger' : 'border-dark' }} bg-light">
                    <p class="mb-1 small fw-bold">KLASIFIKASI RISIKO:</p>
                    <h4 class="fw-bold {{ $pasien->status_label == 'TERINDIKASI STROKE' ? 'text-danger' : 'text-primary' }} mb-3">
                        {{ $pasien->status_label }}
                    </h4>
                    <p class="small italic mb-0" style="line-height: 1.6;">
                        <strong>Rekomendasi DPJP:</strong> 
                        @if($pasien->status_label == 'TERINDIKASI STROKE')
                            Pasien masuk kategori <strong>CITO (Gawat Darurat)</strong>. Diperlukan tindakan CT-Scan Kepala non-kontras segera dan stabilisasi di Unit Stroke.
                        @elseif($pasien->status_label == 'RISIKO TINGGI')
                            Lakukan observasi hemodinamik ketat. Pasien disarankan kontrol ke Poli Spesialis Saraf dalam 1x24 jam untuk evaluasi faktor risiko vaskular.
                        @else
                            Parameter klinis saat ini terkendali. Lanjutkan pola edukasi gizi seimbang dan aktivitas fisik mandiri.
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-7 text-center">
                    <div class="border p-2 d-inline-block small">
                        <p class="mb-0 font-monospace">VERIFIED BY SIMS SYSTEM</p>
                        <p class="mb-0">RSUD BHAKTI NUSANTARA</p>
                    </div>
                </div>
                <div class="col-5 text-center">
                    <p class="mb-0">Jakarta, {{ $pasien->created_at->format('d F Y') }}</p>
                    <p class="mb-5">Dokter Penanggung Jawab,</p>
                    <div class="mt-4"></div>
                    <p class="fw-bold mb-0 text-decoration-underline">dr. Satria Wijaya, Sp.N (K)</p>
                    <p class="small">NIP. 19850312 201212 1 002</p>
                </div>
            </div>
        </div>
    </div>

    <style>
    @media print {
    /* 1. Sembunyikan sidebar & elemen non-penting */
    .sidebar, .navbar, .d-print-none, .btn, footer {
        display: none !important;
    }

    /* 2. RESET TOTAL MARGIN/PADDING (Ini kuncinya!) */
    body, html {
        margin: 0 !important;
        padding: 0 !important;
        background-color: white !important;
    }

    /* Targetkan pembungkus utama yang biasanya punya margin kiri */
    /* Tambahkan semua class/ID pembungkus yang kamu punya */
    .main-content, 
    #layoutSidenav_content, 
    .content-wrapper,
    main {
        margin-left: 0 !important;
        padding-left: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
    }

    /* 3. Pastikan Container Surat melebar penuh */
    .container, .container-fluid {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 4. Perbesar tampilan kartu agar pas di A4 */
    .card {
        border: none !important;
        box-shadow: none !important;
        width: 100% !important;
    }
}
    </style>
@endsection