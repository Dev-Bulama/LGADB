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
            ['key' => 'org_name',            'value' => 'Kano Municipal LGA',  'group' => 'general'],
            ['key' => 'org_phone',           'value' => '+2348012345678',       'group' => 'general'],
            ['key' => 'id_card_expiry_years','value' => '2',                    'group' => 'id_card'],
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
                'title'   => 'Staff Verification Exercise Begins',
                'type'    => 'announcement',
                'excerpt' => 'All staff members are required to present themselves for the annual verification exercise starting this month.',
                'content' => '<p>The annual staff verification exercise has officially commenced. All staff members are required to present themselves at the Human Resources Department with valid identification documents, staff ID cards, and appointment letters.</p><p>The exercise runs from Monday to Friday, 8:00 AM to 4:00 PM. Staff who fail to participate within the stipulated time will be marked as absent and may face salary suspension.</p><p>For enquiries, contact the HR Department on ext. 2201.</p>',
            ],
            [
                'title'   => 'New ID Card Collection Schedule',
                'type'    => 'announcement',
                'excerpt' => 'Staff whose ID cards are ready for collection should report to the Admin office according to the schedule below.',
                'content' => '<p>The following departments should report to the Administration office to collect their newly issued ID cards:</p><ul><li><strong>Monday:</strong> Finance & Accounts, Administration & HR</li><li><strong>Tuesday:</strong> Health Services, Social Welfare</li><li><strong>Wednesday:</strong> Education, Agriculture & Natural Resources</li><li><strong>Thursday:</strong> Works & Infrastructure, Security & Civil Defense</li></ul><p>Please bring your old ID card or appointment letter for verification.</p>',
            ],
            [
                'title'   => 'Training Workshop for Administrative Staff',
                'type'    => 'news',
                'excerpt' => 'A two-day capacity building workshop is scheduled for all administrative and HR staff.',
                'content' => '<p>The Human Resources Department is pleased to announce a two-day capacity building workshop for all administrative and HR staff. The workshop will focus on records management, digital literacy, and public service ethics.</p><p><strong>Date:</strong> To be communicated<br><strong>Venue:</strong> LGA Council Chambers, Main Secretariat<br><strong>Time:</strong> 9:00 AM – 4:00 PM daily</p><p>Attendance is compulsory for all staff in the Administration & HR department. Light refreshments will be provided. Contact HR on ext. 2201 for more information.</p>',
            ],
            [
                'title'   => 'Annual Staff Medical Check-Up',
                'type'    => 'announcement',
                'excerpt' => 'All staff are invited to attend the annual medical examination at the LGA Health Centre.',
                'content' => '<p>In line with our commitment to staff welfare, the Kano Municipal LGA will be conducting its annual medical check-up for all staff. The exercise will take place at the Primary Health Care Centre within the LGA premises.</p><p>Tests include blood pressure, blood glucose, BMI assessment, eye examination, and general physical examination. Results will be treated with strict confidentiality.</p><p>Staff should attend on the day assigned to their department by the Health Services Department.</p>',
            ],
            [
                'title'   => 'Important Notice: Update Your Staff Records',
                'type'    => 'announcement',
                'excerpt' => 'All staff are required to update their personal and contact information in the staff management system.',
                'content' => '<p>This is to notify all staff members that the HR Department is conducting an update of personnel records. All staff are required to submit updated information including:</p><ul><li>Current residential address</li><li>Next of kin details</li><li>Bank account information</li><li>Educational qualifications and certificates</li><li>Valid national identification number (NIN)</li></ul><p>Forms are available at the HR Department. Deadline for submission is end of the current month. Failure to update records may affect salary processing and official correspondence.</p>',
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
                'question' => 'What is the LGA Workforce Identity System?',
                'answer'   => 'The LGA Workforce Identity System (LGADB) is a digital platform designed to manage staff records, issue digital ID cards, and verify the identity of all workers employed by the Kano Municipal Local Government Area.',
                'category' => 'general',
                'order'    => 1,
            ],
            [
                'question' => 'Who can access the system?',
                'answer'   => 'Access is granted based on role. Super Admins, HR Officers, and Department Managers have administrative access. Individual staff members can log in to view their own profile and ID card status.',
                'category' => 'general',
                'order'    => 2,
            ],
            [
                'question' => 'How do I reset my password?',
                'answer'   => 'Click on "Forgot Password" on the login page and enter your registered email address. A reset link will be sent to you. If you do not receive it within 10 minutes, please contact the HR Department.',
                'category' => 'general',
                'order'    => 3,
            ],
            // verification
            [
                'question' => 'What is the staff verification process?',
                'answer'   => 'Staff verification involves confirming the identity, qualifications, and employment status of each worker. HR Officers review submitted documents and either approve or request further information before granting verified status.',
                'category' => 'verification',
                'order'    => 1,
            ],
            [
                'question' => 'How long does verification take?',
                'answer'   => 'Verification typically takes 5–10 working days after all required documents have been submitted. Complex cases may take longer. You will be notified via email once your status changes.',
                'category' => 'verification',
                'order'    => 2,
            ],
            [
                'question' => 'What documents are required for verification?',
                'answer'   => 'Required documents include: valid national ID (NIN slip or voter card), original appointment letter, academic certificates, passport photograph, and a signed staff undertaking form available from HR.',
                'category' => 'verification',
                'order'    => 3,
            ],
            // id-card
            [
                'question' => 'How do I obtain my digital ID card?',
                'answer'   => 'Once your verification status is approved, your digital ID card is generated automatically. You can download it from your profile dashboard under "My ID Card". Physical cards are issued by the Administration office.',
                'category' => 'id-card',
                'order'    => 1,
            ],
            [
                'question' => 'When does my ID card expire?',
                'answer'   => 'ID cards are valid for two (2) years from the date of issue. You will receive a notification email 30 days before expiry reminding you to apply for renewal.',
                'category' => 'id-card',
                'order'    => 2,
            ],
            // employment
            [
                'question' => 'How do I update my employment details?',
                'answer'   => 'Employment details such as designation, department, and grade level can only be updated by HR Officers or the Super Admin. Contact the HR Department with supporting documents to request any changes.',
                'category' => 'employment',
                'order'    => 1,
            ],
            [
                'question' => 'What should I do if I am transferred to another department?',
                'answer'   => 'Upon transfer, your unit head or HR Officer will update your departmental assignment in the system. Ensure you collect a transfer letter and submit it to the HR Department within 5 working days of the transfer.',
                'category' => 'employment',
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
                'meta_title'       => 'About – Kano Municipal LGA Workforce Identity System',
                'meta_description' => 'Learn about the Kano Municipal LGA Workforce Identity System and its mandate.',
                'is_published'     => true,
                'content'          => '<h2>About the Kano Municipal LGA Workforce Identity System</h2><p>The Kano Municipal Local Government Area Workforce Identity System (LGADB) is a centralized platform established to digitise the management, verification, and identification of all workers employed under the Kano Municipal LGA.</p><p>Our mission is to ensure transparency, accountability, and efficiency in workforce management across all departments and units of the local government. The system enables the issuance of tamper-proof digital ID cards, real-time verification of staff status, and comprehensive reporting for decision-makers.</p><h3>Our Mandate</h3><ul><li>Maintain an accurate and up-to-date register of all LGA employees.</li><li>Issue digital and physical staff identity cards.</li><li>Facilitate the verification and authentication of worker credentials.</li><li>Support HR operations including records management and payroll integration.</li></ul>',
            ],
            [
                'id'               => 2,
                'title'            => 'Privacy Policy',
                'slug'             => 'privacy-policy',
                'meta_title'       => 'Privacy Policy – LGADB',
                'meta_description' => 'Read the privacy policy for the Kano Municipal LGA Workforce Identity System.',
                'is_published'     => true,
                'content'          => '<h2>Privacy Policy</h2><p><em>Last updated: ' . now()->format('F Y') . '</em></p><p>Kano Municipal LGA ("we", "us", or "our") is committed to protecting the personal information of all staff members registered on this platform. This Privacy Policy explains how we collect, use, and safeguard your data.</p><h3>Information We Collect</h3><p>We collect personal information including your name, date of birth, contact details, national identification number, employment history, and biometric data (photograph and signature) solely for the purpose of workforce management and identity verification.</p><h3>How We Use Your Information</h3><ul><li>To generate and issue your official staff ID card.</li><li>To verify your employment status for administrative purposes.</li><li>To maintain accurate staff records for payroll and HR operations.</li></ul><h3>Data Security</h3><p>All personal data is stored on secured servers within Nigeria and is accessible only to authorised personnel. We apply industry-standard encryption and access controls to protect your information.</p><h3>Contact</h3><p>For privacy-related enquiries, contact the Data Protection Officer at the HR Department, Kano Municipal LGA Secretariat.</p>',
            ],
            [
                'id'               => 3,
                'title'            => 'Terms of Service',
                'slug'             => 'terms-of-service',
                'meta_title'       => 'Terms of Service – LGADB',
                'meta_description' => 'Terms of service governing the use of the Kano Municipal LGA Workforce Identity System.',
                'is_published'     => true,
                'content'          => '<h2>Terms of Service</h2><p><em>Last updated: ' . now()->format('F Y') . '</em></p><p>By accessing and using the LGADB Workforce Identity System, you agree to be bound by the following terms and conditions.</p><h3>Acceptable Use</h3><ul><li>You must use this system solely for legitimate workforce management purposes.</li><li>You must not attempt to access accounts or records that are not assigned to you.</li><li>You must not share your login credentials with any other person.</li><li>You must not introduce malicious code or attempt to compromise system security.</li></ul><h3>Accuracy of Information</h3><p>You are responsible for ensuring that all information you provide is accurate and up to date. Providing false information may result in disciplinary action in accordance with the public service rules.</p><h3>Account Security</h3><p>You are responsible for maintaining the confidentiality of your username and password. Report any suspected unauthorised access to the IT support desk immediately.</p><h3>Termination</h3><p>Access to this system may be suspended or terminated without notice if there is a breach of these terms, or upon separation from the local government service.</p>',
            ],
            [
                'id'               => 4,
                'title'            => 'Contact Us',
                'slug'             => 'contact',
                'meta_title'       => 'Contact – Kano Municipal LGA',
                'meta_description' => 'Get in touch with the Kano Municipal LGA HR Department for assistance.',
                'is_published'     => true,
                'content'          => '<h2>Contact Us</h2><p>If you have questions or require assistance with the LGADB Workforce Identity System, please reach us through any of the channels below.</p><h3>HR Department</h3><p><strong>Address:</strong> Administration & HR Department, Kano Municipal LGA Secretariat, Hospital Road, Kano State, Nigeria.<br><strong>Phone:</strong> +234 801 234 5678<br><strong>Email:</strong> hr@lgadb.gov.ng<br><strong>Office Hours:</strong> Monday – Friday, 8:00 AM – 4:00 PM</p><h3>IT Support</h3><p>For technical issues with the system, email: <a href="mailto:it@lgadb.gov.ng">it@lgadb.gov.ng</a></p>',
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
      <img src="{{ org_logo }}" alt="LGA Logo" class="logo" onerror="this.style.display='none'">
    </div>
    <div class="org-details">
      <h1 class="org-name">{{ org_name }}</h1>
      <p class="org-subtitle">Kano State, Nigeria</p>
      <p class="card-label">STAFF IDENTITY CARD</p>
    </div>
  </div>
  <div class="card-body">
    <div class="photo-section">
      <img src="{{ worker_photo }}" alt="Staff Photo" class="worker-photo" onerror="this.style.background='#ccc'">
    </div>
    <div class="details-section">
      <p class="worker-name">{{ worker_name }}</p>
      <table class="info-table">
        <tr><td class="label">Staff No:</td><td class="value">{{ staff_number }}</td></tr>
        <tr><td class="label">Department:</td><td class="value">{{ department }}</td></tr>
        <tr><td class="label">Designation:</td><td class="value">{{ designation }}</td></tr>
        <tr><td class="label">Grade Level:</td><td class="value">{{ grade_level }}</td></tr>
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
    <p class="back-title">KANO MUNICIPAL LOCAL GOVERNMENT AREA</p>
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
    <p>If found, please return to: HR Department, Kano Municipal LGA Secretariat, Kano.</p>
    <p>Tel: +234 801 234 5678 &nbsp;|&nbsp; Email: hr@lgadb.gov.ng</p>
    <p class="verify-text">Verify at: https://lgadb.gov.ng/verify/{{ verification_code }}</p>
  </div>
</body>
</html>
HTML;

        $css = <<<'CSS'
* { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
body.id-card { width: 85.6mm; height: 54mm; background: #fff; color: #111; font-size: 7pt; overflow: hidden; }
.card-header { display: flex; align-items: center; background: #006400; color: #fff; padding: 4px 6px; gap: 6px; }
.logo { width: 32px; height: 32px; object-fit: contain; }
.org-name { font-size: 8pt; font-weight: bold; line-height: 1.2; }
.org-subtitle { font-size: 6pt; }
.card-label { font-size: 7pt; font-weight: bold; letter-spacing: 0.5px; margin-top: 2px; }
.card-body { display: flex; padding: 4px 6px; gap: 6px; flex: 1; }
.worker-photo { width: 28mm; height: 30mm; object-fit: cover; border: 1px solid #ccc; }
.worker-name { font-size: 8pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; }
.info-table td { padding: 1px 2px; vertical-align: top; }
.info-table .label { font-weight: bold; white-space: nowrap; color: #555; width: 65px; }
.info-table .value { font-size: 7pt; }
.card-footer { background: #006400; color: #fff; text-align: center; padding: 2px; font-size: 6pt; }
.back-header { background: #006400; color: #fff; text-align: center; padding: 3px; }
.back-title { font-size: 7pt; font-weight: bold; }
.back-body { display: flex; padding: 4px 6px; gap: 6px; }
.qr-code { width: 22mm; height: 22mm; object-fit: contain; }
.verification-code { font-size: 6pt; text-align: center; margin-top: 2px; font-weight: bold; letter-spacing: 1px; }
.emergency-section { background: #f5f5f5; padding: 3px 6px; }
.emergency-label { font-weight: bold; font-size: 6pt; color: #c00; }
.back-footer { padding: 2px 6px; font-size: 5.5pt; color: #555; text-align: center; }
.verify-text { font-weight: bold; color: #006400; }
CSS;

        DB::table('id_card_templates')->upsert(
            [
                [
                    'id'         => 1,
                    'name'       => 'Default LGA Template',
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
