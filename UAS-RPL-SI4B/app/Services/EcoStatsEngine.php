<?php

namespace App\Services;

class EcoStatsEngine
{
    // Konstanta: 1 Kg sampah daur ulang = 2.5 Kg Reduksi Emisi CO2
    private const CO2_MULTIPLIER = 2.5; 

    /**
     * Hitung spesifik reduksi CO2
     */
    public function calculateCO2Reduction(float $totalWeightInKg): float
    {
        return round($totalWeightInKg * self::CO2_MULTIPLIER, 2);
    }

    /**
     * Generate statistik lengkap untuk Dashboard
     */
    public function getMonthlyEcoStats(float $totalWeight): array
    {
        $co2Saved = $this->calculateCO2Reduction($totalWeight);
        
        // Logika pemberian apresiasi berdasarkan kontribusi
        $badge = 'Pemula';
        if ($totalWeight > 50) $badge = 'Pahlawan Bumi';
        elseif ($totalWeight > 20) $badge = 'Ksatria Hijau';

        return [
            'total_weight_kg' => number_format($totalWeight, 2, ',', '.'),
            'co2_saved_kg' => number_format($co2Saved, 2, ',', '.'),
            'badge' => $badge,
            'impact_message' => "Luar biasa! Kontribusi Anda bulan ini berhasil mencegah {$co2Saved} Kg emisi karbon mencemari udara Kota Palembang."
        ];
    }
}