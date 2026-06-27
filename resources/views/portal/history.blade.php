@extends('layouts.portal')

@section('title', 'Employment History')
@section('page-title', 'Employment History')

@section('content')

<div class="space-y-6">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-900 mb-1">Employment Timeline</h2>
        <p class="text-sm text-gray-400">A record of your employment history within the LGA.</p>
    </div>

    {{-- $worker and $histories are passed from WorkerPortalController --}}

    @if($histories->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-14 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-700 mb-1">No History Records</h3>
            <p class="text-sm text-gray-400">Employment history records will appear here once they are entered by HR.</p>
        </div>
    @else
        <div class="relative">
            {{-- Timeline line --}}
            <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-green-100"></div>

            <div class="space-y-4 pl-14">
                @foreach($histories as $history)
                <div class="relative">
                    {{-- Timeline dot --}}
                    <div class="absolute -left-9 w-4 h-4 rounded-full border-2 border-green-500 bg-white flex items-center justify-center">
                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 mb-3">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $history->event_type_label ?? $history->event_type ?? 'Employment Event' }}</h3>
                                @if($history->designation)
                                    <p class="text-green-700 font-medium text-sm">{{ $history->designation }}</p>
                                @endif
                            </div>
                            <span class="text-xs text-gray-400 font-medium flex-shrink-0">
                                {{ optional($history->effective_date)->format('d M Y') }}
                            </span>
                        </div>

                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                            @if($history->department_name ?? $history->department)
                            <div class="flex justify-between sm:flex-col">
                                <dt class="text-gray-400 text-xs uppercase font-semibold">Department</dt>
                                <dd class="text-gray-700">{{ $history->department_name ?? $history->department }}</dd>
                            </div>
                            @endif
                            @if($history->grade_level)
                            <div class="flex justify-between sm:flex-col">
                                <dt class="text-gray-400 text-xs uppercase font-semibold">Grade Level</dt>
                                <dd class="text-gray-700">Level {{ $history->grade_level }}{{ $history->step ? ' / Step ' . $history->step : '' }}</dd>
                            </div>
                            @endif
                            @if($history->location)
                            <div class="flex justify-between sm:flex-col">
                                <dt class="text-gray-400 text-xs uppercase font-semibold">Location</dt>
                                <dd class="text-gray-700">{{ $history->location }}</dd>
                            </div>
                            @endif
                            @if($history->remarks)
                            <div class="sm:col-span-2">
                                <dt class="text-gray-400 text-xs uppercase font-semibold">Remarks</dt>
                                <dd class="text-gray-600 text-xs mt-0.5">{{ $history->remarks }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(method_exists($histories, 'links') && $histories->hasPages())
        <div class="mt-4">{{ $histories->links() }}</div>
    @endif

</div>

@endsection
