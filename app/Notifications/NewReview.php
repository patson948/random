<?php

namespace App\Notifications;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReview extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Review $review,
        public Product $product
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
        $stars = str_repeat('⭐', $this->review->rating);
        
        return (new MailMessage)
            ->subject('New Review Received - ' . $this->product->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have received a new review for your product.')
            ->line('Product: **' . $this->product->name . '**')
            ->line('Rating: **' . $stars . ' (' . $this->review->rating . '/5)**')
            ->line('Review: "' . $this->review->comment . '"')
            ->line('Reviewer: **' . $this->review->user->name . '**')
            ->action('View Review', url('/products/' . $this->product->slug))
            ->line('Thank you for providing quality products to our customers!')
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
            'review_id' => $this->review->id,
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'rating' => $this->review->rating,
            'reviewer_name' => $this->review->user->name,
            'reviewed_at' => now(),
        ];
    }
}

