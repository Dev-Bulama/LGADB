@extends('layouts.public')

@section('title', 'Reset Password')
@section('description', 'Set a new password for your Alimosho LGA Citizen Portal account.')

@section('content')

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6">

        <div class="text-center">
            <div class="w-16 h-16 gov-gradient rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900">Reset Your Password</h1>
            <p class="text-gray-500 text-sm mt-2">Choose a strong new password for your account.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $request->email) }}"
                           required autofocus autocomplete="email"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('email') border-red-400 bg-red-50 @enderror"
                           placeholder="your.email@lga.gov.ng">
                </div>

                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'"
                               id="password" name="password"
                               required autocomplete="new-password"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-11 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('password') border-red-400 bg-red-50 @enderror"
                               placeholder="Minimum 8 characters">
                        <button type="button" @click="show = !show"
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

                <div x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'"
                               id="password_confirmation" name="password_confirmation"
                               required autocomplete="new-password"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-11 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                               placeholder="Repeat your new password">
                        <button type="button" @click="show = !show"
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

                <button type="submit"
                        class="w-full gov-gradient text-white font-bold py-3 rounded-xl hover:opacity-90 transition text-sm">
                    Reset Password
                </button>

            </form>

            <div class="mt-5 text-center">
                <a href="{{ route('login') }}" class="text-sm text-green-700 hover:underline font-medium">← Back to Login</a>
            </div>
        </div>

    </div>
</div>

@endsection
