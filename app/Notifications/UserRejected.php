<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRejected extends Notification
{
    use Queueable;

    protected $reason;

    public function __construct($reason = null)
    {
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Your Account Has Been Rejected')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your account has been rejected.');
        if ($this->reason) {
            $mail->line('Reason: ' . $this->reason);
        }
        $mail->line('If you have questions, please contact support.');
        return $mail;
    }
} 