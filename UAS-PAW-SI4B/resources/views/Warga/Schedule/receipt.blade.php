<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi P3ST - {{ $schedule->id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 300px; margin: 20px auto; padding: 10px; border: 1px dashed #000; font-size: 10pt; }
        .text-center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 3px 0; }
        .total { font-size: 12pt; font-weight: bold; }
        .btn-print { background: #000; color: #fff; border: none; padding: 5px 10px; width: 100%; cursor: pointer; margin-bottom: 15px; font-weight: bold; }
        @media print { .btn-print { display: none; } body { border: none; margin: 0; } }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">KLIK UNTUK CETAK NOTA</button>

    <div class="text-center">
        <strong>BANK SAMPAH P3ST</strong><br>
        Universitas MDP Palembang<br>
        Sistem Penjemputan Otomatis<br>
        ----------------------------
    </div>

    <div>
        No Nota : {{ substr($schedule->id, 0, 10) }}<br>
        Tanggal : {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}<br>
        Warga   : {{ $schedule->warga->name }}<br>
        Kolektor: {{ $schedule->petugas->name ?? 'Staf' }}
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <td>Jenis Sampah:</td>
            <td style="text-align: right;">{{ $transaction->catalogPrice->category_name }}</td>
        </tr>
        <tr>
            <td>Berat Riil :</td>
            <td style="text-align: right;">{{ $transaction->weight_actual }} Kg</td>
        </tr>
        <tr>
            <td>Harga / Kg :</td>
            <td style="text-align: right;">Rp {{ number_format($transaction->catalogPrice->price_per_kg, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <tr class="total">
            <td>TOTAL CASH:</td>
            <td style="text-align: right;">Rp {{ number_format($transaction->price_final, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="text-center" style="font-size: 8pt;">
        -- STATUS PEMBAYARAN: LUNAS --<br>
        Terima kasih telah memilah sampah<br>
        dan menjaga bumi bersama kami!
    </div>

</body>
</html>