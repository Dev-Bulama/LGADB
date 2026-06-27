@extends('layouts.public')

@section('title', $announcement->title)
@section('description', $announcement->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($announcement->content ?? ''), 160))

@section('content')

<div class="gov-gradient py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <a href="{{ route('news') }}" class="inline-flex items-center text-green-200 hover:text-white text-sm mb-4 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to News
        </a>
        <div class="flex items-center space-x-3 mb-3">
            <span class="bg-green-400 text-green-900 text-xs font-semibold px-2 py-0.5 rounded-full uppercase">
                {{ $announcement->type ?? 'Announcement' }}
            </span>
            <span class="text-green-200 text-sm">{{ optional($announcement->published_at)->format('d M Y') }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">{{ $announcement->title }}</h1>
        @if($announcement->author)
            <p class="text-green-200 text-sm mt-2">By {{ $announcement->author->name }}</p>
        @endif
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        @if($announcement->excerpt)
            <p class="text-gray-600 text-lg font-medium leading-relaxed border-l-4 border-green-500 pl-4 mb-6 italic">
                {{ $announcement->excerpt }}
            </p>
        @endif
        <div class="prose prose-green max-w-none text-gray-700 leading-relaxed">
            {!! $announcement->content !!}
        </div>
    </div>
    <div class="mt-8 text-center">
        <a href="{{ route('news') }}" class="text-green-700 font-semibold hover:underline text-sm">← All News &amp; Announcements</a>
    </div>
</div>

@endsection
