<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class TransactionDAO
{
    /**
     * Menambah rekaman transaksi baru ke tabel basis data.
     */
    public function insert(array $data): bool
    {
        return DB::table('transactions')->insert($data);
    }

    /**
     * Menjalankan kueri pencarian dan pengambilan seluruh data transaksi.
     */
    public function selectAll(): array
    {
        return DB::table('transactions')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Mengambil satu data transaksi secara spesifik untuk detail cetak laporan.
     */
    public function selectById(string $transactionId): ?object
    {
        return DB::table('transactions')
            ->where('transaction_id', $transactionId)
            ->first();
    }

    /**
     * Mengambil agregasi data transaksi untuk simulasi MonthlyReport (Laporan Bulanan).
     */
    public function getMonthlyAggregation(): object
    {
        return DB::table('transactions')
            ->where('status', 'selesai') // Diperbaiki menjadi huruf kecil sesuai standar DB kita
            ->select(
                DB::raw('SUM(weight_actual) as total_weight'),
                DB::raw('SUM(price_final) as total_income'),
                // Rumus P3ST: 1 kg sampah disimulasikan menyelamatkan 1.2 kg emisi CO2
                DB::raw('SUM(weight_actual * 1.2) as total_co2_reduction') 
            )
            ->first();
    }

    /**
     * Menghapus transaksi berdasarkan ID.
     */
    public function delete(string $transactionId): int
    {
        return DB::table('transactions')
            ->where('transaction_id', $transactionId)
            ->delete();
    }
}

