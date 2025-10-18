<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_notifications' => $this->total_notifications,
            'unread_notifications' => $this->unread_notifications,
            'read_notifications' => $this->read_notifications,
            'notifications_today' => $this->notifications_today,
            'notifications_this_week' => $this->notifications_this_week,
            'unread_percentage' => $this->total_notifications > 0 
                ? round(($this->unread_notifications / $this->total_notifications) * 100, 2)
                : 0,
        ];
    }
}

