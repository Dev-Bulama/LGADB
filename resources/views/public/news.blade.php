@extends('layouts.public')

@section('title', 'News & Announcements')
@section('description', 'Latest news and announcements from the LGA Workforce Identity System.')

@section('content')

<div class="gov-gradient py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">News &amp; Announcements</h1>
        <p class="text-green-100 text-lg">Stay informed with the latest updates from the Local Government Authority.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @if($announcements->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($announcements as $announcement)
            <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition group flex flex-col">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full uppercase">
                            {{ $announcement->type ?? 'Announcement' }}
                        </span>
                        <span class="text-gray-400 text-xs">
                            {{ optional($announcement->published_at)->format('d M Y') }}
                        </span>
                    </div>
                    <h2 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-green-700 transition line-clamp-2 flex-shrink-0">
                        <a href="{{ route('news.show', $announcement->slug) }}">{{ $announcement->title }}</a>
                    </h2>
                    <p class="text-gray-500 text-sm line-clamp-4 flex-1">
                        {{ $announcement->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($announcement->content ?? ''), 200) }}
                    </p>
                    <a href="{{ route('news.show', $announcement->slug) }}"
                       class="inline-block mt-4 text-green-700 text-sm font-semibold hover:underline">
                        Read More →
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $announcements->links() }}
        </div>

    @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">No Announcements Yet</h2>
            <p class="text-gray-400 text-sm">Check back later for news and updates from the LGA.</p>
        </div>
    @endif
</div>

@endsection
