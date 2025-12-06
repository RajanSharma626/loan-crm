<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Agreement Acceptance - {{ $eagreement->application_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'GreatVibes';
            src: url('{{ asset('fonts/GreatVibes-Regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            background-color: #f3f4f6;
            font-family: 'Arial', sans-serif;
            color: #1f2937;
        }
        .agreement-wrapper {
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            padding: 45px 50px;
            border-radius: 12px;
            box-shadow: 0 15px 45px rgba(15, 23, 42, 0.15);
        }
        .agreement-letter .letter-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        .agreement-letter .letter-address p {
            margin: 0;
            line-height: 1.5;
        }
        .agreement-letter p {
            line-height: 1.8;
            margin-bottom: 15px;
        }
        .agreement-letter .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            font-size: 14px;
        }
        .agreement-letter .details-table td,
        .agreement-letter .details-table th {
            border: 1px solid #e5e7eb;
            padding: 12px 16px;
            vertical-align: top;
        }
        .agreement-letter .details-table td:first-child {
            font-weight: 600;
            width: 38%;
            background-color: #f9fafb;
        }
        .agreement-letter .details-table.particulars thead th {
            background: #111827;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 13px;
        }
        .agreement-letter .particulars tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .agreement-letter .terms-wrapper {
            margin-top: 40px;
            padding: 30px;
            background: #f9fafb;
            border-left: 4px solid #111827;
            border-radius: 8px;
        }
        .agreement-letter .terms-wrapper h3 {
            text-transform: uppercase;
            font-size: 18px;
            margin-bottom: 20px;
            color: #111827;
        }
        .agreement-letter .terms-wrapper h4 {
            font-size: 16px;
            margin-top: 25px;
            color: #111827;
        }
        .agreement-letter .terms-wrapper p,
        .agreement-letter .terms-wrapper li {
            color: #374151;
            font-size: 14px;
            line-height: 1.8;
        }
        .agreement-letter .terms-wrapper ol {
            padding-left: 18px;
        }
        .acceptance-form {
            margin-top: 50px;
            background: #f3f4f6;
            color: #1f2937;
            padding: 35px;
            border-radius: 12px;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
        }
        .acceptance-form h4 {
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 25px;
        }
        .acceptance-form label {
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 12px;
            font-weight: 600;
        }
        .acceptance-form textarea {
            background: #ffffff;
            border: 1px solid #d1d5db;
            color: #1f2937;
        }
        .signature-input {
            font-size: 18px;
            color: #1f2937;
            letter-spacing: 0.8px;
            background: #ffffff;
        }
        .acceptance-form .dotted-line {
            border-bottom: 2px dotted #9ca3af;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        .acceptance-form .signature-preview {
            font-family: 'GreatVibes', 'Brush Script MT', cursive;
            font-size: 30px;
            color: #1d4ed8;
            letter-spacing: 3px;
            line-height: 1.1;
        }
        .acceptance-form .place-preview {
            font-family: 'GreatVibes', 'Brush Script MT', cursive;
            font-size: 32px;
            color: #1d4ed8;
            letter-spacing: 0.8px;
        }
        .acceptance-form .btn-verify {
            background-color: #007d88;
            color: #ffffff;
            font-weight: 700;
            padding: 12px 45px;
            border: none;
            border-radius: 999px;
            letter-spacing: 0.08em;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .acceptance-form .btn-verify:hover {
            transform: translateY(-2px);
            background-color: #01626b;
        }
        .download-actions {
            margin-top: 20px;
            text-align: right;
        }
        .download-actions a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 999px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .download-actions a.download-link {
            background: #111827;
            color: #f3f4f6;
        }
        .download-actions a.download-link:hover {
            background: #1f2937;
            transform: translateY(-2px);
        }
        @media print {
            body { background: #ffffff; }
            .agreement-wrapper { box-shadow: none; margin: 0; padding: 0; }
            .download-actions, .acceptance-form, .print-hide { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="agreement-wrapper">
        @include('agreements.partials.letter', ['lead' => $lead, 'eagreement' => $eagreement, 'hideSignature' => true])

        <div class="acceptance-form print-hide mt-5">
            <h4>Borrower Acceptance</h4>
            <p class="mb-4">Please review the sanction details and confirm your acceptance by providing your signature and current place.</p>

            <form action="{{ route('acceptance.process', $eagreement->acceptance_token) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label">Signature</label>
                    <div class="signature-preview" id="signaturePreview"></div>
                    <textarea
                        class="form-control mt-3 signature-input"
                        name="signature"
                        id="signature"
                        rows="2"
                        placeholder="Write your name for signature"
                        required
                        oninput="updateSignaturePreview(this.value)"
                    ></textarea>
                    <div class="dotted-line"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Date &amp; Time</label>
                    <div class="text-uppercase fw-semibold">{{ now()->format('d-M-Y | h:i A') }}</div>
                    <div class="dotted-line"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">IP Address</label>
                    <div class="text-uppercase fw-semibold">{{ request()->ip() }}</div>
                    <div class="dotted-line"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Place</label>
                    <div id="placePreview" class="fw-semibold"></div>
                    <input type="text"
                        class="form-control mt-3 signature-input"
                        name="place"
                        id="place"
                        placeholder="Enter your current place"
                        required
                        oninput="updatePlacePreview(this.value)"
                        value="">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn-verify">Verify &amp; Accept</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateSignaturePreview(value) {
            const preview = document.getElementById('signaturePreview');
            preview.textContent = value || '';
        }

        function updatePlacePreview(value) {
            const preview = document.getElementById('placePreview');
            preview.textContent = value || '';
        }
    </script>
</body>
</html>

