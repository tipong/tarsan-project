@extends('layouts.app')

@section('title', 'My Notifications')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-slate-800">Notifications</h1>
            <p class="text-slate-600">Manage all your notifications</p>
        </div>
        <button onclick="markAllAsRead()" class="px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800">
            ✓ Mark All as Read
        </button>
    </div>

    @if($notifications->isEmpty())
        <div class="bg-white p-8 rounded-2xl shadow-md text-center">
            <p class="text-slate-600 text-lg">No notifications</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition {{ !$notification->read_at ? 'border-l-4 border-blue-600' : '' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-lg font-bold text-slate-800">{{ $notification->title }}</h3>
                                @if(!$notification->read_at)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                        Baru
                                    </span>
                                @endif
                            </div>

                            <p class="text-slate-600 mb-3">{{ $notification->message }}</p>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>

                                {{-- Type Badge --}}
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $notification->type === 'booking' ? 'bg-green-100 text-green-700' : ($notification->type === 'payment' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                                    @if($notification->type === 'booking')
                                        📅 Pemesanan
                                    @elseif($notification->type === 'payment')
                                        💳 Payment
                                    @elseif($notification->type === 'cancellation')
                                        ✗ Cancellation
                                    @elseif($notification->type === 'checkin')
                                        🔓 Check-in
                                    @elseif($notification->type === 'checkout')
                                        🚪 Check-out
                                    @else
                                        ℹ️ Information
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Action --}}
                        @if(!$notification->read_at)
                            <button onclick="markAsRead({{ $notification->id }})"
                                   class="ml-4 px-3 py-1 bg-slate-100 text-slate-700 rounded-xl hover:bg-gray-300 text-sm">
                                Mark as Read
                            </button>
                        @endif
                    </div>

                    {{-- Order Link --}}
                    @if($notification->order)
                        <div class="mt-3 pt-3 border-t">
                            <a href="{{ route('tamu.orders.show', $notification->order) }}"
                               class="text-indigo-600 hover:text-blue-700 text-sm font-semibold">
                                View Order Details →
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/tamu/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function markAllAsRead() {
    showConfirm('Mark All as Read?', 'All notifications will be marked as read', () => {
        fetch('/tamu/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('Success', 'All notifications have been marked as read');
                setTimeout(() => location.reload(), 1500);
            }
        });
    });
}
</script>
@endsection
