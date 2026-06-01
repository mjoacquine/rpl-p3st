@extends('Layouts.Warga')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
    <h2 class="fw-bold"><i class="fa-solid fa-seedling text-success me-2"></i>Laporan Dampak Lingkungan</h2>
</div>

<div class="row align-items-center mb-5">
    <div class="col-md-5 text-center mb-4 mb-md-0">
        <div class="bg-p3st-light rounded-circle d-inline-flex justify-content-center align-items-center p-5 shadow-sm border border-success border-2" style="width: 200px; height: 200px;">
            <div>
                <i class="fa-solid fa-leaf text-success fa-3x mb-2"></i>
                <h5 class="fw-bold text-dark mb-0 mt-2">Level Anda:</h5>
                <h4 class="fw-bold text-success">{{ $ecoStats['badge'] }}</h4>
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-3 bg-dark text-white p-4">
            <h4 class="fw-bold mb-3 text-success"><i class="fa-solid fa-earth-asia me-2"></i>Jejak Karbon yang Berhasil Dicegah</h4>
            <p class="lead fw-light mb-4">{{ $ecoStats['impact_message'] }}</p>
            
            <div class="row text-center">
                <div class="col-6 border-end border-secondary">
                    <div class="small text-uppercase text-muted fw-bold">Total Sampah Didaur Ulang</div>
                    <h2 class="fw-bold mt-2">{{ $ecoStats['total_weight_kg'] }} <span class="fs-5 text-muted">Kg</span></h2>
                </div>
                <div class="col-6">
                    <div class="small text-uppercase text-muted fw-bold">Emisi Karbon (CO2eq) Berkurang</div>
                    <h2 class="fw-bold mt-2 text-success">{{ $ecoStats['co2_saved_kg'] }} <span class="fs-5 text-muted">Kg</span></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-success border-0 small shadow-sm">
    <i class="fa-solid fa-lightbulb me-2 text-warning"></i> <strong>Tahukah Anda?</strong> Setiap 1 Kg sampah rumah tangga yang Anda pisahkan dan setorkan ke Bank Sampah P3ST, setara dengan mencegah terciptanya sekitar 2.5 Kg gas rumah kaca yang memanaskan suhu bumi.
</div>
@endsection