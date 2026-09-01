<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ID Card — {{ $worker->full_name }}</title>
<style>
* { margin: 0; padding: 0; }
body { font-family: Arial, Helvetica, sans-serif; width: 242.65pt; background: #fff; }

/* ── FRONT ── */
.front {
    width: 242.65pt;
    height: 153.07pt;
    background: #ffffff;
    overflow: hidden;
    page-break-after: always;
}

/* Header */
.f-hdr {
    background-color: #064e3b;
    width: 242.65pt;
    padding: 5pt 7pt 4pt 7pt;
}
.f-hdr table { width: 100%; border-collapse: collapse; }
.f-hdr td { vertical-align: middle; padding: 0; }
.logo-circle {
    width: 18pt; height: 18pt; border-radius: 9pt;
    background: #ffffff; text-align: center;
    font-size: 5.5pt; font-weight: bold; color: #064e3b;
    line-height: 18pt;
}
.org-name { font-size: 7.5pt; font-weight: bold; color: #ffffff; letter-spacing: 0.3pt; line-height: 1.2; }
.org-sub  { font-size: 4.5pt; color: #6ee7b7; margin-top: 1pt; }
.badge-box {
    border: 0.5pt solid #6ee7b7; padding: 2pt 4pt;
    text-align: center; font-size: 4pt; color: #a7f3d0;
    text-transform: uppercase; letter-spacing: 0.3pt; line-height: 1.5;
}

/* Accent stripe */
.f-stripe { background: #10b981; height: 2.5pt; width: 242.65pt; }

/* Body */
.f-body { padding: 6pt 7pt 0 7pt; }
.f-body > table { width: 100%; border-collapse: collapse; }
.f-body > table > tr > td { vertical-align: top; padding: 0; }

/* Photo */
.photo-col { width: 50pt; }
.photo-frame {
    width: 44pt; height: 55pt;
    border: 2pt solid #064e3b;
    background: #d1fae5;
    overflow: hidden;
}
.photo-frame img { width: 40pt; height: 51pt; display: block; }
.photo-initial {
    width: 40pt; height: 51pt;
    background: #d1fae5;
    text-align: center; line-height: 51pt;
    font-size: 22pt; font-weight: bold; color: #064e3b;
}
.photo-label {
    background: #064e3b; color: #ffffff;
    font-size: 4pt; text-align: center;
    padding: 1.5pt 0; text-transform: uppercase; letter-spacing: 0.4pt;
}

/* Info */
.info-col { padding-left: 7pt; }
.w-name  { font-size: 9.5pt; font-weight: bold; color: #064e3b; line-height: 1.2; margin-bottom: 2pt; }
.w-desig { font-size: 6pt; font-weight: bold; color: #059669; text-transform: uppercase; letter-spacing: 0.2pt; margin-bottom: 4pt; }
.info-row table { border-collapse: collapse; margin-bottom: 1.5pt; }
.info-row td { padding: 0; vertical-align: top; }
.i-lbl { font-size: 4pt; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.2pt; width: 30pt; padding-right: 2pt; }
.i-val { font-size: 5pt; font-weight: bold; color: #1f2937; }

/* ID chip */
.id-chip {
    margin-top: 5pt;
    background: #064e3b;
    color: #ffffff;
    font-size: 7pt;
    font-weight: bold;
    font-family: 'Courier New', monospace;
    padding: 2.5pt 6pt;
    letter-spacing: 1pt;
    display: inline-block;
}

/* Footer */
.f-ftr {
    background: #064e3b;
    width: 242.65pt;
    padding: 4pt 7pt;
    border-top: 2pt solid #10b981;
    margin-top: 5pt;
}
.f-ftr table { width: 100%; border-collapse: collapse; }
.f-ftr td { vertical-align: middle; padding: 0; }
.exp-lbl { font-size: 4.5pt; color: #6ee7b7; text-transform: uppercase; letter-spacing: 0.3pt; }
.exp-val { font-size: 8pt; font-weight: bold; color: #ffffff; margin-top: 1pt; }
.sig-center { text-align: center; }
.sig-line  { width: 60pt; border-top: 0.5pt solid rgba(255,255,255,0.5); margin: 0 auto 1.5pt auto; }
.sig-label { font-size: 4pt; color: #a7f3d0; }
.qr-td { width: 34pt; text-align: right; }
.qr-box { background: #ffffff; padding: 2pt; display: inline-block; }
.qr-box img { width: 26pt; height: 26pt; display: block; }

/* ── BACK ── */
.back {
    width: 242.65pt;
    height: 153.07pt;
    background: #ffffff;
    overflow: hidden;
}
.b-hdr {
    background: #064e3b;
    width: 242.65pt;
    padding: 5pt 8pt;
    text-align: center;
    border-bottom: 2pt solid #10b981;
}
.b-org    { font-size: 7pt; font-weight: bold; color: #ffffff; text-transform: uppercase; letter-spacing: 0.8pt; }
.b-tagline{ font-size: 4.5pt; color: #6ee7b7; margin-top: 1pt; }

.b-grid { padding: 6pt 8pt 0 8pt; }
.b-grid table { width: 100%; border-collapse: collapse; }
.b-grid td { vertical-align: top; padding: 0 4pt 0 4pt; border-right: 0.5pt solid #d1fae5; }
.b-grid td:first-child { padding-left: 0; }
.b-grid td:last-child  { border-right: none; }
.b-lbl { font-size: 4pt; color: #6b7280; text-transform: uppercase; font-weight: bold; letter-spacing: 0.3pt; border-bottom: 0.5pt solid #e5e7eb; padding-bottom: 1.5pt; margin-bottom: 2pt; }
.b-val { font-size: 5.5pt; color: #111827; font-weight: bold; line-height: 1.4; }
.b-sub { font-size: 4.5pt; color: #4b5563; margin-top: 1pt; }
.b-blood { font-size: 10pt; font-weight: bold; color: #064e3b; }

.b-divider { height: 0.5pt; background: #d1fae5; margin: 5pt 8pt 4pt 8pt; }

.b-verify { background: #f0fdf4; border-top: 0.5pt solid #a7f3d0; border-bottom: 0.5pt solid #a7f3d0; padding: 3pt 8pt; }
.b-verify table { width: 100%; border-collapse: collapse; }
.b-verify td { vertical-align: middle; padding: 0; }
.bv-lbl { font-size: 4pt; color: #6b7280; text-transform: uppercase; font-weight: bold; letter-spacing: 0.3pt; width: 38pt; }
.bv-url { font-size: 5pt; color: #047857; font-weight: bold; }

.b-ftr {
    background: #064e3b;
    width: 242.65pt;
    padding: 4pt 8pt;
    margin-top: 5pt;
}
.b-ftr table { width: 100%; border-collapse: collapse; }
.b-ftr td { vertical-align: middle; padding: 0; }
.b-terms { font-size: 3.8pt; color: #a7f3d0; line-height: 1.6; width: 68%; }
.b-contact-lbl { font-size: 4pt; color: #6ee7b7; text-transform: uppercase; letter-spacing: 0.2pt; }
.b-contact-val { font-size: 5pt; color: #ffffff; font-weight: bold; }
</style>
</head>
<body>

{{-- ══════ FRONT ══════ --}}
<div class="front">

    <div class="f-hdr">
        <table>
            <tr>
                <td style="width:22pt;">
                    <div class="logo-circle">LGA</div>
                </td>
                <td style="padding-left:5pt;">
                    <div class="org-name">{{ strtoupper(config('lga.name', 'Ayobo Ipaja Local Council Development Area')) }}</div>
                    <div class="org-sub">Lagos State &bull; Federal Republic of Nigeria</div>
                </td>
                <td style="width:44pt; text-align:right;">
                    <div class="badge-box">Official<br>ID Card</div>
                </td>
            </tr>
        </table>
    </div>
    <div class="f-stripe"></div>

    <div class="f-body">
        <table>
            <tr>
                {{-- Photo --}}
                <td class="photo-col">
                    @php
                        $photoPath = $worker->hasMedia('profile_photo')
                            ? $worker->getFirstMediaPath('profile_photo')
                            : null;
                    @endphp
                    <div class="photo-frame">
                        @if($photoPath && file_exists($photoPath))
                            <img src="{{ $photoPath }}" alt="">
                        @else
                            <div class="photo-initial">{{ strtoupper(substr($worker->surname, 0, 1)) }}</div>
                        @endif
                    </div>
                    <div class="photo-label">Photo</div>
                </td>

                {{-- Info --}}
                <td class="info-col">
                    <div class="w-name">{{ $worker->full_name }}</div>
                    @if($worker->designation)
                        <div class="w-desig">{{ $worker->designation }}</div>
                    @endif

                    <div class="info-row">
                        @if($worker->department)
                        <table><tr>
                            <td class="i-lbl">Department</td>
                            <td class="i-val">{{ $worker->department->name }}</td>
                        </tr></table>
                        @endif

                        @php
                            $stateName = $worker->state?->name ?? $worker->state_name ?? '—';
                            $lgaName   = $worker->lga?->name   ?? $worker->lga_name   ?? '—';
                        @endphp
                        <table><tr>
                            <td class="i-lbl">State</td>
                            <td class="i-val">{{ $stateName }}</td>
                        </tr></table>
                        <table><tr>
                            <td class="i-lbl">LGA</td>
                            <td class="i-val">{{ $lgaName }}</td>
                        </tr></table>
                        @if($worker->ward)
                        <table><tr>
                            <td class="i-lbl">Ward</td>
                            <td class="i-val">{{ $worker->ward->name }}</td>
                        </tr></table>
                        @endif
                    </div>

                    <div class="id-chip">{{ $worker->staff_number }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="f-ftr">
        <table>
            <tr>
                <td>
                    <div class="exp-lbl">Expires</div>
                    <div class="exp-val">{{ $worker->id_expiry_date ? $worker->id_expiry_date->format('M Y') : 'See Reverse' }}</div>
                </td>
                <td class="sig-center">
                    <div class="sig-line"></div>
                    <div class="sig-label">Authorised Signatory</div>
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
    </div>

</div>

{{-- ══════ BACK ══════ --}}
<div class="back">

    <div class="b-hdr">
        <div class="b-org">{{ strtoupper(config('lga.name', 'Ayobo Ipaja Local Council Development Area')) }}</div>
        <div class="b-tagline">If found, please return to the LGA Secretariat &bull; Igbogila, Ipaja Road, Lagos</div>
    </div>

    <div class="b-grid">
        <table>
            <tr>
                <td style="width:38%;">
                    <div class="b-lbl">Emergency Contact</div>
                    <div class="b-val">{{ $worker->emergency_contact_name ?? $worker->next_of_kin_name ?? 'N/A' }}</div>
                    <div class="b-sub">{{ $worker->emergency_contact_phone ?? $worker->next_of_kin_phone ?? '' }}</div>
                </td>
                <td style="width:18%;">
                    <div class="b-lbl">Blood Group</div>
                    <div class="b-blood">{{ $worker->blood_group ?? 'N/A' }}</div>
                </td>
                <td style="width:18%;">
                    <div class="b-lbl">Gender</div>
                    <div class="b-val">{{ ucfirst($worker->gender?->value ?? 'N/A') }}</div>
                </td>
                <td style="width:26%;">
                    <div class="b-lbl">Ward / LGA</div>
                    <div class="b-val" style="font-size:4.5pt;">{{ $worker->ward?->name ?? ($worker->lga?->name ?? $worker->lga_name ?? 'N/A') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="b-divider"></div>

    <div class="b-verify">
        <table>
            <tr>
                <td class="bv-lbl">Verify Online</td>
                <td class="bv-url">{{ route('verify.show', $worker->verification_code) }}</td>
            </tr>
        </table>
    </div>

    <div class="b-ftr">
        <table>
            <tr>
                <td class="b-terms">
                    This card is the property of {{ config('lga.name', 'Ayobo Ipaja Local Council Development Area') }}.
                    Misuse is a punishable offence under Nigerian law.
                    Report lost cards immediately to the LGA Secretariat.
                </td>
                <td style="text-align:right;">
                    @if(config('lga.phone'))
                        <div class="b-contact-lbl">Hotline</div>
                        <div class="b-contact-val">{{ config('lga.phone') }}</div>
                    @endif
                    <div class="b-contact-lbl" style="margin-top:2pt;">Website</div>
                    <div class="b-contact-val" style="font-size:4pt;">{{ str_replace(['https://','http://'],'',url('/')) }}</div>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
