<?php

namespace App\Services;

use App\Repositories\TransactionDao;
use Carbon\Carbon;

class ReportGenerator
{
    protected $transactionDao;
    protected $ecoStats;

    public function __construct(TransactionDao $transactionDao, EcoStatsEngine $ecoStats)
    {
        $this->transactionDao = $transactionDao;
        $this->ecoStats = $ecoStats;
    }

    /**
     * Kompilasi data mentah menjadi format laporan terstruktur
     */
    public function generateMonthlyReportData(int $month, int $year): array
    {
        $aggregation = $this->transactionDao->getMonthlyAggregation($month, $year);
        $totalWeight = $aggregation->sum_weight ?? 0.0;
        $totalIncome = $aggregation->sum_income ?? 0.0;

        return [
            'report_metadata' => [
                'period' => Carbon::create($year, $month, 1)->translatedFormat('F Y'),
                'generated_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'author' => 'Sistem Otomatis P3ST'
            ],
            'financial_metrics' => [
                'total_transactions_value' => $totalIncome,
                'formatted_value' => 'Rp ' . number_format($totalIncome, 0, ',', '.')
            ],
            'environmental_metrics' => [
                'total_weight_kg' => $totalWeight,
                'total_co2_reduction_kg' => $this->ecoStats->calculateCO2Reduction($totalWeight)
            ],
            // Data transaksi mentah untuk tabel rincian di PDF
            'raw_transactions' => $this->transactionDao->getTransactionsByMonth($month, $year)
        ];
    }
}