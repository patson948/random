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
use Illuminate\Support\Facades\Http;

class MobileNotificationService
{
    /**
     * Send push notification to mobile device
     */
    public function sendPushNotification(User $user, string $title, string $body, array $data = []): bool
    {
        try {
            // Check if user has FCM token
            if (!$user->fcm_token) {
                Log::info('User has no FCM token', ['user_id' => $user->id]);
                return false;
            }

            // Send FCM notification
            $response = Http::withHeaders([
                'Authorization' => 'key=' . config('services.fcm.server_key'),
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to' => $user->fcm_token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                    'badge' => $user->unreadNotifications->count() + 1,
                ],
                'data' => $data,
                'priority' => 'high',
            ]);

            if ($response->successful()) {
                Log::info('Push notification sent successfully', [
                    'user_id' => $user->id,
                    'title' => $title
                ]);
                return true;
            } else {
                Log::error('Failed to send push notification', [
                    'user_id' => $user->id,
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Push notification error', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send order placed notification with push
     */
    public function sendOrderPlacedNotification(Order $order): void
    {
        try {
            // Send regular notification
            $order->user->notify(new OrderPlaced($order));
            
            // Send push notification
            $this->sendPushNotification(
                $order->user,
                'Order Placed Successfully',
                "Your order #{$order->order_number} has been placed and is being processed.",
                [
                    'type' => 'order_placed',
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'total' => $order->total,
                ]
            );
            
            Log::info('Order placed mobile notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send order placed mobile notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send order shipped notification with push
     */
    public function sendOrderShippedNotification(Order $order, ?string $trackingNumber = null): void
    {
        try {
            $order->user->notify(new OrderShipped($order, $trackingNumber));
            
            $message = "Your order #{$order->order_number} has been shipped";
            if ($trackingNumber) {
                $message .= " with tracking number: {$trackingNumber}";
            }
            
            $this->sendPushNotification(
                $order->user,
                'Order Shipped',
                $message,
                [
                    'type' => 'order_shipped',
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'tracking_number' => $trackingNumber,
                ]
            );
            
            Log::info('Order shipped mobile notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send order shipped mobile notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send payment successful notification with push
     */
    public function sendPaymentSuccessfulNotification(Order $order, string $paymentMethod, ?string $transactionId = null): void
    {
        try {
            $order->user->notify(new PaymentSuccessful($order, $paymentMethod, $transactionId));
            
            $this->sendPushNotification(
                $order->user,
                'Payment Successful',
                "Your payment for order #{$order->order_number} has been processed successfully.",
                [
                    'type' => 'payment_successful',
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_method' => $paymentMethod,
                    'transaction_id' => $transactionId,
                ]
            );
            
            Log::info('Payment successful mobile notification sent', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment successful mobile notification', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send vendor approved notification with push
     */
    public function sendVendorApprovedNotification(Vendor $vendor): void
    {
        try {
            $vendor->user->notify(new VendorApproved($vendor));
            
            $this->sendPushNotification(
                $vendor->user,
                'Vendor Account Approved',
                "Congratulations! Your vendor account for {$vendor->shop_name} has been approved.",
                [
                    'type' => 'vendor_approved',
                    'vendor_id' => $vendor->id,
                    'shop_name' => $vendor->shop_name,
                ]
            );
            
            Log::info('Vendor approved mobile notification sent', ['vendor_id' => $vendor->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send vendor approved mobile notification', [
                'vendor_id' => $vendor->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send new vendor order notification with push
     */
    public function sendNewVendorOrderNotification(Order $order, Vendor $vendor): void
    {
        try {
            $vendor->user->notify(new NewVendorOrder($order, $vendor));
            
            $this->sendPushNotification(
                $vendor->user,
                'New Order Received',
                "You have received a new order #{$order->order_number} for your shop.",
                [
                    'type' => 'new_vendor_order',
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'vendor_id' => $vendor->id,
                ]
            );
            
            Log::info('New vendor order mobile notification sent', [
                'order_id' => $order->id,
                'vendor_id' => $vendor->id
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send new vendor order mobile notification', [
                'order_id' => $order->id,
                'vendor_id' => $vendor->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send new review notification with push
     */
    public function sendNewReviewNotification(Review $review, Product $product): void
    {
        try {
            if ($product->vendor && $product->vendor->user) {
                $product->vendor->user->notify(new NewReview($review, $product));
                
                $this->sendPushNotification(
                    $product->vendor->user,
                    'New Review Received',
                    "You have received a {$review->rating}-star review for {$product->name}.",
                    [
                        'type' => 'new_review',
                        'review_id' => $review->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'rating' => $review->rating,
                    ]
                );
            }
            
            Log::info('New review mobile notification sent', ['review_id' => $review->id]);
        } catch (\Exception $e) {
            Log::error('Failed to send new review mobile notification', [
                'review_id' => $review->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update user FCM token
     */
    public function updateFcmToken(User $user, string $fcmToken): bool
    {
        try {
            $user->update(['fcm_token' => $fcmToken]);
            Log::info('FCM token updated', ['user_id' => $user->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to update FCM token', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Remove FCM token
     */
    public function removeFcmToken(User $user): bool
    {
        try {
            $user->update(['fcm_token' => null]);
            Log::info('FCM token removed', ['user_id' => $user->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to remove FCM token', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}

