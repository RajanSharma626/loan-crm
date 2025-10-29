<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Agreement Acceptance - {{ $eagreement->application_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        .confirmation-text {
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .company-seal {
            width: 150px;
            height: 150px;
            border: 3px solid #0066cc;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 15px;
            background: white;
        }
        .company-seal-text {
            font-size: 10px;
            font-weight: bold;
            color: #0066cc;
            margin: 0;
            line-height: 1.2;
        }
        .seal-signature {
            width: 60px;
            height: 40px;
            margin-top: 5px;
            border: 1px solid #0066cc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
        }
        .loan-details-table {
            width: 100%;
            margin: 30px 0;
            border-collapse: collapse;
        }
        .loan-details-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .loan-details-table td:first-child {
            font-weight: bold;
            width: 40%;
            color: #555;
        }
        .acceptance-form {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 5px;
            margin-top: 30px;
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .signature-display {
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            font-style: italic;
            color: #0066cc;
            font-size: 20px;
            margin-left: 10px;
            margin-top: 10px;
            font-weight: normal;
            letter-spacing: 1px;
        }
        .dotted-line {
            border-bottom: 2px dotted #ccc;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .date-display {
            color: #333;
            font-weight: normal;
        }
        .place-display {
            color: #333;
            font-weight: normal;
            margin-top: 5px;
            font-size: 14px;
        }
        .btn-verify {
            background-color: #ff6600;
            color: white;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
            margin-top: 20px;
        }
        .btn-verify:hover {
            background-color: #e55a00;
            color: white;
        }
        .terms-section {
            margin: 30px 0;
            padding: 20px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            max-height: 400px;
            overflow-y: auto;
        }
        .terms-section h4 {
            color: #0066cc;
            margin-bottom: 15px;
        }
        .terms-section p {
            text-align: justify;
            line-height: 1.8;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <div class="confirmation-text">
                <p><strong>Of My Knowledge and Belief.</strong></p>
                <p><strong>I Confirm That I Have Fully Read and Understood These Terms and Condition.</strong></p>
            </div>
            <div class="company-seal">
                <p class="company-seal-text">REGENCY SHARES<br>& HOLDINGS<br>PVT. LTD</p>
                <div class="seal-signature">SIGNATURE</div>
            </div>
        </div>

        <div class="terms-section">
            <h4>REGENCY SHARES AND HOLDINGS PRIVATE LIMITED</h4>
            <h4>Loan Agreement</h4>
            
            <p>We, REGENCY SHARES AND HOLDINGS PVT. LTD. (hereinafter referred to as the company) a private limited company, incorporated under the provisions of the companies act, 1956, are committed to maintaining the privacy of your invaluable information.</p>
            
            <p>These terms and conditions relate to <strong>www.cashwalle.com</strong>. The information collected from you may be used and disclosed for uninterrupted use of services and better protection of your policy.</p>

            <h5 style="margin-top: 20px; color: #0066cc;">Lending Terms and Conditions</h5>
            <p>Lending loan basis social score is expressly conditioned on borrowers consent and assent to these terms and conditions (T&Cs). Any acceptance of the lenders loan facility is expressly limited to these T&Cs. No document uploaded or document solely signed by the borrower shall modify these T & Cs. The lender may amend T&Cs after prior notification.</p>

            <h5 style="margin-top: 20px; color: #0066cc;">Acceptance</h5>
            <p>By clicking on the accept button at the bottom of this page, you irrevocably and unconditionally accept the terms and conditions for grant of this loan and these terms and conditions will become a legally binding contract between the lender and yourself as the borrower.</p>

            <h5 style="margin-top: 20px; color: #0066cc;">Account Registration</h5>
            <p>Borrowers must register with www.cashwalle.com by filling basic information to receive a Unique CASHWALLE Loan account Number. Once registered, borrowers can apply for loans multiple times without re-registering. Borrowers must notify Cashwalle.com of changes to profile details (Employer, Salary, Address, Contact Details, Bank Account Details) via the website's Dashboard.</p>

            <h5 style="margin-top: 20px; color: #0066cc;">Eligibility Criteria</h5>
            <ul>
                <li>Resident of India</li>
                <li>Above 21 years of age</li>
                <li>Salaried</li>
                <li>Hold a bank account in their own name</li>
                <li>Salary credited directly to their bank account</li>
            </ul>

            <p>Borrowers must provide basic details and documents as per the "Know Your Customer Policy" displayed on the website. A "social score" will be calculated based on provided documents and details, and eligibility will be informed within hours. Delays may occur if the profile is incomplete or documents are missing.</p>

            <p><strong>The Lender reserves the sole right and discretion to approve your application without having the need to provide any reasons for the same.</strong></p>
        </div>

        <table class="loan-details-table">
            <tr>
                <td>Lender:</td>
                <td>Regency Shares and Holdings Pvt. Ltd.</td>
            </tr>
            <tr>
                <td>Loan account number:</td>
                <td><strong>{{ $eagreement->application_number }}</strong></td>
            </tr>
            <tr>
                <td>Platform:</td>
                <td>www.cashwalle.com</td>
            </tr>
            <tr>
                <td>Loan Amount (INR):</td>
                <td>₹ {{ number_format($eagreement->approved_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Per day Interest Rate (%):</td>
                <td>{{ $eagreement->interest_rate }}%</td>
            </tr>
            <tr>
                <td>Approved Period (Days):</td>
                <td>{{ $eagreement->duration }}</td>
            </tr>
            <tr>
                <td>Processing Fee (INR):</td>
                <td>₹ {{ number_format($eagreement->processing_fees ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td>Pre-Closer Charges (INR):</td>
                <td>Nil</td>
            </tr>
            <tr>
                <td>Net Disbursement Amount (INR):</td>
                <td>₹ {{ number_format($eagreement->disbursed_amount ?? ($eagreement->approved_amount - ($eagreement->processing_fees ?? 0)), 2) }}</td>
            </tr>
            <tr>
                <td>Security/Collateral:</td>
                <td>Nil</td>
            </tr>
        </table>

        <div class="acceptance-form">
            <h4 style="margin-bottom: 25px; color: #0066cc;">Acceptance Form</h4>
            
            <form action="{{ route('acceptance.process', $eagreement->acceptance_token) }}" method="POST" id="acceptanceForm">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label">Signature:</label>
                    <div class="dotted-line"></div>
                    <div class="signature-display" id="signaturePreview">{{ $lead->first_name }} {{ $lead->last_name }}</div>
                    <textarea 
                        class="form-control mt-2" 
                        name="signature" 
                        id="signature" 
                        rows="2" 
                        placeholder="Write Your Name for Signature" 
                        required
                        style="font-family: 'Brush Script MT', 'Lucida Handwriting', cursive; font-size: 18px;"
                        oninput="updateSignaturePreview(this.value)"
                    >{{ $lead->first_name }} {{ $lead->last_name }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Date:</label>
                    <div class="date-display">{{ now()->format('d/m/Y - h:i:s A') }}</div>
                    <input type="hidden" name="acceptance_date" value="{{ now() }}">
                </div>

                <div class="mb-4">
                    <label class="form-label">Place:</label>
                    <div class="dotted-line"></div>
                    <div class="place-display" id="placePreview">{{ $lead->city ?? '' }}</div>
                    <textarea 
                        class="form-control mt-2" 
                        name="place" 
                        id="place" 
                        rows="2" 
                        placeholder="Your place" 
                        required
                        oninput="updatePlacePreview(this.value)"
                    >{{ $lead->city ?? '' }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-verify">VERIFY & ACCEPT</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateSignaturePreview(value) {
            const preview = document.getElementById('signaturePreview');
            preview.textContent = value || '{{ $lead->first_name }} {{ $lead->last_name }}';
        }
        
        function updatePlacePreview(value) {
            const preview = document.getElementById('placePreview');
            preview.textContent = value || '{{ $lead->city ?? '' }}';
        }
    </script>
</body>
</html>

