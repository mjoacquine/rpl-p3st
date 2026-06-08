<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek dulu agar tidak error jika tabel sudah ada
        if (!Schema::hasTable('monthly_reports')) {
            Schema::create('monthly_reports', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->integer('report_month');
                $table->integer('report_year');
                $table->decimal('total_weight', 10, 2);
                $table->decimal('total_income', 15, 2);
                $table->decimal('total_co2_reduction', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};