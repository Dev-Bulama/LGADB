<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name')) — Alimosho Citizen Identity & Verification Platform</title>
    <meta name="description" content="@yield('description', 'Official Alimosho LGA Citizen Identity & Verification Database Platform')">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .gov-gradient { background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%); }
        .gov-gradient-light { background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); }
    </style>
</head>
<body class="h-full bg-gray-50 flex flex-col min-h-screen">

    <!-- Top stripe -->
    <div class="bg-green-900 text-green-200 text-xs py-1 text-center">
        Official Website of {{ $appSettings['lga_name'] ?? 'the Local Government Authority' }} — {{ $appSettings['lga_state'] ?? 'Nigeria' }}
    </div>

    <!-- Navigation -->
    <nav class="gov-gradient shadow-lg sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Brand -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-green-800 font-extrabold text-sm">LGA</span>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-white font-bold text-sm leading-tight">{{ $appSettings['org_name'] ?? config('app.name') }}</div>
                            <div class="text-green-200 text-xs">Citizen Identity & Verification Platform</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop menu -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                       class="text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('home') ? 'bg-green-700 text-white' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('verify.index') }}"
                       class="text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('verify.*') ? 'bg-green-700 text-white' : '' }}">
                        Verify Citizen
                    </a>
                    <a href="{{ route('news') }}"
                       class="text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('news*') ? 'bg-green-700 text-white' : '' }}">
                        News
                    </a>
                    <a href="{{ route('faqs') }}"
                       class="text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('faqs') ? 'bg-green-700 text-white' : '' }}">
                        FAQs
                    </a>
                    <a href="{{ route('contact') }}"
                       class="text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('contact') ? 'bg-green-700 text-white' : '' }}">
                        Contact
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('register') ? 'bg-green-700 text-white' : '' }}">
                        Register
                    </a>
                    @auth
                        <a href="{{ route('portal.dashboard') }}"
                           class="ml-2 bg-white text-green-800 hover:bg-green-50 px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                            My Portal
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="ml-2 bg-white text-green-800 hover:bg-green-50 px-4 py-2 rounded-md text-sm font-semibold transition shadow">
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile hamburger -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-green-100 hover:text-white p-2 rounded-md focus:outline-none">
                        <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div x-show="open" x-cloak class="md:hidden pb-4 border-t border-green-700 pt-3 space-y-1">
                <a href="{{ route('home') }}" class="block text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                <a href="{{ route('verify.index') }}" class="block text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">Verify Citizen</a>
                <a href="{{ route('news') }}" class="block text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">News</a>
                <a href="{{ route('faqs') }}" class="block text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">FAQs</a>
                <a href="{{ route('contact') }}" class="block text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                <a href="{{ route('register') }}" class="block text-green-100 hover:text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">Register</a>
                @auth
                    <a href="{{ route('portal.dashboard') }}" class="block text-green-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">My Portal</a>
                @else
                    <a href="{{ route('login') }}" class="block text-green-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-400 text-green-800 px-4 py-3 rounded-lg flex items-center" role="alert">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-400 text-red-800 px-4 py-3 rounded-lg flex items-center" role="alert">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="gov-gradient mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <span class="text-green-800 font-extrabold text-sm">LGA</span>
                        </div>
                        <h3 class="text-white font-bold text-lg">{{ config('app.name') }}</h3>
                    </div>
                    <p class="text-green-200 text-sm leading-relaxed">
                        Official Citizen Identity &amp; Verification Database Platform for Alimosho Local Government Authority, Lagos State, Nigeria.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('verify.index') }}" class="text-green-200 hover:text-white transition">→ Verify Citizen</a></li>
                        <li><a href="{{ route('news') }}" class="text-green-200 hover:text-white transition">→ News &amp; Updates</a></li>
                        <li><a href="{{ route('faqs') }}" class="text-green-200 hover:text-white transition">→ FAQs</a></li>
                        <li><a href="{{ route('contact') }}" class="text-green-200 hover:text-white transition">→ Contact Us</a></li>
                        <li><a href="{{ route('about') }}" class="text-green-200 hover:text-white transition">→ About</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4 text-sm uppercase tracking-wider">Contact</h3>
                    <ul class="space-y-2 text-sm text-green-200">
                        <li class="flex items-start space-x-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ config('lga.address') }}</span>
                        </li>
                        @if(config('lga.phone'))
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ config('lga.phone') }}</span>
                        </li>
                        @endif
                        @if(config('lga.email'))
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ config('lga.email') }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="border-t border-green-700 mt-8 pt-8 flex flex-col sm:flex-row justify-between items-center text-green-300 text-xs gap-2">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p>Government of Nigeria &bull; Federal Republic of Nigeria</p>
            </div>
        </div>
    </footer>

</body>
</html>
