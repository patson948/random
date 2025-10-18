<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessful extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public string $paymentMethod,
        public ?string $transactionId = null
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
            ->subject('Payment Successful - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your payment has been processed successfully.')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Amount Paid: **ZMW ' . number_format($this->order->total, 2) . '**')
            ->line('Payment Method: **' . ucfirst($this->paymentMethod) . '**');

        if ($this->transactionId) {
            $message->line('Transaction ID: **' . $this->transactionId . '**');
        }

        $message->action('View Order Details', url('/orders/' . $this->order->id))
            ->line('Your order is now being processed and you will receive updates on its status.')
            ->line('Thank you for your purchase!')
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
            'transaction_id' => $this->transactionId,
            'paid_at' => now(),
        ];
    }
}

