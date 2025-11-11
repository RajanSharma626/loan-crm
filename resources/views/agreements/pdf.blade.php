<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan Agreement - {{ $eagreement->application_number }}</title>
    <style>
        @page { margin: 30px 40px; }

        @font-face {
            font-family: 'GreatVibes';
            src: url('{{ public_path('fonts/GreatVibes-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.6;
        }
        .agreement-letter .letter-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .agreement-letter .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .agreement-letter .details-table td,
        .agreement-letter .details-table th {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            vertical-align: top;
        }
        .agreement-letter .details-table td:first-child {
            font-weight: 600;
            width: 38%;
            background-color: #f3f4f6;
        }
        .agreement-letter .details-table.particulars thead th {
            background-color: #111827;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 11px;
        }
        .agreement-letter .particulars tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .agreement-letter .terms-wrapper {
            margin-top: 20px;
            padding: 20px;
            background: #f9fafb;
            border-left: 3px solid #111827;
            border-radius: 6px;
        }
        .agreement-letter .terms-wrapper h3 {
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 12px;
        }
        .agreement-letter .terms-wrapper h4 {
            font-size: 13px;
            margin-top: 18px;
        }
        .agreement-letter .terms-wrapper p,
        .agreement-letter .terms-wrapper li {
            font-size: 12px;
        }
        .signature-area {
            margin-top: 35px;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 18px 20px;
        }
        .signature-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 25px;
        }
        .signature-box {
            flex: 1;
        }
        .signature-line {
            display: inline-block;
            min-width: 280px;
            border-bottom: 1px dotted #d1d5db;
            font-family: 'GreatVibes', 'Brush Script MT', cursive;
            font-size: 20px;
            color: #d97706;
            line-height: 1.1;
        }
        .signature-caption {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: #9ca3af;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .signature-place {
            margin-top: 4px;
            font-size: 11px;
            color: #374151;
            font-weight: 600;
        }
        .signature-ip {
            min-width: 140px;
            text-align: right;
            color: #1f2937;
        }
        .signature-ip span {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
            color: #9ca3af;
        }
        .signature-ip strong {
            font-size: 12px;
            color: #111827;
            letter-spacing: 0.06em;
        }
        .authorised-sign {
            margin-top: 25px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .authorised-sign .line {
            border-bottom: 1px dotted #374151;
            padding-bottom: 5px;
            width: 45%;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    @include('agreements.partials.letter', ['lead' => $lead, 'eagreement' => $eagreement])

    <div class="signature-area">
        <div class="signature-row">
            <div class="signature-box">
                <div class="signature-caption">
                    <span>Signature : &nbsp; <span class="signature-line">{{ $eagreement->signature ?? ($lead->first_name . ' ' . $lead->last_name) }}</span></span>
                </div>
                
                <div class="signature-place">Place: {{ $eagreement->acceptance_place ?? $lead->city ?? '________________' }}</div>
            </div>
            
            <div class="signature-ip">
                <span>IP Address</span>
                <strong>{{ $eagreement->acceptance_ip ?? '________________' }}</strong>
            </div>
        </div>
    </div>

</body>
</html>

