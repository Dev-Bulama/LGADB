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
            ['key' => 'org_name',    'value' => 'Alimosho Local Government Authority', 'group' => 'general', 'description' => 'Organisation display name'],
            ['key' => 'lga_name',    'value' => 'Alimosho LGA',             'group' => 'general', 'description' => 'Short LGA name used in certificates and ID cards'],
            ['key' => 'lga_state',   'value' => 'Lagos State',              'group' => 'general', 'description' => 'State the LGA belongs to'],
            ['key' => 'org_phone',   'value' => env('LGA_PHONE', '+234 800 000 0000'), 'group' => 'general', 'description' => 'Main contact phone number'],
            ['key' => 'org_email',   'value' => env('LGA_EMAIL', 'info@alimosholgalagos.gov.ng'), 'group' => 'general', 'description' => 'Public contact email'],
            ['key' => 'org_address', 'value' => env('LGA_ADDRESS', 'LGA Secretariat, Alimosho, Lagos State, Nigeria'), 'group' => 'general', 'description' => 'Physical office address'],
            ['key' => 'org_website', 'value' => 'https://alimosholgalagos.gov.ng', 'group' => 'general', 'description' => 'Official website URL'],

            // ID Card
            ['key' => 'id_card_validity_years', 'value' => '3',     'group' => 'id_card', 'description' => 'Years before ID card expires'],
            ['key' => 'id_card_issuer',          'value' => 'LGA Chairman, Alimosho LGA', 'group' => 'id_card', 'description' => 'Issuing authority name on the ID card'],

            // Verification
            ['key' => 'verification_public_message', 'value' => 'This verification portal allows the public to confirm the employment status of Alimosho LGA staff. Enter a staff number, verification code, or other identifier to verify.', 'group' => 'verification', 'description' => 'Introductory text on the public verification page'],
            ['key' => 'verification_footer_note',    'value' => 'For fraud concerns, call our fraud hotline or visit the LGA Secretariat.', 'group' => 'verification', 'description' => 'Footer note on verification result pages'],

            // Mail
            ['key' => 'mail_from_name',    'value' => 'Alimosho LGA HR', 'group' => 'mail', 'description' => 'From name for system emails'],
            ['key' => 'mail_support_email', 'value' => env('LGA_EMAIL', 'hr@alimosholgalagos.gov.ng'), 'group' => 'mail', 'description' => 'Support email shown in notification emails'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
