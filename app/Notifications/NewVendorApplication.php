<?php

namespace App\Notifications;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVendorApplication extends Notification implements ShouldQueue
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
            ->subject('New Vendor Application - ' . $this->vendor->shop_name)
            ->greeting('Hello Admin!')
            ->line('A new vendor application has been submitted and requires your review.')
            ->line('Shop Name: **' . $this->vendor->shop_name . '**')
            ->line('Applicant: **' . $this->vendor->user->name . '**')
            ->line('Email: **' . $this->vendor->user->email . '**')
            ->line('Phone: **' . $this->vendor->phone . '**')
            ->line('Description: ' . $this->vendor->description)
            ->action('Review Application', url('/admin/vendors/' . $this->vendor->id))
            ->line('Please review the application and approve or reject it based on your criteria.')
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
            'vendor_id' => $this->vendor->id,
            'shop_name' => $this->vendor->shop_name,
            'applicant_name' => $this->vendor->user->name,
            'applicant_email' => $this->vendor->user->email,
            'submitted_at' => now(),
        ];
    }
}

