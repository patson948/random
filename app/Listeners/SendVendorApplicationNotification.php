<?php

namespace App\Listeners;

use App\Events\VendorApplicationSubmitted;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVendorApplicationNotification implements ShouldQueue
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
    public function handle(VendorApplicationSubmitted $event): void
    {
        $this->notificationService->sendNewVendorApplicationNotification($event->vendor);
    }
}

