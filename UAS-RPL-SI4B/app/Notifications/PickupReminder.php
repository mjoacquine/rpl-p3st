<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Schedule; 

class PickupReminder extends Notification 
{
    use Queueable;

    protected $schedule;
    protected $roleTarget;

    /**
     * Create a new notification instance.
     */
    public function __construct(Schedule $schedule, $roleTarget)
    {
        $this->schedule = $schedule;
        $this->roleTarget = $roleTarget; 
    }

    /**
     * Tentukan jalur pengiriman notifikasi (Wajib 'database' agar masuk ke lonceng)
     */
    public function via($notifiable)
    {
        return ['database']; 
    }

    /**
     * Format pesan yang akan masuk ke tabel MySQL dan dibaca oleh sistem Lonceng
     */
    public function toDatabase(object $notifiable): array
    {
        // Logika percabangan pesan
        if ($this->roleTarget === 'warga') {
            
            $namaPetugas = $this->schedule->petugas->name ?? 'Petugas P3ST';
            $pesan = "Halo! Besok petugas penjemput ({$namaPetugas}) akan datang untuk menjemput sampah Anda. Mohon siapkan sampah Anda ya!";
            $judul = "Pengingat Penjemputan Besok";

        } elseif ($this->roleTarget === 'petugas') {
            
            $namaWarga = $this->schedule->warga->name ?? 'Warga';
            $alamatWarga = $this->schedule->warga->address ?? 'Alamat tidak tersedia';
            $pesan = "Halo! Besok Anda memiliki jadwal penjemputan di lokasi {$namaWarga} ({$alamatWarga}). Tolong dicek rutenya ya!";
            $judul = "Jadwal Tugas Besok";
            
        } else {
            // Jaga-jaga kalau role-nya tidak terbaca
            $judul = "Pengingat Sistem P3ST";
            $pesan = "Anda memiliki pemberitahuan baru terkait jadwal penjemputan.";
        }

        return [
            'schedule_id' => $this->schedule->id,
            'title'       => $judul,
            'message'     => $pesan,
            'type'        => 'pickup_reminder',
            'pickup_time' => $this->schedule->pickup_time, // ✅ Sudah diganti agar tidak error!
        ];
    }
}