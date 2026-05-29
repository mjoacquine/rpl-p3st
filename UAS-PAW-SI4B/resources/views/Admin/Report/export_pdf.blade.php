<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan Bank Sampah P3ST</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 11pt; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #2e7d32; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #2e7d32; font-size: 16pt; }
        .header p { margin: 4px 0 0 0; font-size: 9pt; text-transform: uppercase; color: #666; }
        .meta-table { width: 100%; margin-bottom: 20px; font-size: 10pt; }
        .meta-table td { padding: 4px 0; }
        .box-container { width: 100%; margin-bottom: 20px; }
        .box { width: 30%; float: left; background-color: #f4fbf5; border: 1px solid #c8e6c9; padding: 10px; text-align: center; margin-right: 2%; }
        .box h3 { margin: 5px 0; color: #1b5e20; font-size: 14pt; }
        .box small { font-size: 8pt; text-transform: uppercase; color: #555; font-weight: bold; }
        .clear { clear: both; }
        .footer { margin-top: 50px; text-align: right; font-size: 10pt; }
        .signature { margin-top: 60px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="header">
        <h2>PLATFORM P3ST - UNIVERSITAS MULTI DATA PALEMBANG</h2>
        <p>Dokumen Resmi Hasil Agregasi Data Bulanan Ekonomi Sirkular Bank Sampah</p>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 15%;"><strong>Periode Laporan:</strong></td>
            <td style="width: 45%;">{{ $reportData['report_metadata']['period'] }}</td>
            <td style="width: 20%; text-align: right;"><strong>Tanggal Cetak:</strong></td>
            <td style="width: 20%; text-align: right;">{{ $reportData['report_metadata']['generated_at'] }}</td>
        </tr>
        <tr>
            <td><strong>Otoritas Akun:</strong></td>
            <td>{{ $reportData['report_metadata']['author'] }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div class="box-container">
        <div class="box">
            <small>Total Massa Sampah</small>
            <h3>{{ number_format($reportData['environmental_metrics']['total_weight_kg'], 2, ',', '.') }} Kg</h3>
        </div>
        <div class="box">
            <small>Perputaran Tunai</small>
            <h3>{{ $reportData['financial_metrics']['formatted_value'] }}</h3>
        </div>
        <div class="box" style="margin-right: 0;">
            <small>Reduksi Karbon</small>
            <h3>{{ number_format($reportData['environmental_metrics']['total_co2_reduction_kg'], 2, ',', '.') }} Kg</h3>
        </div>
    </div>

    <div class="clear"></div>

    <p style="margin-top: 30px; font-size: 9pt; color: #555; text-align: justify;">
        *Keterangan: Data di atas dikompilasi secara sah melalui pencatatan riil timbangan digital petugas pengepul Bank Sampah P3ST di lapangan. Estimasi reduksi emisi CO2 dihitung menggunakan instrumen baku konversi dampak lingkungan instansi nasional.
    </p>

    <div class="footer">
        <p>Palembang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Mengetahui, <br> Kepala Administrasi Bank Sampah P3ST</p>
        <div class="signature">Siti Chairunisah Suyta, S.SI</div>
    </div>

</body>
</html>