<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserApproved extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Account Has Been Approved')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Congratulations! Your account has been approved by our team.')
            ->action('Login Now', url('/login'))
            ->line('Thank you for completing your onboarding.');
    }
} 