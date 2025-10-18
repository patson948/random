<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommissionEarned extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public Vendor $vendor,
        public float $commissionAmount,
        public float $commissionRate
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
            ->subject('Commission Earned - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Congratulations! You have earned commission from a completed order.')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Commission Rate: **' . number_format($this->commissionRate, 2) . '%**')
            ->line('Commission Amount: **ZMW ' . number_format($this->commissionAmount, 2) . '**')
            ->line('This commission will be added to your vendor account balance.')
            ->action('View Vendor Dashboard', url('/vendor/dashboard'))
            ->line('Keep up the great work! Continue providing excellent service to earn more commissions.')
            ->salutation('Happy Selling! The ShopHub Team');
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
            'vendor_id' => $this->vendor->id,
            'commission_amount' => $this->commissionAmount,
            'commission_rate' => $this->commissionRate,
            'earned_at' => now(),
        ];
    }
}

