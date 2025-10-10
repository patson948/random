<?php

namespace App\Notifications;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorApproved extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
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
        return (new MailMessage)
            ->subject('Congratulations! Your Vendor Account is Approved')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Great news! Your vendor application for **' . $this->vendor->shop_name . '** has been approved.')
            ->line('You can now start listing your products and selling on ShopHub.')
            ->action('Go to Vendor Dashboard', url('/vendor/dashboard'))
            ->line('Here are your next steps:')
            ->line('1. Complete your shop profile')
            ->line('2. Add your products')
            ->line('3. Set up payment details')
            ->line('4. Start selling!')
            ->line('If you need any assistance, our support team is here to help.')
            ->salutation('Welcome to ShopHub! The ShopHub Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'vendor_id' => $this->vendor->id,
            'shop_name' => $this->vendor->shop_name,
            'approved_at' => now(),
        ];
    }
}

