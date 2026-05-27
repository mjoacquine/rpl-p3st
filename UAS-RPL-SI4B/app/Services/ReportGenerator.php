<?php
namespace App\Services;

use App\Repositories\TransactionDAO;
use App\Services\EcoStatsEngine;

class ReportGenerator
{
    protected $transactionDAO;
    protected $ecoStatsEngine;

    public function __construct(TransactionDAO $transactionDAO, EcoStatsEngine $ecoStatsEngine)
    {
        $this->transactionDAO = $transactionDAO;
        $this->ecoStatsEngine = $ecoStatsEngine;
    }

    public function generateMonthlyReport(): array
    {
        // Panggil fungsi DAO yang namanya sudah diperbaiki
        $rawData = $this->transactionDAO->getMonthlyAggregation();
        $totalWeight = $rawData->total_weight ?? 0;
        $totalIncome = $rawData->total_income ?? 0;

        $ecoImpact = $this->ecoStatsEngine->calculateIndividualImpact($totalWeight);

        return [
            'report_period' => date('F Y'),
            'total_sampah_terkumpul_kg' => $totalWeight,
            'total_perputaran_uang_rp' => $totalIncome,
            'estimasi_co2_dicegah_kg' => $ecoImpact['estimasi_reduksi_co2_kg'],
            'status' => 'Data Ready for Export'
        ];
    }
}