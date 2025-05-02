<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserUnderReview extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Account is Under Review')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Thank you for registering. Your account is now under review by our team.')
            ->line('You will be notified by email once your account is approved or if further information is required.')
            ->line('Thank you for your patience.');
    }
} 