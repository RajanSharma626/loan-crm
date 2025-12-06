@extends('layouts.app')

@section('title', 'Underwriting Review | Money Portal')

@section('content')
<style>
    .signature-handwriting {
        font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
        font-size: 24px;
        color: #0066cc;
        font-style: italic;
        margin-top: 10px;
        letter-spacing: 1px;
    }
    .dotted-line {
        border-bottom: 2px dotted #ccc;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }
    .place-display {
        font-size: 16px;
        color: #333;
        margin-top: 5px;
    }
</style>
    <div class="hk-pg-wrapper pb-0">
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between">
                                <div class="d-flex justify-content-between w-100">
                                    <a class="contactapp-title link-dark">
                                        <h1>Underwriting Review - #{{ $lead->id }}</h1>
                                    </a>
                                    <span>
                                        <a href="{{ route('document.info', $lead->id) }}"
                                            class="btn btn-sm btn-outline-info">Upload Docs</a>
                                        <a href="{{ route('underwriting') }}"
                                            class="btn btn-sm btn-outline-warning">Back</a>
                                    </span>
                                </div>
                            </div>
                        </header>

                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                <div class="contact-list-view">
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger" role="alert">
                                            @foreach ($errors->all() as $error)
                                                {{ $error . ',' }}
                                            @endforeach
                                        </div>
                                    @endif

                                    @php
                                        $fields = [
                                            'pan_card' => 'Pan Card',
                                            'photograph' => 'Photograph',
                                            'adhar_card' => 'ID Proof',
                                            'current_address' => 'Current Address',
                                            'permanent_address' => 'Permanent Address',
                                            'salary_slip' => 'Salary Slip',
                                            'bank_statement' => 'Bank Statement',
                                            'cibil' => 'CIBIL',
                                            'other_documents' => 'Other Documents',
                                        ];
                                    @endphp

                                    <form action="{{ route('underwriting.review.save') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}" />

                                        <div class="card p-5">
                                            @foreach ($fields as $key => $label)
                                                @php
                                                    $arr = $doc && $doc->{$key} ? json_decode($doc->{$key}) : [];
                                                    $statusField = $key . '_status';
                                                    $statusValue = $doc->{$statusField} ?? null;
                                                    $isApproved = $statusValue === 'Approved';
                                                    $remarksField = $key . '_remarks';
                                                    $remarksValue = $doc && $doc->{$remarksField} ? $doc->{$remarksField} : null;
                                                @endphp
                                                <div class="row gx-3 align-items-center mb-3">
                                                    <div class="col-sm-2">
                                                        <div class="fw-semibold">{{ $label }} : </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        @if (!empty($arr))
                                                            @php $no = 1; @endphp
                                                            @foreach ($arr as $file)
                                                                <a href="{{ asset($file) }}"
                                                                    class="btn-link small fw-semibold me-3"
                                                                    target="_blank">View -
                                                                    {{ $no >= 1 ? $no : '' }}</a>
                                                                @php $no++; @endphp
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No files uploaded</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="alert alert-info py-2 px-3 mb-0 small">
                                                            <strong>Remarks/Password for {{ $label }}:</strong> 
                                                            <span class="ms-2">{{ $remarksValue }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        @if ($isApproved)
                                                            <span class="badge badge-success me-2">Approved</span>
                                                            <span class="text-success" title="Locked">✔</span>
                                                        @else
                                                            <select class="form-select form-select-sm" @if(empty($arr)) disabled @endif
                                                                name="statuses[{{ $key }}]">
                                                                <option value=""
                                                                    {{ $statusValue ? '' : 'selected' }}>Select</option>
                                                                <option value="Approved"
                                                                    {{ $statusValue === 'Approved' ? 'selected' : '' }}>
                                                                    Approved</option>
                                                                <option value="Disapproved"
                                                                    {{ $statusValue === 'Disapproved' ? 'selected' : '' }}>
                                                                    Disapproved</option>
                                                                <option value="Docs Received"
                                                                    {{ $statusValue === 'Docs Received' ? 'selected' : '' }}>
                                                                    Docs Received</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>


                                    {{-- ============================== E-Agreement ============================== --}}
                                    <div class="card p-5">
                                        <h5 class="mb-5">E-agreement</h5>
                                        <form action="{{ route('lead.update.agreement') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="number" name="lead_id" value="{{ $lead->id }}" hidden>

                                            <input type="number" name="id" value="{{ $lead->eagreement->id ?? '' }}"
                                                hidden>
                                            @php
                                                $hasApplicationNumber = !empty($lead->eagreement->application_number);
                                                $hasSignedApplication = !empty($lead->eagreement->signed_application);
                                            @endphp
                                            <div class="row gx-3">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Disposition*</label>
                                                        <select class="form-select" name="disposition"
                                                            {{ $hasApplicationNumber ? 'disabled' : '' }} required>
                                                            <option value="">--</option>
                                                            <option value="Pending" {{ ($lead->eagreement->disposition ?? '') === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="Approved" {{ ($lead->eagreement->disposition ?? '') === 'Approved' ? 'selected' : '' }}>Approved</option>
                                                            <option value="Disbursed" {{ ($lead->eagreement->disposition ?? '') === 'Disbursed' ? 'selected' : '' }}>Disbursed</option>
                                                            <option value="Rejected" {{ ($lead->eagreement->disposition ?? '') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                            <option value="Hold" {{ ($lead->eagreement->disposition ?? '') === 'Hold' ? 'selected' : '' }}>Hold</option>
                                                            <option value="FI Negative" {{ ($lead->eagreement->disposition ?? '') === 'FI Negative' ? 'selected' : '' }}>FI Negative</option>
                                                        </select>
                                                        @if($hasApplicationNumber)
                                                            <input type="hidden" name="disposition" value="{{ $lead->eagreement->disposition ?? '' }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Applied Amount</label>
                                                        <input class="form-control" type="number" name="applied_amount" value="{{ $lead->loan_amount }}"
                                                            placeholder="Amount" disabled />
                                                        <input type="hidden" name="applied_amount" value="{{ $lead->loan_amount }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Approved Amount*</label>
                                                        <input class="form-control" type="number" name="approved_amount"
                                                            id="approved_amount" value="{{ $lead->eagreement->approved_amount ?? '' }}" 
                                                            placeholder="Amount" {{ $hasApplicationNumber ? 'readonly' : 'required' }} />
                                                        @if($hasApplicationNumber)
                                                            <input type="hidden" name="approved_amount" value="{{ $lead->eagreement->approved_amount ?? '' }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Duration (In Days)* </label>
                                                        <input class="form-control" type="number" name="duration" 
                                                            id="duration" value="{{ $lead->duration }}" placeholder="Duration" required disabled />
                                                        <input type="hidden" name="duration" value="{{ $lead->duration }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Rate of intrest per day (%)*
                                                        </label>
                                                        <input class="form-control" type="number" name="interest_rate"
                                                            id="interest_rate" step="0.01" min="0" 
                                                            value="{{ $lead->eagreement->interest_rate ?? '' }}" 
                                                            placeholder="Rate of intrest per day (e.g., 0.90)" {{ $hasApplicationNumber ? 'readonly' : 'required' }} />
                                                        @if($hasApplicationNumber)
                                                            <input type="hidden" name="interest_rate" value="{{ $lead->eagreement->interest_rate ?? '' }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Processing fees </label>
                                                        <input class="form-control" type="number" name="processing_fees"
                                                            id="processing_fees" value="{{ $lead->eagreement->processing_fees ?? '' }}" 
                                                            placeholder="Processing fees" {{ $hasApplicationNumber ? 'readonly' : 'required' }} />
                                                        @if($hasApplicationNumber)
                                                            <input type="hidden" name="processing_fees" value="{{ $lead->eagreement->processing_fees ?? '' }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Amount to be Disbursed </label>
                                                        <input class="form-control" type="number"
                                                            name="disbursed_amount" id="disbursed_amount" value="{{ $lead->eagreement->disbursed_amount ?? '' }}"
                                                            placeholder="Amount to be Disbursed" readonly />
                                                        <input type="hidden" name="disbursed_amount" value="{{ $lead->eagreement->disbursed_amount ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">EMI/Repayment Amount </label>
                                                        <input class="form-control" type="number"
                                                            name="repayment_amount" id="repayment_amount" value="{{ $lead->eagreement->repayment_amount ?? '' }}"
                                                            placeholder="EMI/Repayment Amount" readonly />
                                                        <input type="hidden" name="repayment_amount" value="{{ $lead->eagreement->repayment_amount ?? '' }}">
                                                    </div>
                                                </div>
                                                @if($hasApplicationNumber)
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Application Number </label>
                                                        <input class="form-control" type="text"
                                                            name="application_number" value="{{ $lead->eagreement->application_number ?? '' }}"
                                                            placeholder="Loan Application Number" readonly />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Application Status By
                                                            Customer*</label>
                                                        @php
                                                            $isClientAccepted = $lead->eagreement && $lead->eagreement->is_accepted;
                                                        @endphp
                                                        <select class="form-select" name="customer_application_status"
                                                            {{ $isClientAccepted ? 'disabled' : 'required' }}>
                                                            <option value="">--</option>
                                                            <option value="Accepted" {{ ($lead->eagreement->customer_application_status ?? '') === 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                                            <option value="Not Intrested" {{ ($lead->eagreement->customer_application_status ?? '') === 'Not Intrested' ? 'selected' : '' }}>Not Intrested</option>
                                                            <option value="Rejected" {{ ($lead->eagreement->customer_application_status ?? '') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                        @if($isClientAccepted)
                                                            <input type="hidden" name="customer_application_status" value="{{ $lead->eagreement->customer_application_status ?? 'Approved' }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Signed Loan Application </label>
                                                        @if($hasSignedApplication || $isClientAccepted)
                                                            @if($hasSignedApplication)
                                                            <div class="mb-2">
                                                                <a href="{{ asset($lead->eagreement->signed_application) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    View Signed Application
                                                                </a>
                                                            </div>
                                                            @endif
                                                            <div style="font-family: 'Brush Script MT', 'Lucida Handwriting', cursive; font-size: 24px; color: #0066cc; font-style: italic;">
                                                                {{ $lead->eagreement->signature ?? 'N/A' }}
                                                            </div>
                                                        @else
                                                            <input class="form-control" type="file"
                                                                name="signed_application" />
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                               

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Note*</label>
                                                        <textarea name="notes" class="form-control" id=""></textarea>
                                                        @error('notes')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="modal-footer align-items-center">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ $hasApplicationNumber ? 'Update Agreement' : 'Approve & Upload Loan Application' }}
                                                    </button>
                                                </div>
                                            </div>

                                        </form>

                                        

                                    </div>


                                    {{-- ============================== Notes History ============================== --}}
                                    <div class="card p-5">
                                        <h5 class="mb-5">Notes History</h5>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Created Date</th>
                                                    <th>Updated By</th>
                                                    <th>Disposition</th>
                                                    <th>Note</th>
                                                    <th>Lead Assigned</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @if ($lead && is_iterable($lead->notesRelation))
                                                    @foreach ($lead->notesRelation as $note)
                                                        <tr>
                                                            <td>{{ $note->created_at->format('d M, Y h:i A') }}</td>
                                                            <td>
                                                                @if($note->user)
                                                                    {{ $note->user->name }} ({{ $note->user->users_id }})
                                                                @else
                                                                    <span class="text-muted">Client</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $note->disposition ?? 'N/A' }}</td>
                                                            <td>{{ $note->note }}</td>
                                                            <td>
                                                                @if($note->assignBy)
                                                                    {{ $note->assignBy->name }} ({{ $note->assignBy->users_id }})
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center">No Notes Found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const approvedAmountInput = document.getElementById('approved_amount');
            const processingFeesInput = document.getElementById('processing_fees');
            const interestRateInput = document.getElementById('interest_rate');
            const durationInput = document.getElementById('duration');
            const disbursedAmountInput = document.getElementById('disbursed_amount');
            const repaymentAmountInput = document.getElementById('repayment_amount');

            function calculateDisbursedAmount() {
                const approvedAmount = parseFloat(approvedAmountInput.value) || 0;
                const processingFees = parseFloat(processingFeesInput.value) || 0;
                
                if (approvedAmount > 0 && processingFees >= 0) {
                    const disbursedAmount = approvedAmount - processingFees;
                    disbursedAmountInput.value = disbursedAmount > 0 ? disbursedAmount.toFixed(2) : 0;
                } else {
                    disbursedAmountInput.value = '';
                }
            }

            function calculateRepaymentAmount() {
                const approvedAmount = parseFloat(approvedAmountInput.value) || 0;
                const interestRate = parseFloat(interestRateInput.value) || 0;
                const duration = parseFloat(durationInput.value) || 0;
                
                if (approvedAmount > 0 && interestRate >= 0 && duration > 0) {
                    // Total Interest = Principal × (Interest Rate / 100) × Duration (in days)
                    // Repayment Amount = Principal + Total Interest
                    const totalInterest = approvedAmount * (interestRate / 100) * duration;
                    const repaymentAmount = approvedAmount + totalInterest;
                    repaymentAmountInput.value = repaymentAmount > 0 ? repaymentAmount.toFixed(2) : '';
                } else {
                    repaymentAmountInput.value = '';
                }
            }

            // Calculate when approved amount or processing fees change
            if (approvedAmountInput) {
                approvedAmountInput.addEventListener('input', function() {
                    calculateDisbursedAmount();
                    calculateRepaymentAmount();
                });
            }
            if (processingFeesInput) {
                processingFeesInput.addEventListener('input', calculateDisbursedAmount);
            }
            if (interestRateInput) {
                interestRateInput.addEventListener('input', calculateRepaymentAmount);
            }

            // Calculate on page load if values exist
            calculateDisbursedAmount();
            calculateRepaymentAmount();
        });

        function copyAcceptanceLink() {
            const linkInput = document.getElementById('acceptanceLink');
            linkInput.select();
            linkInput.setSelectionRange(0, 99999); // For mobile devices
            
            try {
                document.execCommand('copy');
                alert('Link copied to clipboard!');
            } catch (err) {
                // Fallback for browsers that don't support execCommand
                navigator.clipboard.writeText(linkInput.value).then(function() {
                    alert('Link copied to clipboard!');
                }, function(err) {
                    alert('Failed to copy. Please copy manually.');
                });
            }
        }
    </script>
@endsection
