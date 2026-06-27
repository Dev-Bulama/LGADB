<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ID Card — {{ $worker->full_name }}</title>
<style>
* { margin: 0; padding: 0; }
body { font-family: Arial, Helvetica, sans-serif; }

/* ===================== FRONT ===================== */
.front {
    width: 85.6mm;
    height: 54mm;
    background-color: #065f46;
    color: white;
    overflow: hidden;
    page-break-after: always;
}

.front-header {
    background-color: #043927;
    padding: 2mm 3mm 2mm 3mm;
    border-bottom: 0.5pt solid #a7f3d0;
}
.front-header table { width: 100%; border-collapse: collapse; }
.front-header td { vertical-align: middle; padding: 0; }

.logo-wrap {
    width: 8mm;
    height: 8mm;
    background-color: white;
    border-radius: 4mm;
    text-align: center;
    line-height: 8mm;
}
.logo-wrap span {
    color: #043927;
    font-size: 4pt;
    font-weight: bold;
}
.hdr-org {
    font-size: 5.5pt;
    font-weight: bold;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.3pt;
}
.hdr-sub {
    font-size: 3.8pt;
    color: #a7f3d0;
    margin-top: 0.5mm;
}

.front-body {
    padding: 2.5mm 3mm 0 3mm;
}
.front-body table { width: 100%; border-collapse: collapse; }
.front-body td { vertical-align: top; padding: 0; }

.photo-cell { width: 16mm; }
.photo-img {
    width: 15mm;
    height: 19mm;
    border: 0.8pt solid rgba(255,255,255,0.5);
}
.photo-placeholder {
    width: 15mm;
    height: 19mm;
    background-color: #047857;
    border: 0.8pt solid rgba(255,255,255,0.4);
    text-align: center;
    line-height: 19mm;
    font-size: 11pt;
    font-weight: bold;
    color: white;
}

.info-cell { padding-left: 2.5mm; }
.worker-name {
    font-size: 7pt;
    font-weight: bold;
    color: white;
    margin-bottom: 1.5mm;
    line-height: 1.2;
}
.worker-desig {
    font-size: 5.5pt;
    color: #a7f3d0;
    font-weight: bold;
    margin-bottom: 1mm;
}
.worker-dept {
    font-size: 4.8pt;
    color: #d1fae5;
    margin-bottom: 0.8mm;
}
.worker-no {
    font-size: 5.5pt;
    font-weight: bold;
    color: #d1fae5;
    font-family: 'Courier New', monospace;
    margin-top: 1.5mm;
    border-top: 0.5pt solid rgba(255,255,255,0.2);
    padding-top: 1mm;
}

.front-footer {
    padding: 1.5mm 3mm 1.5mm 3mm;
    border-top: 0.5pt solid rgba(255,255,255,0.25);
    background-color: #043927;
    margin-top: 2mm;
}
.front-footer table { width: 100%; border-collapse: collapse; }
.front-footer td { vertical-align: middle; padding: 0; }

.expiry-label { font-size: 3.8pt; color: #a7f3d0; }
.expiry-val { font-size: 5.5pt; font-weight: bold; color: white; margin-top: 0.5mm; }

.qr-wrap {
    width: 14mm;
    height: 14mm;
    background-color: white;
    padding: 1mm;
    float: right;
}
.qr-wrap img { width: 12mm; height: 12mm; }

/* ===================== BACK ===================== */
.back {
    width: 85.6mm;
    height: 54mm;
    background-color: #f0fdf4;
    overflow: hidden;
}

.back-header {
    background-color: #064e3b;
    color: white;
    text-align: center;
    padding: 2mm 3mm;
    border-bottom: 1pt solid #065f46;
}
.back-org {
    font-size: 6pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5pt;
    color: white;
}
.back-tagline { font-size: 3.8pt; color: #a7f3d0; margin-top: 0.5mm; }

.back-body { padding: 1.5mm 3mm; }
.back-body table { width: 100%; border-collapse: collapse; }
.back-body td { vertical-align: top; padding: 0 1mm 0 0; }

.bl { font-size: 3.5pt; color: #6b7280; text-transform: uppercase; font-weight: bold; margin-bottom: 0.5mm; }
.bv { font-size: 4.8pt; color: #1f2937; line-height: 1.3; }

.back-divider {
    border: none;
    border-top: 0.5pt solid #a7f3d0;
    margin: 1.5mm 3mm;
}

.back-url-section { padding: 0 3mm; }
.verify-label { font-size: 3.5pt; color: #6b7280; text-transform: uppercase; font-weight: bold; margin-bottom: 0.5mm; }
.verify-url { font-size: 4.5pt; color: #047857; font-weight: bold; }

.back-footer {
    border-top: 0.5pt solid #a7f3d0;
    padding: 1.5mm 3mm;
    background-color: #ecfdf5;
    margin-top: 1.5mm;
}
.back-footer table { width: 100%; border-collapse: collapse; }
.back-footer td { vertical-align: top; padding: 0; }
.terms { font-size: 3.5pt; color: #6b7280; line-height: 1.5; }
.contact-info { text-align: right; }
.ci-label { font-size: 3.5pt; color: #6b7280; }
.ci-val { font-size: 4pt; color: #064e3b; font-weight: bold; }
</style>
</head>
<body>

{{-- =================== FRONT =================== --}}
<div class="front">

    <div class="front-header">
        <table>
            <tr>
                <td style="width: 10mm;">
                    <div class="logo-wrap"><span>LGA</span></div>
                </td>
                <td>
                    <div class="hdr-org">{{ strtoupper(config('lga.name', 'Alimosho LGA')) }}</div>
                    <div class="hdr-sub">Official Staff Identity Card</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="front-body">
        <table>
            <tr>
                <td class="photo-cell">
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
                <td class="info-cell">
                    <div class="worker-name">{{ strtoupper($worker->full_name) }}</div>
                    <div class="worker-desig">{{ $worker->designation }}</div>
                    @if($worker->department?->name)
                        <div class="worker-dept">{{ $worker->department->name }}</div>
                    @endif
                    @if($worker->unit?->name)
                        <div class="worker-dept">{{ $worker->unit->name }}</div>
                    @endif
                    <div class="worker-no">No: {{ $worker->staff_number }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="front-footer">
        <table>
            <tr>
                <td>
                    <div class="expiry-label">EXPIRES</div>
                    <div class="expiry-val">
                        {{ $worker->id_expiry_date ? $worker->id_expiry_date->format('M Y') : 'N/A' }}
                    </div>
                </td>
                <td style="text-align: right; width: 16mm;">
                    @if(!empty($qrCode))
                        <div class="qr-wrap">
                            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR">
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</div>

{{-- =================== BACK =================== --}}
<div class="back">

    <div class="back-header">
        <div class="back-org">{{ strtoupper(config('lga.name', 'Alimosho LGA')) }}</div>
        <div class="back-tagline">If found, please return to the LGA Secretariat</div>
    </div>

    <div class="back-body">
        <table>
            <tr>
                <td style="width: 45%;">
                    <div class="bl">Emergency Contact</div>
                    <div class="bv">{{ $worker->emergency_contact_name ?? $worker->next_of_kin_name ?? 'N/A' }}</div>
                    <div class="bv">{{ $worker->emergency_contact_phone ?? $worker->next_of_kin_phone ?? '' }}</div>
                </td>
                <td style="width: 25%;">
                    <div class="bl">Blood Group</div>
                    <div class="bv">{{ $worker->blood_group ?? 'N/A' }}</div>
                </td>
                <td style="width: 30%;">
                    <div class="bl">Gender</div>
                    <div class="bv">{{ ucfirst($worker->gender?->value ?? 'N/A') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <hr class="back-divider">

    <div class="back-url-section">
        <div class="verify-label">Verification URL</div>
        <div class="verify-url">{{ route('verify.show', $worker->verification_code) }}</div>
    </div>

    <div class="back-footer">
        <table>
            <tr>
                <td style="width: 65%;">
                    <div class="terms">
                        This card is the property of {{ config('lga.name', 'Alimosho LGA') }}.
                        Misuse is an offence. Report lost cards immediately to the LGA Secretariat.
                    </div>
                </td>
                <td class="contact-info" style="width: 35%;">
                    @if(config('lga.phone'))
                        <div class="ci-label">Hotline</div>
                        <div class="ci-val">{{ config('lga.phone') }}</div>
                    @endif
                    <div class="ci-label" style="margin-top: 1mm;">Website</div>
                    <div class="ci-val" style="font-size:3.5pt;">{{ str_replace(['https://', 'http://'], '', url('/')) }}</div>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
