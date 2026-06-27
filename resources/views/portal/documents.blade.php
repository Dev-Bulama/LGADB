@extends('layouts.portal')

@section('title', 'My Documents')
@section('page-title', 'My Documents')

@section('content')

<div class="space-y-6">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-gray-900">Uploaded Documents</h2>
                <p class="text-sm text-gray-400 mt-0.5">Your verified and submitted documents</p>
            </div>
            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                {{ $documents->count() }} file(s)
            </span>
        </div>

        @if($documents->isEmpty())
            <div class="text-center py-16 px-6">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-700 mb-1">No Documents Found</h3>
                <p class="text-sm text-gray-400">No documents have been uploaded to your record yet. Contact HR if you need to submit documents.</p>
            </div>
        @else
            <div class="divide-y divide-gray-50">
                @foreach($documents as $document)
                <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            @php
                                $ext = pathinfo($document->file_name ?? $document->file_path ?? '', PATHINFO_EXTENSION);
                                $iconColor = match(strtolower($ext)) {
                                    'pdf' => 'text-red-500',
                                    'jpg', 'jpeg', 'png' => 'text-purple-500',
                                    'doc', 'docx' => 'text-blue-500',
                                    default => 'text-gray-500',
                                };
                            @endphp
                            <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $document->name ?? $document->type ?? 'Document' }}</p>
                            <div class="flex items-center space-x-2 mt-0.5">
                                @if($document->document_type ?? $document->type)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded">
                                        {{ $document->document_type ?? $document->type }}
                                    </span>
                                @endif
                                <span class="text-gray-400 text-xs">
                                    {{ optional($document->created_at)->format('d M Y') }}
                                </span>
                                @if($document->verified ?? false)
                                    <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded font-semibold">Verified</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($document->download_url ?? $document->file_path)
                            <a href="{{ $document->download_url ?? route('portal.documents.download', $document) }}"
                               class="flex items-center space-x-1 text-green-700 hover:text-green-900 text-xs font-semibold px-3 py-1.5 bg-green-50 hover:bg-green-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>Download</span>
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
        <p class="text-sm text-blue-800 font-medium">Need to submit additional documents?</p>
        <p class="text-xs text-blue-700 mt-1">Contact the LGA HR department or visit the secretariat with your documents for submission.</p>
    </div>

</div>

@endsection
