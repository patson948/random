<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderPlacedNotification implements ShouldQueue
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
    public function handle(OrderPlaced $event): void
    {
        $this->notificationService->sendOrderPlacedNotification($event->order);
    }
}

