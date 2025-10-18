<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemAlert extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $title,
        public string $message,
        public string $level = 'info'
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = match($this->level) {
            'error' => '🚨 System Error Alert',
            'warning' => '⚠️ System Warning',
            'info' => 'ℹ️ System Information',
            default => 'System Alert'
        };

        return (new MailMessage)
            ->subject($subject . ' - ' . $this->title)
            ->greeting('Hello Admin!')
            ->line($this->message)
            ->line('Alert Level: **' . ucfirst($this->level) . '**')
            ->line('Timestamp: **' . now()->format('Y-m-d H:i:s') . '**')
            ->action('View Admin Dashboard', url('/admin/dashboard'))
            ->line('Please take appropriate action if required.')
            ->salutation('ShopHub System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'level' => $this->level,
            'alerted_at' => now(),
        ];
    }
}

