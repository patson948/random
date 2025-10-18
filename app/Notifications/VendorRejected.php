<?php

namespace App\Notifications;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorRejected extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Vendor $vendor,
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
            ->subject('Vendor Application Update - ' . $this->vendor->shop_name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Thank you for your interest in becoming a vendor on ShopHub.')
            ->line('Unfortunately, we cannot approve your vendor application at this time.');

        if ($this->reason) {
            $message->line('Reason: **' . $this->reason . '**');
        }

        $message->line('You may reapply in the future once you have addressed the concerns mentioned above.')
            ->action('Learn More About Vendor Requirements', url('/vendor/requirements'))
            ->line('If you have any questions about this decision, please contact our support team.')
            ->salutation('Thank you for your interest, The ShopHub Team');

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
            'vendor_id' => $this->vendor->id,
            'shop_name' => $this->vendor->shop_name,
            'reason' => $this->reason,
            'rejected_at' => now(),
        ];
    }
}

