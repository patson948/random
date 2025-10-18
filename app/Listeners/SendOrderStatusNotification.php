<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderStatusNotification implements ShouldQueue
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
    public function handle(OrderStatusChanged $event): void
    {
        $order = $event->order;
        $newStatus = $event->newStatus;
        $trackingNumber = $event->trackingNumber;

        switch ($newStatus) {
            case 'shipped':
                $this->notificationService->sendOrderShippedNotification($order, $trackingNumber);
                break;
            case 'delivered':
                $this->notificationService->sendOrderDeliveredNotification($order);
                break;
            case 'cancelled':
                $this->notificationService->sendOrderCancelledNotification($order);
                break;
        }
    }
}

