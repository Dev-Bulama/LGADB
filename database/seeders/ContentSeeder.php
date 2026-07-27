<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // ── Settings ─────────────────────────────────────────────────────────────
        $settings = [
            ['key' => 'org_name',            'value' => 'Ayobo Ipaja Local Council Development Area', 'group' => 'general'],
            ['key' => 'org_phone',           'value' => '+2348012345678',                             'group' => 'general'],
            ['key' => 'id_card_expiry_years','value' => '3',                                          'group' => 'id_card'],
        ];

        foreach ($settings as &$setting) {
            $setting['created_at'] = now();
            $setting['updated_at'] = now();
        }

        DB::table('settings')->upsert($settings, ['key'], ['value', 'group', 'updated_at']);

        // ── Announcements ────────────────────────────────────────────────────────
        $adminUser = User::where('email', 'admin@lgadb.gov.ng')->first();
        $authorId  = $adminUser?->id ?? 1;

        $announcements = [
            [
                'title'   => 'Citizen Identity Verification Exercise Begins',
                'type'    => 'announcement',
                'excerpt' => 'All registered citizens are required to present themselves for the annual identity verification exercise starting this month.',
                'content' => '<p>The annual citizen identity verification exercise has officially commenced. All registered citizens are required to present themselves at the LCDA Citizen Registry Office with valid identification documents and their citizen ID cards.</p><p>The exercise runs from Monday to Friday, 8:00 AM to 4:00 PM. Citizens who fail to participate within the stipulated period may have their records flagged for review.</p><p>For enquiries, contact the Citizen Registry Office on ext. 2201 or visit our office at Igbogila, Ipaja Road, Lagos.</p>',
            ],
            [
                'title'   => 'New Citizen ID Card Collection Schedule',
                'type'    => 'announcement',
                'excerpt' => 'Citizens whose ID cards are ready for collection should report to the LCDA Administration office according to the schedule below.',
                'content' => '<p>The following wards should report to the Administration office to collect their newly issued citizen ID cards:</p><ul><li><strong>Monday:</strong> Ayobo Ward 1 &amp; 2</li><li><strong>Tuesday:</strong> Ipaja Ward 1 &amp; 2</li><li><strong>Wednesday:</strong> Igbogila &amp; Abesan Wards</li><li><strong>Thursday:</strong> Ekoro &amp; Ijaiye Wards</li><li><strong>Friday:</strong> Remaining wards &amp; walk-ins</li></ul><p>Please bring your Citizen ID number or a government-issued identification document for verification. Cards not collected within 30 days will be held at the Registry Office.</p>',
            ],
            [
                'title'   => 'Digital Registration Drive for Unregistered Citizens',
                'type'    => 'news',
                'excerpt' => 'Ayobo Ipaja LCDA is launching a ward-by-ward registration drive to capture all unregistered citizens and residents.',
                'content' => '<p>The Ayobo Ipaja Local Council Development Area is pleased to announce a comprehensive digital registration drive aimed at capturing every unregistered citizen and resident within our boundaries.</p><p><strong>How it works:</strong> Registration officers will be deployed to each ward on a rolling schedule. Citizens should come with their NIN slip, a recent passport photograph, and proof of address (utility bill, tenancy agreement, or any official document showing your address).</p><p><strong>Why register?</strong> Registration gives you a verified digital identity and a tamper-proof citizen ID card, which can be used for residency verification by banks, employers, landlords, government agencies and security operatives.</p><p>Registration is <strong>free of charge</strong>. No citizen should pay any fee to any officer for registration. Report any demand for payment immediately.</p>',
            ],
            [
                'title'   => 'Notice: Public Verification Portal Now Live',
                'type'    => 'announcement',
                'excerpt' => 'Any member of the public can now verify the identity and residency status of a registered citizen online.',
                'content' => '<p>Ayobo Ipaja LCDA is pleased to announce that the Public Citizen Verification Portal is now live and accessible to any member of the public.</p><p>The portal allows banks, employers, landlords, security agencies, and any member of the public to instantly verify the identity and residency status of a registered citizen by:</p><ul><li>Scanning the QR code on the citizen ID card</li><li>Searching by Citizen ID number, full name, NIN, or phone number</li></ul><p>Visit the verification portal on this website and search for any registered citizen. Verification is instant and available 24 hours a day, 7 days a week.</p><p>For fraud reports or discrepancies, use the Contact Us page or call our hotline.</p>',
            ],
            [
                'title'   => 'Important Notice: Update Your Citizen Records',
                'type'    => 'announcement',
                'excerpt' => 'All registered citizens are required to update their personal and contact information through the citizen portal.',
                'content' => '<p>This is to notify all registered citizens that the LCDA Citizen Registry is conducting an update of citizen records. All citizens are required to verify and update the following information where applicable:</p><ul><li>Current residential address</li><li>Emergency contact details</li><li>Phone number and email address</li><li>Valid National Identification Number (NIN)</li><li>Recent passport photograph</li></ul><p>Updates can be made by logging in to your citizen portal at any time, or by visiting the Registry Office at Igbogila, Ipaja Road, Lagos. Ensuring your records are current guarantees the accuracy of your citizen ID card and residency verification.</p>',
            ],
        ];

        foreach ($announcements as $index => &$ann) {
            $ann['id']           = $index + 1;
            $ann['slug']         = Str::slug($ann['title']);
            $ann['is_published'] = true;
            $ann['published_at'] = now()->subDays(mt_rand(1, 30));
            $ann['author_id']    = $authorId;
            $ann['created_at']   = now();
            $ann['updated_at']   = now();
        }

        DB::table('announcements')->upsert(
            $announcements,
            ['id'],
            ['title', 'slug', 'type', 'excerpt', 'content', 'is_published', 'published_at', 'author_id', 'updated_at']
        );

        // ── FAQs ─────────────────────────────────────────────────────────────────
        $faqs = [
            // general
            [
                'question' => 'What is the Ayobo Ipaja Citizen Identity & Verification Platform?',
                'answer'   => 'The Ayobo Ipaja Citizen Identity & Verification Database Platform is a secure, web-based digital system built to register, manage and verify the identity of every citizen and resident of Ayobo Ipaja Local Council Development Area. It replaces paper records and unverifiable residency claims with a single, tamper-proof digital database accessible from any device at any time.',
                'category' => 'general',
                'order'    => 1,
            ],
            [
                'question' => 'Who can access the system?',
                'answer'   => 'The public verification portal is open to anyone — banks, employers, landlords, security agencies and the general public can verify a citizen\'s identity online without logging in. Registered citizens can log in to view their own profile and download their ID card. Administrative access is role-based and restricted to authorised LCDA officers.',
                'category' => 'general',
                'order'    => 2,
            ],
            [
                'question' => 'How do I reset my password?',
                'answer'   => 'Click on "Forgot Password" on the login page and enter your registered email address. A reset link will be sent to you. If you do not receive it within 10 minutes, please contact the LCDA Registry Office.',
                'category' => 'general',
                'order'    => 3,
            ],
            [
                'question' => 'Is registration mandatory for all citizens?',
                'answer'   => 'All citizens and residents of Ayobo Ipaja LCDA are encouraged to register. A registered citizen gains a verified digital identity, a tamper-proof citizen ID card, and the ability to be verified instantly by banks, employers, landlords and government agencies. Registration is free of charge.',
                'category' => 'general',
                'order'    => 4,
            ],
            // verification
            [
                'question' => 'What is the citizen verification process?',
                'answer'   => 'Citizen verification involves confirming the identity, residential address, and residency status of each registered citizen. Registry Officers review submitted information and documents and either approve or request further information before granting verified status.',
                'category' => 'verification',
                'order'    => 1,
            ],
            [
                'question' => 'How long does verification take?',
                'answer'   => 'Verification typically takes 5–10 working days after all required information has been submitted and confirmed. You will be notified via email and your citizen portal once your verification status changes.',
                'category' => 'verification',
                'order'    => 2,
            ],
            [
                'question' => 'What documents are required for verification?',
                'answer'   => 'Required documents include: a valid national ID (NIN slip or voter card), a recent passport photograph, and proof of residential address within Ayobo Ipaja LCDA (utility bill, tenancy agreement, or any official document showing your current address).',
                'category' => 'verification',
                'order'    => 3,
            ],
            [
                'question' => 'Can anyone verify my identity using the platform?',
                'answer'   => 'Yes. Once your record is approved, any authorised party — including banks, employers, landlords, security agencies, and members of the public — can verify your identity by scanning the QR code on your citizen ID card or searching the public verification portal by your Citizen ID, name, NIN, or phone number.',
                'category' => 'verification',
                'order'    => 4,
            ],
            // id-card
            [
                'question' => 'How do I obtain my digital citizen ID card?',
                'answer'   => 'Once your verification status is approved, your digital citizen ID card is generated automatically. You can download it from your citizen portal under "My ID Card". Physical cards can be collected from the LCDA Administration office.',
                'category' => 'id-card',
                'order'    => 1,
            ],
            [
                'question' => 'When does my citizen ID card expire?',
                'answer'   => 'Citizen ID cards are valid for three (3) years from the date of issue. You will receive a notification email 30 days before expiry reminding you to apply for renewal through your citizen portal or at the Registry Office.',
                'category' => 'id-card',
                'order'    => 2,
            ],
            [
                'question' => 'What information is on the citizen ID card?',
                'answer'   => 'Each citizen ID card displays your full name, photograph, unique Citizen ID number, residential address, ward, LCDA, card issue and expiry dates, and a QR code that links directly to your live verification profile.',
                'category' => 'id-card',
                'order'    => 3,
            ],
            // registration
            [
                'question' => 'How do I update my residential address or personal details?',
                'answer'   => 'You can request updates to your personal information and address by logging in to your citizen portal. Certain details such as your verified residential address require supporting documentation and approval by a Registry Officer.',
                'category' => 'registration',
                'order'    => 1,
            ],
            [
                'question' => 'What should I do if I move to a different address within the LCDA?',
                'answer'   => 'If you move to a new address within Ayobo Ipaja LCDA, log in to your citizen portal and submit a change-of-address request with supporting proof of your new address. A Registry Officer will review and update your record, and a new ID card reflecting your updated address will be generated.',
                'category' => 'registration',
                'order'    => 2,
            ],
        ];

        foreach ($faqs as $index => &$faq) {
            $faq['id']         = $index + 1;
            $faq['is_active']  = true;
            $faq['created_at'] = now();
            $faq['updated_at'] = now();
        }

        DB::table('faqs')->upsert(
            $faqs,
            ['id'],
            ['question', 'answer', 'category', 'order', 'is_active', 'updated_at']
        );

        // ── Pages ────────────────────────────────────────────────────────────────
        $pages = [
            [
                'id'               => 1,
                'title'            => 'About Us',
                'slug'             => 'about',
                'meta_title'       => 'About – Ayobo Ipaja LCDA Citizen Identity & Verification Platform',
                'meta_description' => 'Learn about the Ayobo Ipaja LCDA Citizen Identity & Verification Database Platform and its mandate.',
                'is_published'     => true,
                'content'          => '<h2>About the Ayobo Ipaja Citizen Identity &amp; Verification Platform</h2><p>The Ayobo Ipaja Local Council Development Area Citizen Identity &amp; Verification Database Platform is a secure, web-based digital system established to register, manage and verify the identity of every citizen and resident of Ayobo Ipaja LCDA — not a select group, but the general public in its entirety.</p><p>Developed by Skillscore IT Solutions &amp; Training and deployed for Ayobo Ipaja Local Council Development Area, Lagos State, the platform replaces scattered paper records and unverifiable residency claims with a single, tamper-proof digital database accessible from any internet-connected device at any time.</p><h3>Our Mandate</h3><ul><li>Maintain an accurate and up-to-date digital register of all citizens and residents of Ayobo Ipaja LCDA.</li><li>Issue secure, tamper-proof digital and physical citizen identity cards.</li><li>Enable instant, public verification of any registered citizen\'s identity and residency status.</li><li>Support accurate targeting of social interventions, palliatives and government programmes to genuine citizens.</li><li>Provide ward-level population and household data to guide infrastructure and service delivery planning.</li></ul><h3>Our Address</h3><p>Ayobo Ipaja Local Council Development Area<br>Igbogila, Ipaja Road, Lagos State, Nigeria.</p>',
            ],
            [
                'id'               => 2,
                'title'            => 'Privacy Policy',
                'slug'             => 'privacy-policy',
                'meta_title'       => 'Privacy Policy – Ayobo Ipaja LCDA Citizen Platform',
                'meta_description' => 'Read the privacy policy for the Ayobo Ipaja LCDA Citizen Identity & Verification Platform.',
                'is_published'     => true,
                'content'          => '<h2>Privacy Policy</h2><p><em>Last updated: ' . now()->format('F Y') . '</em></p><p>Ayobo Ipaja Local Council Development Area ("we", "us", or "our") is committed to protecting the personal information of all citizens registered on this platform. This Privacy Policy explains how we collect, use, and safeguard your data in line with the Nigeria Data Protection Act (NDPA) 2023.</p><h3>Information We Collect</h3><p>We collect personal information including your full name, date of birth, contact details, residential address, National Identification Number (NIN), residency status, and biometric data (photograph) solely for the purpose of citizen identity management and residency verification.</p><h3>How We Use Your Information</h3><ul><li>To generate and issue your official citizen ID card bearing your verified residential address.</li><li>To enable authorised parties to verify your identity and residency status.</li><li>To support the accurate targeting of government social intervention programmes.</li><li>To maintain accurate citizen records for planning and administrative purposes.</li></ul><h3>Who Can See Your Information</h3><p>Access is tiered by role. The general public can verify your name, photo, ward and residency status. Government agencies and security operatives may access additional detail as authorised. Your full record is never disclosed to the general public by default.</p><h3>Data Security</h3><p>All personal data is stored on secured servers within Nigeria and is accessible only to authorised personnel. We apply industry-standard encryption and access controls to protect your information.</p><h3>Contact</h3><p>For privacy-related enquiries, contact the Data Protection Officer at the LCDA Registry Office, Ayobo Ipaja Local Council Development Area, Igbogila, Ipaja Road, Lagos.</p>',
            ],
            [
                'id'               => 3,
                'title'            => 'Terms of Service',
                'slug'             => 'terms-of-service',
                'meta_title'       => 'Terms of Service – Ayobo Ipaja LCDA Citizen Platform',
                'meta_description' => 'Terms of service governing the use of the Ayobo Ipaja LCDA Citizen Identity & Verification Platform.',
                'is_published'     => true,
                'content'          => '<h2>Terms of Service</h2><p><em>Last updated: ' . now()->format('F Y') . '</em></p><p>By accessing and using the Ayobo Ipaja Citizen Identity &amp; Verification Platform, you agree to be bound by the following terms and conditions.</p><h3>Acceptable Use</h3><ul><li>You must use this platform solely for legitimate citizen identity registration and verification purposes.</li><li>You must not attempt to access accounts or records that are not assigned to you.</li><li>You must not share your login credentials with any other person.</li><li>You must not introduce malicious code or attempt to compromise system security.</li><li>You must not use the verification portal to harass, stalk, or unlawfully obtain information about any citizen.</li></ul><h3>Accuracy of Information</h3><p>You are responsible for ensuring that all information you provide during registration is accurate and up to date. Providing false information, including a false residential address, is an offence and may result in cancellation of your registration and referral to appropriate authorities.</p><h3>Account Security</h3><p>You are responsible for maintaining the confidentiality of your username and password. Report any suspected unauthorised access to the LCDA Registry Office immediately.</p><h3>Termination</h3><p>Access to this platform may be suspended or terminated without notice if there is a breach of these terms or if your registration record is found to contain false information.</p>',
            ],
            [
                'id'               => 4,
                'title'            => 'Contact Us',
                'slug'             => 'contact',
                'meta_title'       => 'Contact – Ayobo Ipaja LCDA Citizen Identity Platform',
                'meta_description' => 'Get in touch with the Ayobo Ipaja LCDA Citizen Registry Office for assistance.',
                'is_published'     => true,
                'content'          => '<h2>Contact Us</h2><p>If you have questions or require assistance with the Ayobo Ipaja Citizen Identity &amp; Verification Platform, please reach us through any of the channels below.</p><h3>LCDA Citizen Registry Office</h3><p><strong>Address:</strong> Ayobo Ipaja Local Council Development Area, Igbogila, Ipaja Road, Lagos State, Nigeria.<br><strong>Phone:</strong> +234 801 234 5678<br><strong>Email:</strong> registry@ayoboipajalgadb.gov.ng<br><strong>Office Hours:</strong> Monday – Friday, 8:00 AM – 4:00 PM</p><h3>IT Support</h3><p>For technical issues with the platform, email: <a href="mailto:support@ayoboipajalgadb.gov.ng">support@ayoboipajalgadb.gov.ng</a></p><h3>Fraud Hotline</h3><p>To report a fraudulent citizen ID card or suspected identity fraud, call our hotline or use the fraud report form on this page.</p>',
            ],
        ];

        foreach ($pages as &$page) {
            $page['created_at'] = now();
            $page['updated_at'] = now();
        }

        DB::table('pages')->upsert(
            $pages,
            ['id'],
            ['title', 'slug', 'content', 'meta_title', 'meta_description', 'is_published', 'updated_at']
        );

        // ── ID Card Template ─────────────────────────────────────────────────────
        $frontHtml = <<<'HTML'
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body class="id-card front">
  <div class="card-header">
    <div class="logo-area">
      <img src="{{ org_logo }}" alt="LCDA Logo" class="logo" onerror="this.style.display='none'">
    </div>
    <div class="org-details">
      <h1 class="org-name">AYOBO IPAJA LCDA</h1>
      <p class="org-subtitle">Lagos State, Nigeria</p>
      <p class="card-label">CITIZEN IDENTITY CARD</p>
    </div>
  </div>
  <div class="card-body">
    <div class="photo-section">
      <img src="{{ citizen_photo }}" alt="Citizen Photo" class="citizen-photo" onerror="this.style.background='#ccc'">
    </div>
    <div class="details-section">
      <p class="citizen-name">{{ citizen_name }}</p>
      <table class="info-table">
        <tr><td class="label">Citizen ID:</td><td class="value">{{ citizen_id }}</td></tr>
        <tr><td class="label">Occupation:</td><td class="value">{{ designation }}</td></tr>
        <tr><td class="label">Ward:</td><td class="value">{{ ward }}</td></tr>
        <tr><td class="label">Address:</td><td class="value">{{ residential_address }}</td></tr>
      </table>
    </div>
  </div>
  <div class="card-footer">
    <p>Issue Date: {{ issue_date }} &nbsp;|&nbsp; Expiry: {{ expiry_date }}</p>
  </div>
</body>
</html>
HTML;

        $backHtml = <<<'HTML'
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body class="id-card back">
  <div class="back-header">
    <p class="back-title">AYOBO IPAJA LOCAL COUNCIL DEVELOPMENT AREA</p>
  </div>
  <div class="back-body">
    <div class="qr-section">
      <img src="{{ qr_code }}" alt="QR Code" class="qr-code">
      <p class="verification-code">Code: {{ verification_code }}</p>
    </div>
    <div class="back-details">
      <table class="info-table">
        <tr><td class="label">Blood Group:</td><td class="value">{{ blood_group }}</td></tr>
        <tr><td class="label">NIN:</td><td class="value">{{ national_id }}</td></tr>
        <tr><td class="label">Phone:</td><td class="value">{{ phone }}</td></tr>
      </table>
    </div>
  </div>
  <div class="emergency-section">
    <p class="emergency-label">EMERGENCY CONTACT</p>
    <p>{{ emergency_contact_name }} &nbsp; {{ emergency_contact_phone }}</p>
  </div>
  <div class="back-footer">
    <p>If found, please return to: LCDA Registry Office, Igbogila, Ipaja Road, Lagos.</p>
    <p>Tel: +234 801 234 5678</p>
    <p class="verify-text">Verify at: {{ verification_url }}</p>
  </div>
</body>
</html>
HTML;

        $css = <<<'CSS'
* { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
body.id-card { width: 85.6mm; height: 54mm; background: #fff; color: #111; font-size: 7pt; overflow: hidden; }
.card-header { display: flex; align-items: center; background: #064e3b; color: #fff; padding: 4px 6px; gap: 6px; }
.logo { width: 32px; height: 32px; object-fit: contain; }
.org-name { font-size: 8pt; font-weight: bold; line-height: 1.2; }
.org-subtitle { font-size: 6pt; }
.card-label { font-size: 7pt; font-weight: bold; letter-spacing: 0.5px; margin-top: 2px; }
.card-body { display: flex; padding: 4px 6px; gap: 6px; flex: 1; }
.citizen-photo { width: 28mm; height: 30mm; object-fit: cover; border: 1px solid #ccc; }
.citizen-name { font-size: 8pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; }
.info-table td { padding: 1px 2px; vertical-align: top; }
.info-table .label { font-weight: bold; white-space: nowrap; color: #555; width: 65px; }
.info-table .value { font-size: 7pt; }
.card-footer { background: #064e3b; color: #fff; text-align: center; padding: 2px; font-size: 6pt; }
.back-header { background: #064e3b; color: #fff; text-align: center; padding: 3px; }
.back-title { font-size: 7pt; font-weight: bold; }
.back-body { display: flex; padding: 4px 6px; gap: 6px; }
.qr-code { width: 22mm; height: 22mm; object-fit: contain; }
.verification-code { font-size: 6pt; text-align: center; margin-top: 2px; font-weight: bold; letter-spacing: 1px; }
.emergency-section { background: #f0fdf4; padding: 3px 6px; }
.emergency-label { font-weight: bold; font-size: 6pt; color: #064e3b; }
.back-footer { padding: 2px 6px; font-size: 5.5pt; color: #555; text-align: center; }
.verify-text { font-weight: bold; color: #064e3b; }
CSS;

        DB::table('id_card_templates')->upsert(
            [
                [
                    'id'         => 1,
                    'name'       => 'Ayobo Ipaja LCDA Citizen ID Template',
                    'front_html' => $frontHtml,
                    'back_html'  => $backHtml,
                    'css'        => $css,
                    'is_default' => true,
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ],
            ['id'],
            ['name', 'front_html', 'back_html', 'css', 'is_default', 'is_active', 'updated_at']
        );

        $this->command->info('Content (settings, announcements, FAQs, pages, ID card template) seeded successfully.');
    }
}
