@extends('layouts.public')

@section('title', 'Home')
@section('description', 'Official Ayobo Ipaja LCDA Citizen Identity & Verification Platform — verify citizens, access your portal.')

@section('content')

<!-- Hero Section -->
<section class="gov-gradient text-white relative overflow-hidden" x-data="homeSearch()">
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-10 left-10 w-40 h-40 rounded-full bg-white"></div>
        <div class="absolute bottom-10 right-10 w-60 h-60 rounded-full bg-white"></div>
        <div class="absolute top-1/2 left-1/3 w-20 h-20 rounded-full bg-white"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative text-center">

        <!-- Badge -->
        <div class="inline-flex items-center bg-green-700 bg-opacity-60 text-green-100 text-xs font-semibold px-3 py-1 rounded-full mb-5 uppercase tracking-wide">
            Official Government System
        </div>

        <!-- Title -->
        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight mb-3">
            Citizen Identity &amp;<br>
            <span class="text-green-200">Verification Platform</span>
        </h1>
        <p class="text-green-100 text-base sm:text-lg mb-10 max-w-2xl mx-auto">
            The official platform for registering, verifying, and authenticating the identity of every citizen and resident of {{ $appSettings['lga_name'] ?? 'Ayobo Ipaja LCDA' }}.
        </p>

        <!-- Google-style search bar -->
        <form action="{{ route('verify.search') }}" method="POST" class="w-full max-w-2xl mx-auto">
            @csrf
            <input type="hidden" name="type" x-model="selectedType">

            <div class="relative flex items-center bg-white rounded-full shadow-2xl px-5 py-3.5">
                <!-- Search icon -->
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <!-- Input -->
                <input
                    type="text"
                    name="query"
                    id="home-query"
                    required
                    minlength="2"
                    maxlength="200"
                    autocomplete="off"
                    x-model="query"
                    @input="autoDetect()"
                    placeholder="Search by name, Citizen ID, NIN, email, phone or verification code…"
                    class="flex-1 mx-3 text-base text-gray-700 placeholder-gray-400 bg-transparent focus:outline-none"
                />

                <!-- Type badge -->
                <span
                    x-show="query.length >= 2"
                    x-cloak
                    x-text="typeLabel"
                    class="hidden sm:inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 flex-shrink-0 mr-2"
                ></span>

                <!-- Clear -->
                <button
                    type="button"
                    x-show="query.length > 0"
                    x-cloak
                    @click="query = ''; selectedType = ''; $nextTick(() => document.getElementById('home-query').focus())"
                    class="text-gray-400 hover:text-gray-600 flex-shrink-0 mr-2"
                    aria-label="Clear"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <span class="border-l border-gray-300 h-5 mx-1"></span>

                <!-- Submit -->
                <button type="submit" class="ml-2 bg-green-700 hover:bg-green-800 text-white text-sm font-semibold px-5 py-2 rounded-full transition flex-shrink-0">
                    Search
                </button>
            </div>

            <!-- Type chips -->
            <div class="flex flex-wrap gap-2 justify-center mt-4">
                <template x-for="chip in typeChips" :key="chip.value">
                    <button
                        type="button"
                        @click="selectedType = (selectedType === chip.value ? '' : chip.value)"
                        :class="selectedType === chip.value
                            ? 'bg-white text-green-800 border-white'
                            : 'bg-transparent text-green-200 border-green-500 hover:border-white hover:text-white'"
                        class="px-3 py-1 rounded-full border text-xs font-medium transition"
                        x-text="chip.label"
                    ></button>
                </template>
            </div>
        </form>

        <!-- CTA links below search -->
        <div class="flex flex-wrap items-center justify-center gap-4 mt-8 text-sm">
            <a href="{{ route('verify.index') }}" class="text-green-200 hover:text-white transition underline underline-offset-2">
                Advanced Search
            </a>
            <span class="text-green-500">|</span>
            <a href="{{ route('register') }}" class="bg-white text-green-800 font-semibold px-4 py-1.5 rounded-full hover:bg-green-50 transition shadow">
                Register as Citizen
            </a>
            <span class="text-green-500">|</span>
            @auth
                <a href="{{ route('portal.dashboard') }}" class="text-green-200 hover:text-white transition underline underline-offset-2">
                    My Portal
                </a>
            @else
                <a href="{{ route('login') }}" class="text-green-200 hover:text-white transition underline underline-offset-2">
                    Citizen Login
                </a>
            @endauth
        </div>
    </div>
</section>

<script>
function homeSearch() {
    return {
        query: '',
        selectedType: '',
        typeChips: [
            { value: 'staff_number',      label: 'Citizen ID' },
            { value: 'verification_code', label: 'Verif. Code' },
            { value: 'surname',           label: 'Surname' },
            { value: 'full_name',         label: 'Full Name' },
            { value: 'email',             label: 'Email' },
            { value: 'phone',             label: 'Phone' },
            { value: 'national_id',       label: 'NIN' },
        ],
        get typeLabel() {
            if (this.selectedType) {
                const chip = this.typeChips.find(c => c.value === this.selectedType);
                return (chip ? chip.label : this.selectedType) + ' ✓';
            }
            const detected = this.detectType(this.query);
            const chip = this.typeChips.find(c => c.value === detected);
            return chip ? chip.label : detected;
        },
        autoDetect() {},
        detectType(q) {
            q = q.trim();
            if (!q) return 'auto';
            if (/^[A-Za-z]{2,5}\/\d{4}\/\d{4,6}$/.test(q)) return 'staff_number';
            if (/^[A-Za-z0-9]{10}$/.test(q) && !q.includes(' ')) return 'verification_code';
            if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(q)) return 'email';
            if (/^[\+]?[\d\s\-]{7,15}$/.test(q)) return 'phone';
            if (/^\d{11}$/.test(q)) return 'national_id';
            if (!q.includes(' ')) return 'surname';
            return 'full_name';
        },
    }
}
</script>

<!-- Stats Section -->
<section class="bg-white py-12 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-4">
                <div class="text-3xl font-extrabold text-green-700 mb-1">{{ \App\Models\Worker::verified()->count() }}</div>
                <div class="text-gray-500 text-sm font-medium">Verified Citizens</div>
            </div>
            <div class="p-4">
                <div class="text-3xl font-extrabold text-green-700 mb-1">{{ \App\Models\Department::count() }}</div>
                <div class="text-gray-500 text-sm font-medium">Departments</div>
            </div>
            <div class="p-4">
                <div class="text-3xl font-extrabold text-green-700 mb-1">{{ \App\Models\Worker::count() }}</div>
                <div class="text-gray-500 text-sm font-medium">Total Registered</div>
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
            <p class="text-gray-500 max-w-2xl mx-auto">A comprehensive digital platform to register, manage, verify and authenticate the identity of every citizen and resident of Ayobo Ipaja LCDA.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Citizen Verification</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Instantly verify any Ayobo Ipaja LCDA citizen or resident by Citizen ID, full name, NIN, phone, or verification code. Get real-time results.</p>
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
                <p class="text-gray-500 text-sm leading-relaxed">Citizens can download their official digital Resident ID cards with a unique QR code for instant on-the-spot verification.</p>
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
                <p class="text-gray-500 text-sm leading-relaxed">Complete, verified citizen records — addresses, household data, and identity documents — all in one secure, auditable system.</p>
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
                <p class="text-gray-500">Stay up to date with LGA citizen services and announcements.</p>
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
        <h2 class="text-3xl font-extrabold text-white mb-4">Are You a Registered Citizen?</h2>
        <p class="text-green-100 text-lg mb-8">Log in to your citizen portal to download your ID card, update your profile, and access your registration records.</p>
        <a href="{{ route('login') }}"
           class="inline-flex items-center bg-white text-green-800 font-bold px-8 py-3 rounded-lg hover:bg-green-50 transition shadow-lg text-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Access Citizen Portal
        </a>
    </div>
</section>

@endsection
