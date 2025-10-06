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
                                    <a href="{{ route('underwriting') }}" class="btn btn-sm btn-outline-warning">Back</a>
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
                                                                <a href="{{ asset($file) }}" class="btn-link small fw-semibold me-3" target="_blank">View {{ $label }}{{ $no > 1 ? $no : '' }}</a>
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
                                                            <select class="form-select" name="statuses[{{ $key }}]">
                                                                <option value="" {{ $statusValue ? '' : 'selected' }}>Select</option>
                                                                <option value="Approved" {{ $statusValue === 'Approved' ? 'selected' : '' }}>Approved</option>
                                                                <option value="Disapproved" {{ $statusValue === 'Disapproved' ? 'selected' : '' }}>Disapproved</option>
                                                                <option value="Docs Received" {{ $statusValue === 'Docs Received' ? 'selected' : '' }}>Docs Received</option>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


