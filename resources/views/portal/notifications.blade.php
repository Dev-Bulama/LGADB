@extends('layouts.portal')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')

<div class="space-y-4">

    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">
                {{ Auth::user()->unreadNotifications->count() }} unread notification(s)
            </p>
        </div>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <form method="POST" action="{{ route('portal.notifications.read-all') }}">
                @csrf
                <button type="submit"
                        class="text-xs text-green-700 font-semibold hover:underline border border-green-200 px-3 py-1.5 rounded-lg hover:bg-green-50 transition">
                    Mark All as Read
                </button>
            </form>
        @endif
    </div>

    @forelse($notifications as $notification)
        <div class="bg-white rounded-xl border {{ $notification->read_at ? 'border-gray-100' : 'border-green-200 bg-green-50' }} shadow-sm p-5 flex items-start space-x-4 transition hover:shadow-md">
            <div class="flex-shrink-0 mt-0.5">
                @if(!$notification->read_at)
                    <div class="w-2.5 h-2.5 bg-green-500 rounded-full mt-1"></div>
                @else
                    <div class="w-2.5 h-2.5 bg-gray-200 rounded-full mt-1"></div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-800 mb-0.5">
                            {{ $notification->data['title'] ?? $notification->data['message'] ?? 'Notification' }}
                        </p>
                        @if(isset($notification->data['body']) || isset($notification->data['message']))
                            <p class="text-sm text-gray-600">
                                {{ $notification->data['body'] ?? $notification->data['message'] }}
                            </p>
                        @endif
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                        @if(!$notification->read_at)
                            <form method="POST" action="{{ route('portal.notifications.read', $notification->id) }}" class="mt-1">
                                @csrf
                                <button type="submit" class="text-xs text-green-700 hover:underline font-medium">Mark read</button>
                            </form>
                        @endif
                    </div>
                </div>
                @if(isset($notification->data['url']))
                    <a href="{{ $notification->data['url'] }}" class="inline-block mt-2 text-green-700 text-xs font-semibold hover:underline">
                        View Details →
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-14 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-700 mb-1">No Notifications</h3>
            <p class="text-sm text-gray-400">You're all caught up! Notifications about your account will appear here.</p>
        </div>
    @endforelse

    @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif

</div>

@endsection
