<?php

namespace App\Listeners;

use App\Events\ReviewSubmitted;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReviewNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct(
        private NotificationService $notificationService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(ReviewSubmitted $event): void
    {
        $this->notificationService->sendNewReviewNotification($event->review, $event->product);
    }
}

