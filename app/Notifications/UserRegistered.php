<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user
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
        return (new MailMessage)
            ->subject('Welcome to ShopHub!')
            ->greeting('Welcome to ShopHub, ' . $notifiable->name . '!')
            ->line('Thank you for joining our community. We\'re excited to have you on board!')
            ->line('Here\'s what you can do on ShopHub:')
            ->line('• Browse and purchase from thousands of products')
            ->line('• Discover amazing deals and discounts')
            ->line('• Read and write product reviews')
            ->line('• Track your orders in real-time')
            ->line('• Apply to become a vendor and start selling')
            ->action('Start Shopping', url('/products'))
            ->line('If you have any questions, our support team is here to help.')
            ->salutation('Happy Shopping! The ShopHub Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'registered_at' => now(),
        ];
    }
}

