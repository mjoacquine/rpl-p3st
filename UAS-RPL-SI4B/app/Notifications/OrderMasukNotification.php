<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderMasukNotification extends Notification
{
    use Queueable;

    protected $schedule;

    // Menangkap data jadwal pesanan yang baru dibuat Warga
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    // 👇 WAJIB UBAH JADI DATABASE BIAR MASUK LONCENG 👇
    public function via($notifiable)
    {
        return ['database']; 
    }

    // Isi pesan yang masuk ke lonceng kuning Petugas
    public function toArray($notifiable)
    {
        // Ambil nama warga, kalau error/kosong default ke 'Warga'
        $namaWarga = $this->schedule->warga->name ?? 'Warga';

        return [
            'pesan' => 'Ada pesanan jemputan baru dari ' . $namaWarga . '! Cek Bursa Tugas sekarang.',
            'schedule_id' => $this->schedule->id
        ];
    }
}