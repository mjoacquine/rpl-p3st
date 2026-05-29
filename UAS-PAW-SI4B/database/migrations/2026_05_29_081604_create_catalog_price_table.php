<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalog_prices', function (Blueprint $table) {
            // Sesuai class diagram: categoryId, categoryName, effectiveDate
            $table->id('category_id'); 
            $table->string('category_name')->comment('Contoh: Plastik, Logam, Kertas');
            $table->decimal('price_per_kg', 10, 2)->comment('Harga beli sampah per Kg');
            $table->date('effective_date')->comment('Tanggal mulai berlakunya harga pasar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_prices');
    }
};