<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan Agreement - {{ $eagreement->application_number }}</title>
    <style>
        @page { margin: 25px 35px; }

        @font-face {
            font-family: 'GreatVibes';
            src: url('{{ public_path('fonts/GreatVibes-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            font-size: 11px;
            line-height: 1.4;
        }
        .agreement-letter {
            page-break-inside: avoid;
        }
        .agreement-letter .terms-wrapper {
            page-break-inside: auto;
        }
        .agreement-letter .details-table {
            page-break-inside: auto;
        }
        .agreement-letter .letter-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .agreement-letter .letter-address {
            margin-bottom: 10px;
        }
        .agreement-letter .letter-address p {
            margin: 0;
            line-height: 1.5;
        }
        .agreement-letter p {
            margin-bottom: 10px;
            line-height: 1.5;
        }
        .agreement-letter .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            font-size: 10px;
        }
        .agreement-letter .details-table td,
        .agreement-letter .details-table th {
            border: 1px solid #d1d5db;
            padding: 5px 8px;
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
            font-size: 10px;
            padding: 6px 8px;
        }
        .agreement-letter .particulars tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .agreement-letter .terms-wrapper {
            margin-top: 12px;
            padding: 15px;
            background: #f9fafb;
            border-left: 3px solid #111827;
            border-radius: 6px;
        }
        .agreement-letter .terms-wrapper h3 {
            text-transform: uppercase;
            font-size: 12px;
            margin-bottom: 8px;
            margin-top: 0;
        }
        .agreement-letter .terms-wrapper h4 {
            font-size: 11px;
            margin-top: 12px;
            margin-bottom: 6px;
        }
        .agreement-letter .terms-wrapper p,
        .agreement-letter .terms-wrapper li {
            font-size: 10px;
            line-height: 1.4;
            margin-bottom: 8px;
        }
        .agreement-letter .terms-wrapper ol {
            padding-left: 20px;
            margin-bottom: 8px;
        }
        .agreement-letter .terms-wrapper li {
            margin-bottom: 6px;
        }
        .signature-area {
            margin-top: 15px;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 12px 15px;
            page-break-inside: avoid;
        }
        .signature-row {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        .signature-box {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 20px;
        }
        .stamp-box {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            min-width: 200px;
            border-bottom: 1px dotted #d1d5db;
            font-family: 'GreatVibes', 'Brush Script MT', cursive;
            font-size: 18px;
            color: #1d4ed8;
            text-shadow: 0.8px 0.8px 0 rgba(29, 78, 216, 0.35);
            line-height: 1.05;
            margin-bottom: 6px;
        }
        .signature-caption {
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #9ca3af;
            margin-bottom: 6px;
        }
        .signature-place {
            margin-top: 6px;
            font-size: 10px;
            color: #374151;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .signature-ip {
            margin-top: 6px;
            font-size: 10px;
            color: #374151;
            font-weight: 600;
        }
        .signature-ip span {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 3px;
            color: #9ca3af;
        }
        .signature-ip strong {
            font-size: 11px;
            color: #111827;
            letter-spacing: 0.06em;
        }
        .stamp-box img {
            width: 100px;
            height: auto;
            display: block;
            margin-left: auto;
        }
        .authorised-sign {
            margin-top: 20px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .authorised-sign .line {
            border-bottom: 1px dotted #374151;
            padding-bottom: 4px;
            width: 45%;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    @include('agreements.partials.letter', ['lead' => $lead, 'eagreement' => $eagreement])
</body>
</html>

