<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            // Sesuai class diagram: TransactionId, scheduleId, weightActual, priceFinal, status
            $table->uuid('id')->primary(); // TransactionId
            $table->foreignUuid('schedule_id')->constrained('schedules')->onDelete('cascade');
            
            // Relasi ke kategori sampah untuk mengetahui harga yang berlaku saat itu
            $table->foreignId('category_id')->constrained('catalog_prices', 'category_id')->onDelete('restrict');
            
            $table->decimal('weight_actual', 8, 2)->nullable()->comment('Berat sampah rill hasil penimbangan petugas');
            $table->decimal('price_final', 12, 2)->nullable()->comment('Total harga yang dibayar ke warga');
            
            $table->enum('status', ['menunggu', 'selesai', 'batal'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};