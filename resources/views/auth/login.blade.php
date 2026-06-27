@extends('layouts.public')

@section('title', 'Worker Login')
@section('description', 'Secure login portal for LGA staff members.')

@section('content')

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6">

        {{-- Header Branding --}}
        <div class="text-center">
            <div class="w-16 h-16 gov-gradient rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <span class="text-white font-extrabold text-lg">LGA</span>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900">Worker Portal</h1>
            <p class="text-gray-500 text-sm mt-2">{{ config('app.name') }}</p>
        </div>

        {{-- Notice --}}
        <div class="bg-green-50 border border-green-200 rounded-xl p-3 text-center">
            <p class="text-green-800 text-xs font-semibold">
                This portal is for authorised LGA staff members only.
            </p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Sign In to Your Account</h2>

            {{-- Session Error --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Email Address
                    </label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="email"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('email') border-red-400 bg-red-50 @enderror"
                           placeholder="your.email@lga.gov.ng">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'"
                               id="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-11 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('password') border-red-400 bg-red-50 @enderror"
                               placeholder="Enter your password">
                        <button type="button"
                                @click="show = !show"
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-green-600 focus:ring-green-500 h-4 w-4">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-green-700 hover:underline font-medium">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full gov-gradient text-white font-bold py-3 rounded-xl hover:opacity-90 transition shadow-sm text-sm">
                    Sign In
                </button>

            </form>
        </div>

        <div class="text-center space-y-2">
            <p class="text-sm text-gray-600">
                New staff member?
                <a href="{{ route('register') }}" class="text-green-700 font-semibold hover:underline">Register here</a>
            </p>
            <p class="text-xs text-gray-400">
                Having trouble? <a href="{{ route('contact') }}" class="text-green-700 font-semibold hover:underline">Contact Support</a>
            </p>
        </div>

    </div>
</div>

@endsection
