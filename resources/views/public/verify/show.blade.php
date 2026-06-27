@extends('layouts.public')

@section('title', 'Verified Staff — ' . $worker->full_name)

@section('content')

<div class="gov-gradient py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <span class="inline-flex items-center bg-green-400 text-green-900 text-sm font-bold px-4 py-1 rounded-full mb-3">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Verified Staff Record
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">{{ $worker->full_name }}</h1>
        <p class="text-green-200 mt-2">{{ $worker->designation ?? 'LGA Staff Member' }}</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10 space-y-6">

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="gov-gradient px-6 py-3 flex items-center justify-between">
            <span class="text-white font-semibold text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                OFFICIAL WORKFORCE IDENTITY RECORD
            </span>
            <span class="bg-green-400 text-green-900 text-xs font-bold px-3 py-1 rounded-full">APPROVED</span>
        </div>

        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Photo & QR -->
                <div class="flex flex-col items-center gap-4 md:w-48 flex-shrink-0">
                    @if($worker->profile_photo_url)
                        <img src="{{ $worker->profile_photo_url }}" alt="{{ $worker->full_name }}"
                             class="w-36 h-36 object-cover rounded-2xl border-4 border-green-100 shadow-md">
                    @else
                        <div class="w-36 h-36 bg-green-50 rounded-2xl border-4 border-green-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="text-center">
                        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Verification Code</p>
                        <p class="font-mono font-bold text-green-700 tracking-widest text-sm">{{ $worker->verification_code }}</p>
                    </div>
                </div>

                <!-- Details -->
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Full Name</span>
                        <p class="text-gray-900 font-bold text-lg">{{ $worker->full_name }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Staff Number</span>
                        <p class="text-gray-900 font-mono font-bold">{{ $worker->staff_number }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Designation</span>
                        <p class="text-gray-800">{{ $worker->designation ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Department</span>
                        <p class="text-gray-800">{{ $worker->department?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Unit</span>
                        <p class="text-gray-800">{{ $worker->unit?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Office</span>
                        <p class="text-gray-800">{{ $worker->office?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Grade Level / Step</span>
                        <p class="text-gray-800">{{ $worker->grade_level ?? 'N/A' }}{{ $worker->step ? ' / Step ' . $worker->step : '' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Employment Type</span>
                        <p class="text-gray-800">{{ $worker->employment_type?->label() ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Employment Date</span>
                        <p class="text-gray-800">{{ optional($worker->employment_date)->format('d M Y') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Verified On</span>
                        <p class="text-gray-800">{{ optional($worker->verified_at)->format('d M Y') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">LGA</span>
                        <p class="text-gray-800">{{ $worker->lga?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">State</span>
                        <p class="text-gray-800">{{ $worker->state?->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Footer -->
            <div class="mt-6 pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-600">This record is <strong class="text-green-700">active and verified</strong> in the LGA Workforce Identity System.</span>
                </div>
                <p class="text-xs text-gray-400">Verified on {{ optional($worker->verified_at)->format('d M Y \a\t H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('verify.index') }}" class="text-green-700 font-semibold hover:underline text-sm">← Search Again</a>
    </div>
</div>

@endsection
