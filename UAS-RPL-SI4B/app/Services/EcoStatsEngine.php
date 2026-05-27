<?php
namespace App\Services;

use App\Repositories\TransactionDAO;

class EcoStatsEngine
{
    protected $transactionDAO;

    public function __construct(TransactionDAO $transactionDAO)
    {
        $this->transactionDAO = $transactionDAO;
    }

    /**
     * Menghitung total berat sampah. 1 kg sampah = 1.2 kg reduksi CO2.
     */
    public function calculateIndividualImpact(float $totalWeight): array
    {
        $co2Reduction = $totalWeight * 1.2;
        return [
            'total_berat_kg' => $totalWeight,
            'estimasi_reduksi_co2_kg' => $co2Reduction
        ];
    }
}