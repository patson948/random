<?php

namespace App\Notifications;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewResponse extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Review $review,
        public Product $product,
        public string $response
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
            ->subject('Response to Your Review - ' . $this->product->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('The vendor has responded to your review.')
            ->line('Product: **' . $this->product->name . '**')
            ->line('Your Review: "' . $this->review->comment . '"')
            ->line('Vendor Response: "' . $this->response . '"')
            ->action('View Product', url('/products/' . $this->product->slug))
            ->line('Thank you for taking the time to review our products!')
            ->salutation('Best regards, The ShopHub Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'review_id' => $this->review->id,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'response' => $this->response,
            'responded_at' => now(),
        ];
    }
}

