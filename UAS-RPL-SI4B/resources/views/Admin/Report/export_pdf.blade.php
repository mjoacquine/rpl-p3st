<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan P3ST</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2e7d32; padding-bottom: 10px; }
        .meta-table { width: 100%; margin-bottom: 20px; }
        .metric-box { width: 30%; display: inline-block; padding: 10px; border: 1px solid #ccc; text-align: center; margin-right: 2%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN BANK SAMPAH P3ST</h1>
        <p>Universitas Multi Data Palembang</p>
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Periode:</strong> {{ $reportData['report_metadata']['period'] }} <br>
        <strong>Dicetak Pada:</strong> {{ $reportData['report_metadata']['generated_at'] }}
    </div>

    <div>
        <div class="metric-box">
            <strong>Total Berat</strong><br>
            {{ number_format($reportData['environmental_metrics']['total_weight_kg'], 2) }} Kg
        </div>
        <div class="metric-box">
            <strong>Total Uang</strong><br>
            {{ $reportData['financial_metrics']['formatted_value'] }}
        </div>
        <div class="metric-box">
            <strong>Reduksi CO2</strong><br>
            {{ number_format($reportData['environmental_metrics']['total_co2_reduction_kg'], 2) }} Kg
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Warga</th>
                <th>Berat</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['raw_transactions'] as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($t->created_at)->format('d-m-Y') }}</td>
                <td>{{ $t->schedule->warga->name ?? '-' }}</td>
                <td>{{ $t->weight_actual }} Kg</td>
                <td>Rp {{ number_format($t->price_final, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>