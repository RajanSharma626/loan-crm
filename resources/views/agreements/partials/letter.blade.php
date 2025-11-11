@php
    use Carbon\Carbon;

    $leadFullName = trim(($lead->first_name ?? '') . ' ' . ($lead->last_name ?? ''));
    $sanctionDateCarbon = Carbon::parse($eagreement->updated_at ?? $eagreement->created_at ?? now());
    $sanctionDate = $sanctionDateCarbon->format('d M, Y');
    $sanctionDateFormatted = $sanctionDateCarbon->format('d M, Y');
    $principalAmount = $eagreement->approved_amount ?? $lead->loan_amount ?? 0;
    $processingFee = $eagreement->processing_fees ?? 0;
    $gstOnProcessing = round($processingFee * 0.18, 2);
    $calculatedDisbursal = max($principalAmount - $processingFee - $gstOnProcessing, 0);
    $netDisbursal = $eagreement->disbursed_amount ?? $calculatedDisbursal;
    $tenureDays = $eagreement->duration ?? $lead->duration ?? 0;
    $roiPerDay = $eagreement->interest_rate ?? 0;

    if (!is_null($eagreement->repayment_amount)) {
        $repaymentAmount = $eagreement->repayment_amount;
        $interestAmount = max($repaymentAmount - $principalAmount, 0);
    } else {
        $interestAmount = round($principalAmount * ($roiPerDay / 100) * $tenureDays, 2);
        $repaymentAmount = $principalAmount + $interestAmount;
    }

    $repaymentDate = $tenureDays
        ? $sanctionDateCarbon->copy()->addDays($tenureDays)->format('d M, Y')
        : '---';

    $aprTenure = $principalAmount > 0 ? round(($interestAmount / $principalAmount) * 100, 2) : null;
    $aprEffective = ($aprTenure !== null && $tenureDays > 0)
        ? round($aprTenure * (365 / $tenureDays), 2)
        : null;

    $loanRepaymentAmount = $repaymentAmount;
@endphp

<div class="agreement-letter">
    <div class="letter-header">
        <div class="letter-date">
            <strong>Date - {{ $sanctionDateCarbon->format('d M, Y') }}</strong>
        </div>
        
    </div>
    <div class="letter-address">
        <p>
            To<br>
            <strong>{{ $leadFullName }}</strong>
        </p>
    </div>
    <p class="mt-3">
        Thank you for showing your interest in moneyportal.in and giving us an opportunity to serve you.
        We are pleased to inform you that your loan application has been approved as per the below
        mentioned terms and conditions.
    </p>

    <p>
        Money Portal, through its Digital Lending Partner - NBFC : <strong>SEED CAPITAL PRIVATE LIMITED
        (RBI registered NBFC - Reg No. N-14.00973)</strong><br>
        Registered Office at D-12202 BPTP, Princess Park, Sector-86, Faridabad, HR-121007<br>
        This sanction will be subject to the following Terms and Conditions:
    </p>

    <table class="details-table">
        <tbody>
            <tr>
                <td>Name of the Borrower</td>
                <td>{{ $leadFullName }}</td>
            </tr>
            <tr>
                <td>PAN No.</td>
                <td>{{ $lead->pancard_number ?? '---' }}</td>
            </tr>
            <tr>
                <td>Aadhaar No.</td>
                <td>{{ $lead->aadhaar_number ?? $lead->adhar_number ?? '---' }}</td>
            </tr>
            <tr>
                <td>Mobile No.</td>
                <td>{{ $lead->mobile ?? '---' }}</td>
            </tr>
            <tr>
                <td>Email ID</td>
                <td>{{ $lead->email ?? '---' }}</td>
            </tr>
            <tr>
                <td>Place</td>
                <td>{{ $lead->city ?? '---' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="details-table particulars">
        <thead>
            <tr>
                <th>Particulars</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sanction Date</td>
                <td>{{ $sanctionDate }}</td>
            </tr>
            <tr>
                <td>Principal Loan Amount</td>
                <td>₹ {{ number_format($principalAmount, 2) }}</td>
            </tr>
            <tr>
                <td>Processing Fee</td>
                <td>₹ {{ number_format($processingFee, 2) }}</td>
            </tr>
            <tr>
                <td>GST on PF @18%</td>
                <td>₹ {{ number_format($gstOnProcessing, 2) }}</td>
            </tr>
            <tr>
                <td>Net Disbursal</td>
                <td>₹ {{ number_format($netDisbursal, 2) }}</td>
            </tr>
            <tr>
                <td>ROI Per Day</td>
                <td>{{ rtrim(rtrim(number_format($roiPerDay, 3), '0'), '.') }}%</td>
            </tr>
            <tr>
                <td>Tenure in Days</td>
                <td>{{ $tenureDays }}</td>
            </tr>
            <tr>
                <td>Interest Amount</td>
                <td>₹ {{ number_format($interestAmount, 2) }}</td>
            </tr>
            <tr>
                <td>Loan Repayment Date</td>
                <td>{{ $repaymentDate }}</td>
            </tr>
            <tr>
                <td>Loan Repayment Amount as on Due Date</td>
                <td>₹ {{ number_format($loanRepaymentAmount, 2) }}</td>
            </tr>
            <tr>
                <td>Other up-front charges, if any</td>
                <td>Nil</td>
            </tr>
            <tr>
                <td>Insurance charges, if any</td>
                <td>Nil</td>
            </tr>
            <tr>
                <td>APR - Applied tenure interest rate</td>
                <td>{{ $aprTenure !== null ? $aprTenure . '%' : '---' }}</td>
            </tr>
            <tr>
                <td>APR - Effective annualized interest rate</td>
                <td>{{ $aprEffective !== null ? $aprEffective . '%' : '---' }}</td>
            </tr>
            <tr>
                <td>Number of instalments of repayment</td>
                <td>BULLET</td>
            </tr>
            <tr>
                <td>Rate of penal interest in case of delayed payments</td>
                <td>No penal charges are levied. Only interest for the extended period is to be paid.</td>
            </tr>
            <tr>
                <td>Cooling off/Look-up period (No penalty on prepayment)</td>
                <td>3 Days</td>
            </tr>
        </tbody>
    </table>

    <p>
        Henceforth visiting (physically) your Workplace and Residence has your concurrence on it. Kindly request you to go through above
        mentioned terms and conditions and provide your kind acceptance over the email or “esign” so that we can process your loan for final disbursement.
    </p>

    <p>
        <strong>Best Regards<br>
        Team MoneyPortal.in<br>
        (Digital Lending Partner - SEED CAPITAL PRIVATE LIMITED)</strong><br>
        <a href="mailto:info@moneyportal.in">info@moneyportal.in</a><br>
        <a href="https://www.moneyportal.in" target="_blank">https://www.moneyportal.in</a>
    </p>

    <div class="terms-wrapper">
        <h3>TERMS AND CONDITIONS</h3>
        <p>The Borrower confirms to have read and understood these Terms of Agreement before accepting a personal loan (“Loan”) offer with us. By clicking on the “esign” button or accepting over the email, the Borrower shall be deemed to have electronically accepted these Terms of Agreement. To the extent of any inconsistency, these Terms of Agreement shall prevail.</p>

        <ol>
            <li>The Loan shall carry a fixed rate of interest specified at the time of applying for the loan.</li>
            <li>The Loan amount shall be disbursed, after debiting processing fees inclusive GST, in the Borrower’s account only with the Bank on accepting the Personal Loan Terms of Agreement.</li>
            <li>The repayment amount shall consist of principal and interest components. The Borrower confirms to repay the repayment amount on the specified repayment date.</li>
            <li>If repayment is not done by the specified date, the Borrower will be liable only interest for the extended period is to be paid.</li>
            <li>If any repayment cheque is not honored, the Borrower will be liable for dishonor charges and will be liable only interest for the extended period is to be paid.</li>
            <li>The Borrower agrees to pay the processing fee, payment dishonor charges, etc.</li>
            <li>Any overdue payment incurs interest at the penal interest rate (which is higher than the usual interest rate). We may change the interest rate if required by the statutory/regulatory authority.</li>
            <li>The Borrower agrees that fees and charges specified may be revised from time to time and binding on the Borrower.</li>
            <li>The Borrower agrees to pay applicable Goods and Service Tax.</li>
            <li>Any dispute, difference or obligations arising out between, or under or in connection with this agreement/Key Fact Sheet (KFS) on loan or document, the parties hereto agree that all disputes or differences arising out of and/or relating to or in connection with the Loan or any other document shall subject to the exclusive jurisdiction of the courts at Faridabad (Haryana) only.</li>
        </ol>

        <p><strong>Governing Law &amp; Jurisdiction</strong> - The Loan shall be governed by the laws of India and all claims and disputes arising out of or in connection with the Loan shall be settled by arbitration. Any arbitration award/direction passed shall be final and binding on the parties. The language of the arbitration shall be English/Hindi and the venue of such arbitration shall be in Faridabad (Haryana).</p>

        <p><strong>Effective Date</strong> - These Terms of Agreement shall be effective from the date of disbursal of the loan amount.</p>

        <h4>Background:</h4>
        <p>The Borrower has approached the Lender for a loan to meet its financial requirements, and the Lender has agreed to provide the loan on the terms and conditions set forth in this Agreement.</p>
        <p>The Lender reserves the right to take legal action or pursue any other remedies available under law in case of default by the Borrower.</p>
        <p>Non-payment of loan on time will adversely affect your Credit score, further reducing your chances of getting the Loan again. Upon approval, the processing fee will be deducted from your Sanction amount and the balance amount will be disbursed to your account.</p>
        <p>Please ensure that all terms and conditions are thoroughly reviewed and understood by both parties before signing the agreement. It is also advisable to consult with legal professionals to ensure compliance with applicable laws and regulations.</p>
    </div>
</div>

