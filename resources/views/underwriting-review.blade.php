@extends('layouts.app')

@section('title', 'Underwriting Review | Money Portal')

@section('content')
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
                                                @endphp
                                                <div class="row gx-3 align-items-center mb-3">
                                                    <div class="col-sm-2">
                                                        <div class="fw-semibold">{{ $label }}</div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        @if (!empty($arr))
                                                            @php $no = 1; @endphp
                                                            @foreach ($arr as $file)
                                                                <a href="{{ asset($file) }}"
                                                                    class="btn-link small fw-semibold me-3"
                                                                    target="_blank">View
                                                                    {{ $label }}{{ $no > 1 ? $no : '' }}</a>
                                                                @php $no++; @endphp
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No files uploaded</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-4">
                                                        @if ($isApproved)
                                                            <span class="badge badge-success me-2">Approved</span>
                                                            <span class="text-success" title="Locked">✔</span>
                                                        @else
                                                            <select class="form-select"
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
                                        <form action="{{ route('lead.update.agreement') }}" method="post">
                                            @csrf
                                            <input type="number" name="lead_id" value="{{ $lead->id }}" hidden>

                                            <input type="number" name="id" value="{{ $lead->eagreement->id ?? '' }}"
                                                hidden>
                                            <div class="row gx-3">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Disposition*</label>
                                                        <select class="form-select" name="disposition" value=""
                                                            required>
                                                            <option selected="">--</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Applied Amount</label>
                                                        <input class="form-control" type="number" name="applied_amount" value="{{ $lead->loan_amount }}"
                                                            value="" placeholder="Amount" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Approved Amount*</label>
                                                        <input class="form-control" type="number" name="approved_amount"
                                                            value="" placeholder="Amount" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Duration (In Days)* </label>
                                                        <input class="form-control" type="number" name="duration"
                                                            value="" placeholder="Duration" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Rate of intrest per day (%)*
                                                        </label>
                                                        <input class="form-control" type="number" name="interest_rate"
                                                            value="" placeholder="Rate of intrest per day" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Processing fees </label>
                                                        <input class="form-control" type="number" name="processing_fees"
                                                            value="" placeholder="Processing fees" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">EMI/Repayment Amount </label>
                                                        <input class="form-control" type="number"
                                                            name="repayment_amount" value=""
                                                            placeholder="EMI/Repayment Amount" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Amount to be Disbursed </label>
                                                        <input class="form-control" type="number"
                                                            name="disbursed_amount" value=""
                                                            placeholder="Amount to be Disbursed" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Application Number </label>
                                                        <input class="form-control" type="number"
                                                            name="application_number" value=""
                                                            placeholder="Loan Application Number" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loan Application Status By
                                                            Customer*</label>
                                                        <select class="form-select" name="customer_application_status"
                                                            value="" required>
                                                            <option selected="">--</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Approved">Approved</option>
                                                            <option value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Signed Loan Application </label>
                                                        <input class="form-control" type="file"
                                                            name="signed_application" required />
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Note*</label>
                                                        <textarea name="notes" class="form-control" id="">  </textarea>
                                                        @error('notes')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="modal-footer align-items-center">
                                                    <button type="submit" class="btn btn-primary">Approve &
                                                        Upload Loan
                                                        Application </button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
