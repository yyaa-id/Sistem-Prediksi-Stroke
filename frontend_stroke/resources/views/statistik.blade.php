@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="d-none d-print-block" style="font-family: 'Times New Roman', Times, serif;">
    <div class="row align-items-center mb-2">
        <div class="col-2 text-center">
            <img src="{{ asset('img/Logo_RS.png') }}" style="width: 90px; height: auto;">
        </div>
        <div class="col-10 text-center">
            <h5 class="fw-bold mb-0" style="letter-spacing: 1px;">PEMERINTAH KOTA YOGYAKARTA</h5>
            <h4 class="fw-bold mb-0" style="letter-spacing: 1px;">RSUD BHAKTI - STROKE CENTER</h4>
            <p class="mb-0 small">Jl. Kesehatan No. 101, Kota Yogyakarta, Telp: (0274) 123456</p>
            <p class="mb-0 small text-primary">E-mail: info@rsudbhakti.go.id | Website: www.rsudbhakti.go.id</p>
        </div>
    </div>
    <hr style="border: 2px solid #000; opacity: 1; margin-top: 5px;">
    <hr style="border: 1px solid #000; opacity: 1; margin-top: -14px; margin-bottom: 20px;">
    
    <div class="text-center mb-4">
        <h5 class="fw-bold text-decoration-underline text-uppercase">LAPORAN SURVEILANS EPIDEMIOLOGI STROKE</h5>
        <p class="small">Periode Laporan: {{ request('start_date') ?? 'Awal Tahun' }} s/d {{ request('end_date') ?? 'Akhir Tahun' }}</p>
    </div>
</div>

    <div class="card border-0 shadow-sm mb-4 d-print-none">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <h4 class="fw-bold text-dark mb-1">Surveilans Epidemiologi Stroke</h4>
                    <p class="text-muted small mb-0">Unit Neurologi • RSUD Bhakti Nusantara</p>
                </div>
                
                <div class="col-md-7">
                    <form action="{{ route('statistik.index') }}" method="GET" class="row g-2 justify-content-end">
                        <div class="col-auto">
                            <label class="small text-muted d-block">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control form-control-sm" 
                                   value="{{ request('start_date') ?? date('Y-01-01') }}">
                        </div>
                        <div class="col-auto">
                            <label class="small text-muted d-block">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control form-control-sm" 
                                   value="{{ request('end_date') ?? date('Y-12-31') }}">
                        </div>
                        <div class="col-auto d-flex align-items-end">
                            <div class="btn-group shadow-sm">
                                <button type="submit" class="btn btn-sm btn-primary px-3">
                                    <i class="fas fa-search me-1"></i> Tampilkan
                                </button>
                                @if(request('start_date') || request('end_date'))
                                    <a href="{{ route('statistik.index') }}" class="btn btn-sm btn-light border" title="Reset">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                @endif
                                <button type="button" onclick="window.print()" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-print me-1"></i> Cetak
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none d-print-block mb-4">
        <h6 class="fw-bold mb-3 text-uppercase">1. Rekapitulasi Data Pasien</h6>
        <table class="table table-bordered w-100">
            <thead class="text-center bg-light">
                <tr>
                    <th>Kategori Kondisi</th>
                    <th>Jumlah Pasien</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $labels = ['Terindikasi', 'Risiko Tinggi', 'Risiko Rendah', 'Normal'];
                    $total = array_sum($pieData) ?: 1;
                @endphp
                @foreach($labels as $i => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td class="text-center">{{ $pieData[$i] }}</td>
                    <td class="text-center">{{ round(($pieData[$i]/$total)*100, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row g-3 mb-4 d-print-none">
        @php
            $cards = [
                ['title' => 'Terindikasi', 'value' => $pieData[0], 'color' => 'danger', 'icon' => 'fa-exclamation-circle', 'note' => 'Butuh Tindakan Segera'],
                ['title' => 'Risiko Tinggi', 'value' => $pieData[1], 'color' => 'warning', 'icon' => 'fa-user-clock', 'note' => 'Observasi Ketat'],
                ['title' => 'Risiko Rendah', 'value' => $pieData[2], 'color' => 'info', 'icon' => 'fa-user-shield', 'note' => 'Pemantauan Berkala'],
                ['title' => 'Normal', 'value' => $pieData[3], 'color' => 'success', 'icon' => 'fa-check-circle', 'note' => 'Kondisi Stabil']
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-md">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3 border-start border-{{ $card['color'] }} border-5 rounded-start">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="text-muted small fw-bold mb-0 text-uppercase" style="letter-spacing: 0.5px;">{{ $card['title'] }}</h6>
                        <i class="fas {{ $card['icon'] }} text-{{ $card['color'] }} opacity-50"></i>
                    </div>
                    <h3 class="fw-bold mb-0 text-dark">{{ $card['value'] }}</h3>
                    <div class="small text-{{ $card['color'] }} fw-bold" style="font-size: 10px;">
                        <i class="fas fa-info-circle me-1"></i>{{ $card['note'] }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="col-md">
            <div class="card border-0 shadow-sm h-100 bg-navy" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <h6 class="text-white-50 small fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px;">Total Periksa</h6>
                    <h3 class="fw-bold mb-0 text-white">{{ array_sum($pieData) }}</h3>
                    <div class="text-white-50 mt-1" style="font-size: 10px;">
                        <i class="fas fa-sync-alt fa-spin me-1"></i> DATA TERINTEGRASI
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold text-dark mb-0">Distribusi Kondisi Pasien</h6>
                        <i class="fas fa-chart-pie text-muted d-print-none"></i>
                    </div>
                    <div style="height: 280px; position: relative;">
                        <canvas id="statusChart"></canvas>
                        <div style="position: absolute; top: 43%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                            <span class="text-muted small d-block">Total</span>
                            <span class="fw-bold h4 mb-0">{{ array_sum($pieData) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold text-dark mb-0">Tren Kunjungan Pasien</h6>
                        <div class="badge bg-light text-primary border px-2 py-1 d-print-none" style="font-size: 10px;">
                            <i class="fas fa-arrow-up me-1"></i>Trend Bulanan
                        </div>
                    </div>
                    <div style="height: 280px;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-body p-4 text-dark">
            <h6 class="fw-bold mb-3 text-uppercase small d-none d-print-block">2. Analisis & Interpretasi Data</h6>
            <h6 class="fw-bold mb-3 d-print-none">Analisis Situasi Medis</h6>
            
            <p class="small mb-3" style="text-align: justify; line-height: 1.6;">
                <strong>Analisis Distribusi:</strong> Berdasarkan data di atas, mayoritas pasien berada pada kategori <strong>{{ $labels[array_search(max($pieData), $pieData)] }}</strong>. 
                @if($pieData[0] > 0)
                    Ditemukan lonjakan sebanyak <strong>{{ $pieData[0] }}</strong> pasien terindikasi gejala stroke akut yang memerlukan intervensi medis segera.
                @endif
            </p>
            
            <p class="small mb-0" style="text-align: justify; line-height: 1.6;">
                <strong>Analisis Tren:</strong> Grafik tren bulanan menunjukkan tingkat kunjungan pasien yang fluktuatif. Puncak kunjungan tercatat pada bulan <strong>{{ $trenData->sortByDesc('total')->first()->bulan ?? '-' }}</strong>. Data ini memberikan dasar evaluasi bagi Unit Neurologi untuk mengatur alokasi SDM dan logistik pada periode berikutnya.
            </p>
        </div>
    </div>
</div>

<div class="print-footer d-none d-print-block mt-5">
    <div class="row">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p class="mb-0">Yogyakarta, {{ date('d/m/Y') }}</p>
            <p class="fw-bold mb-5">Kepala Unit Neurologi,</p>
            <br>
            <p class="fw-bold text-decoration-underline mb-0">dr. Hendra Kurniadi, Sp.N</p>
            <p class="small">NIP. 19850412 201012 1 003</p>
        </div>
    </div>
</div>

<style>
    .bg-navy { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); }
    .card { transition: transform 0.2s; border-radius: 12px; }
    .card:hover { transform: translateY(-3px); }

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#94a3b8';

    const ctxPie = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Terindikasi', 'Risiko Tinggi', 'Risiko Rendah', 'Normal'],
            datasets: [{
                data: @json($pieData),
                backgroundColor: ['#ef4444', '#f59e0b','#3b82f6', '#10b981'],
                borderWidth: 4,
                borderColor: '#ffffff',
            }]
        },
        options: { 
            devicePixelRatio: 2,
            maintainAspectRatio: false,
            cutout: '80%', 
            plugins: { 
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } 
            } 
        }
    });

    const ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: @json($trenData->pluck('bulan')),
            datasets: [{
                label: 'Jumlah Pasien',
                data: @json($trenData->pluck('total')),
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection