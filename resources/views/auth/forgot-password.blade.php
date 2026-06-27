@extends('layouts.public')

@section('title', 'Forgot Password')
@section('description', 'Reset your LGA Worker Portal password.')

@section('content')

<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6">

        <div class="text-center">
            <div class="w-16 h-16 gov-gradient rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900">Forgot Password?</h1>
            <p class="text-gray-500 text-sm mt-2">Enter your email and we'll send you a reset link.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if(session('status'))
                <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-5 text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           required autofocus
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition @error('email') border-red-400 bg-red-50 @enderror"
                           placeholder="your.email@lga.gov.ng">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full gov-gradient text-white font-bold py-3 rounded-xl hover:opacity-90 transition text-sm">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-5 text-center">
                <a href="{{ route('login') }}" class="text-sm text-green-700 hover:underline font-medium">
                    ← Back to Login
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
