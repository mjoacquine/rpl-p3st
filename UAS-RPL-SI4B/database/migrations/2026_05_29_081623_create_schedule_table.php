<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            // Menggunakan UUID untuk ID yang lebih aman dan terdistribusi
            $table->uuid('id')->primary(); 
            // Relasi ke warga yang melakukan booking
            $table->foreignId('warga_id')->constrained('users')->onDelete('cascade');
            // Relasi ke petugas yang ditugaskan (bisa null saat awal booking)
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->date('pickup_date')->comment('Tanggal penjemputan');
            $table->time('pickup_time')->comment('Waktu penjemputan');
            $table->decimal('estimated_weight', 8, 2)->comment('Estimasi berat dari kalkulator awal');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'diproses', 'selesai', 'batal'])->default('menunggu');
            $table->text('notes')->nullable()->comment('Catatan tambahan dari warga');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};