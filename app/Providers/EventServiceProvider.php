<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\OrderStatusChanged;
use App\Events\PaymentProcessed;
use App\Events\VendorApplicationSubmitted;
use App\Events\ReviewSubmitted;
use App\Listeners\SendOrderPlacedNotification;
use App\Listeners\SendOrderStatusNotification;
use App\Listeners\SendPaymentNotification;
use App\Listeners\SendVendorApplicationNotification;
use App\Listeners\SendReviewNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        // Order Events
        OrderPlaced::class => [
            SendOrderPlacedNotification::class,
        ],
        
        OrderStatusChanged::class => [
            SendOrderStatusNotification::class,
        ],
        
        // Payment Events
        PaymentProcessed::class => [
            SendPaymentNotification::class,
        ],
        
        // Vendor Events
        VendorApplicationSubmitted::class => [
            SendVendorApplicationNotification::class,
        ],
        
        // Review Events
        ReviewSubmitted::class => [
            SendReviewNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

