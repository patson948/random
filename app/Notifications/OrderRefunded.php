<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderRefunded extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public float $refundAmount,
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
            ->subject('Refund Processed - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your refund has been processed successfully.')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Refund Amount: **ZMW ' . number_format($this->refundAmount, 2) . '**');

        if ($this->reason) {
            $message->line('Reason: **' . $this->reason . '**');
        }

        $message->line('The refund will be credited to your original payment method within 3-5 business days.')
            ->action('View Order Details', url('/orders/' . $this->order->id))
            ->line('If you have any questions about this refund, please contact our support team.')
            ->salutation('Thank you for your patience, The ShopHub Team');

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
            'refund_amount' => $this->refundAmount,
            'reason' => $this->reason,
            'refunded_at' => now(),
        ];
    }
}

