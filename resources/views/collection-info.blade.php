@extends('layouts.app')

@section('title', 'Collection Info | Money Portal')

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
    .disabled-field {
        background-color: #f8f9fa !important;
        cursor: not-allowed;
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
                                    <h1>Collection Information - #{{ $lead->id }}</h1>
                                </a>
                                <a href="{{ route('collection') }}" class="btn btn-sm btn-outline-warning">Back to Collection</a>
                            </div>
                        </div>
                    </header>

                    <div class="contact-body">
                        <div data-simplebar class="nicescroll-bar">
                            <div class="contact-list-view">
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        @foreach ($errors->all() as $error)
                                            {{ $error . ',' }}
                                        @endforeach
                                    </div>
                                @endif
                                
                                {{-- ============================== Lead Information ============================== --}}
                                <div class="card p-5 mb-4">
                                    <h5 class="mb-5">Lead Information</h5>
                                    <div class="row gx-3">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">First Name</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->first_name }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Last Name</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->last_name }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Mobile</label>
                                                <input class="form-control disabled-field" type="number" value="{{ $lead->mobile }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Email Address</label>
                                                <input class="form-control disabled-field" type="email" value="{{ $lead->email }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Lead Source</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->lead_source }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Keyword</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->keyword }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Loan Type</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->loan_type }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">City</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->city }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Monthly Salary (INR)</label>
                                                <input class="form-control disabled-field" type="number" value="{{ $lead->monthly_salary }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Loan Amount (INR)</label>
                                                <input class="form-control disabled-field" type="number" value="{{ $lead->loan_amount }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Duration (In Days)</label>
                                                <input class="form-control disabled-field" type="number" value="{{ $lead->duration }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Pancard Number</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->pancard_number }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Gender</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->gender }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">DOB</label>
                                                <input class="form-control disabled-field" type="date" value="{{ $lead->dob }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Marital Status</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->marital_status }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Education</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->education }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Disposition</label>
                                                <input class="form-control disabled-field" type="text" value="{{ $lead->disposition }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Agent Name</label>
                                                <input class="form-control disabled-field" type="text" 
                                                    value="{{ $lead->agent ? $lead->agent->name . ' (' . $lead->agent->users_id . ')' : 'N/A' }}" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ============================== Upload Documents ============================== --}}
                                <div class="card p-5 mb-4">
                                    <h5 class="mb-5">Upload Documents</h5>
                                    @php
                                        $docFields = [
                                            'photograph' => 'Photograph',
                                            'pan_card' => 'Pan Card',
                                            'adhar_card' => 'Aadhaar Card',
                                            'current_address' => 'Current Address',
                                            'permanent_address' => 'Permanent Address',
                                            'salary_slip' => 'Salary Slip',
                                            'bank_statement' => 'Bank Statement',
                                            'cibil' => 'CIBIL',
                                            'other_documents' => 'Other Documents',
                                        ];
                                    @endphp
                                    <div class="row gx-3">
                                        @foreach ($docFields as $key => $label)
                                            @php
                                                $statusField = $key . '_status';
                                                $statusValue = $doc ? ($doc->{$statusField} ?? null) : null;
                                            @endphp
                                            <div class="col-sm-6 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">{{ $label }}</label>
                                                    <div>
                                                        @if ($doc && $doc->{$key})
                                                            @php
                                                                $docArray = json_decode($doc->{$key});
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($docArray as $file)
                                                                <div class="mb-2">
                                                                    <a href="{{ asset($file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                        View {{ $label }} {{ count($docArray) > 1 ? $no : '' }}
                                                                    </a>
                                                                </div>
                                                                @php $no++; @endphp
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No files uploaded</span>
                                                        @endif
                                                        @if($statusValue)
                                                            @php
                                                                $badgeClass = 'secondary';
                                                                if($statusValue === 'Approved') $badgeClass = 'success';
                                                                elseif($statusValue === 'Disapproved') $badgeClass = 'danger';
                                                                elseif($statusValue === 'Docs Received') $badgeClass = 'info';
                                                            @endphp
                                                            <div class="mt-2">
                                                                <span class="badge badge-{{ $badgeClass }}">{{ $statusValue }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- ============================== E-Agreement ============================== --}}
                                @if($lead->eagreement)
                                <div class="card p-5 mb-4">
                                    <h5 class="mb-5">E-Agreement</h5>
                                    <div class="row gx-3">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Loan Disposition</label>
                                                <input class="form-control disabled-field" type="text" 
                                                    value="{{ $lead->eagreement->disposition ?? 'N/A' }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Loan Applied Amount</label>
                                                <input class="form-control disabled-field" type="number" 
                                                    value="{{ $lead->eagreement->applied_amount ?? $lead->loan_amount }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Loan Approved Amount</label>
                                                <input class="form-control disabled-field" type="number" 
                                                    value="{{ $lead->eagreement->approved_amount ?? 'N/A' }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Duration (In Days)</label>
                                                <input class="form-control disabled-field" type="number" 
                                                    value="{{ $lead->duration }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Rate of Interest per Day (%)</label>
                                                <input class="form-control disabled-field" type="number" 
                                                    value="{{ $lead->eagreement->interest_rate ?? 'N/A' }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Processing Fees</label>
                                                <input class="form-control disabled-field" type="number" 
                                                    value="{{ $lead->eagreement->processing_fees ?? 'N/A' }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Amount to be Disbursed</label>
                                                <input class="form-control disabled-field" type="number" 
                                                    value="{{ $lead->eagreement->disbursed_amount ?? 'N/A' }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">EMI/Repayment Amount</label>
                                                <input class="form-control disabled-field" type="number" 
                                                    value="{{ $lead->eagreement->repayment_amount ?? 'N/A' }}" disabled />
                                            </div>
                                        </div>
                                        @if(!empty($lead->eagreement->application_number))
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Loan Application Number</label>
                                                <input class="form-control disabled-field" type="text" 
                                                    value="{{ $lead->eagreement->application_number }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Loan Application Status By Customer</label>
                                                <input class="form-control disabled-field" type="text" 
                                                    value="{{ $lead->eagreement->customer_application_status ?? 'N/A' }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="form-label">Signed Loan Application</label>
                                                @if(!empty($lead->eagreement->signed_application))
                                                    <div>
                                                        <a href="{{ asset($lead->eagreement->signed_application) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            View Signed Application
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No signed application uploaded</span>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($lead->eagreement->closed_date || $lead->eagreement->received_amount)
                                        <div class="col-12 mt-3">
                                            <h6 class="mb-3">Collection Details</h6>
                                            <div class="row gx-3">
                                                @if($lead->eagreement->closed_date)
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Closed Date</label>
                                                        <input class="form-control disabled-field" type="text" 
                                                            value="{{ \Carbon\Carbon::parse($lead->eagreement->closed_date)->format('d M, Y') }}" disabled>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($lead->eagreement->received_amount)
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Received Amount (INR)</label>
                                                        <input class="form-control disabled-field" type="text" 
                                                            value="₹ {{ number_format($lead->eagreement->received_amount, 2) }}" disabled>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Notes</label>
                                                <textarea class="form-control disabled-field" disabled>{{ $lead->eagreement->notes ?? 'N/A' }}</textarea>
                                            </div>
                                        </div>
                                        
                                        {{-- Client Acceptance Details --}}
                                        @if($lead->eagreement->is_accepted)
                                        <div class="col-12 mt-4">
                                            <div class="p-4 bg-success bg-opacity-10 border border-success rounded">
                                                <h6 class="mb-2 text-success">✓ Client Has Accepted the Agreement</h6>
                                                <p class="mb-1"><strong>Accepted Date:</strong> 
                                                    {{ $lead->eagreement->acceptance_date ? \Carbon\Carbon::parse($lead->eagreement->acceptance_date)->format('d M, Y h:i A') : 'N/A' }}
                                                </p>
                                                <div class="mb-2">
                                                    <strong>Signature:</strong>
                                                    <div class="dotted-line mb-2"></div>
                                                    <div class="signature-handwriting">
                                                        {{ $lead->eagreement->signature ?? 'N/A' }}
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <strong>Place:</strong>
                                                    <div class="dotted-line mb-2"></div>
                                                    <div class="place-display">
                                                        {{ $lead->eagreement->acceptance_place ?? 'N/A' }}
                                                    </div>
                                                </div>
                                                <p class="mb-0"><strong>IP Address:</strong> {{ $lead->eagreement->acceptance_ip ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="card p-5 mb-4">
                                    <div class="alert alert-info">
                                        No E-Agreement found for this lead.
                                    </div>
                                </div>
                                @endif

                                {{-- ============================== Collection Management ============================== --}}
                                @if($lead->eagreement && in_array($lead->disposition, ['Closed', 'Partially Received', 'Settled', 'NPA', 'Disbursed']))
                                <div class="card p-5 mb-4">
                                    <h5 class="mb-5">Collection Management</h5>
                                    
                                    <form action="{{ route('collection.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                        
                                        <div class="row gx-3">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Disposition <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="disposition" required>
                                                        <option value="Closed" {{ $lead->disposition === 'Closed' ? 'selected' : '' }}>Closed</option>
                                                        <option value="Partially Received" {{ $lead->disposition === 'Partially Received' ? 'selected' : '' }}>Partially Received</option>
                                                        <option value="Settled" {{ $lead->disposition === 'Settled' ? 'selected' : '' }}>Settled</option>
                                                        <option value="NPA" {{ $lead->disposition === 'NPA' ? 'selected' : '' }}>NPA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Closed Date <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="date" name="closed_date" 
                                                        value="{{ $lead->eagreement->closed_date ? \Carbon\Carbon::parse($lead->eagreement->closed_date)->format('Y-m-d') : '' }}" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Received Amount (INR) <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="number" name="received_amount" 
                                                        value="{{ $lead->eagreement->received_amount ?? '' }}" step="0.01" min="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row gx-3 mt-3">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Note</label>
                                                    <textarea class="form-control" name="note" rows="3" 
                                                        placeholder="Enter any additional notes...">{{ old('note') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-primary">Update Collection</button>
                                        </div>
                                    </form>
                                    
                                    @if(in_array($lead->disposition, ['Closed', 'Partially Received', 'Settled', 'NPA']))
                                    <hr class="my-4">
                                    
                                    <div class="mt-4">
                                        <h6 class="mb-3">Send Fresh E-Agreement</h6>
                                        <p class="text-muted">Generate a new acceptance link for this closed lead to sign a fresh e-agreement.</p>
                                        <form action="{{ route('collection.send.eagreement') }}" method="POST" onsubmit="return confirm('Are you sure you want to send a fresh e-agreement? This will invalidate the current acceptance.');">
                                            @csrf
                                            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                            <button type="submit" class="btn btn-outline-primary">Send Fresh E-Agreement</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                @endif

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
                                            @if ($lead && is_iterable($lead->notesRelation) && count($lead->notesRelation) > 0)
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
@endsection


