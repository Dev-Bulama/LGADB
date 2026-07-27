@extends('layouts.portal')
@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('content')
<div class="space-y-6">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-green-700 text-sm font-medium">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-700 text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center space-x-6">
            <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center overflow-hidden border-4 border-green-200">
                @if($worker && $worker->getFirstMediaUrl('profile_photo'))
                    <img src="{{ $worker->getFirstMediaUrl('profile_photo') }}" alt="{{ $worker?->full_name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-12 h-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $worker?->full_name ?? $user->name }}</h2>
                <p class="text-green-600 font-medium">{{ $worker?->designation ?? 'No designation' }}</p>
                <p class="text-gray-500 text-sm">{{ $worker?->staff_number ?? 'Pending assignment' }} — Citizen ID</p>
                @if($worker)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                    {{ $worker->verification_status?->value === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $worker->verification_status?->label() ?? 'Pending' }}
                </span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Registration Info (Read-only) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Registration Information</h3>
            <dl class="space-y-3">
                <div><dt class="text-sm text-gray-500">Department</dt><dd class="font-medium">{{ $worker?->department?->name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Unit</dt><dd class="font-medium">{{ $worker?->unit?->name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Office</dt><dd class="font-medium">{{ $worker?->office?->name ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Residency Type</dt><dd class="font-medium">{{ $worker?->employment_type?->label() ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Registration Date</dt><dd class="font-medium">{{ $worker?->employment_date?->format('d M Y') ?? '—' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Grade Level / Step</dt><dd class="font-medium">{{ $worker?->grade_level ?? '—' }} / {{ $worker?->step ?? '—' }}</dd></div>
            </dl>
        </div>

        <!-- Editable Fields -->
        @if($worker)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Contact Information</h3>
            <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $worker->phone) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $worker->whatsapp) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Residential Address</label>
                    <textarea name="residential_address" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('residential_address', $worker->residential_address) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Next of Kin Name</label>
                    <input type="text" name="next_of_kin_name" value="{{ old('next_of_kin_name', $worker->next_of_kin_name) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Next of Kin Phone</label>
                    <input type="text" name="next_of_kin_phone" value="{{ old('next_of_kin_phone', $worker->next_of_kin_phone) }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition font-medium">
                    Save Changes
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Change Password -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h3>
        <form action="{{ route('portal.profile.password') }}" method="POST" class="space-y-4 max-w-md">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent @error('current_password') border-red-400 @enderror">
                @error('current_password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-400 @enderror">
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-gray-800 text-white py-2 px-6 rounded-lg hover:bg-gray-900 transition font-medium text-sm">
                Update Password
            </button>
        </form>
    </div>
</div>
@endsection
