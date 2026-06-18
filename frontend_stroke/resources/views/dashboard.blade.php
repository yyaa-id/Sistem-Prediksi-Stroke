@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row g-3 mb-4">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm text-white h-100" style="background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%); border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-1">Pusat Kendali Stroke Regional</h5>
                        <p class="small opacity-75 mb-3">Selamat datang, Admin. Monitoring aktivitas Unit Pelayanan Neurologi RSUD Bhakti Nusantara hari ini.</p>
                        <div class="d-flex gap-2">
                            <a href="/predict" class="btn btn-sm btn-white btn-light rounded-pill px-3 fw-bold text-primary">Input Skrining</a>
                            <a href="/pasien" class="btn btn-sm btn-outline-light rounded-pill px-3">Data Pasien</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 15px;">
                    <h6 class="fw-bold small mb-3 text-muted">RINGKASAN OPERASIONAL</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light text-center">
                                <div class="small text-muted" style="font-size: 10px;">TOTAL DPJP</div>
                                <div class="fw-bold text-dark">3 Spesialis</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded bg-light text-center">
                                <div class="small text-muted" style="font-size: 10px;">BED TERSEDIA</div>
                                <div class="fw-bold text-success">12 Unit</div>
                            </div>
                        </div>
                        <div class="col-12 mt-2 text-center">
                            <span class="badge bg-primary-subtle text-primary rounded-pill w-100 py-2">
                                <i class="fas fa-clock me-1"></i> Update: {{ date('H:i') }} WIB
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0"><i class="fas fa-user-md text-primary me-2"></i> Tim Dokter Spesialis Saraf</h6>
                <span class="small text-muted">Aktif / On-Duty</span>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                        <img src="https://img.freepik.com/free-photo/portrait-hansome-young-male-doctor-man_171337-5068.jpg" 
                            class="rounded-circle mx-auto mb-2 shadow-sm border border-2 border-white" 
                            width="70" height="70" style="object-fit: cover;">
                        <h6 class="fw-bold mb-0" style="font-size: 13px;">dr. Satria Wijaya, Sp.N (K)</h6>
                        <p class="text-primary fw-bold mb-2" style="font-size: 10px;">Spesialis Saraf Vaskular</p>
                        <div class="d-flex justify-content-center gap-1">
                            <span class="badge bg-success" style="font-size: 9px;">Hadir</span>
                            <span class="badge bg-light text-dark" style="font-size: 9px;">Poliklinik</span>
                        </div>
                        <hr class="my-2 opacity-50">
                        <div class="small text-muted d-flex justify-content-between" style="font-size: 10px;">
                            <span><i class="fas fa-id-card me-1"></i> NIP. 1985...</span>
                            <span><i class="fas fa-door-open me-1"></i> R.01</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                        <img src="https://img.freepik.com/free-photo/female-doctor-hospital-with-stethoscope_23-2148827715.jpg" 
                            class="rounded-circle mx-auto mb-2 shadow-sm border border-2 border-white" 
                            width="70" height="70" style="object-fit: cover;">
                        <h6 class="fw-bold mb-0" style="font-size: 13px;">dr. Lisa Amelia, Sp.N</h6>
                        <p class="text-primary fw-bold mb-2" style="font-size: 10px;">Spesialis Saraf Umum</p>
                        <div class="d-flex justify-content-center gap-1">
                            <span class="badge bg-success" style="font-size: 9px;">Hadir</span>
                            <span class="badge bg-light text-dark" style="font-size: 9px;">Unit Stroke</span>
                        </div>
                        <hr class="my-2 opacity-50">
                        <div class="small text-muted d-flex justify-content-between" style="font-size: 10px;">
                            <span><i class="fas fa-id-card me-1"></i> NIP. 1990...</span>
                            <span><i class="fas fa-door-open me-1"></i> R.03</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center p-3" style="border-radius: 15px;">
                        <img src="https://img.freepik.com/free-photo/doctor-standing-with-folder-stethoscope_1291-16.jpg" 
                            class="rounded-circle mx-auto mb-2 shadow-sm border border-2 border-white" 
                            width="70" height="70" style="object-fit: cover;">
                        <h6 class="fw-bold mb-0" style="font-size: 13px;">dr. Budi Setiawan, Sp.N</h6>
                        <p class="text-primary fw-bold mb-2" style="font-size: 10px;">Neuro-Intervensi</p>
                        <div class="d-flex justify-content-center gap-1">
                            <span class="badge bg-warning text-dark" style="font-size: 9px;">On Call</span>
                            <span class="badge bg-light text-dark" style="font-size: 9px;">IGD Saraf</span>
                        </div>
                        <hr class="my-2 opacity-50">
                        <div class="small text-muted d-flex justify-content-between" style="font-size: 10px;">
                            <span><i class="fas fa-id-card me-1"></i> NIP. 1988...</span>
                            <span><i class="fas fa-door-open me-1"></i> R.05</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection