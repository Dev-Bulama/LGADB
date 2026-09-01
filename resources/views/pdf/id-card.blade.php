<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ID Card</title>
<style>
* { margin:0; padding:0; }
body { font-family: Arial, Helvetica, sans-serif; width:242.65pt; }

/* One big table per face — no overflow possible */
.card-table {
    width: 242.65pt;
    height: 153.07pt;
    border-collapse: collapse;
    table-layout: fixed;
    page-break-after: always;
}

/* ── FRONT header row ── */
.f-hdr-row { background: #064e3b; height: 26pt; }
.f-hdr-cell { padding: 4pt 7pt; vertical-align: middle; }
.logo-wrap { width: 22pt; vertical-align: middle; }
.logo-circle {
    width: 18pt; height: 18pt; border-radius: 9pt;
    background: #fff; text-align: center;
    font-size: 5.5pt; font-weight: bold; color: #064e3b;
    line-height: 18pt;
}
.org-name { font-size: 7pt; font-weight: bold; color: #fff; line-height: 1.2; }
.org-sub  { font-size: 4pt; color: #6ee7b7; margin-top: 1pt; }
.badge {
    border: 0.5pt solid #6ee7b7; padding: 2pt 3pt;
    font-size: 4pt; color: #a7f3d0; text-align: center;
    text-transform: uppercase; letter-spacing: 0.3pt; line-height: 1.4;
}

/* ── Accent stripe ── */
.stripe-row { height: 2.5pt; background: #10b981; }

/* ── FRONT body row ── */
.f-body-row { background: #fff; }
.f-body-cell { padding: 6pt 7pt 0 7pt; vertical-align: top; }

/* Photo */
.photo-outer { width: 46pt; vertical-align: top; }
.photo-frame {
    width: 40pt; height: 50pt;
    border: 2pt solid #064e3b; background: #d1fae5; overflow: hidden;
}
.photo-frame img { width: 36pt; height: 46pt; display: block; }
.photo-init {
    width: 36pt; height: 46pt; background: #d1fae5;
    text-align: center; line-height: 46pt;
    font-size: 20pt; font-weight: bold; color: #064e3b;
}
.photo-lbl {
    background: #064e3b; color: #fff;
    font-size: 3.5pt; text-align: center;
    padding: 1.5pt 0; text-transform: uppercase; letter-spacing: 0.3pt;
}

/* Info */
.info-outer { padding-left: 7pt; vertical-align: top; }
.w-name  { font-size: 9pt; font-weight: bold; color: #064e3b; margin-bottom: 2pt; }
.w-desig { font-size: 5.5pt; font-weight: bold; color: #059669; text-transform: uppercase; letter-spacing: 0.2pt; margin-bottom: 4pt; }
.row-lbl { font-size: 4pt; color: #9ca3af; text-transform: uppercase; width: 30pt; vertical-align: top; padding-right: 2pt; }
.row-val { font-size: 5pt; font-weight: bold; color: #1f2937; vertical-align: top; }
.id-chip {
    background: #064e3b; color: #fff;
    font-size: 7pt; font-weight: bold;
    font-family: 'Courier New', monospace;
    padding: 2pt 5pt; letter-spacing: 0.8pt;
}

/* ── FRONT footer row ── */
.f-ftr-row { background: #064e3b; height: 30pt; border-top: 2pt solid #10b981; }
.f-ftr-cell { padding: 4pt 7pt; vertical-align: middle; }
.exp-lbl { font-size: 4.5pt; color: #6ee7b7; text-transform: uppercase; letter-spacing: 0.3pt; }
.exp-val { font-size: 7.5pt; font-weight: bold; color: #fff; margin-top: 1pt; }
.sig-line  { width: 55pt; border-top: 0.5pt solid rgba(255,255,255,0.5); margin: 0 auto 1.5pt auto; }
.sig-lbl   { font-size: 3.5pt; color: #a7f3d0; text-align: center; }
.qr-td { width: 34pt; text-align: right; vertical-align: middle; }
.qr-box { background: #fff; padding: 2pt; display: inline-block; }
.qr-box img { width: 24pt; height: 24pt; display: block; }

/* ══════════════════════════════════════
   BACK
══════════════════════════════════════ */
.b-hdr-row  { background: #064e3b; height: 22pt; border-bottom: 2pt solid #10b981; }
.b-hdr-cell { padding: 4pt 8pt; text-align: center; vertical-align: middle; }
.b-org      { font-size: 7pt; font-weight: bold; color: #fff; text-transform: uppercase; letter-spacing: 0.7pt; }
.b-tagline  { font-size: 4pt; color: #6ee7b7; margin-top: 1pt; }

.b-body-row  { background: #fff; }
.b-body-cell { padding: 5pt 8pt 0 8pt; vertical-align: top; }

/* Info grid */
.b-grid { width: 100%; border-collapse: collapse; }
.b-gcell { vertical-align: top; padding: 0 4pt 0 4pt; border-right: 0.5pt solid #d1fae5; }
.b-gcell:first-child { padding-left: 0; }
.b-gcell:last-child  { border-right: none; }
.b-lbl { font-size: 4pt; color: #6b7280; text-transform: uppercase; font-weight: bold; letter-spacing: 0.3pt; border-bottom: 0.5pt solid #e5e7eb; padding-bottom: 1.5pt; margin-bottom: 2pt; }
.b-val { font-size: 5.5pt; color: #111827; font-weight: bold; line-height: 1.4; }
.b-sub { font-size: 4.5pt; color: #4b5563; margin-top: 1pt; }
.b-blood { font-size: 9pt; font-weight: bold; color: #064e3b; }

.b-div-row  { height: 1pt; background: #d1fae5; }

/* Verify bar */
.b-verify-row  { background: #f0fdf4; height: 16pt; border-top: 0.5pt solid #a7f3d0; border-bottom: 0.5pt solid #a7f3d0; }
.b-verify-cell { padding: 0 8pt; vertical-align: middle; }
.bv-lbl { font-size: 4pt; color: #6b7280; text-transform: uppercase; font-weight: bold; letter-spacing: 0.3pt; width: 38pt; vertical-align: middle; }
.bv-url { font-size: 5pt; color: #047857; font-weight: bold; vertical-align: middle; }

/* Back footer */
.b-ftr-row  { background: #064e3b; height: 24pt; }
.b-ftr-cell { padding: 3.5pt 8pt; vertical-align: middle; }
.b-terms    { font-size: 3.8pt; color: #a7f3d0; line-height: 1.6; width: 68%; vertical-align: middle; }
.b-ctc-lbl  { font-size: 4pt; color: #6ee7b7; text-transform: uppercase; letter-spacing: 0.2pt; }
.b-ctc-val  { font-size: 5pt; color: #fff; font-weight: bold; }
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
<table class="card-table">

    {{-- Header --}}
    <tr class="f-hdr-row">
        <td class="f-hdr-cell">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td class="logo-wrap">
                        <div class="logo-circle">LGA</div>
                    </td>
                    <td style="padding-left:5pt; vertical-align:middle;">
                        <div class="org-name">{{ strtoupper(config('lga.name', 'Ayobo Ipaja Local Council Development Area')) }}</div>
                        <div class="org-sub">Lagos State &bull; Federal Republic of Nigeria</div>
                    </td>
                    <td style="width:42pt; text-align:right; vertical-align:middle;">
                        <div class="badge">Official<br>ID Card</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Accent stripe --}}
    <tr><td class="stripe-row"></td></tr>

    {{-- Body --}}
    <tr class="f-body-row">
        <td class="f-body-cell">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    {{-- Photo --}}
                    <td class="photo-outer">
                        <div class="photo-frame">
                            @if($photoPath && file_exists($photoPath))
                                <img src="{{ $photoPath }}" alt="">
                            @else
                                <div class="photo-init">{{ strtoupper(substr($worker->surname, 0, 1)) }}</div>
                            @endif
                        </div>
                        <div class="photo-lbl">Photo</div>
                    </td>
                    {{-- Info --}}
                    <td class="info-outer">
                        <div class="w-name">{{ $worker->full_name }}</div>
                        @if($worker->designation)
                            <div class="w-desig">{{ $worker->designation }}</div>
                        @endif

                        <table style="border-collapse:collapse; margin-bottom:1.5pt;">
                            @if($worker->department)
                            <tr>
                                <td class="row-lbl">Department</td>
                                <td class="row-val">{{ $worker->department->name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="row-lbl">State</td>
                                <td class="row-val">{{ $stateName }}</td>
                            </tr>
                            <tr>
                                <td class="row-lbl">LGA</td>
                                <td class="row-val">{{ $lgaName }}</td>
                            </tr>
                            @if($worker->ward)
                            <tr>
                                <td class="row-lbl">Ward</td>
                                <td class="row-val">{{ $worker->ward->name }}</td>
                            </tr>
                            @endif
                        </table>

                        <span class="id-chip">{{ $worker->staff_number }}</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Footer --}}
    <tr class="f-ftr-row">
        <td class="f-ftr-cell">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="vertical-align:middle;">
                        <div class="exp-lbl">Expires</div>
                        <div class="exp-val">{{ $worker->id_expiry_date ? $worker->id_expiry_date->format('M Y') : 'See Reverse' }}</div>
                    </td>
                    <td style="text-align:center; vertical-align:middle;">
                        <div class="sig-line"></div>
                        <div class="sig-lbl">Authorised Signatory</div>
                    </td>
                    <td class="qr-td">
                        @if(!empty($qrCode))
                            <div class="qr-box">
                                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR">
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>

{{-- ══════ BACK ══════ --}}
<table class="card-table" style="page-break-after:auto;">

    {{-- Header --}}
    <tr class="b-hdr-row">
        <td class="b-hdr-cell">
            <div class="b-org">{{ strtoupper(config('lga.name', 'Ayobo Ipaja Local Council Development Area')) }}</div>
            <div class="b-tagline">If found, please return to the LGA Secretariat &bull; Igbogila, Ipaja Road, Lagos</div>
        </td>
    </tr>

    {{-- Info grid --}}
    <tr class="b-body-row">
        <td class="b-body-cell">
            <table class="b-grid">
                <tr>
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
                </tr>
            </table>
        </td>
    </tr>

    {{-- Divider --}}
    <tr><td class="b-div-row"></td></tr>

    {{-- Verify --}}
    <tr class="b-verify-row">
        <td class="b-verify-cell">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td class="bv-lbl">Verify Online</td>
                    <td class="bv-url">{{ route('verify.show', $worker->verification_code) }}</td>
                </tr>
            </table>
        </td>
    </tr>

    {{-- Footer --}}
    <tr class="b-ftr-row">
        <td class="b-ftr-cell">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td class="b-terms">
                        This card is the property of {{ config('lga.name', 'Ayobo Ipaja Local Council Development Area') }}.
                        Misuse is a punishable offence under Nigerian law.
                        Report lost cards immediately to the LGA Secretariat.
                    </td>
                    <td style="text-align:right; vertical-align:middle;">
                        @if(config('lga.phone'))
                            <div class="b-ctc-lbl">Hotline</div>
                            <div class="b-ctc-val">{{ config('lga.phone') }}</div>
                        @endif
                        <div class="b-ctc-lbl" style="margin-top:2pt;">Website</div>
                        <div class="b-ctc-val" style="font-size:4pt;">{{ str_replace(['https://','http://'],'',url('/')) }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>

</body>
</html>
