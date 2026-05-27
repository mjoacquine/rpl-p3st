<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'transaction_id',
        'user_id',          
        'category_id',      
        'pickup_date',      
        'address',          
        'notes',            
        'weight_actual',    
        'price_final',      
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->transaction_id)) {
                $model->transaction_id = 'TX-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
            }
        });
    }

    // RELASI: 1 Transaksi dimiliki oleh 1 User (Warga)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // RELASI: 1 Transaksi memiliki 1 Jenis Sampah (Katalog)
    public function catalogPrice()
    {
        return $this->belongsTo(CatalogPrice::class, 'category_id', 'category_id');
    }

    // FUNGSI BANTUAN: Untuk filter bulanan di ReportController Admin
    public function scopeMonthly($query, $month, $year)
    {
        return $query->whereMonth('created_at', $month)
                     ->whereYear('created_at', $year);
    }
}