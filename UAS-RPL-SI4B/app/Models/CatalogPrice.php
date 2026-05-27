<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CatalogPrice extends Model
{
    use HasFactory;

    protected $table = 'catalog_prices';
    protected $primaryKey = 'category_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'category_id',
        'category_name',
        'unit',
        'price',
        'effective_date',
    ];

    // Otomatis membuat category_id unik saat admin tambah data baru
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->category_id)) {
                $model->category_id = 'CAT-' . strtoupper(Str::random(4));
            }
        });
    }
}