<?php

namespace App\Traits;

use App\Services\NotificationService;
use App\Events\OrderPlaced;
use App\Events\OrderStatusChanged;
use App\Events\PaymentProcessed;
use App\Events\VendorApplicationSubmitted;
use App\Events\ReviewSubmitted;
use Illuminate\Support\Facades\Event;

trait NotifiesUsers
{
    /**
     * Send order placed notification
     */
    protected function notifyOrderPlaced($order)
    {
        Event::dispatch(new OrderPlaced($order));
    }

    /**
     * Send order status change notification
     */
    protected function notifyOrderStatusChanged($order, $oldStatus, $newStatus, $trackingNumber = null)
    {
        Event::dispatch(new OrderStatusChanged($order, $oldStatus, $newStatus, $trackingNumber));
    }

    /**
     * Send payment processed notification
     */
    protected function notifyPaymentProcessed($order, $status, $paymentMethod, $transactionId = null, $reason = null)
    {
        Event::dispatch(new PaymentProcessed($order, $status, $paymentMethod, $transactionId, $reason));
    }

    /**
     * Send vendor application submitted notification
     */
    protected function notifyVendorApplicationSubmitted($vendor)
    {
        Event::dispatch(new VendorApplicationSubmitted($vendor));
    }

    /**
     * Send review submitted notification
     */
    protected function notifyReviewSubmitted($review, $product)
    {
        Event::dispatch(new ReviewSubmitted($review, $product));
    }

    /**
     * Send high value order alert
     */
    protected function notifyHighValueOrder($order, $threshold)
    {
        $notificationService = app(NotificationService::class);
        $notificationService->sendHighValueOrderNotification($order, $threshold);
    }

    /**
     * Send system alert
     */
    protected function notifySystemAlert($title, $message, $level = 'info')
    {
        $notificationService = app(NotificationService::class);
        $notificationService->sendSystemAlertNotification($title, $message, $level);
    }
}

