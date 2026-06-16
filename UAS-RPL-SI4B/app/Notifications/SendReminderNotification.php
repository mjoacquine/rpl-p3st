<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SendReminderNotification extends Notification
{
    use Queueable;

    protected $schedule;

    // Menangkap data jadwal yang dikirim dari controller
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    // WAJIB UBAH JADI DATABASE
    public function via($notifiable)
    {
        return ['database']; 
    }

    // Isi pesan yang masuk ke lonceng kuning warga
    public function toArray($notifiable)
    {
        return [
            'pesan' => 'Siap-siap ya! Petugas sedang bergerak menuju lokasi penjemputan Anda.',
            'schedule_id' => $this->schedule->id,
            'estimasi_berat' => $this->schedule->estimated_weight
        ];
    }
}