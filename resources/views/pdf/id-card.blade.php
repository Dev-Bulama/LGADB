<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ID Card</title>
<style>
* { margin:0; padding:0; }
body { font-family: Arial, Helvetica, sans-serif; }

.face {
    width: 242.65pt;
    height: 153.07pt;
    overflow: hidden;
    position: relative;
    page-break-after: always;
    background: #ffffff;
}

/* ── FRONT ── */
.f-top {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 26pt;
    background: #064e3b;
}
.f-top table { width: 100%; border-collapse: collapse; height: 26pt; }
.f-top td { vertical-align: middle; padding: 0 7pt; }

.logo-c {
    width: 18pt; height: 18pt; border-radius: 9pt;
    background: #fff; text-align: center; line-height: 18pt;
    font-size: 5.5pt; font-weight: bold; color: #064e3b;
}
.org-n { font-size: 7pt; font-weight: bold; color: #fff; line-height: 1.2; }
.org-s { font-size: 4pt; color: #6ee7b7; margin-top: 1pt; }
.badge {
    border: 0.5pt solid #6ee7b7; padding: 2pt 3pt; font-size: 4pt;
    color: #a7f3d0; text-align: center; text-transform: uppercase;
    letter-spacing: 0.3pt; line-height: 1.4;
}

.f-stripe {
    position: absolute;
    top: 26pt; left: 0; right: 0;
    height: 2.5pt; background: #10b981;
}

.f-bot {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 28pt;
    background: #064e3b;
    border-top: 2pt solid #10b981;
}
.f-bot table { width: 100%; border-collapse: collapse; height: 28pt; }
.f-bot td { vertical-align: middle; padding: 0 7pt; }

.exp-l { font-size: 4.5pt; color: #6ee7b7; text-transform: uppercase; }
.exp-v { font-size: 7.5pt; font-weight: bold; color: #fff; margin-top: 1pt; }
.sig-line { width: 55pt; border-top: 0.5pt solid rgba(255,255,255,0.5); margin: 0 auto 1.5pt auto; }
.sig-lbl  { font-size: 3.5pt; color: #a7f3d0; text-align: center; }

.qr-box { background: #fff; padding: 2pt; display: inline-block; }
.qr-box img { width: 22pt; height: 22pt; display: block; }

.f-mid {
    position: absolute;
    top: 28.5pt; left: 7pt; right: 7pt; bottom: 30pt;
}
.f-mid table { width: 100%; border-collapse: collapse; }
.f-mid td { vertical-align: top; padding: 0; }

.photo-frame {
    width: 38pt; height: 48pt;
    border: 2pt solid #064e3b;
    overflow: hidden; background: #d1fae5;
}
.photo-frame img { width: 34pt; height: 44pt; display: block; }
.photo-init {
    width: 34pt; height: 44pt;
    background: #d1fae5; text-align: center;
    line-height: 44pt; font-size: 18pt; font-weight: bold; color: #064e3b;
}
.photo-lbl {
    background: #064e3b; color: #fff; font-size: 3.5pt;
    text-align: center; padding: 1.5pt 0;
    text-transform: uppercase; letter-spacing: 0.3pt;
}

.info-cell { padding-left: 7pt; vertical-align: top; }
.w-name  { font-size: 8.5pt; font-weight: bold; color: #064e3b; line-height: 1.2; margin-bottom: 1.5pt; }
.w-desig { font-size: 5.5pt; font-weight: bold; color: #059669; text-transform: uppercase; margin-bottom: 3pt; }
.row-lbl { font-size: 4pt; color: #9ca3af; text-transform: uppercase; width: 32pt; padding-right: 2pt; vertical-align: top; }
.row-val { font-size: 5pt; font-weight: bold; color: #1f2937; vertical-align: top; }
.id-chip {
    background: #064e3b; color: #fff; font-size: 6.5pt;
    font-weight: bold; font-family: 'Courier New', monospace;
    padding: 2pt 5pt; letter-spacing: 0.8pt;
}

/* ── BACK ── */
.b-top {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 22pt; background: #064e3b;
    border-bottom: 2pt solid #10b981;
    text-align: center;
}
.b-org  { font-size: 7pt; font-weight: bold; color: #fff; text-transform: uppercase; letter-spacing: 0.7pt; line-height: 22pt; }
.b-tag  { font-size: 4pt; color: #6ee7b7; margin-top: -4pt; }

.b-bot {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 22pt; background: #064e3b;
}
.b-bot table { width: 100%; border-collapse: collapse; height: 22pt; }
.b-bot td { vertical-align: middle; padding: 0 8pt; }
.bt-terms { font-size: 3.8pt; color: #a7f3d0; line-height: 1.6; width: 68%; }
.bt-lbl { font-size: 4pt; color: #6ee7b7; text-transform: uppercase; }
.bt-val { font-size: 5pt; color: #fff; font-weight: bold; }

.b-verify {
    position: absolute;
    bottom: 22pt; left: 0; right: 0;
    height: 14pt; background: #f0fdf4;
    border-top: 0.5pt solid #a7f3d0;
    border-bottom: 0.5pt solid #a7f3d0;
}
.b-verify table { width: 100%; border-collapse: collapse; height: 14pt; }
.b-verify td { vertical-align: middle; padding: 0 8pt; }
.bv-lbl { font-size: 4pt; color: #6b7280; text-transform: uppercase; font-weight: bold; width: 36pt; }
.bv-url { font-size: 5pt; color: #047857; font-weight: bold; }

.b-mid {
    position: absolute;
    top: 24pt; left: 8pt; right: 8pt; bottom: 37pt;
}
.b-grid { width: 100%; border-collapse: collapse; }
.b-gcell { vertical-align: top; padding: 0 4pt; border-right: 0.5pt solid #d1fae5; }
.b-gcell:first-child { padding-left: 0; }
.b-gcell:last-child  { border-right: none; }
.b-lbl { font-size: 4pt; color: #6b7280; text-transform: uppercase; font-weight: bold; border-bottom: 0.5pt solid #e5e7eb; padding-bottom: 1.5pt; margin-bottom: 2pt; }
.b-val { font-size: 5.5pt; color: #111827; font-weight: bold; line-height: 1.4; }
.b-sub { font-size: 4.5pt; color: #4b5563; margin-top: 1pt; }
.b-blood { font-size: 9pt; font-weight: bold; color: #064e3b; }
</style>
</head>
<body>

@php
    $photoPath = $worker->hasMedia('profile_photo')
        ? $worker->getFirstMediaPath('profile_photo')
        : null;
    $stateName = $worker->state?->name ?? $worker->state_name ?? '—';
    $lgaName   = $worker->lga?->name   ?? $worker->lga_name   ?? '—';
@endphp

{{-- ══════ FRONT ══════ --}}
<div class="face">

    {{-- Top bar --}}
    <div class="f-top">
        <table><tr>
            <td style="width:24pt;">
                <div class="logo-c">LGA</div>
            </td>
            <td>
                <div class="org-n">{{ strtoupper(config('lga.name', 'Ayobo Ipaja Local Council Development Area')) }}</div>
                <div class="org-s">Lagos State &bull; Federal Republic of Nigeria</div>
            </td>
            <td style="width:44pt; text-align:right;">
                <div class="badge">Official<br>ID Card</div>
            </td>
        </tr></table>
    </div>

    {{-- Stripe --}}
    <div class="f-stripe"></div>

    {{-- Bottom bar --}}
    <div class="f-bot">
        <table><tr>
            <td>
                <div class="exp-l">Expires</div>
                <div class="exp-v">{{ $worker->id_expiry_date ? $worker->id_expiry_date->format('M Y') : 'See Reverse' }}</div>
            </td>
            <td style="text-align:center;">
                <div class="sig-line"></div>
                <div class="sig-lbl">Authorised Signatory</div>
            </td>
            <td style="width:34pt; text-align:right;">
                @if(!empty($qrCode))
                    <div class="qr-box">
                        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR">
                    </div>
                @endif
            </td>
        </tr></table>
    </div>

    {{-- Middle body --}}
    <div class="f-mid">
        <table><tr>
            <td style="width:46pt;">
                <div class="photo-frame">
                    @if($photoPath && file_exists($photoPath))
                        <img src="{{ $photoPath }}" alt="">
                    @else
                        <div class="photo-init">{{ strtoupper(substr($worker->surname, 0, 1)) }}</div>
                    @endif
                </div>
                <div class="photo-lbl">Photo</div>
            </td>
            <td class="info-cell">
                <div class="w-name">{{ $worker->full_name }}</div>
                @if($worker->designation)
                    <div class="w-desig">{{ $worker->designation }}</div>
                @endif
                <table style="border-collapse:collapse; margin-bottom:3pt;">
                    @if($worker->department)
                    <tr><td class="row-lbl">Department</td><td class="row-val">{{ $worker->department->name }}</td></tr>
                    @endif
                    <tr><td class="row-lbl">State</td><td class="row-val">{{ $stateName }}</td></tr>
                    <tr><td class="row-lbl">LGA</td><td class="row-val">{{ $lgaName }}</td></tr>
                    @if($worker->ward)
                    <tr><td class="row-lbl">Ward</td><td class="row-val">{{ $worker->ward->name }}</td></tr>
                    @endif
                </table>
                <span class="id-chip">{{ $worker->staff_number }}</span>
            </td>
        </tr></table>
    </div>

</div>

{{-- ══════ BACK ══════ --}}
<div class="face" style="page-break-after:auto;">

    {{-- Top bar --}}
    <div class="b-top">
        <div class="b-org">{{ strtoupper(config('lga.name', 'Ayobo Ipaja Local Council Development Area')) }}</div>
        <div class="b-tag">If found, please return to the LGA Secretariat &bull; Igbogila, Ipaja Road, Lagos</div>
    </div>

    {{-- Verify bar --}}
    <div class="b-verify">
        <table><tr>
            <td class="bv-lbl">Verify Online</td>
            <td class="bv-url">{{ route('verify.show', $worker->verification_code) }}</td>
        </tr></table>
    </div>

    {{-- Bottom bar --}}
    <div class="b-bot">
        <table><tr>
            <td class="bt-terms">
                This card is the property of {{ config('lga.name', 'Ayobo Ipaja Local Council Development Area') }}.
                Misuse is a punishable offence under Nigerian law.
                Report lost cards immediately to the LGA Secretariat.
            </td>
            <td style="text-align:right;">
                @if(config('lga.phone'))
                    <div class="bt-lbl">Hotline</div>
                    <div class="bt-val">{{ config('lga.phone') }}</div>
                @endif
                <div class="bt-lbl" style="margin-top:2pt;">Website</div>
                <div class="bt-val" style="font-size:4pt;">{{ str_replace(['https://','http://'],'',url('/')) }}</div>
            </td>
        </tr></table>
    </div>

    {{-- Info grid --}}
    <div class="b-mid">
        <table class="b-grid"><tr>
            <td class="b-gcell" style="width:38%;">
                <div class="b-lbl">Emergency Contact</div>
                <div class="b-val">{{ $worker->emergency_contact_name ?? $worker->next_of_kin_name ?? 'N/A' }}</div>
                <div class="b-sub">{{ $worker->emergency_contact_phone ?? $worker->next_of_kin_phone ?? '' }}</div>
            </td>
            <td class="b-gcell" style="width:18%;">
                <div class="b-lbl">Blood Group</div>
                <div class="b-blood">{{ $worker->blood_group ?? 'N/A' }}</div>
            </td>
            <td class="b-gcell" style="width:18%;">
                <div class="b-lbl">Gender</div>
                <div class="b-val">{{ ucfirst($worker->gender?->value ?? 'N/A') }}</div>
            </td>
            <td class="b-gcell" style="width:26%;">
                <div class="b-lbl">Ward / LGA</div>
                <div class="b-val" style="font-size:4.5pt;">{{ $worker->ward?->name ?? $lgaName }}</div>
            </td>
        </tr></table>
    </div>

</div>

</body>
</html>
