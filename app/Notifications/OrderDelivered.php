<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDelivered extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order
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
            ->subject('Your Order Has Been Delivered - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Great news! Your order has been successfully delivered.')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Total: **ZMW ' . number_format($this->order->total, 2) . '**')
            ->line('We hope you enjoy your purchase!')
            ->action('View Order Details', url('/orders/' . $this->order->id))
            ->line('Please consider leaving a review for your items to help other customers.')
            ->action('Leave a Review', url('/orders/' . $this->order->id . '/review'))
            ->line('Thank you for shopping with ShopHub!')
            ->salutation('Best regards, The ShopHub Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total' => $this->order->total,
            'delivered_at' => now(),
        ];
    }
}

