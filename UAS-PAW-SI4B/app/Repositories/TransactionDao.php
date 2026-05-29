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

    // Fungsi khusus untuk mengambil ringkasan transaksi dalam bulan tertentu (untuk Dashboard & Laporan)
    public function getMonthlyAggregation($month, $year)
    {
        return Transaction::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'selesai')
            ->selectRaw('SUM(weight_actual) as sum_weight, SUM(price_final) as sum_income')
            ->first();
    }
}