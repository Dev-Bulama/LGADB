<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'org_name',    'value' => 'Ayobo Ipaja Local Council Development Area', 'group' => 'general', 'description' => 'Organisation display name'],
            ['key' => 'lga_name',    'value' => 'Ayobo Ipaja LCDA',         'group' => 'general', 'description' => 'Short LCDA name used in certificates and ID cards'],
            ['key' => 'lga_state',   'value' => 'Lagos State',              'group' => 'general', 'description' => 'State the LCDA belongs to'],
            ['key' => 'org_phone',   'value' => env('LGA_PHONE', '+234 800 000 0000'), 'group' => 'general', 'description' => 'Main contact phone number'],
            ['key' => 'org_email',   'value' => env('LGA_EMAIL', 'info@ayoboipajalgadb.gov.ng'), 'group' => 'general', 'description' => 'Public contact email'],
            ['key' => 'org_address', 'value' => env('LGA_ADDRESS', 'Ayobo Ipaja Local Council Development Area, Igbogila, Ipaja Road, Lagos'), 'group' => 'general', 'description' => 'Physical office address'],
            ['key' => 'org_website', 'value' => url('/'), 'group' => 'general', 'description' => 'Official website URL'],

            // ID Card
            ['key' => 'id_card_validity_years', 'value' => '3',     'group' => 'id_card', 'description' => 'Years before ID card expires'],
            ['key' => 'id_card_issuer',          'value' => 'LCDA Chairman, Ayobo Ipaja LCDA', 'group' => 'id_card', 'description' => 'Issuing authority name on the ID card'],

            // Verification
            ['key' => 'verification_public_message', 'value' => 'This portal allows the public to verify the identity and residency status of any registered citizen or resident of Ayobo Ipaja Local Council Development Area. Enter a Citizen ID, full name, NIN, phone number, or verification code to verify.', 'group' => 'verification', 'description' => 'Introductory text on the public verification page'],
            ['key' => 'verification_footer_note',    'value' => 'For fraud concerns, call our fraud hotline or visit the LCDA Registry Office at Igbogila, Ipaja Road, Lagos.', 'group' => 'verification', 'description' => 'Footer note on verification result pages'],

            // Mail
            ['key' => 'mail_from_name',    'value' => 'Ayobo Ipaja LCDA Registry', 'group' => 'mail', 'description' => 'From name for system emails'],
            ['key' => 'mail_support_email', 'value' => env('LGA_EMAIL', 'registry@ayoboipajalgadb.gov.ng'), 'group' => 'mail', 'description' => 'Support email shown in notification emails'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
