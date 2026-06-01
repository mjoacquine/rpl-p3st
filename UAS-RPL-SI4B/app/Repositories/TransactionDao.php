<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionDao
{
    public function getAllWithRelations()
    {
        return Transaction::with(['schedule.warga', 'schedule.petugas', 'catalogPrice'])->latest()->get();
    }

    public function findById($id)
    {
        return Transaction::with(['schedule', 'catalogPrice'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function update($id, array $data)
    {
        $transaction = $this->findById($id);
        $transaction->update($data);
        return $transaction;
    }

    // Fungsi khusus untuk mengambil ringkasan nominal transaksi dalam bulan tertentu 
    public function getMonthlyAggregation($month, $year)
    {
        return Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'selesai')
            ->selectRaw('SUM(weight_actual) as sum_weight, SUM(price_final) as sum_income')
            ->first();
    }

    // --- FUNGSI TAMBAHAN BARU UNTUK MENGATASI ERROR ---
    // Fungsi ini dipanggil oleh ReportGenerator untuk melampirkan daftar transaksi ke PDF
    public function getTransactionsByMonth($month, $year)
    {
        return Transaction::with(['schedule.warga', 'catalogPrice'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}