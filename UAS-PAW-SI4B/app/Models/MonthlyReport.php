<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MonthlyReport extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'report_month',
        'report_year',
        'total_weight',
        'total_income',
        'total_co2_reduction',
    ];

    protected $casts = [
        'total_weight' => 'decimal:2',
        'total_income' => 'decimal:2',
        'total_co2_reduction' => 'decimal:2',
    ];
}