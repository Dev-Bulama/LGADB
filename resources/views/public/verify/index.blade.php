<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Verification — {{ $appSettings['org_name'] ?? config('app.name') }}</title>
    <meta name="description" content="Verify the identity of any LGA workforce member using their Citizen ID, name, verification code, email, phone, or NIN.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .gov-gradient { background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%); }
        body { font-family: arial, sans-serif; }
    </style>
</head>
<body class="h-full bg-white flex flex-col min-h-screen" x-data="verifyApp()">

    <!-- Slim top nav -->
    <nav class="border-b border-gray-200 px-4 py-3 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-green-800 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-white font-extrabold text-xs">LGA</span>
            </div>
            <span class="text-gray-700 text-sm font-medium hidden sm:inline">{{ $appSettings['org_name'] ?? config('app.name') }}</span>
        </a>
        <div class="flex items-center space-x-4 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-green-700 transition">Home</a>
            <a href="{{ route('news') }}" class="hover:text-green-700 transition">News</a>
            <a href="{{ route('faqs') }}" class="hover:text-green-700 transition">FAQs</a>
            <a href="{{ route('contact') }}" class="hover:text-green-700 transition">Contact</a>
            @auth
                <a href="{{ route('portal.dashboard') }}" class="bg-green-700 text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-green-800 transition">My Portal</a>
            @else
                <a href="{{ route('login') }}" class="border border-green-700 text-green-700 px-3 py-1.5 rounded text-xs font-semibold hover:bg-green-50 transition">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Main centered content -->
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-8">

        <!-- Shield icon + title -->
        <div class="mb-6 text-center">
            <div class="w-16 h-16 bg-green-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-normal text-gray-800">Citizen Verification</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $appSettings['org_name'] ?? config('app.name') }}</p>
        </div>

        @if($errors->any())
            <div class="w-full max-w-xl mb-4 bg-red-50 border border-red-200 rounded-lg px-4 py-3 text-red-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Search form -->
        <form action="{{ route('verify.search') }}" method="POST" class="w-full max-w-xl">
            @csrf
            <input type="hidden" name="type" x-model="selectedType">

            <!-- Big Google-style search bar -->
            <div class="relative flex items-center border border-gray-300 rounded-full shadow-md hover:shadow-lg focus-within:shadow-lg transition-shadow bg-white px-5 py-3.5">

                <!-- Search icon -->
                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <!-- Input -->
                <input
                    type="text"
                    name="query"
                    id="query"
                    required
                    minlength="2"
                    maxlength="200"
                    autocomplete="off"
                    x-model="query"
                    @input="autoDetect()"
                    placeholder="Search by name, Citizen ID, code, email, phone or NIN…"
                    class="flex-1 mx-3 text-base text-gray-700 placeholder-gray-400 bg-transparent focus:outline-none"
                />

                <!-- Detected type badge -->
                <span
                    x-show="query.length >= 2"
                    x-cloak
                    x-text="typeLabel"
                    class="hidden sm:inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 flex-shrink-0 mr-2"
                ></span>

                <!-- Clear button -->
                <button
                    type="button"
                    x-show="query.length > 0"
                    x-cloak
                    @click="query = ''; selectedType = ''; $nextTick(() => document.getElementById('query').focus())"
                    class="text-gray-400 hover:text-gray-600 flex-shrink-0 mr-2"
                    aria-label="Clear"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Divider -->
                <span class="text-gray-200 border-l border-gray-300 h-5 mx-1"></span>

                <!-- Submit button -->
                <button type="submit" class="ml-2 bg-green-700 hover:bg-green-800 text-white text-sm font-medium px-4 py-1.5 rounded-full transition flex-shrink-0">
                    Search
                </button>
            </div>

            <!-- Type override chips -->
            <div class="flex flex-wrap gap-2 justify-center mt-4">
                <template x-for="chip in typeChips" :key="chip.value">
                    <button
                        type="button"
                        @click="selectedType = (selectedType === chip.value ? '' : chip.value)"
                        :class="selectedType === chip.value
                            ? 'bg-green-700 text-white border-green-700'
                            : 'bg-white text-gray-600 border-gray-300 hover:border-green-400 hover:text-green-700'"
                        class="px-3 py-1 rounded-full border text-xs font-medium transition"
                        x-text="chip.label"
                    ></button>
                </template>
            </div>
        </form>

        <!-- Info pills -->
        <div class="flex flex-wrap gap-3 justify-center mt-10 text-xs text-gray-500">
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Verified citizens only
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                QR code supported
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Searches are logged
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                No private data shown
            </span>
        </div>

        <p class="text-xs text-gray-400 mt-4 text-center max-w-sm">
            {{ $appSettings['verification_public_message'] ?? 'Enter any identifier to verify an LGA citizen or resident. Only officially approved records are returned.' }}
        </p>
    </main>

    <!-- Slim footer -->
    <footer class="border-t border-gray-200 py-4 px-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} {{ $appSettings['org_name'] ?? config('app.name') }}
        &nbsp;&bull;&nbsp;
        <a href="{{ route('verify.index') }}" class="hover:text-gray-600">Verify Staff</a>
        &nbsp;&bull;&nbsp;
        <a href="{{ route('faqs') }}" class="hover:text-gray-600">FAQs</a>
        &nbsp;&bull;&nbsp;
        <a href="{{ route('contact') }}" class="hover:text-gray-600">Contact</a>
        &nbsp;&bull;&nbsp;
        <a href="{{ route('about') }}" class="hover:text-gray-600">About</a>
    </footer>

<script>
function verifyApp() {
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
        autoDetect() {
            if (!this.selectedType) {
                // auto mode — no action needed, typeLabel getter handles it
            }
        },
        detectType(q) {
            q = q.trim();
            if (!q) return 'auto';
            // Staff number: LGA/YYYY/NNNNN
            if (/^[A-Za-z]{2,5}\/\d{4}\/\d{4,6}$/.test(q)) return 'staff_number';
            // Verification code: exactly 10 uppercase alphanum chars, no spaces
            if (/^[A-Za-z0-9]{10}$/.test(q) && !q.includes(' ')) return 'verification_code';
            // Email
            if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(q)) return 'email';
            // Phone
            if (/^[\+]?[\d\s\-]{7,15}$/.test(q)) return 'phone';
            // NIN: 11 digits
            if (/^\d{11}$/.test(q)) return 'national_id';
            // Single word → surname
            if (!q.includes(' ')) return 'surname';
            return 'full_name';
        },
    }
}
</script>
</body>
</html>
