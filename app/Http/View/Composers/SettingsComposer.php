<?php

namespace App\Http\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingsComposer
{
    public function compose(View $view): void
    {
        $view->with('appSettings', [
            'org_name'    => Setting::get('org_name', config('lga.name', config('app.name'))),
            'org_phone'   => Setting::get('org_phone', config('lga.phone')),
            'org_email'   => Setting::get('org_email', config('lga.email')),
            'org_address' => Setting::get('org_address', config('lga.address')),
            'org_website' => Setting::get('org_website'),
            'lga_name'    => Setting::get('lga_name', config('lga.name')),
            'lga_state'   => Setting::get('lga_state', config('lga.state')),
        ]);
    }
}
