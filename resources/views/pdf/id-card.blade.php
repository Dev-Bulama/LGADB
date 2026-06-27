<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LGA Staff ID Card — {{ $worker->full_name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            width: 85.6mm;
            background: white;
        }

        /* ===== CARD FRONT ===== */
        .card-front {
            width: 85.6mm;
            height: 53.98mm;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);
            color: white;
            padding: 5mm;
            position: relative;
            page-break-after: always;
            overflow: hidden;
        }

        /* Decorative circle */
        .card-front::before {
            content: '';
            position: absolute;
            right: -10mm;
            bottom: -10mm;
            width: 35mm;
            height: 35mm;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .card-front::after {
            content: '';
            position: absolute;
            right: 5mm;
            bottom: -5mm;
            width: 20mm;
            height: 20mm;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
        }

        .card-header {
            display: flex;
            align-items: center;
            border-bottom: 0.5px solid rgba(255,255,255,0.3);
            padding-bottom: 2.5mm;
            margin-bottom: 3mm;
        }
        .card-logo {
            width: 7mm;
            height: 7mm;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 2mm;
        }
        .card-logo-text {
            color: #064e3b;
            font-size: 4pt;
            font-weight: 900;
        }
        .card-title-block p {
            color: white;
            font-size: 5pt;
            font-weight: 700;
            line-height: 1.3;
        }
        .card-title-block small {
            color: rgba(167,243,208,1);
            font-size: 4pt;
        }

        .card-body {
            display: flex;
            gap: 3mm;
            align-items: flex-start;
        }
        .card-photo {
            width: 16mm;
            height: 18mm;
            object-fit: cover;
            border-radius: 2mm;
            border: 1px solid rgba(255,255,255,0.4);
            flex-shrink: 0;
        }
        .card-photo-placeholder {
            width: 16mm;
            height: 18mm;
            background: rgba(255,255,255,0.15);
            border-radius: 2mm;
            border: 1px solid rgba(255,255,255,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .card-photo-placeholder span {
            font-size: 8pt;
            font-weight: 900;
            color: rgba(255,255,255,0.8);
        }
        .card-info {
            flex: 1;
        }
        .card-name {
            font-size: 7pt;
            font-weight: 900;
            line-height: 1.3;
            margin-bottom: 1mm;
        }
        .card-designation {
            font-size: 5.5pt;
            color: rgba(167,243,208,1);
            font-weight: 600;
            margin-bottom: 1mm;
        }
        .card-dept {
            font-size: 5pt;
            color: rgba(209,250,229,1);
            margin-bottom: 2mm;
        }
        .card-staff-no {
            font-family: 'Courier New', monospace;
            font-size: 6pt;
            color: rgba(209,250,229,1);
            font-weight: 700;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 3mm;
            padding-top: 2mm;
            border-top: 0.5px solid rgba(255,255,255,0.2);
            position: relative;
            z-index: 1;
        }
        .card-expiry-label {
            font-size: 4pt;
            color: rgba(167,243,208,1);
        }
        .card-expiry-value {
            font-size: 5.5pt;
            font-weight: 700;
        }
        .card-qr-box {
            width: 13mm;
            height: 13mm;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1mm;
        }
        .card-qr-box img {
            width: 12mm;
            height: 12mm;
        }

        /* ===== CARD BACK ===== */
        .card-back {
            width: 85.6mm;
            height: 53.98mm;
            background: #f0fdf4;
            border: 1.5px solid #064e3b;
            padding: 5mm;
            display: flex;
            flex-direction: column;
        }
        .card-back-header {
            text-align: center;
            border-bottom: 0.5px solid #a7f3d0;
            padding-bottom: 2mm;
            margin-bottom: 3mm;
        }
        .card-back-header p {
            font-size: 5pt;
            color: #064e3b;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }
        .card-back-header small {
            font-size: 4pt;
            color: #047857;
        }
        .back-section {
            margin-bottom: 2mm;
        }
        .back-label {
            font-size: 4pt;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 0.5mm;
        }
        .back-value {
            font-size: 5pt;
            color: #1f2937;
        }
        .back-row {
            display: flex;
            gap: 5mm;
        }
        .back-row .back-section {
            flex: 1;
        }
        .card-back-footer {
            margin-top: auto;
            border-top: 0.5px solid #a7f3d0;
            padding-top: 2mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .back-terms {
            font-size: 3.5pt;
            color: #6b7280;
            flex: 1;
            line-height: 1.4;
            margin-right: 3mm;
        }
        .back-url {
            font-size: 4pt;
            color: #047857;
            font-weight: 700;
            word-break: break-all;
            text-align: right;
            max-width: 30mm;
        }
    </style>
</head>
<body>

    {{-- ===== CARD FRONT ===== --}}
    <div class="card-front">

        <div class="card-header">
            <div class="card-logo">
                <span class="card-logo-text">LGA</span>
            </div>
            <div class="card-title-block">
                <p>{{ strtoupper(config('app.name')) }}</p>
                <small>OFFICIAL STAFF IDENTITY CARD</small>
            </div>
        </div>

        <div class="card-body">
            @if($worker->profile_photo_url)
                <img src="{{ $worker->profile_photo_url }}" class="card-photo" alt="{{ $worker->full_name }}">
            @else
                <div class="card-photo-placeholder">
                    <span>{{ strtoupper(substr($worker->full_name, 0, 1)) }}</span>
                </div>
            @endif

            <div class="card-info">
                <div class="card-name">{{ strtoupper($worker->full_name) }}</div>
                <div class="card-designation">{{ $worker->designation ?? 'LGA Staff' }}</div>
                <div class="card-dept">{{ $worker->department?->name ?? '' }}</div>
                @if($worker->unit?->name)
                    <div class="card-dept">{{ $worker->unit->name }}</div>
                @endif
                <div class="card-staff-no">No: {{ $worker->staff_number }}</div>
            </div>
        </div>

        <div class="card-footer">
            <div>
                <div class="card-expiry-label">EXPIRES</div>
                <div class="card-expiry-value">
                    {{ $worker->id_expiry_date ? $worker->id_expiry_date->format('M Y') : 'N/A' }}
                </div>
            </div>
            <div class="card-qr-box">
                @if($qrCode ?? false)
                    {!! $qrCode !!}
                @else
                    <span style="font-size:4pt;color:#064e3b;font-weight:900;">QR</span>
                @endif
            </div>
        </div>

    </div>

    {{-- ===== CARD BACK ===== --}}
    <div class="card-back">

        <div class="card-back-header">
            <p>{{ strtoupper(config('app.name')) }}</p>
            <small>If found, please return to the LGA Secretariat</small>
        </div>

        <div class="back-row">
            <div class="back-section">
                <div class="back-label">Emergency Contact</div>
                <div class="back-value">{{ $worker->emergency_contact_name ?? $worker->next_of_kin_name ?? 'N/A' }}</div>
                <div class="back-value">{{ $worker->emergency_contact_phone ?? $worker->next_of_kin_phone ?? '' }}</div>
            </div>
            <div class="back-section">
                <div class="back-label">Blood Group</div>
                <div class="back-value">{{ $worker->blood_group ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="back-section" style="margin-top:2mm;">
            <div class="back-label">Verification URL</div>
            <div class="back-value" style="font-family: monospace; font-size:4.5pt; color:#047857;">
                {{ route('verify.show', $worker->verification_code) }}
            </div>
        </div>

        <div class="card-back-footer">
            <div class="back-terms">
                This card is the property of {{ config('app.name') }}. Misuse is an offence. 
                Report lost cards immediately to the LGA Secretariat.
            </div>
            <div class="back-url">
                <div style="font-size:3.5pt; color:#6b7280; margin-bottom:1mm;">Hotline</div>
                <div>{{ config('lga.phone', 'N/A') }}</div>
                <div style="margin-top:1mm; font-size:3.5pt; color:#6b7280;">Website</div>
                <div style="font-size:4pt;">{{ str_replace(['https://', 'http://'], '', url('/')) }}</div>
            </div>
        </div>

    </div>

</body>
</html>
