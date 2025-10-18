<?php

namespace App\Listeners;

use App\Events\PaymentProcessed;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPaymentNotification implements ShouldQueue
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
    public function handle(PaymentProcessed $event): void
    {
        $order = $event->order;
        $status = $event->status;
        $paymentMethod = $event->paymentMethod;
        $transactionId = $event->transactionId;
        $reason = $event->reason;

        switch ($status) {
            case 'successful':
                $this->notificationService->sendPaymentSuccessfulNotification($order, $paymentMethod, $transactionId);
                break;
            case 'failed':
                $this->notificationService->sendPaymentFailedNotification($order, $paymentMethod, $reason);
                break;
        }
    }
}

