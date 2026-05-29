<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogPrice extends Model
{
    use HasFactory;

    // Menyesuaikan dengan nama primary key di migration
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
        'price_per_kg',
        'effective_date',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'price_per_kg' => 'decimal:2',
    ];

    // Relasi: Satu kategori harga bisa dimiliki oleh banyak transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'category_id', 'category_id');
    }
}