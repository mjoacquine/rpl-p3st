<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('schedule_id')->constrained('schedules')->onDelete('cascade');
            
            // Relasi ke kategori sampah
            $table->foreignId('category_id')->constrained('catalog_prices', 'category_id')->onDelete('restrict');
            
            $table->decimal('weight_actual', 8, 2)->nullable()->comment('Berat sampah rill hasil penimbangan petugas');
            $table->decimal('price_final', 12, 2)->nullable()->comment('Total harga yang dibayar ke warga');
            
            // STATUS DIPERBARUI: Menambahkan 'menunggu_konfirmasi'
            $table->enum('status', [
                'menunggu', 
                'menunggu_konfirmasi', 
                'selesai', 
                'batal'
            ])->default('menunggu');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};