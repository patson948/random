<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications->items()),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
                'from' => $notifications->firstItem(),
                'to' => $notifications->lastItem(),
            ]
        ]);
    }

    /**
     * Get unread notifications count.
     */
    public function unreadCount(): JsonResponse
    {
        $count = Auth::user()->unreadNotifications->count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'unread_count' => $count
            ]
        ]);
    }

    /**
     * Get recent notifications (last 10).
     */
    public function recent(): JsonResponse
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications)
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, string $id): JsonResponse
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->markAsRead();
            
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'data' => new NotificationResource($notification)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(): JsonResponse
    {
        try {
            Auth::user()->unreadNotifications->markAsRead();
            
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark notifications as read',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a notification.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete all notifications.
     */
    public function destroyAll(): JsonResponse
    {
        try {
            Auth::user()->notifications()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'All notifications deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get notification statistics.
     */
    public function stats(): JsonResponse
    {
        $user = Auth::user();
        
        $stats = [
            'total_notifications' => $user->notifications()->count(),
            'unread_notifications' => $user->unreadNotifications->count(),
            'read_notifications' => $user->readNotifications->count(),
            'notifications_today' => $user->notifications()
                ->whereDate('created_at', today())
                ->count(),
            'notifications_this_week' => $user->notifications()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get notifications by type.
     */
    public function byType(Request $request, string $type): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $notifications = Auth::user()
            ->notifications()
            ->where('type', 'App\\Notifications\\' . $type)
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications->items()),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
                'from' => $notifications->firstItem(),
                'to' => $notifications->lastItem(),
            ]
        ]);
    }

    /**
     * Get notification types.
     */
    public function types(): JsonResponse
    {
        $types = Auth::user()
            ->notifications()
            ->select('type')
            ->distinct()
            ->get()
            ->map(function ($notification) {
                return [
                    'type' => class_basename($notification->type),
                    'full_type' => $notification->type,
                    'count' => Auth::user()->notifications()->where('type', $notification->type)->count()
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $types
        ]);
    }
}

