<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ID Card — {{ $worker->full_name }}</title>
<style>
* { margin: 0; padding: 0; }

/* Paper = 242.65pt × 153.07pt (CR80 85.6mm × 54mm at 72dpi) */
/* Each card-side fills the page exactly */

body {
    font-family: Arial, Helvetica, sans-serif;
    width: 242.65pt;
}

/* ─── FRONT ─── */
.front {
    width: 242.65pt;
    height: 153.07pt;
    background-color: #065f46;
    color: #ffffff;
    overflow: hidden;
    page-break-after: always;
}

/* Header bar */
.hdr {
    background-color: #043a28;
    width: 242.65pt;
    padding: 5pt 8pt 4pt 8pt;
    border-bottom: 1pt solid #a7f3d0;
}
.hdr table { width: 100%; border-collapse: collapse; }
.hdr td { padding: 0; vertical-align: middle; }
.logo-circle {
    width: 20pt;
    height: 20pt;
    background-color: #ffffff;
    border-radius: 10pt;
    text-align: center;
    line-height: 20pt;
}
.logo-text { color: #043a28; font-size: 6pt; font-weight: bold; }
.hdr-org { font-size: 8pt; font-weight: bold; color: #ffffff; letter-spacing: 0.3pt; }
.hdr-sub { font-size: 5.5pt; color: #a7f3d0; margin-top: 1pt; }

/* Body */
.body {
    padding: 5pt 8pt 0pt 8pt;
    width: 242.65pt;
}
.body table { width: 100%; border-collapse: collapse; }
.body td { padding: 0; vertical-align: top; }

.photo-td { width: 48pt; }
.photo-img { width: 44pt; height: 56pt; border: 1pt solid rgba(255,255,255,0.5); }
.photo-placeholder {
    width: 44pt;
    height: 56pt;
    background-color: #047857;
    border: 1pt solid rgba(255,255,255,0.4);
    text-align: center;
    line-height: 56pt;
    font-size: 18pt;
    font-weight: bold;
    color: rgba(255,255,255,0.9);
}

.info-td { padding-left: 7pt; }
.w-name  { font-size: 9pt; font-weight: bold; color: #ffffff; line-height: 1.15; margin-bottom: 3pt; }
.w-desig { font-size: 6.5pt; color: #6ee7b7; font-weight: bold; margin-bottom: 2pt; }
.w-dept  { font-size: 5.5pt; color: #d1fae5; margin-bottom: 1.5pt; }
.w-no    {
    font-size: 6.5pt;
    font-weight: bold;
    color: #d1fae5;
    font-family: 'Courier New', monospace;
    margin-top: 5pt;
    padding-top: 3pt;
    border-top: 0.5pt solid rgba(255,255,255,0.2);
}

/* Footer bar */
.ftr {
    background-color: #043a28;
    border-top: 0.8pt solid rgba(255,255,255,0.25);
    padding: 4pt 8pt;
    margin-top: 5pt;
    width: 242.65pt;
}
.ftr table { width: 100%; border-collapse: collapse; }
.ftr td { padding: 0; vertical-align: middle; }
.exp-label { font-size: 5pt; color: #6ee7b7; }
.exp-val   { font-size: 7pt; font-weight: bold; color: #ffffff; margin-top: 1pt; }
.qr-wrap   { width: 32pt; text-align: right; }
.qr-inner  { background-color: #ffffff; padding: 2pt; display: inline-block; }
.qr-inner img { width: 28pt; height: 28pt; display: block; }

/* Issuer signature area */
.sig-line  { border-top: 0.5pt solid rgba(255,255,255,0.4); width: 60pt; margin-top: 1pt; }
.sig-label { font-size: 4.5pt; color: #a7f3d0; margin-top: 1pt; }

/* ─── BACK ─── */
.back {
    width: 242.65pt;
    height: 153.07pt;
    background-color: #f0fdf4;
    overflow: hidden;
}

.back-hdr {
    background-color: #064e3b;
    padding: 5pt 8pt;
    text-align: center;
    width: 242.65pt;
    border-bottom: 1pt solid #047857;
}
.back-org  { font-size: 7pt; font-weight: bold; color: #ffffff; text-transform: uppercase; letter-spacing: 0.5pt; }
.back-tag  { font-size: 5pt; color: #a7f3d0; margin-top: 1pt; }

.back-body { padding: 5pt 8pt 0 8pt; }
.back-body table { width: 100%; border-collapse: collapse; }
.back-body td { vertical-align: top; padding: 0 3pt 0 0; }

.bl { font-size: 4.5pt; color: #6b7280; text-transform: uppercase; font-weight: bold; margin-bottom: 1.5pt; }
.bv { font-size: 5.5pt; color: #111827; line-height: 1.4; }

.divider { border: none; border-top: 0.5pt solid #a7f3d0; margin: 4pt 8pt; }

.url-section { padding: 0 8pt; }
.url-label { font-size: 4.5pt; color: #6b7280; text-transform: uppercase; font-weight: bold; margin-bottom: 1.5pt; }
.url-val   { font-size: 5.5pt; color: #047857; font-weight: bold; }

.back-ftr {
    background-color: #dcfce7;
    border-top: 0.5pt solid #a7f3d0;
    padding: 3.5pt 8pt;
    margin-top: 4pt;
    width: 242.65pt;
}
.back-ftr table { width: 100%; border-collapse: collapse; }
.back-ftr td { vertical-align: top; padding: 0; }
.terms  { font-size: 4pt; color: #6b7280; line-height: 1.5; }
.ci     { text-align: right; }
.ci-lbl { font-size: 4pt; color: #6b7280; }
.ci-val { font-size: 5pt; color: #064e3b; font-weight: bold; }
</style>
</head>
<body>

{{-- ═══════════ FRONT ═══════════ --}}
<div class="front">

    <div class="hdr">
        <table>
            <tr>
                <td style="width: 24pt;">
                    <div class="logo-circle"><span class="logo-text">LGA</span></div>
                </td>
                <td>
                    <div class="hdr-org">{{ strtoupper(config('lga.name', 'Alimosho LGA')) }}</div>
                    <div class="hdr-sub">Official Resident Identity Card</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="body">
        <table>
            <tr>
                <td class="photo-td">
                    @php
                        $photoPath = $worker->hasMedia('profile_photo')
                            ? $worker->getFirstMediaPath('profile_photo')
                            : null;
                    @endphp
                    @if($photoPath && file_exists($photoPath))
                        <img src="{{ $photoPath }}" class="photo-img" alt="">
                    @else
                        <div class="photo-placeholder">{{ strtoupper(substr($worker->surname, 0, 1)) }}</div>
                    @endif
                </td>
                <td class="info-td">
                    <div class="w-name">{{ strtoupper($worker->full_name) }}</div>
                    @if($worker->designation)
                        <div class="w-desig">{{ $worker->designation }}</div>
                    @endif
                    <div class="w-dept" style="font-size: 5pt;">Ayobo Ipaja Local Council Development Area</div>
                    <div class="w-dept" style="font-size: 5pt;">Igbogila, Ipaja Road. Lagos</div>
                    <div class="w-no">ID: {{ $worker->staff_number }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="ftr">
        <table>
            <tr>
                <td>
                    <div class="exp-label">EXPIRES</div>
                    <div class="exp-val">
                        {{ $worker->id_expiry_date ? $worker->id_expiry_date->format('M Y') : 'N/A' }}
                    </div>
                    <div style="margin-top: 4pt;">
                        <div class="sig-line"></div>
                        <div class="sig-label">{{ config('lga.name', 'Alimosho LGA') }} — Authorised Signatory</div>
                    </div>
                </td>
                <td class="qr-wrap">
                    @if(!empty($qrCode))
                        <div class="qr-inner">
                            <img src="data:image/png;base64,{{ $qrCode }}" alt="Scan to verify">
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</div>

{{-- ═══════════ BACK ═══════════ --}}
<div class="back">

    <div class="back-hdr">
        <div class="back-org">{{ strtoupper(config('lga.name', 'Alimosho LGA')) }}</div>
        <div class="back-tag">If found, please return to the LGA Secretariat</div>
    </div>

    <div class="back-body">
        <table>
            <tr>
                <td style="width: 42%;">
                    <div class="bl">Emergency Contact</div>
                    <div class="bv">{{ $worker->emergency_contact_name ?? $worker->next_of_kin_name ?? 'N/A' }}</div>
                    <div class="bv">{{ $worker->emergency_contact_phone ?? $worker->next_of_kin_phone ?? '' }}</div>
                </td>
                <td style="width: 22%;">
                    <div class="bl">Blood Group</div>
                    <div class="bv">{{ $worker->blood_group ?? 'N/A' }}</div>
                </td>
                <td style="width: 18%;">
                    <div class="bl">Gender</div>
                    <div class="bv">{{ ucfirst($worker->gender?->value ?? 'N/A') }}</div>
                </td>
                <td style="width: 18%;">
                    <div class="bl">Ward</div>
                    <div class="bv" style="font-size: 4.5pt;">{{ $worker->ward?->name ?? ($worker->lga?->name ?? 'N/A') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <hr class="divider">

    <div class="url-section">
        <div class="url-label">Verification URL</div>
        <div class="url-val">{{ route('verify.show', $worker->verification_code) }}</div>
    </div>

    <div class="back-ftr">
        <table>
            <tr>
                <td style="width: 62%;">
                    <div class="terms">This card is the property of {{ config('lga.name', 'Alimosho LGA') }}.
                    Misuse is a punishable offence under Nigerian law. Report lost cards immediately to the LGA Secretariat.</div>
                </td>
                <td class="ci" style="width: 38%;">
                    @if(config('lga.phone'))
                        <div class="ci-lbl">Hotline</div>
                        <div class="ci-val">{{ config('lga.phone') }}</div>
                    @endif
                    <div class="ci-lbl" style="margin-top: 2pt;">Website</div>
                    <div class="ci-val" style="font-size: 4.5pt;">{{ str_replace(['https://', 'http://'], '', url('/')) }}</div>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
