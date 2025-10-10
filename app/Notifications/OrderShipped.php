<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShipped extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public ?string $trackingNumber = null
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
        $message = (new MailMessage)
            ->subject('Your Order Has Shipped - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Good news! Your order has been shipped and is on its way to you.')
            ->line('Order Number: **' . $this->order->order_number . '**');

        if ($this->trackingNumber) {
            $message->line('Tracking Number: **' . $this->trackingNumber . '**')
                ->action('Track Your Order', url('/track-order?number=' . $this->trackingNumber));
        }

        return $message
            ->line('Expected delivery: 3-5 business days')
            ->line('You will receive another notification when your order is delivered.')
            ->salutation('Thank you for shopping with us! The ShopHub Team');
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
            'tracking_number' => $this->trackingNumber,
            'shipped_at' => now(),
        ];
    }
}

