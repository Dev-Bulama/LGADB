@extends('layouts.public')

@section('title', 'Verification Result')

@section('content')

<div class="gov-gradient py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">Verification Result</h1>
        <p class="text-green-100">Search query: <strong>{{ $query ?? '' }}</strong></p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

    @if($worker)

        <!-- Success - Worker Found -->
        <div class="bg-green-50 border border-green-200 rounded-xl px-5 py-3 flex items-center mb-6">
            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-green-800 font-semibold">Verified Staff Record Found</p>
                <p class="text-green-700 text-sm">This staff member is a verified and approved LGA worker.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header bar -->
            <div class="gov-gradient px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <span class="text-white font-bold">VERIFIED STAFF RECORD</span>
                </div>
                <span class="bg-green-400 text-green-900 text-xs font-bold px-3 py-1 rounded-full uppercase">✓ Approved</span>
            </div>

            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6">
                    <!-- Photo -->
                    <div class="flex-shrink-0">
                        @if($worker->profile_photo_url)
                            <img src="{{ $worker->profile_photo_url }}" alt="{{ $worker->full_name }}"
                                 class="w-28 h-28 object-cover rounded-xl border-4 border-green-100 shadow">
                        @else
                            <div class="w-28 h-28 bg-green-100 rounded-xl border-4 border-green-200 flex items-center justify-center">
                                <svg class="w-14 h-14 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-1">{{ $worker->full_name }}</h2>
                        <p class="text-green-700 font-semibold mb-3">{{ $worker->designation ?? 'Staff Member' }}</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-400 text-xs uppercase font-semibold">Staff Number</span>
                                <p class="text-gray-800 font-mono font-bold">{{ $worker->staff_number }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs uppercase font-semibold">Department</span>
                                <p class="text-gray-800">{{ $worker->department?->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs uppercase font-semibold">Unit / Office</span>
                                <p class="text-gray-800">{{ $worker->unit?->name ?? $worker->office?->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs uppercase font-semibold">Employment Type</span>
                                <p class="text-gray-800">{{ $worker->employment_type?->label() ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs uppercase font-semibold">Grade Level</span>
                                <p class="text-gray-800">{{ $worker->grade_level ?? 'N/A' }}{{ $worker->step ? ' / Step ' . $worker->step : '' }}</p>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs uppercase font-semibold">Verified On</span>
                                <p class="text-gray-800">{{ optional($worker->verified_at)->format('d M Y') ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verification Code -->
                <div class="mt-5 bg-gray-50 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">Verification Code</span>
                        <p class="font-mono font-bold text-green-700 text-lg tracking-widest">{{ $worker->verification_code }}</p>
                    </div>
                    <a href="{{ route('verify.show', $worker->verification_code) }}"
                       class="text-sm text-green-700 font-semibold hover:underline">
                        Full Details →
                    </a>
                </div>
            </div>
        </div>

    @else

        <!-- Not Found -->
        <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-3 flex items-center mb-6">
            <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-red-800 font-semibold">No Verified Staff Record Found</p>
                <p class="text-red-700 text-sm">The search query "<strong>{{ $query ?? '' }}</strong>" did not match any approved staff records.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow border border-gray-100 p-8 text-center">
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">No Record Found</h2>
            <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">
                No verified LGA staff member matched your search. Please check the information and try again.
                If you believe this is an error, please contact the LGA office.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('verify.index') }}"
                   class="inline-flex items-center justify-center bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-green-800 transition text-sm">
                    Try Another Search
                </a>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center justify-center border border-gray-300 text-gray-700 font-semibold px-5 py-2.5 rounded-lg hover:bg-gray-50 transition text-sm">
                    Contact Us
                </a>
            </div>
        </div>

    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('verify.index') }}" class="text-green-700 font-semibold hover:underline text-sm">
            ← Back to Verification Portal
        </a>
    </div>
</div>

@endsection
