<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'full_type' => $this->full_type,
            'count' => $this->count,
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
            'description' => $this->getDescription(),
        ];
    }

    /**
     * Get icon for notification type.
     */
    private function getIcon(): string
    {
        return match($this->type) {
            'OrderPlaced' => '🛒',
            'OrderShipped' => '🚚',
            'OrderDelivered' => '✅',
            'OrderCancelled' => '❌',
            'OrderRefunded' => '💰',
            'PaymentSuccessful' => '💳',
            'PaymentFailed' => '⚠️',
            'VendorApproved' => '🎉',
            'VendorRejected' => '😞',
            'NewVendorOrder' => '📦',
            'CommissionEarned' => '💎',
            'UserRegistered' => '👋',
            'PasswordReset' => '🔐',
            'ProfileUpdated' => '✏️',
            'NewVendorApplication' => '📝',
            'HighValueOrder' => '💎',
            'SystemAlert' => '🚨',
            'NewReview' => '⭐',
            'ReviewResponse' => '💬',
            default => '🔔'
        };
    }

    /**
     * Get color for notification type.
     */
    private function getColor(): string
    {
        return match($this->type) {
            'OrderPlaced' => 'blue',
            'OrderShipped' => 'indigo',
            'OrderDelivered' => 'green',
            'OrderCancelled' => 'red',
            'OrderRefunded' => 'orange',
            'PaymentSuccessful' => 'green',
            'PaymentFailed' => 'red',
            'VendorApproved' => 'green',
            'VendorRejected' => 'red',
            'NewVendorOrder' => 'blue',
            'CommissionEarned' => 'green',
            'UserRegistered' => 'blue',
            'PasswordReset' => 'yellow',
            'ProfileUpdated' => 'blue',
            'NewVendorApplication' => 'purple',
            'HighValueOrder' => 'gold',
            'SystemAlert' => 'red',
            'NewReview' => 'yellow',
            'ReviewResponse' => 'blue',
            default => 'gray'
        };
    }

    /**
     * Get description for notification type.
     */
    private function getDescription(): string
    {
        return match($this->type) {
            'OrderPlaced' => 'Order placed notifications',
            'OrderShipped' => 'Order shipped notifications',
            'OrderDelivered' => 'Order delivered notifications',
            'OrderCancelled' => 'Order cancelled notifications',
            'OrderRefunded' => 'Order refunded notifications',
            'PaymentSuccessful' => 'Payment successful notifications',
            'PaymentFailed' => 'Payment failed notifications',
            'VendorApproved' => 'Vendor approval notifications',
            'VendorRejected' => 'Vendor rejection notifications',
            'NewVendorOrder' => 'New vendor order notifications',
            'CommissionEarned' => 'Commission earned notifications',
            'UserRegistered' => 'User registration notifications',
            'PasswordReset' => 'Password reset notifications',
            'ProfileUpdated' => 'Profile update notifications',
            'NewVendorApplication' => 'New vendor application notifications',
            'HighValueOrder' => 'High value order notifications',
            'SystemAlert' => 'System alert notifications',
            'NewReview' => 'New review notifications',
            'ReviewResponse' => 'Review response notifications',
            default => 'General notifications'
        };
    }
}

