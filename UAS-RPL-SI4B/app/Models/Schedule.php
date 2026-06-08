<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Schedule extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'warga_id', 'petugas_id', 'pickup_date', 'pickup_time', 
        'estimated_weight', 'status', 'notes',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'pickup_time' => 'datetime:H:i',
        'estimated_weight' => 'decimal:2',
    ];

    public function warga() { return $this->belongsTo(User::class, 'warga_id'); }
    public function petugas() { return $this->belongsTo(User::class, 'petugas_id'); }
    public function transaction() { return $this->hasOne(Transaction::class, 'schedule_id'); }
}