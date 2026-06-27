<?php

namespace App\Providers;

use App\Http\View\Composers\SettingsComposer;
use Illuminate\Auth\Events\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('verification', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip())->response(function () {
                return response()->json(['message' => 'Too many verification attempts. Please wait before trying again.'], 429);
            });
        });

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perHour(5)->by($request->ip());
        });

        Event::listen(Login::class, function (Login $event) {
            $event->user->update(['last_login_at' => now()]);
        });

        View::composer(['layouts.public', 'layouts.portal'], SettingsComposer::class);
    }
}
