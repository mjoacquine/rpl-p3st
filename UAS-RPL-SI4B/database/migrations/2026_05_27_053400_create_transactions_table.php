<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            // transaction_id sebagai Primary Key String (Contoh: TX-20260527-ABCD)
            $table->string('transaction_id')->primary();
            
            // Menghubungkan transaksi ke ID Warga yang login
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Menghubungkan ke tabel catalog_prices lewat category_id
            $table->string('category_id')->nullable();
            $table->foreign('category_id')->references('category_id')->on('catalog_prices')->onDelete('set null');
            
            // Kolom inputan warga saat mengisi form order penjemputan
            $table->date('pickup_date');
            $table->text('address');
            $table->text('notes')->nullable();
            
            // Kolom eksekusi petugas lapangan setelah menimbang sampah warga
            $table->double('weight_actual', 8, 2)->default(0.00); 
            $table->double('price_final', 15, 2)->default(0.00); 
            
            // Status awal otomatis 'menunggu'
            $table->string('status')->default('menunggu'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};