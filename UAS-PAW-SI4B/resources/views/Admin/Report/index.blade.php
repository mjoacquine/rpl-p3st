@extends('Layouts.Admin')

@section('content')
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white fw-bold py-3"><i class="fa-solid fa-filter text-success me-1"></i>Filter Laporan Bulanan</div>
    <div class="card-body">
        <form action="{{ route('admin.report.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small">Bulan</label>
                <select name="month" class="form-select form-select-sm">
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ \Carbon\Carbon::create(2026, $m, 1)->translatedFormat('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small">Tahun</label>
                <select name="year" class="form-select form-select-sm">
                    <option value="2026" {{ $year == 2026 ? 'selected' : '' }}>2026</option>
                    <option value="2027" {{ $year == 2027 ? 'selected' : '' }}>2027</option>
                </select>
            </div>
            <div class="col-md-4 d-grid gap-2 d-md-flex">
                <button type="submit" class="btn btn-sm btn-p3st fw-bold px-3"><i class="fa-solid fa-magnifying-glass me-1"></i> Cari</button>
                <a href="{{ route('admin.report.export_pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-sm btn-danger fw-bold"><i class="fa-solid fa-file-pdf me-1"></i> Ekspor Cetak PDF</a>
            </div>
        </form>
    </div>
</div>

<div class="row text-center mb-4">
    <div class="col-md-4">
        <div class="p-3 bg-light rounded shadow-sm border">
            <div class="small text-muted fw-bold text-uppercase">Total Berat Sampah Terkumpul</div>
            <h3 class="fw-bold text-success my-2">{{ number_format($reportData['environmental_metrics']['total_weight_kg'], 2, ',', '.') }} Kg</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-light rounded shadow-sm border">
            <div class="small text-muted fw-bold text-uppercase">Perputaran Finansial (Sirkular)</div>
            <h3 class="fw-bold text-dark my-2">{{ $reportData['financial_metrics']['formatted_value'] }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-light rounded shadow-sm border">
            <div class="small text-muted fw-bold text-uppercase">Total Pengurangan Emisi Karbon</div>
            <h3 class="fw-bold text-info my-2">{{ number_format($reportData['environmental_metrics']['total_co2_reduction_kg'], 2, ',', '.') }} Kg CO2eq</h3>
        </div>
    </div>
</div>
@endsection