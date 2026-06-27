@extends('layouts.portal')
@section('title', 'My ID Card')
@section('page-title', 'My ID Card')
@section('content')
<div class="max-w-2xl mx-auto">
    @if($worker && $worker->verification_status?->value === 'approved')
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- ID Card Preview -->
            <div class="bg-gradient-to-br from-green-800 to-green-600 p-8 text-white">
                <div class="text-center mb-4">
                    <div class="text-xs uppercase tracking-widest text-green-200 mb-1">Federal Republic of Nigeria</div>
                    <div class="font-bold text-lg">{{ config('lga.name') }}</div>
                    <div class="text-green-200 text-sm">Official Staff Identification Card</div>
                </div>
                <div class="flex items-center space-x-4 bg-white/10 rounded-xl p-4">
                    <div class="w-20 h-24 rounded-lg overflow-hidden bg-white/20 flex items-center justify-center">
                        @if($worker->getFirstMediaUrl('profile_photo'))
                            <img src="{{ $worker->getFirstMediaUrl('profile_photo') }}" class="w-full h-full object-cover" alt="Photo">
                        @else
                            <svg class="w-10 h-10 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @endif
                    </div>
                    <div>
                        <div class="font-bold text-lg">{{ $worker->full_name }}</div>
                        <div class="text-green-200 text-sm">{{ $worker->designation }}</div>
                        <div class="text-green-200 text-sm">{{ $worker->department?->name }}</div>
                        <div class="font-mono text-sm mt-1 bg-white/20 px-2 py-0.5 rounded">{{ $worker->staff_number }}</div>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-4 text-sm text-green-200">
                    <div>Expires: {{ $worker->id_expiry_date?->format('M Y') ?? 'N/A' }}</div>
                    <div>Issued: {{ $worker->employment_date?->format('M Y') ?? 'N/A' }}</div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="font-medium text-gray-900">Download your official ID card</p>
                        <p class="text-sm text-gray-500">High-quality PDF suitable for printing</p>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Verified</span>
                </div>
                <a href="{{ route('portal.id-card.download') }}" 
                   class="flex items-center justify-center w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition font-medium space-x-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Download ID Card (PDF)</span>
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">ID Card Not Available</h3>
            <p class="text-gray-500">Your ID card will be available after your verification is approved by HR. Current status: 
                <span class="font-medium {{ $worker?->verification_status?->value === 'pending' ? 'text-yellow-600' : 'text-blue-600' }}">
                    {{ $worker?->verification_status?->label() ?? 'Not Registered' }}
                </span>
            </p>
        </div>
    @endif
</div>
@endsection
