<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentFailed extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public string $paymentMethod,
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
            ->subject('Payment Failed - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Unfortunately, your payment could not be processed.')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Amount: **ZMW ' . number_format($this->order->total, 2) . '**')
            ->line('Payment Method: **' . ucfirst($this->paymentMethod) . '**');

        if ($this->reason) {
            $message->line('Reason: **' . $this->reason . '**');
        }

        $message->line('Please try again with a different payment method or contact your bank if the issue persists.')
            ->action('Retry Payment', url('/orders/' . $this->order->id . '/payment'))
            ->line('Your order is still reserved for you. Please complete payment within 24 hours.')
            ->line('If you need assistance, please contact our support team.')
            ->salutation('Best regards, The ShopHub Team');

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
            'amount' => $this->order->total,
            'payment_method' => $this->paymentMethod,
            'reason' => $this->reason,
            'failed_at' => now(),
        ];
    }
}

