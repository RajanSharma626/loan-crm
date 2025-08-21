@extends('layouts.app')

@section('title', 'Leads')

@section('content')
    <div class="hk-pg-wrapper pb-0">
        <!-- Page Body -->
        <div class="hk-pg-body py-0">
            <div class="contactapp-wrap">
                <div class="contactapp-content">
                    <div class="contactapp-detail-wrap">
                        <header class="contact-header">
                            <div class="w-100 align-items-center justify-content-between">

                                <div class="d-flex justify-content-between w-100">
                                    <a class="contactapp-title link-dark">
                                        <h1>Lead Detail</h1>
                                    </a>
                                    <a href="{{ route('leads') }}"
                                        class="btn btn-sm btn-outline-warning flex-shrink-0 d-lg-inline-block d-none">
                                        Back</a>
                                </div>

                            </div>

                        </header>
                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
                                <div class="contact-list-view">
                                    <div class="card p-5">
                                        @if (session('success'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger" role="alert">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error . ',' }}
                                                @endforeach
                                            </div>
                                        @endif

                                        <form action="{{ route('lead.update.info') }}" method="post">
                                            @csrf

                                            <input type="number" name="id" id="" value="{{ $lead->id }}"
                                                hidden>
                                            <div class="modal-body">
                                                <h5 class="mb-5">Lead Information</h5>

                                                <div class="row gx-3">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">First Name*</label>
                                                            <input class="form-control" type="text" name="first_name"
                                                                value="{{ $lead->first_name }}" placeholder="First Name"
                                                                required />
                                                            @error('first_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Last Name</label>
                                                            <input class="form-control" type="text" name="last_name"
                                                                value="{{ $lead->last_name }}" placeholder="Last Name" />
                                                            @error('last_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Mobile*</label>
                                                            <input class="form-control" type="number"
                                                                value="{{ $lead->mobile }}" min="0" name="mobile"
                                                                placeholder="00000 00000" required />
                                                            @error('mobile')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Email Address*</label>
                                                            <input class="form-control" type="email" name="email"
                                                                value="{{ $lead->email }}" placeholder="Email Address"
                                                                required />
                                                            @error('email')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Lead Source</label>
                                                            <input class="form-control" type="text" name="lead_source"
                                                                value="{{ $lead->lead_source }}"
                                                                placeholder="Leade Source" />
                                                            @error('lead_source')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Keyword</label>
                                                            <input class="form-control" type="text" name="keyword"
                                                                value="{{ $lead->keyword }}" placeholder="Keyword" />
                                                            @error('keyword')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Loan Type*</label>
                                                            <select class="form-select" name="loan_type" required>
                                                                <option selected="">--</option>
                                                                <option value="Instant Loan"
                                                                    {{ $lead->loan_type == 'Instant Loan' ? 'Selected' : '' }}>
                                                                    Instant Loan</option>
                                                            </select>
                                                            @error('loan_type')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">City*</label>
                                                            <input type="text" class="form-control" name="city"
                                                                placeholder="Enter City" value="{{ $lead->city }}"
                                                                required>
                                                            @error('city')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Monthly Salary (INR)*</label>
                                                            <input class="form-control" type="number"
                                                                value="{{ $lead->monthly_salary }}" min="0"
                                                                name="monthly_salary" placeholder="₹0" required />
                                                            @error('monthly_salary')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Loan Amount (INR)*</label>
                                                            <input class="form-control" type="number" min="0"
                                                                name="loan_amount" placeholder="₹0"
                                                                value="{{ $lead->loan_amount }}" required />
                                                            @error('loan_amount')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Duration (In Days)*</label>
                                                            <input class="form-control" type="number"
                                                                value="{{ $lead->duration }}" min="0"
                                                                max="61" name="duration" placeholder="0 Days"
                                                                required oninput="if(this.value > 61) this.value = 61;" />
                                                            @error('duration')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Pancard Number*</label>
                                                            <input class="form-control" type="text"
                                                                value="{{ $lead->pancard_number }}" name="pancard_number"
                                                                placeholder="PAN No." required />
                                                            @error('pancard_number')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Gender*</label>
                                                            <select class="form-select" name="gender" required>
                                                                <option selected="">--</option>
                                                                <option value="Male"
                                                                    {{ $lead->gender == 'Male' ? 'Selected' : '' }}>Male
                                                                </option>
                                                                <option value="Female"
                                                                    {{ $lead->gender == 'Female' ? 'Selected' : '' }}>
                                                                    Female</option>
                                                                <option value="Other"
                                                                    {{ $lead->gender == 'Other' ? 'Selected' : '' }}>Other
                                                                </option>
                                                            </select>
                                                            @error('gender')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">DOB*</label>
                                                            <input class="form-control" type="date" name="dob"
                                                                value="{{ $lead->dob }}" required />
                                                            @error('dob')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Merital Status</label>
                                                            <select class="form-select" name="marital_status"
                                                                value="{{ old('marital_status') }}">
                                                                <option selected="">--</option>
                                                                <option value="Single"
                                                                    {{ $lead->marital_status == 'Single' ? 'Selected' : '' }}>
                                                                    Single</option>
                                                                <option value="Married"
                                                                    {{ $lead->marital_status == 'Married' ? 'Selected' : '' }}>
                                                                    Married</option>
                                                                <option value="Divorced"
                                                                    {{ $lead->marital_status == 'Devorced' ? 'Selected' : '' }}>
                                                                    Divorced</option>
                                                                <option value="Widowed"
                                                                    {{ $lead->marital_status == 'Widowed' ? 'Selected' : '' }}>
                                                                    Widowed</option>
                                                            </select>
                                                            @error('marital_status')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Education</label>
                                                            <input class="form-control" type="text" name="education"
                                                                value="{{ $lead->education }}" placeholder="Education" />
                                                            @error('education')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Disposition*</label>
                                                            <select class="form-select" name="disposition"
                                                                value="{{ old('disposition') }}" required>
                                                                <option value="" selected disabled>--</option>
                                                                <option value="Open">Open</option>
                                                                <option value="Closed">Closed</option>
                                                                <option value="Ringing">Ringing</option>
                                                                <option value="Busy">Busy</option>
                                                                <option value="Not reachable">Not reachable</option>
                                                                <option value="Wrong number">Wrong number</option>
                                                                <option value="Out of scope">Out of scope</option>
                                                                <option value="Call back">Call back</option>
                                                                <option value="Follow up">Follow up</option>
                                                                <option value="Rejected">Rejected</option>
                                                                <option value="Language barrier">Language barrier</option>
                                                                <option value="Nc Rejected">Nc Rejected</option>
                                                                <option value="Docs received">Docs received</option>
                                                                <option value="Approved">Approved</option>
                                                                <option value="Disbursed">Disbursed</option>
                                                                <option value="Reopen">Reopen</option>
                                                            </select>
                                                            @error('disposition')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Agent Name*</label>
                                                            <select class="form-select" name="agent_id"
                                                                value="{{ old('agent_id') }}">
                                                                <option value="" selected disabled>--</option>

                                                                @foreach ($emp as $employee)
                                                                    <option value="{{ $employee->id }}"
                                                                        {{ $employee->id == Auth::id() ? 'selected' : '' }}>
                                                                        {{ $employee->name }}
                                                                        ({{ $employee->employee_id }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('agent_id')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Note*</label>
                                                            <textarea name="notes" class="form-control" required> {{ old('notes') }}</textarea>
                                                            @error('notes')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>


                                            </div>
                                            <div class="modal-footer align-items-center">
                                                <button type="submit" class="btn btn-primary">Update
                                                    Lead</button>
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
                                                            <td>{{ $note->user->name }} ({{ $note->user->employee_id }})
                                                            </td>
                                                            <td>{{ $note->disposition }}</td>
                                                            <td>{{ $note->note }}</td>
                                                            <td>{{ $note->assignBy->name }}
                                                                ({{ $note->assignBy->employee_id }})
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



                                    {{-- ============================== Upload Information ============================== --}}
                                    <div class="card p-5">
                                        <h5 class="mb-5">Upload Information</h5>

                                        <form action="{{ route('lead.update.upload') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="number" name="lead_id" value="{{ $lead->id }}" hidden>

                                            <div class="row gx-3">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Photograph</label>
                                                        <input class="form-control" type="file" name="photograph[]"
                                                            accept=".png,.jpg,.jpeg,.webp,.pdf" multiple />
                                                        @error('photograph')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->photograph)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->photograph) as $photograph)
                                                                <a href="{{ asset($photograph) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Pan Card</label>
                                                        <input class="form-control" type="file" name="pan_card[]"
                                                            accept=".png,.jpg,.jpeg,.webp,.pdf" multiple />
                                                        @error('pan_card')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->pan_card)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->pan_card) as $panCard)
                                                                <a href="{{ asset($panCard) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Adhaar card</label>
                                                        <input class="form-control" type="file" name="adhar_card[]"
                                                            accept=".png,.jpg,.jpeg,.webp,.pdf" multiple />
                                                        @error('adhar_card')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->adhar_card)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->adhar_card) as $adharCard)
                                                                <a href="{{ asset($adharCard) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Current Address</label>
                                                        <input class="form-control" type="file"
                                                            name="current_address[]" accept=".png,.jpg,.jpeg,.webp,.pdf"
                                                            multiple />
                                                        @error('current_address')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->current_address)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->current_address) as $currentAddress)
                                                                <a href="{{ asset($currentAddress) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Permanent Address</label>
                                                        <input class="form-control" type="file"
                                                            name="permanent_address[]" accept=".png,.jpg,.jpeg,.webp,.pdf"
                                                            multiple />
                                                        @error('permanent_address')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->permanent_address)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->permanent_address) as $permanentAddress)
                                                                <a href="{{ asset($permanentAddress) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Salary Slip</label>
                                                        <input class="form-control" type="file" name="salary_slip[]"
                                                            accept=".png,.jpg,.jpeg,.webp,.pdf" multiple />
                                                        @error('salary_slip')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->salary_slip)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->salary_slip) as $salarySlip)
                                                                <a href="{{ asset($salarySlip) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Bank Statement</label>
                                                        <input class="form-control" type="file"
                                                            name="bank_statement[]" accept=".png,.jpg,.jpeg,.webp,.pdf"
                                                            multiple />
                                                        @error('bank_statement')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->bank_statement)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->bank_statement) as $bankStatement)
                                                                <a href="{{ asset($bankStatement) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Cibil</label>
                                                        <input class="form-control" type="file" name="cibil[]"
                                                            accept=".png,.jpg,.jpeg,.webp,.pdf" multiple />
                                                        @error('cibil')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->cibil)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->cibil) as $cibil)
                                                                <a href="{{ asset($cibil) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Upload Other Documents</label>
                                                        <input class="form-control" type="file"
                                                            name="other_documents[]" accept=".png,.jpg,.jpeg,.webp,.pdf"
                                                            multiple />
                                                        @error('other_documents')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        @if ($doc && $doc->other_documents)
                                                            @php
                                                                $no = 1;
                                                            @endphp

                                                            @foreach (json_decode($doc->other_documents) as $other)
                                                                <a href="{{ asset($other) }}" target="_blank"
                                                                    class="m-2 btn-link">View {{ $no }}</a>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer align-items-center">
                                                <button type="submit" class="btn btn-primary"> Upload Document</button>
                                            </div>
                                        </form>
                                    </div>





                                    {{-- ============================== E-Agreement ============================== --}}
                                    <div class="card p-5">
                                        <h5 class="mb-5">E-agreement</h5>
                                        <form action="{{ route('lead.update.agreement') }}" method="post">
                                            @csrf
                                            <input type="number" name="lead_id" value="{{ $lead->id }}" hidden>

                                            <input type="number" name="id"
                                                value="{{ $lead->eagreement->id ?? '' }}" hidden>
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
                                                        <input class="form-control" type="number" name="applied_amount"
                                                            value="" placeholder="Amount" required />
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
                                                            value="" placeholder="Rate of intrest per day"
                                                            required />
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
        <!-- /Page Body -->
    </div>
@endsection
