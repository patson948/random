@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
            <div class="flex space-x-2">
                <button onclick="markAllAsRead()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Mark All as Read
                </button>
            </div>
        </div>

        @if($notifications->count() > 0)
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="bg-white rounded-lg shadow p-6 {{ $notification->read_at ? 'opacity-75' : 'border-l-4 border-blue-500' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ ucfirst(str_replace('App\\Notifications\\', '', $notification->type)) }}
                                </h3>
                                <p class="text-gray-600 mt-2">
                                    @if(isset($notification->data['order_number']))
                                        Order #{{ $notification->data['order_number'] }}
                                    @endif
                                    @if(isset($notification->data['message']))
                                        {{ $notification->data['message'] }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500 mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                @if(!$notification->read_at)
                                    <button onclick="markAsRead('{{ $notification->id }}')" 
                                            class="text-blue-500 hover:text-blue-700 text-sm">
                                        Mark as Read
                                    </button>
                                @endif
                                <button onclick="deleteNotification('{{ $notification->id }}')" 
                                        class="text-red-500 hover:text-red-700 text-sm">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">🔔</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No notifications</h3>
                <p class="text-gray-600">You're all caught up! We'll notify you when something important happens.</p>
            </div>
        @endif
    </div>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function markAllAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteNotification(notificationId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endsection

