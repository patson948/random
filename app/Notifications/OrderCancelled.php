<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public ?string $reason = null
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
            ->subject('Order Cancelled - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We regret to inform you that your order has been cancelled.')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Order Total: **ZMW ' . number_format($this->order->total, 2) . '**');

        if ($this->reason) {
            $message->line('Reason: **' . $this->reason . '**');
        }

        $message->line('If payment was made, you will receive a full refund within 3-5 business days.')
            ->action('View Order Details', url('/orders/' . $this->order->id))
            ->line('If you have any questions about this cancellation, please contact our support team.')
            ->salutation('We apologize for any inconvenience, The ShopHub Team');

        return $message;
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
            'reason' => $this->reason,
            'cancelled_at' => now(),
        ];
    }
}

