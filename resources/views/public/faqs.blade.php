@extends('layouts.public')

@section('title', 'Frequently Asked Questions')
@section('description', 'Answers to common questions about the Alimosho LGA Citizen Identity & Verification Platform.')

@section('content')

<div class="gov-gradient py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">Frequently Asked Questions</h1>
        <p class="text-green-100 text-lg">Find answers to common questions about the Alimosho Citizen Identity & Verification Platform.</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @if($faqs->isEmpty())
        <div class="text-center py-16">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-gray-500">No FAQs available at the moment. Please check back later.</p>
        </div>
    @else
        <div class="space-y-8">
            @foreach($faqs as $category => $items)
            <div>
                @if($category)
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="w-2 h-6 bg-green-600 rounded-full mr-3 flex-shrink-0"></span>
                    {{ $category }}
                </h2>
                @endif
                <div class="space-y-3" x-data="{ open: null }">
                    @foreach($items as $index => $faq)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                            class="w-full text-left px-5 py-4 flex items-center justify-between focus:outline-none hover:bg-gray-50 transition">
                            <span class="font-semibold text-gray-800 pr-4 text-sm">{{ $faq->question }}</span>
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 transition-transform duration-200"
                                 :class="open === {{ $index }} ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open === {{ $index }}"
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="px-5 pb-4 border-t border-gray-50">
                            <p class="text-gray-600 text-sm leading-relaxed pt-3">{{ $faq->answer }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Contact Prompt -->
    <div class="mt-12 bg-green-50 border border-green-100 rounded-2xl p-6 text-center">
        <h3 class="font-bold text-green-900 text-lg mb-2">Still have questions?</h3>
        <p class="text-green-700 text-sm mb-4">Our team is ready to help. Reach out to us directly.</p>
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gov-gradient text-white font-semibold px-6 py-2.5 rounded-lg text-sm hover:opacity-90 transition">
            Contact Us →
        </a>
    </div>
</div>

@endsection
