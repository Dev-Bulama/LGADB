@extends('layouts.public')

@section('title', 'About')
@section('description', 'About the Ayobo Ipaja LCDA Citizen Identity & Verification Platform.')

@section('content')

<div class="gov-gradient py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">About This System</h1>
        <p class="text-green-100 text-lg">Learn about the Ayobo Ipaja LCDA Citizen Identity &amp; Verification Database Platform.</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($page && $page->content)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-10">
            <div class="prose prose-green max-w-none text-gray-700 leading-relaxed">
                {!! $page->content !!}
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-10 space-y-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">About the Ayobo Ipaja Citizen Identity & Verification Platform</h2>
                <p class="text-gray-600 leading-relaxed">
                    The Ayobo Ipaja Citizen Identity &amp; Verification Platform is the official digital system
                    for registering, managing, verifying and authenticating the identity of every citizen and resident of Ayobo Ipaja LCDA. It was developed to
                    enhance transparency, accountability, and public trust in local government service delivery across Lagos State.
                </p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed">
                    To maintain a single, verified record of every citizen and resident of Ayobo Ipaja LCDA — enabling accurate targeting of government services, reducing
                    identity fraud, ensuring proof of address for every resident, and strengthening the security and accountability of the LGA.
                </p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-3">Key Features</h3>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li class="flex items-start space-x-2">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>Real-time citizen verification by name, NIN, Citizen ID, phone or verification code</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>QR-code enabled digital ID cards for quick on-the-spot verification</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>Citizen self-service portal to view profile, download Resident ID card and proof of address</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>Comprehensive audit trails for all verification activities</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <span class="text-green-600 mt-0.5">✓</span>
                        <span>Household and family record linkage for accurate ward-level population data</span>
                    </li>
                </ul>
            </div>
        </div>
    @endif
</div>

@endsection
