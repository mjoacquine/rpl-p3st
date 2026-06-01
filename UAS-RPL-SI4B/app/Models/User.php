<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relasi: Warga memiliki banyak jadwal booking
    public function schedulesAsWarga()
    {
        return $this->hasMany(Schedule::class, 'warga_id');
    }

    // Relasi: Petugas ditugaskan pada banyak jadwal penjemputan
    public function schedulesAsPetugas()
    {
        return $this->hasMany(Schedule::class, 'petugas_id');
    }
}