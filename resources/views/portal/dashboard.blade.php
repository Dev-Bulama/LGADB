@extends('layouts.portal')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-6">

    <!-- Welcome Banner -->
    <div class="gov-gradient rounded-2xl p-6 text-white">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                @if($worker && $worker->profile_photo_url)
                    <img src="{{ $worker->profile_photo_url }}" alt="{{ $worker->full_name }}"
                         class="w-14 h-14 rounded-full border-4 border-white border-opacity-40 object-cover">
                @else
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center border-4 border-white border-opacity-40">
                        <span class="text-white font-extrabold text-xl">{{ strtoupper(substr($user->name ?? 'W', 0, 1)) }}</span>
                    </div>
                @endif
                <div>
                    <p class="text-green-200 text-sm">Welcome back,</p>
                    <h1 class="text-2xl font-extrabold">{{ $worker?->full_name ?? $user->name }}</h1>
                    @if($worker)
                        <p class="text-green-200 text-sm">{{ $worker->designation ?? 'Alimosho LGA Resident' }} &bull; {{ $worker->staff_number }}</p>
                    @endif
                </div>
            </div>
            @if($worker)
                <div class="text-right">
                    @if($worker->verification_status?->value === 'approved')
                        <span class="inline-flex items-center bg-green-400 text-green-900 text-xs font-bold px-4 py-2 rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Verified Citizen
                        </span>
                    @elseif($worker->verification_status?->value === 'pending')
                        <span class="inline-flex items-center bg-yellow-400 text-yellow-900 text-xs font-bold px-4 py-2 rounded-full">
                            ⏳ Verification Pending
                        </span>
                    @elseif($worker->verification_status?->value === 'under_review')
                        <span class="inline-flex items-center bg-blue-400 text-blue-900 text-xs font-bold px-4 py-2 rounded-full">
                            🔍 Under Review
                        </span>
                    @else
                        <span class="inline-flex items-center bg-red-400 text-red-900 text-xs font-bold px-4 py-2 rounded-full">
                            ✗ Not Verified
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if($worker)

    <!-- Quick Actions -->
    <div>
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Quick Actions</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @if($worker->verification_status?->value === 'approved')
            <a href="{{ route('portal.id-card') }}"
               class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col items-center text-center hover:border-green-300 hover:shadow-md transition group">
                <div class="w-10 h-10 bg-green-100 group-hover:bg-green-200 rounded-lg flex items-center justify-center mb-2 transition">
                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Download ID Card</span>
            </a>
            @endif
            <a href="{{ route('portal.profile') }}"
               class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col items-center text-center hover:border-green-300 hover:shadow-md transition group">
                <div class="w-10 h-10 bg-blue-50 group-hover:bg-blue-100 rounded-lg flex items-center justify-center mb-2 transition">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Update Profile</span>
            </a>
            <a href="{{ route('portal.documents') }}"
               class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col items-center text-center hover:border-green-300 hover:shadow-md transition group">
                <div class="w-10 h-10 bg-purple-50 group-hover:bg-purple-100 rounded-lg flex items-center justify-center mb-2 transition">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">My Documents</span>
            </a>
            <a href="{{ route('portal.history') }}"
               class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col items-center text-center hover:border-green-300 hover:shadow-md transition group">
                <div class="w-10 h-10 bg-orange-50 group-hover:bg-orange-100 rounded-lg flex items-center justify-center mb-2 transition">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Registration History</span>
            </a>
        </div>
    </div>

    <!-- Employment Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Registration Details
            </h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-400 font-medium">Citizen ID</dt>
                    <dd class="font-mono font-bold text-gray-800">{{ $worker->staff_number }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-400 font-medium">Department</dt>
                    <dd class="text-gray-800">{{ $worker->department?->name ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-400 font-medium">Unit</dt>
                    <dd class="text-gray-800">{{ $worker->unit?->name ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-400 font-medium">Occupation</dt>
                    <dd class="text-gray-800">{{ $worker->designation ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-400 font-medium">Grade Level</dt>
                    <dd class="text-gray-800">{{ $worker->grade_level ?? 'N/A' }}{{ $worker->step ? ' / Step ' . $worker->step : '' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-400 font-medium">Registration Date</dt>
                    <dd class="text-gray-800">{{ optional($worker->employment_date)->format('d M Y') ?? 'N/A' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-400 font-medium">Residency Type</dt>
                    <dd class="text-gray-800">{{ $worker->employment_type?->label() ?? 'N/A' }}</dd>
                </div>
                @if($worker->id_expiry_date)
                <div class="flex justify-between">
                    <dt class="text-gray-400 font-medium">ID Expiry</dt>
                    <dd class="text-gray-800 {{ $worker->id_expiry_date->isPast() ? 'text-red-600 font-semibold' : '' }}">
                        {{ $worker->id_expiry_date->format('d M Y') }}
                        @if($worker->id_expiry_date->isPast())
                            <span class="text-xs">(Expired)</span>
                        @endif
                    </dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Verification Status -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Verification Status
            </h2>

            @php
                $vs = $worker->verification_status?->value;
                $statusConfig = match($vs) {
                    'approved' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'icon' => 'text-green-500', 'title' => 'Verified & Approved', 'desc' => 'Your record is verified. You can download your ID card.', 'color' => 'text-green-700'],
                    'pending' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'icon' => 'text-yellow-500', 'title' => 'Pending Verification', 'desc' => 'Your record is awaiting review by the LGA administration.', 'color' => 'text-yellow-700'],
                    'under_review' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'icon' => 'text-blue-500', 'title' => 'Under Review', 'desc' => 'Your record is currently being reviewed.', 'color' => 'text-blue-700'],
                    'rejected' => ['bg' => 'bg-red-50', 'border' => 'border-red-200', 'icon' => 'text-red-500', 'title' => 'Rejected', 'desc' => 'Your verification was rejected. Contact the LGA office for details.', 'color' => 'text-red-700'],
                    default => ['bg' => 'bg-gray-50', 'border' => 'border-gray-200', 'icon' => 'text-gray-500', 'title' => 'Unknown', 'desc' => '', 'color' => 'text-gray-700'],
                };
            @endphp

            <div class="{{ $statusConfig['bg'] }} {{ $statusConfig['border'] }} border rounded-xl p-4 mb-4">
                <p class="{{ $statusConfig['color'] }} font-bold text-lg mb-1">{{ $statusConfig['title'] }}</p>
                <p class="{{ $statusConfig['color'] }} text-sm opacity-80">{{ $statusConfig['desc'] }}</p>
            </div>

            @if($vs === 'approved')
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">Verification Code</span>
                    <span class="font-mono font-bold text-green-700 tracking-wider">{{ $worker->verification_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Verified On</span>
                    <span class="text-gray-800">{{ optional($worker->verified_at)->format('d M Y') }}</span>
                </div>
                @if($worker->id_card_generated_at)
                <div class="flex justify-between">
                    <span class="text-gray-400">ID Card Generated</span>
                    <span class="text-gray-800">{{ $worker->id_card_generated_at->format('d M Y') }}</span>
                </div>
                @endif
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('portal.id-card.download') }}"
                   class="w-full flex items-center justify-center gov-gradient text-white font-semibold py-2.5 rounded-lg text-sm hover:opacity-90 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download ID Card
                </a>
            </div>
            @elseif($vs === 'rejected' && $worker->rejection_reason)
            <div class="mt-3 bg-red-50 rounded-lg p-3">
                <p class="text-xs font-semibold text-red-700 mb-1">Rejection Reason:</p>
                <p class="text-xs text-red-600">{{ $worker->rejection_reason }}</p>
            </div>
            @endif
        </div>
    </div>

    @else
        <!-- No worker record linked -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="font-bold text-yellow-900 mb-2">No Citizen Record Found</h3>
            <p class="text-yellow-700 text-sm">Your account is not yet linked to a citizen record. Please contact the LGA Registration office to complete your registration.</p>
        </div>
    @endif

</div>

@endsection
