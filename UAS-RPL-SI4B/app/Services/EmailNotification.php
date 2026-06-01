<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailNotification extends NotificationService
{
    public function send(): bool
    {
        try {
            Mail::raw($this->message, function ($mail) {
                $mail->to($this->recipient)
                     ->subject($this->subject);
            });
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send Email to {$this->recipient}. Error: " . $e->getMessage());
            return false;
        }
    }
}