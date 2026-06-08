<?php

namespace App\Services;

abstract class NotificationService
{
    protected $recipient;
    protected $message;
    protected $subject = 'Pemberitahuan P3ST';

    public function setRecipient(string $recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }
    
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    // Memaksa class turunannya (seperti WhatsappNotification) untuk wajib memiliki fungsi send()
    abstract public function send(): bool;
}