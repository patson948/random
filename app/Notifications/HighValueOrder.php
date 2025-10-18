<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HighValueOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public float $threshold
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
            ->subject('High Value Order Alert - ' . $this->order->order_number)
            ->greeting('Hello Admin!')
            ->line('A high-value order has been placed that exceeds the threshold.')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Customer: **' . $this->order->user->name . '**')
            ->line('Email: **' . $this->order->user->email . '**')
            ->line('Order Total: **ZMW ' . number_format($this->order->total, 2) . '**')
            ->line('Threshold: **ZMW ' . number_format($this->threshold, 2) . '**')
            ->line('Payment Method: **' . ucfirst($this->order->payment_method) . '**')
            ->action('View Order Details', url('/admin/orders/' . $this->order->id))
            ->line('Please monitor this order closely for any potential issues.')
            ->salutation('ShopHub Admin Panel');
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
            'customer_name' => $this->order->user->name,
            'customer_email' => $this->order->user->email,
            'total' => $this->order->total,
            'threshold' => $this->threshold,
            'alerted_at' => now(),
        ];
    }
}

