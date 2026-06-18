@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="bg-primary" style="height: 150px; background: linear-gradient(45deg, #2c3e50, #3498db) !important;"></div>
                    <div class="card-body p-4 text-center" style="margin-top: -75px;">
                        <img src="https://ui-avatars.com/api/?name=Admin+Medis&background=fff&color=3498db&size=150" 
                            class="rounded-circle border border-5 border-white shadow-sm mb-3" width="150">
                        <h3 class="fw-bold mb-1">{{ Auth::user()->name }}</h3>
                        <p class="text-muted"><i class="fas fa-id-card-alt me-2"></i> Kepala Unit Neurologi & Stroke</p>
                        <div class="d-flex justify-content-center gap-2 mt-2">
                            <span class="badge bg-light text-primary border border-primary px-3 py-2">ID Medis: 19920811202301</span>
                            <span class="badge bg-success px-3 py-2">Status: Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                            <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">Informasi Personal</h5>
                            <div class="mb-3">
                                <label class="small text-muted d-block">Nama Lengkap</label>
                                <span class="fw-bold">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted d-block">Alamat Email</label>
                                <span class="fw-bold">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted d-block">Nomor STR (Izin Praktik)</label>
                                <span class="fw-bold text-primary">STR-9921-0021-99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                            <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">Unit Kerja</h5>
                            <div class="mb-3">
                                <label class="small text-muted d-block">Instansi</label>
                                <span class="fw-bold">Rumah Sakit Pusat MED-INFO AI</span>
                            </div>
                            <div class="mb-3">
                                <label class="small text-muted d-block">Departemen</label>
                                <span class="fw-bold">Neurologi (Spesialis Saraf)</span>
                            </div>
                            <div class="mb-0">
                                <label class="small text-muted d-block">Terakhir Login</label>
                                <span class="fw-bold text-muted small">{{ date('d M Y, H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection