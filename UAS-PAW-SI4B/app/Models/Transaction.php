<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'schedule_id',
        'category_id',
        'weight_actual',
        'price_final',
        'status',
    ];

    protected $casts = [
        'weight_actual' => 'decimal:2',
        'price_final' => 'decimal:2',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function catalogPrice()
    {
        return $this->belongsTo(CatalogPrice::class, 'category_id', 'category_id');
    }
}