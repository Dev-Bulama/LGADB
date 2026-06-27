@extends('layouts.public')

@section('title', $page->title ?? 'Page')

@section('content')

<div class="gov-gradient py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">{{ $page->title }}</h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-10">
        <div class="prose prose-green max-w-none text-gray-700 leading-relaxed">
            {!! $page->content !!}
        </div>
    </div>
</div>

@endsection
