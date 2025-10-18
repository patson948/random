<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'type_name' => $this->getTypeName(),
            'data' => $this->data,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_read' => $this->read_at !== null,
            'time_ago' => $this->created_at->diffForHumans(),
            'formatted_data' => $this->getFormattedData(),
        ];
    }

    /**
     * Get the type name without namespace.
     */
    private function getTypeName(): string
    {
        return class_basename($this->type);
    }

    /**
     * Get formatted data for mobile display.
     */
    private function getFormattedData(): array
    {
        $data = $this->data;
        $formatted = [];

        // Common fields
        if (isset($data['order_number'])) {
            $formatted['order_number'] = $data['order_number'];
        }

        if (isset($data['total'])) {
            $formatted['total'] = number_format($data['total'], 2);
            $formatted['currency'] = 'ZMW';
        }

        if (isset($data['status'])) {
            $formatted['status'] = ucfirst($data['status']);
        }

        if (isset($data['payment_method'])) {
            $formatted['payment_method'] = ucfirst($data['payment_method']);
        }

        if (isset($data['shop_name'])) {
            $formatted['shop_name'] = $data['shop_name'];
        }

        if (isset($data['product_name'])) {
            $formatted['product_name'] = $data['product_name'];
        }

        if (isset($data['rating'])) {
            $formatted['rating'] = $data['rating'];
        }

        if (isset($data['commission_amount'])) {
            $formatted['commission_amount'] = number_format($data['commission_amount'], 2);
        }

        if (isset($data['commission_rate'])) {
            $formatted['commission_rate'] = number_format($data['commission_rate'], 2) . '%';
        }

        if (isset($data['reason'])) {
            $formatted['reason'] = $data['reason'];
        }

        if (isset($data['message'])) {
            $formatted['message'] = $data['message'];
        }

        if (isset($data['title'])) {
            $formatted['title'] = $data['title'];
        }

        if (isset($data['level'])) {
            $formatted['level'] = ucfirst($data['level']);
        }

        // Add notification-specific formatting
        $formatted['notification_type'] = $this->getTypeName();
        $formatted['icon'] = $this->getNotificationIcon();
        $formatted['color'] = $this->getNotificationColor();

        return $formatted;
    }

    /**
     * Get notification icon based on type.
     */
    private function getNotificationIcon(): string
    {
        return match($this->getTypeName()) {
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
     * Get notification color based on type.
     */
    private function getNotificationColor(): string
    {
        return match($this->getTypeName()) {
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
}

