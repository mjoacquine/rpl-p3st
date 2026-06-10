<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Schedule; // Pastikan ini mengarah ke model Jadwal kalian

class PickupReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $schedule;
    protected $roleTarget;

    /**
     * Create a new notification instance.
     */
    public function __construct(Schedule $schedule, $roleTarget)
    {
        // Menerima data jadwal dan peran (warga atau petugas) dari Command
        $this->schedule = $schedule;
        $this->roleTarget = $roleTarget; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Menggunakan channel 'database' agar tersimpan di tabel notifications
        return ['database']; 
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        // Logika percabangan pesan berdasarkan siapa yang menerima notifikasi
        if ($this->roleTarget === 'warga') {
            
            $namaPetugas = $this->schedule->petugas->name ?? 'Petugas P3ST';
            $pesan = "Halo! Besok petugas penjemput ({$namaPetugas}) akan datang untuk menjemput sampah Anda. Mohon siapkan sampah Anda ya!";
            $judul = "Pengingat Penjemputan Besok";

        } elseif ($this->roleTarget === 'petugas') {
            
            $namaWarga = $this->schedule->warga->name ?? 'Warga';
            $alamatWarga = $this->schedule->warga->address ?? 'Alamat tidak tersedia';
            $pesan = "Halo! Besok Anda memiliki jadwal penjemputan di lokasi {$namaWarga} ({$alamatWarga}). Tolong dicek rutenya ya!";
            $judul = "Jadwal Tugas Besok";
            
        }

        // Data yang akan disimpan ke dalam kolom 'data' (format JSON) di tabel notifications
        return [
            'schedule_id' => $this->schedule->id,
            'title' => $judul,
            'message' => $pesan,
            'type' => 'pickup_reminder',
            'pickup_date' => $this->schedule->date,
        ];
    }
}