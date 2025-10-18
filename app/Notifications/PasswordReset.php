<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $resetUrl
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password Reset Request')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You requested to reset your password for your ShopHub account.')
            ->line('Click the button below to reset your password:')
            ->action('Reset Password', $this->resetUrl)
            ->line('This link will expire in 60 minutes.')
            ->line('If you did not request a password reset, please ignore this email.')
            ->line('For security reasons, please do not share this link with anyone.')
            ->salutation('Best regards, The ShopHub Team');
    }
}

