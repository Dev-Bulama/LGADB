@extends('layouts.public')

@section('title', 'Home')
@section('description', 'Official LGA Workforce Identity & Verification Management System — verify staff, access worker portal.')

@section('content')

<!-- Hero Section -->
<section class="gov-gradient text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-40 h-40 rounded-full bg-white"></div>
        <div class="absolute bottom-10 right-10 w-60 h-60 rounded-full bg-white"></div>
        <div class="absolute top-1/2 left-1/3 w-20 h-20 rounded-full bg-white"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center bg-green-700 bg-opacity-60 text-green-100 text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-wide">
                    Official Government System
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight mb-4">
                    Workforce Identity &amp;<br>
                    <span class="text-green-200">Verification System</span>
                </h1>
                <p class="text-green-100 text-lg leading-relaxed mb-8">
                    The official platform for verifying LGA workforce identities, managing staff records, and ensuring transparency in local government operations.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('verify.index') }}"
                       class="inline-flex items-center justify-center bg-white text-green-800 font-bold px-6 py-3 rounded-lg hover:bg-green-50 transition shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Verify a Staff Member
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center border-2 border-white text-white font-bold px-6 py-3 rounded-lg hover:bg-green-700 transition">
                        Worker Login
                    </a>
                </div>
            </div>

            <!-- Quick Verify Form -->
            <div class="bg-white bg-opacity-10 backdrop-blur-sm border border-white border-opacity-20 rounded-2xl p-6">
                <h2 class="text-white font-bold text-xl mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Quick Staff Verification
                </h2>
                <form action="{{ route('verify.search') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-green-100 text-sm font-medium mb-1">Search By</label>
                        <select name="type"
                                class="w-full bg-white bg-opacity-20 border border-white border-opacity-30 text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-white placeholder-green-200">
                            <option value="staff_number" class="text-gray-800">Staff Number</option>
                            <option value="verification_code" class="text-gray-800">Verification Code</option>
                            <option value="surname" class="text-gray-800">Surname</option>
                            <option value="full_name" class="text-gray-800">Full Name</option>
                            <option value="phone" class="text-gray-800">Phone Number</option>
                            <option value="email" class="text-gray-800">Email Address</option>
                            <option value="national_id" class="text-gray-800">National ID (NIN)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-green-100 text-sm font-medium mb-1">Search Query</label>
                        <input type="text" name="query" required minlength="2"
                               placeholder="Enter staff number, name, etc."
                               class="w-full bg-white bg-opacity-20 border border-white border-opacity-30 text-white placeholder-green-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-white">
                    </div>
                    <button type="submit"
                            class="w-full bg-white text-green-800 font-bold py-2.5 rounded-lg hover:bg-green-50 transition text-sm">
                        Search Staff Records
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-white py-12 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-4">
                <div class="text-3xl font-extrabold text-green-700 mb-1">{{ \App\Models\Worker::verified()->count() }}</div>
                <div class="text-gray-500 text-sm font-medium">Verified Staff</div>
            </div>
            <div class="p-4">
                <div class="text-3xl font-extrabold text-green-700 mb-1">{{ \App\Models\Department::count() }}</div>
                <div class="text-gray-500 text-sm font-medium">Departments</div>
            </div>
            <div class="p-4">
                <div class="text-3xl font-extrabold text-green-700 mb-1">{{ \App\Models\Worker::count() }}</div>
                <div class="text-gray-500 text-sm font-medium">Total Workers</div>
            </div>
            <div class="p-4">
                <div class="text-3xl font-extrabold text-green-700 mb-1">{{ \App\Models\VerificationLog::count() }}</div>
                <div class="text-gray-500 text-sm font-medium">Verifications Done</div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-3">System Features</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">A comprehensive digital platform to manage, verify, and authenticate Local Government workforce identities.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Staff Verification</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Instantly verify any LGA staff member by staff number, name, NIN, or unique verification code. Get real-time status updates.</p>
                <a href="{{ route('verify.index') }}" class="inline-block mt-4 text-green-700 font-semibold text-sm hover:underline">Verify Now →</a>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Digital ID Cards</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Workers can download their official digital ID cards with QR code for instant verification. ID cards are issued after approval.</p>
                <a href="{{ route('login') }}" class="inline-block mt-4 text-green-700 font-semibold text-sm hover:underline">Access Portal →</a>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Transparent Records</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Full employment history, department assignments, and document management in one secure system.</p>
                <a href="{{ route('about') }}" class="inline-block mt-4 text-green-700 font-semibold text-sm hover:underline">Learn More →</a>
            </div>
        </div>
    </div>
</section>

<!-- Announcements Section -->
@if($announcements->count())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-1">Latest News &amp; Announcements</h2>
                <p class="text-gray-500">Stay up to date with LGA workforce updates.</p>
            </div>
            <a href="{{ route('news') }}" class="hidden sm:inline-flex items-center text-green-700 font-semibold hover:underline">
                View All News →
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($announcements as $announcement)
            <article class="bg-gray-50 rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition group">
                <div class="p-5">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full uppercase">
                            {{ $announcement->type ?? 'Announcement' }}
                        </span>
                        <span class="text-gray-400 text-xs">
                            {{ optional($announcement->published_at)->format('d M Y') }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2 group-hover:text-green-700 transition line-clamp-2">
                        <a href="{{ route('news.show', $announcement->slug) }}">{{ $announcement->title }}</a>
                    </h3>
                    <p class="text-gray-500 text-sm line-clamp-3">
                        {{ $announcement->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($announcement->content ?? ''), 120) }}
                    </p>
                    <a href="{{ route('news.show', $announcement->slug) }}"
                       class="inline-block mt-3 text-green-700 text-sm font-semibold hover:underline">
                        Read More →
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        <div class="text-center mt-8 sm:hidden">
            <a href="{{ route('news') }}" class="text-green-700 font-semibold hover:underline">View All News →</a>
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="gov-gradient py-16">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-extrabold text-white mb-4">Are You an LGA Worker?</h2>
        <p class="text-green-100 text-lg mb-8">Log in to your worker portal to download your ID card, update your profile, and access your employment records.</p>
        <a href="{{ route('login') }}"
           class="inline-flex items-center bg-white text-green-800 font-bold px-8 py-3 rounded-lg hover:bg-green-50 transition shadow-lg text-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Access Worker Portal
        </a>
    </div>
</section>

@endsection
