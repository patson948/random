<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVendorOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public Vendor $vendor
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
        $vendorTotal = $this->order->items()
            ->where('vendor_id', $this->vendor->id)
            ->sum('total');

        return (new MailMessage)
            ->subject('New Order Received - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have received a new order for your shop: **' . $this->vendor->shop_name . '**')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Customer: **' . $this->order->user->name . '**')
            ->line('Order Total: **ZMW ' . number_format($vendorTotal, 2) . '**')
            ->line('Status: **' . ucfirst($this->order->status) . '**')
            ->action('View Order Details', url('/vendor/orders/' . $this->order->id))
            ->line('Please process this order as soon as possible to maintain good customer service.')
            ->line('You can update the order status from your vendor dashboard.')
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
            'shop_name' => $this->vendor->shop_name,
            'customer_name' => $this->order->user->name,
            'total' => $this->order->items()->where('vendor_id', $this->vendor->id)->sum('total'),
            'received_at' => now(),
        ];
    }
}

