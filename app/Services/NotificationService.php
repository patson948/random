<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Review;
use App\Notifications\OrderPlaced;
use App\Notifications\OrderShipped;
use App\Notifications\OrderDelivered;
use App\Notifications\OrderCancelled;
use App\Notifications\OrderRefunded;
use App\Notifications\PaymentSuccessful;
use App\Notifications\PaymentFailed;
use App\Notifications\VendorApproved;
use App\Notifications\VendorRejected;
use App\Notifications\NewVendorOrder;
use App\Notifications\CommissionEarned;
use App\Notifications\UserRegistered;
use App\Notifications\PasswordReset;
use App\Notifications\ProfileUpdated;
use App\Notifications\NewVendorApplication;
use App\Notifications\HighValueOrder;
use App\Notifications\SystemAlert;
use App\Notifications\NewReview;
use App\Notifications\ReviewResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send order placed notification
     */
    public function sendOrderPlacedNotification(Order $order): void
    {
        try {
            $order->user->notify(new OrderPlaced($order));
            
            // Notify vendors about new order
            $vendors = $order->items()->with('vendor.user')->get()
                ->pluck('vendor')
                ->unique('id')
                ->filter();
                
            foreach ($vendors as $vendor) {
                if ($vendor->user) {
                    $vendor->user->notify(new NewVendorOrder($order, $vendor));
                }
            }
            
            Log::info('Order placed notifications sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send order placed notifications', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send order shipped notification
     */
    public function sendOrderShippedNotification(Order $order, ?string $trackingNumber = null): void
    {
        try {
            $order->user->notify(new OrderShipped($order, $trackingNumber));
            Log::info('Order shipped notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send order shipped notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send order delivered notification
     */
    public function sendOrderDeliveredNotification(Order $order): void
    {
        try {
            $order->user->notify(new OrderDelivered($order));
            Log::info('Order delivered notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send order delivered notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send order cancelled notification
     */
    public function sendOrderCancelledNotification(Order $order, ?string $reason = null): void
    {
        try {
            $order->user->notify(new OrderCancelled($order, $reason));
            Log::info('Order cancelled notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send order cancelled notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send order refunded notification
     */
    public function sendOrderRefundedNotification(Order $order, float $refundAmount, ?string $reason = null): void
    {
        try {
            $order->user->notify(new OrderRefunded($order, $refundAmount, $reason));
            Log::info('Order refunded notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send order refunded notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send payment successful notification
     */
    public function sendPaymentSuccessfulNotification(Order $order, string $paymentMethod, ?string $transactionId = null): void
    {
        try {
            $order->user->notify(new PaymentSuccessful($order, $paymentMethod, $transactionId));
            Log::info('Payment successful notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment successful notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send payment failed notification
     */
    public function sendPaymentFailedNotification(Order $order, string $paymentMethod, ?string $reason = null): void
    {
        try {
            $order->user->notify(new PaymentFailed($order, $paymentMethod, $reason));
            Log::info('Payment failed notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment failed notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send vendor approved notification
     */
    public function sendVendorApprovedNotification(Vendor $vendor): void
    {
        try {
            $vendor->user->notify(new VendorApproved($vendor));
            Log::info('Vendor approved notification sent', ['vendor_id' => $vendor->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send vendor approved notification', [
                'vendor_id' => $vendor->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send vendor rejected notification
     */
    public function sendVendorRejectedNotification(Vendor $vendor, ?string $reason = null): void
    {
        try {
            $vendor->user->notify(new VendorRejected($vendor, $reason));
            Log::info('Vendor rejected notification sent', ['vendor_id' => $vendor->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send vendor rejected notification', [
                'vendor_id' => $vendor->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send commission earned notification
     */
    public function sendCommissionEarnedNotification(Order $order, Vendor $vendor, float $commissionAmount, float $commissionRate): void
    {
        try {
            $vendor->user->notify(new CommissionEarned($order, $vendor, $commissionAmount, $commissionRate));
            Log::info('Commission earned notification sent', [
                'order_id' => $order->id,
                'vendor_id' => $vendor->id
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send commission earned notification', [
                'order_id' => $order->id,
                'vendor_id' => $vendor->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send user registered notification
     */
    public function sendUserRegisteredNotification(User $user): void
    {
        try {
            $user->notify(new UserRegistered($user));
            Log::info('User registered notification sent', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send user registered notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send password reset notification
     */
    public function sendPasswordResetNotification(User $user, string $resetUrl): void
    {
        try {
            $user->notify(new PasswordReset($resetUrl));
            Log::info('Password reset notification sent', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send password reset notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send profile updated notification
     */
    public function sendProfileUpdatedNotification(User $user, array $changes): void
    {
        try {
            $user->notify(new ProfileUpdated($user, $changes));
            Log::info('Profile updated notification sent', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send profile updated notification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send new vendor application notification to admins
     */
    public function sendNewVendorApplicationNotification(Vendor $vendor): void
    {
        try {
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new NewVendorApplication($vendor));
            Log::info('New vendor application notification sent', ['vendor_id' => $vendor->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send new vendor application notification', [
                'vendor_id' => $vendor->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send high value order notification to admins
     */
    public function sendHighValueOrderNotification(Order $order, float $threshold): void
    {
        try {
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new HighValueOrder($order, $threshold));
            Log::info('High value order notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send high value order notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send system alert notification to admins
     */
    public function sendSystemAlertNotification(string $title, string $message, string $level = 'info'): void
    {
        try {
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new SystemAlert($title, $message, $level));
            Log::info('System alert notification sent', ['title' => $title, 'level' => $level]);
        } catch (\Exception $e) {
            Log::error('Failed to send system alert notification', [
                'title' => $title,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send new review notification to vendor
     */
    public function sendNewReviewNotification(Review $review, Product $product): void
    {
        try {
            if ($product->vendor && $product->vendor->user) {
                $product->vendor->user->notify(new NewReview($review, $product));
            }
            Log::info('New review notification sent', ['review_id' => $review->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send new review notification', [
                'review_id' => $review->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send review response notification to customer
     */
    public function sendReviewResponseNotification(Review $review, Product $product, string $response): void
    {
        try {
            $review->user->notify(new ReviewResponse($review, $product, $response));
            Log::info('Review response notification sent', ['review_id' => $review->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send review response notification', [
                'review_id' => $review->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}

