@extends('layouts.public')

@section('title', 'Contact Us')
@section('description', 'Get in touch with the Alimosho LGA Citizen Identity & Verification Platform team.')

@section('content')

<div class="gov-gradient py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Contact Us</h1>
        <p class="text-green-100 text-lg">We're here to help. Reach out with any enquiries or concerns.</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Contact Info -->
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-1 text-sm">Office Address</h3>
                <p class="text-gray-500 text-sm">{{ config('lga.address') }}</p>
            </div>

            @if(config('lga.phone'))
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-1 text-sm">Phone Number</h3>
                <a href="tel:{{ config('lga.phone') }}" class="text-green-700 text-sm hover:underline">{{ config('lga.phone') }}</a>
            </div>
            @endif

            @if(config('lga.email'))
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-1 text-sm">Email Address</h3>
                <a href="mailto:{{ config('lga.email') }}" class="text-green-700 text-sm hover:underline">{{ config('lga.email') }}</a>
            </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-1 text-sm">Office Hours</h3>
                <p class="text-gray-500 text-sm">Monday – Friday<br>8:00 AM – 4:00 PM</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-green-50 border-b border-green-100 px-6 py-4">
                    <h2 class="font-bold text-green-800 text-lg">Send Us a Message</h2>
                    <p class="text-green-700 text-sm mt-0.5">We typically respond within 1-2 business days.</p>
                </div>
                @if(session('success'))
                    <div class="mx-6 mt-6 bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                <form class="p-6 space-y-4" action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Your full name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number</label>
                            <input type="tel" name="phone"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Your phone number">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="your@email.com">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Subject <span class="text-red-500">*</span></label>
                        <select name="subject"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select a subject</option>
                            <option value="verification">Citizen Verification Enquiry</option>
                            <option value="id_card">ID Card Issue</option>
                            <option value="portal">Citizen Portal Access</option>
                            <option value="fraud">Report Fraudulent ID</option>
                            <option value="general">General Enquiry</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Message <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"
                                  placeholder="Describe your enquiry in detail..."></textarea>
                    </div>
                    <button type="submit"
                            class="w-full gov-gradient text-white font-bold py-3 rounded-lg hover:opacity-90 transition text-sm">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
