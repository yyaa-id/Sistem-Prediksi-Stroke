@extends('layouts.app')

@section('content')
    <div class="container-fluid py-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold text-dark mb-1">
                    <i class="fas fa-folder-medical text-primary me-2"></i> Database Rekam Medis
                </h4>
                <p class="text-muted small mb-0">Manajemen data skrining dan riwayat diagnosa stroke pasien.</p>
            </div>
            <div class="text-end">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                    <i class="fas fa-users me-1"></i> Total: {{ $riwayat->total() }} Pasien
                </span>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3 d-print-none" style="border-radius: 15px;">
            <div class="card-body p-3">
                <form action="{{ route('pasien.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-auto">
                        <div class="input-group input-group-sm">
                            <label class="input-group-text bg-transparent border-end-0 text-muted small">Tampilkan</label>
                            <select name="per_page" class="form-select form-select-sm shadow-none border-secondary-subtle fw-bold" onchange="this.form.submit()" style="width: 80px;">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4 ms-auto">
                        <div class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden border">
                            <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-0 shadow-none ps-0" placeholder="Cari Nama atau No. RM..." value="{{ request('search') }}">
                            @if(request('search'))
                                <a href="{{ route('pasien.index') }}" class="btn btn-white border-0 text-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary px-3 fw-bold">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data Pasien -->
        <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 15px;">
            <div class="table-responsive" style="max-height: 500px;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr class="small text-muted text-uppercase text-left align-middle">
                            <th class="ps-4 py-3 border-0" style="font-size: 10px; letter-spacing: 1px;">No. RM</th>
                            <th class="border-0" style="font-size: 10px; letter-spacing: 1px;">Identitas Pasien</th>
                            <th class="border-0" style="font-size: 10px; letter-spacing: 1px;">Hasil Analisis AI</th>
                            <th class="border-0" style="font-size: 10px; letter-spacing: 1px;">Waktu Pemeriksaan</th>
                            <th class="border-0 pe-4" style="font-size: 10px; letter-spacing: 1px;">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($riwayat as $data)
                        @php
                            $statusColor = match($data->status_label) {
                                'TERINDIKASI STROKE' => 'danger',
                                'RISIKO TINGGI' => 'warning',
                                'RISIKO RENDAH' => 'success',
                                default => 'secondary',
                            };
                        @endphp
                        <tr>
                            <td class="text-center">
                                <span class="text-primary fw-bold" style="font-family: 'Courier New', Courier, monospace;">#{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td >
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold text-navy" style="font-size: 13px;">{{ $data->patient_name }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ $data->age }} Thn • {{ $data->gender }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} border border-{{ $statusColor }}-subtle rounded-pill px-3 py-2" style="font-size: 10px; font-weight: 700;">
                                    <i class="fas fa-shield-virus me-1"></i> {{ $data->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light text-secondary rounded-2 p-2 me-2 d-none d-md-block" style="font-size: 12px; border: 1px solid #e2e8f0;">
                                        <i class="far fa-calendar-check text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 13px;">
                                        {{ $data->created_at->translatedFormat('d F Y') }}
                                    </div>
                                    <div class="text-muted d-flex align-items-center" style="font-size: 10px;">
                                        <span class="badge bg-secondary-subtle text-secondary border-0 py-1 px-2 me-1" style="font-size: 9px;">
                                            <i class="far fa-clock me-1"></i> {{ $data->created_at->format('H:i') }} WIB
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('predict.result', $data->id) }}" class="btn btn-sm btn-outline-info rounded-pill" title="Lihat Hasil">
                                    <i class="fas fa-file-medical"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-primary rounded-pill" title="Edit Identitas" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $data->id }}">
                                    <i class="fas fa-pen-nib"></i>
                                </button>
                                <form action="/pasien/{{ $data->id }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" title="Hapus" onclick="return confirm('Hapus data rekam medis ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="opacity-25 mb-3">
                                <i class="fas fa-folder-open fa-4x"></i>
                            </div>
                            <p class="text-muted mb-0">Database kosong atau pasien tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white py-3 border-0">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="small text-muted mb-0 text-center text-md-start">
                        Menampilkan <strong>{{ $riwayat->firstItem() ?? 0 }}</strong> sampai <strong>{{ $riwayat->lastItem() ?? 0 }}</strong> dari <strong>{{ $riwayat->total() }}</strong> pasien
                    </p>
                </div>
                <div class="col-md-6 mt-2 mt-md-0 d-flex justify-content-center justify-content-md-end"> 
                    {{ $riwayat->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    @foreach($riwayat as $data)
        <div class="modal fade" id="modalEdit{{ $data->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm"> {{-- modal-sm agar pas di layar 100% --}}
                <form action="/pasien/{{ $data->id }}" method="POST" class="modal-content border-0 shadow" style="border-radius: 20px;">
                    @csrf @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <h6 class="fw-bold mb-0">Update Identitas</h6>
                        <button type="button" class="btn-close small" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Pasien</label>
                            <input type="text" name="patient_name" class="form-control form-control-sm border-secondary-subtle" value="{{ $data->patient_name }}" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Usia</label>
                                <input type="number" name="age" class="form-control form-control-sm border-secondary-subtle" value="{{ $data->age }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Gender</label>
                                <select name="gender" class="form-select form-select-sm border-secondary-subtle">
                                    <option value="Laki-laki" {{ $data->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $data->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="btn btn-primary w-100 btn-sm rounded-pill fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <style>
        .text-navy { color: #0f172a; }
        .table-hover tbody tr:hover { background-color: #f1f5f9; }
        .btn-outline-info, .btn-outline-primary, .btn-outline-danger {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-width: 1px;
        }
        .pagination { margin-bottom: 0; }
        .page-link { font-size: 11px; padding: 5px 10px; border-radius: 8px !important; margin: 0 2px; border: none; color: #64748b; }
        .page-item.active .page-link { background-color: var(--rs-primary); color: white; box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2); }

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