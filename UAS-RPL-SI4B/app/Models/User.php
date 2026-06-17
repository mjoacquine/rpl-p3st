<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address', 'latitude', 'longitude', 'google_id',
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'latitude' => 'decimal:10',
        'longitude' => 'decimal:10',
    ];

    // Method ini yang menghubungkan User dengan file VerifyEmailNotification
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function schedulesAsWarga()
    {
        return $this->hasMany(Schedule::class, 'warga_id');
    }

    public function schedulesAsPetugas()
    {
        return $this->hasMany(Schedule::class, 'petugas_id');
    }
}