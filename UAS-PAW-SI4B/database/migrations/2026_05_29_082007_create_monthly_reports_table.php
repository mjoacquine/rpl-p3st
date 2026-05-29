<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_reports', function (Blueprint $table) {
            // Sesuai class diagram: reportId, totalWeight, totalIncome, totalCO2Reduction
            $table->uuid('id')->primary(); // reportId
            $table->integer('report_month')->comment('Bulan laporan (1-12)');
            $table->integer('report_year')->comment('Tahun laporan');
            
            $table->decimal('total_weight', 12, 2)->default(0)->comment('Akumulasi berat sampah dalam sebulan (Kg)');
            $table->decimal('total_income', 15, 2)->default(0)->comment('Total perputaran ekonomi (Rp)');
            $table->decimal('total_co2_reduction', 12, 2)->default(0)->comment('Total metrik dampak lingkungan / emisi (Kg CO2eq)');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};