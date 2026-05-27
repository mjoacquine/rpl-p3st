<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalog_prices', function (Blueprint $table) {
            // category_id: ID unik kategori sampah sebagai Primary Key
            $table->string('category_id')->primary(); 
            
            // category_name: Nama kategori sampah (misal: Plastik, Logam, Kertas)
            $table->string('category_name'); 
            
            // unit: Satuan takaran sampah (misal: kg, lembar, botol)
            $table->string('unit')->default('kg'); 
            
            // price: Nilai ekonomi/harga per unit sampah
            $table->double('price', 15, 2)->default(0); 
            
            // effective_date: Diubah menjadi nullable agar tidak error saat admin tambah data baru
            $table->date('effective_date')->nullable(); 
            
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_prices');
    }
};