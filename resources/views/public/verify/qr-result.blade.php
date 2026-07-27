@extends('layouts.public')

@section('title', $worker ? 'QR Verification — ' . $worker->full_name : 'QR Verification Failed')

@section('content')

<div class="gov-gradient py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
        <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
            </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white">QR Code Verification</h1>
        <p class="text-green-100 mt-2 text-sm">Scanned from citizen ID card</p>
    </div>
</div>

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    @if($worker)

        <div class="bg-green-50 border border-green-200 rounded-xl px-5 py-3 flex items-center mb-6">
            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-green-800 font-semibold">QR Code is Valid — Verified LGA Citizen</p>
                <p class="text-green-700 text-sm">This ID card belongs to a verified and approved citizen of Ayobo Ipaja LCDA.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="gov-gradient px-6 py-3">
                <span class="text-white font-semibold text-sm">VERIFIED CITIZEN IDENTITY</span>
            </div>
            <div class="p-6 flex flex-col sm:flex-row gap-6 items-start">
                @if($worker->profile_photo_url)
                    <img src="{{ $worker->profile_photo_url }}" alt="{{ $worker->full_name }}"
                         class="w-24 h-24 object-cover rounded-xl border-4 border-green-100 flex-shrink-0">
                @else
                    <div class="w-24 h-24 bg-green-50 rounded-xl border-4 border-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-12 h-12 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1">
                    <h2 class="text-2xl font-extrabold text-gray-900">{{ $worker->full_name }}</h2>
                    <p class="text-green-700 font-medium mb-3">{{ $worker->designation ?? 'Ayobo Ipaja LCDA Citizen' }}</p>
                    <dl class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <dt class="text-gray-400 text-xs uppercase font-semibold">Citizen ID</dt>
                            <dd class="font-mono font-bold text-gray-800">{{ $worker->staff_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-400 text-xs uppercase font-semibold">Department</dt>
                            <dd class="text-gray-800">{{ $worker->department?->name ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-400 text-xs uppercase font-semibold">Verification Code</dt>
                            <dd class="font-mono text-green-700 font-bold tracking-wider">{{ $worker->verification_code }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-400 text-xs uppercase font-semibold">Status</dt>
                            <dd class="text-green-700 font-semibold">✓ Approved</dd>
                        </div>
                    </dl>
                    <a href="{{ route('verify.show', $worker->verification_code) }}"
                       class="inline-block mt-4 text-green-700 text-sm font-semibold hover:underline">
                        View Full Details →
                    </a>
                </div>
            </div>
        </div>

    @else

        <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-3 flex items-center mb-6">
            <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-red-800 font-semibold">Invalid or Unrecognised QR Code</p>
                <p class="text-red-700 text-sm">This QR code does not match any verified citizen record in our system.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow border border-gray-100 p-8 text-center">
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">QR Code Not Valid</h2>
            <p class="text-gray-500 text-sm max-w-sm mx-auto mb-2">
                The scanned QR code (hash: <code class="text-xs bg-gray-100 px-1 rounded">{{ isset($hash) ? substr($hash, 0, 16) : '...' }}...</code>) does not correspond to any approved citizen.
            </p>
            <p class="text-red-600 text-sm font-medium mb-6">This may indicate a fraudulent or tampered ID card.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('verify.index') }}" class="inline-flex items-center justify-center bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-green-800 transition text-sm">
                    Manual Verification
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center border border-red-300 text-red-700 font-semibold px-5 py-2.5 rounded-lg hover:bg-red-50 transition text-sm">
                    Report Fraud
                </a>
            </div>
        </div>

    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('verify.index') }}" class="text-green-700 font-semibold hover:underline text-sm">← Back to Verification Portal</a>
    </div>
</div>

@endsection
