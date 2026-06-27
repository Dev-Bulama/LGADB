<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily ID card expiry check
Schedule::call(function () {
    \App\Models\Worker::where('id_expiry_date', '<', now())
        ->where('status', 'active')
        ->update(['status' => 'pending']);
})->daily()->name('check-expired-id-cards');
