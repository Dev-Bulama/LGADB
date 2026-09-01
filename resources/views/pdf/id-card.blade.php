<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ID Card — {{ $worker->full_name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: Arial, Helvetica, sans-serif;
    width: 242.65pt;
    background: #fff;
}

/* ══════════════════════════════════════════
   FRONT
══════════════════════════════════════════ */
.front {
    width: 242.65pt;
    height: 153.07pt;
    background: #ffffff;
    overflow: hidden;
    page-break-after: always;
    position: relative;
}

/* ── Top header band ── */
.f-header {
    background: #064e3b;
    width: 100%;
    padding: 5pt 7pt 4pt 7pt;
    display: table;
}
.f-header-logo {
    display: table-cell;
    width: 22pt;
    vertical-align: middle;
}
.f-logo-circle {
    width: 18pt;
    height: 18pt;
    border-radius: 9pt;
    background: #ffffff;
    text-align: center;
    line-height: 18pt;
    font-size: 5pt;
    font-weight: bold;
    color: #064e3b;
}
.f-header-text {
    display: table-cell;
    vertical-align: middle;
    padding-left: 4pt;
}
.f-org {
    font-size: 7.5pt;
    font-weight: bold;
    color: #ffffff;
    letter-spacing: 0.3pt;
    line-height: 1.2;
}
.f-sub {
    font-size: 5pt;
    color: #6ee7b7;
    margin-top: 1pt;
    letter-spacing: 0.2pt;
}
.f-header-badge {
    display: table-cell;
    vertical-align: middle;
    text-align: right;
    width: 50pt;
}
.f-badge {
    font-size: 4.5pt;
    color: #a7f3d0;
    border: 0.5pt solid #a7f3d0;
    padding: 1pt 3pt;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.3pt;
}

/* ── Green accent stripe under header ── */
.f-stripe {
    width: 100%;
    height: 3pt;
    background: linear-gradient(to right, #059669, #34d399, #059669);
    background: #10b981;
}

/* ── Body ── */
.f-body {
    padding: 6pt 7pt 0pt 7pt;
    display: table;
    width: 100%;
}

/* Photo column */
.f-photo-col {
    display: table-cell;
    vertical-align: top;
    width: 50pt;
}
.f-photo-wrap {
    width: 46pt;
    height: 58pt;
    border: 2pt solid #064e3b;
    background: #ecfdf5;
    overflow: hidden;
    position: relative;
}
.f-photo-wrap img {
    width: 42pt;
    height: 54pt;
    display: block;
}
.f-photo-placeholder {
    width: 100%;
    height: 100%;
    background: #d1fae5;
    text-align: center;
    line-height: 54pt;
    font-size: 22pt;
    font-weight: bold;
    color: #064e3b;
}
.f-photo-label {
    background: #064e3b;
    color: #ffffff;
    font-size: 4pt;
    text-align: center;
    padding: 1.5pt 0;
    text-transform: uppercase;
    letter-spacing: 0.3pt;
}

/* Info column */
.f-info-col {
    display: table-cell;
    vertical-align: top;
    padding-left: 7pt;
}
.f-name {
    font-size: 9.5pt;
    font-weight: bold;
    color: #064e3b;
    line-height: 1.2;
    margin-bottom: 2pt;
    text-transform: uppercase;
}
.f-desig {
    font-size: 6pt;
    font-weight: bold;
    color: #059669;
    text-transform: uppercase;
    letter-spacing: 0.2pt;
    margin-bottom: 3pt;
}
.f-dept-row {
    display: table;
    width: 100%;
    margin-bottom: 1.5pt;
}
.f-dept-label {
    display: table-cell;
    font-size: 4.5pt;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.2pt;
    width: 35pt;
    vertical-align: top;
}
.f-dept-value {
    display: table-cell;
    font-size: 5pt;
    color: #1f2937;
    font-weight: bold;
    vertical-align: top;
}

/* ID number chip */
.f-id-chip {
    margin-top: 5pt;
    background: #064e3b;
    color: #ffffff;
    font-size: 7.5pt;
    font-weight: bold;
    font-family: 'Courier New', monospace;
    padding: 2.5pt 5pt;
    display: inline-block;
    letter-spacing: 1pt;
}

/* ── Footer band ── */
.f-footer {
    background: #064e3b;
    width: 100%;
    padding: 4pt 7pt;
    display: table;
    margin-top: 5pt;
    border-top: 1.5pt solid #10b981;
}
.f-footer-left {
    display: table-cell;
    vertical-align: middle;
}
.f-footer-center {
    display: table-cell;
    vertical-align: middle;
    text-align: center;
}
.f-footer-right {
    display: table-cell;
    vertical-align: middle;
    text-align: right;
    width: 36pt;
}
.f-exp-label {
    font-size: 4.5pt;
    color: #6ee7b7;
    text-transform: uppercase;
    letter-spacing: 0.3pt;
}
.f-exp-val {
    font-size: 8pt;
    font-weight: bold;
    color: #ffffff;
    margin-top: 1pt;
}
.f-sig-line {
    width: 55pt;
    border-top: 0.5pt solid rgba(255,255,255,0.5);
    margin: 1pt auto 1pt auto;
}
.f-sig-label {
    font-size: 4pt;
    color: #a7f3d0;
    text-align: center;
}
.f-qr-wrap {
    background: #ffffff;
    padding: 2pt;
    display: inline-block;
}
.f-qr-wrap img {
    width: 26pt;
    height: 26pt;
    display: block;
}

/* ══════════════════════════════════════════
   BACK
══════════════════════════════════════════ */
.back {
    width: 242.65pt;
    height: 153.07pt;
    background: #ffffff;
    overflow: hidden;
}

/* ── Back header ── */
.b-header {
    background: #064e3b;
    width: 100%;
    padding: 5pt 8pt;
    text-align: center;
    border-bottom: 2pt solid #10b981;
}
.b-org {
    font-size: 7.5pt;
    font-weight: bold;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.8pt;
}
.b-tagline {
    font-size: 4.5pt;
    color: #6ee7b7;
    margin-top: 1pt;
    letter-spacing: 0.2pt;
}

/* ── Back info grid ── */
.b-grid {
    padding: 6pt 8pt 4pt 8pt;
    display: table;
    width: 100%;
}
.b-cell {
    display: table-cell;
    vertical-align: top;
    padding-right: 4pt;
    border-right: 0.5pt solid #d1fae5;
    padding-left: 4pt;
}
.b-cell:first-child { padding-left: 0; }
.b-cell:last-child  { border-right: none; }
.b-label {
    font-size: 4pt;
    color: #6b7280;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 0.3pt;
    margin-bottom: 2pt;
    border-bottom: 0.5pt solid #e5e7eb;
    padding-bottom: 1pt;
}
.b-value {
    font-size: 5.5pt;
    color: #111827;
    line-height: 1.4;
    font-weight: bold;
}
.b-value-sub {
    font-size: 4.5pt;
    color: #4b5563;
    margin-top: 1pt;
}

/* Blood group highlight */
.b-blood {
    font-size: 9pt;
    font-weight: bold;
    color: #064e3b;
}

/* ── Divider ── */
.b-divider {
    height: 0.5pt;
    background: #d1fae5;
    margin: 0 8pt;
}

/* ── Verification URL bar ── */
.b-verify {
    background: #f0fdf4;
    border-top: 0.5pt solid #a7f3d0;
    border-bottom: 0.5pt solid #a7f3d0;
    padding: 3pt 8pt;
    display: table;
    width: 100%;
    margin-top: 0;
}
.b-verify-label {
    display: table-cell;
    font-size: 4pt;
    color: #6b7280;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 0.3pt;
    vertical-align: middle;
    width: 40pt;
}
.b-verify-url {
    display: table-cell;
    font-size: 5pt;
    color: #047857;
    font-weight: bold;
    vertical-align: middle;
}

/* ── Back footer ── */
.b-footer {
    background: #064e3b;
    width: 100%;
    padding: 4pt 8pt;
    display: table;
    position: absolute;
    bottom: 0;
    left: 0;
}
.b-footer-terms {
    display: table-cell;
    font-size: 4pt;
    color: #a7f3d0;
    line-height: 1.6;
    vertical-align: middle;
    width: 68%;
}
.b-footer-contact {
    display: table-cell;
    text-align: right;
    vertical-align: middle;
}
.b-contact-label {
    font-size: 4pt;
    color: #6ee7b7;
    text-transform: uppercase;
    letter-spacing: 0.2pt;
}
.b-contact-val {
    font-size: 5pt;
    color: #ffffff;
    font-weight: bold;
}
</style>
</head>
<body>

{{-- ══════════════════ FRONT ══════════════════ --}}
<div class="front">

    {{-- Header --}}
    <div class="f-header">
        <div class="f-header-logo">
            <div class="f-logo-circle">LGA</div>
        </div>
        <div class="f-header-text">
            <div class="f-org">{{ strtoupper(config('lga.name', 'Ayobo Ipaja Local Council Development Area')) }}</div>
            <div class="f-sub">Lagos State &bull; Federal Republic of Nigeria</div>
        </div>
        <div class="f-header-badge">
            <div class="f-badge">Official<br>ID Card</div>
        </div>
    </div>
    <div class="f-stripe"></div>

    {{-- Body --}}
    <div class="f-body">

        {{-- Photo --}}
        <div class="f-photo-col">
            @php
                $photoPath = $worker->hasMedia('profile_photo')
                    ? $worker->getFirstMediaPath('profile_photo')
                    : null;
            @endphp
            <div class="f-photo-wrap">
                @if($photoPath && file_exists($photoPath))
                    <img src="{{ $photoPath }}" alt="">
                @else
                    <div class="f-photo-placeholder">{{ strtoupper(substr($worker->surname, 0, 1)) }}</div>
                @endif
            </div>
            <div class="f-photo-label">Photo</div>
        </div>

        {{-- Info --}}
        <div class="f-info-col">
            <div class="f-name">{{ $worker->full_name }}</div>
            @if($worker->designation)
                <div class="f-desig">{{ $worker->designation }}</div>
            @endif

            @if($worker->department)
            <div class="f-dept-row">
                <div class="f-dept-label">Dept.</div>
                <div class="f-dept-value">{{ $worker->department->name }}</div>
            </div>
            @endif

            @php
                $stateName = $worker->state?->name ?? $worker->state_name ?? '—';
                $lgaName   = $worker->lga?->name   ?? $worker->lga_name   ?? '—';
            @endphp
            <div class="f-dept-row">
                <div class="f-dept-label">State</div>
                <div class="f-dept-value">{{ $stateName }}</div>
            </div>
            <div class="f-dept-row">
                <div class="f-dept-label">LGA</div>
                <div class="f-dept-value">{{ $lgaName }}</div>
            </div>

            <div class="f-id-chip">{{ $worker->staff_number }}</div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="f-footer">
        <div class="f-footer-left">
            <div class="f-exp-label">Expires</div>
            <div class="f-exp-val">
                {{ $worker->id_expiry_date ? $worker->id_expiry_date->format('M Y') : 'See Reverse' }}
            </div>
        </div>
        <div class="f-footer-center">
            <div class="f-sig-line"></div>
            <div class="f-sig-label">Authorised Signatory</div>
        </div>
        <div class="f-footer-right">
            @if(!empty($qrCode))
                <div class="f-qr-wrap">
                    <img src="data:image/png;base64,{{ $qrCode }}" alt="Scan to verify">
                </div>
            @endif
        </div>
    </div>

</div>

{{-- ══════════════════ BACK ══════════════════ --}}
<div class="back" style="position:relative;">

    {{-- Header --}}
    <div class="b-header">
        <div class="b-org">{{ strtoupper(config('lga.name', 'Ayobo Ipaja Local Council Development Area')) }}</div>
        <div class="b-tagline">If found, please return to the LGA Secretariat &bull; Igbogila, Ipaja Road, Lagos</div>
    </div>

    {{-- Info grid --}}
    <div class="b-grid">
        <div class="b-cell" style="width:40%;">
            <div class="b-label">Emergency Contact</div>
            <div class="b-value">{{ $worker->emergency_contact_name ?? $worker->next_of_kin_name ?? 'N/A' }}</div>
            <div class="b-value-sub">{{ $worker->emergency_contact_phone ?? $worker->next_of_kin_phone ?? '' }}</div>
        </div>
        <div class="b-cell" style="width:18%;">
            <div class="b-label">Blood Group</div>
            <div class="b-blood">{{ $worker->blood_group ?? 'N/A' }}</div>
        </div>
        <div class="b-cell" style="width:18%;">
            <div class="b-label">Gender</div>
            <div class="b-value">{{ ucfirst($worker->gender?->value ?? 'N/A') }}</div>
        </div>
        <div class="b-cell" style="width:24%;">
            <div class="b-label">Ward / LGA</div>
            <div class="b-value" style="font-size:4.5pt;">{{ $worker->ward?->name ?? ($worker->lga?->name ?? $worker->lga_name ?? 'N/A') }}</div>
        </div>
    </div>

    <div class="b-divider"></div>

    {{-- Verification --}}
    <div class="b-verify">
        <div class="b-verify-label">Verify Online</div>
        <div class="b-verify-url">{{ route('verify.show', $worker->verification_code) }}</div>
    </div>

    {{-- Footer --}}
    <div class="b-footer">
        <div class="b-footer-terms">
            This card is the property of {{ config('lga.name', 'Ayobo Ipaja Local Council Development Area') }}.
            Misuse is a punishable offence under Nigerian law.
            Report lost cards immediately to the LGA Secretariat.
        </div>
        <div class="b-footer-contact">
            @if(config('lga.phone'))
                <div class="b-contact-label">Hotline</div>
                <div class="b-contact-val">{{ config('lga.phone') }}</div>
            @endif
            <div class="b-contact-label" style="margin-top:2pt;">Web</div>
            <div class="b-contact-val" style="font-size:4pt;">{{ str_replace(['https://','http://'],'',url('/')) }}</div>
        </div>
    </div>

</div>

</body>
</html>
