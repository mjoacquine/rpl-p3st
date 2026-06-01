<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class EconomicCalculator
{
    /**
     * Kalkulasi harga akhir per transaksi dengan presisi desimal
     */
    public function calculateEstimatedPrice(float $weight, float $pricePerKg): float
    {
        try {
            if ($weight <= 0 || $pricePerKg <= 0) {
                return 0.00;
            }
            // Menggunakan round 2 desimal standar mata uang
            return round($weight * $pricePerKg, 2);
        } catch (\Exception $e) {
            Log::error('Error calculating economic value: ' . $e->getMessage());
            return 0.00;
        }
    }

    /**
     * Kalkulasi total pendapatan agregat untuk kebutuhan pelaporan bulanan
     */
    public function calculateTotalIncome(Collection $transactions): float
    {
        if ($transactions->isEmpty()) {
            return 0.00;
        }
        
        return $transactions->reduce(function ($carry, $item) {
            // Memastikan data yang dijumlahkan adalah float yang valid
            return $carry + (float) $item->price_final;
        }, 0.00);
    }
}