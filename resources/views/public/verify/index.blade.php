@extends('layouts.public')

@section('title', 'Staff Verification Portal')
@section('description', 'Verify the identity of any LGA workforce member using their staff number, name, or verification code.')

@section('content')

<!-- Page Header -->
<div class="gov-gradient py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Staff Verification Portal</h1>
        <p class="text-green-100 text-lg max-w-2xl mx-auto">
            Verify the authenticity of any LGA workforce member using multiple search criteria. Results show only officially approved staff records.
        </p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Search Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-green-50 border-b border-green-100 px-6 py-4">
            <h2 class="font-bold text-green-800 text-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Search Staff Records
            </h2>
            <p class="text-green-700 text-sm mt-1">Only verified and approved staff members appear in search results.</p>
        </div>

        <form action="{{ route('verify.search') }}" method="POST" class="p-6 space-y-5">
            @csrf

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 text-red-700 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="type" class="block text-sm font-semibold text-gray-700 mb-1.5">Search By</label>
                <select id="type" name="type"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                    <option value="staff_number">Staff Number (e.g. LGA/2024/00001)</option>
                    <option value="verification_code">Verification Code (10-character code)</option>
                    <option value="surname">Surname / Last Name</option>
                    <option value="full_name">Full Name</option>
                    <option value="phone">Phone Number</option>
                    <option value="email">Email Address</option>
                    <option value="national_id">National ID Number (NIN)</option>
                </select>
            </div>

            <div>
                <label for="query" class="block text-sm font-semibold text-gray-700 mb-1.5">Search Query</label>
                <input type="text" id="query" name="query" required minlength="2"
                       placeholder="Enter value to search..."
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <button type="submit"
                    class="w-full gov-gradient text-white font-bold py-3 px-6 rounded-lg hover:opacity-90 transition flex items-center justify-center space-x-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Search Staff Records</span>
            </button>
        </form>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Who can be verified?</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Only LGA staff members whose records have been reviewed and officially approved appear in the verification system.</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">QR Code Verification</h3>
            <p class="text-gray-500 text-xs leading-relaxed">You can also scan the QR code on a staff member's ID card for instant verification directly from your mobile device.</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Privacy & Security</h3>
            <p class="text-gray-500 text-xs leading-relaxed">All verification searches are logged for security purposes. Misuse of this system is prohibited and may result in legal action.</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Report Fraudulent IDs</h3>
            <p class="text-gray-500 text-xs leading-relaxed">If you suspect a fraudulent staff ID, contact the LGA office immediately at <a href="{{ route('contact') }}" class="text-green-600 hover:underline">our contact page</a>.</p>
        </div>
    </div>
</div>

@endsection
