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
                                                            <label class="form-label">Last Name*</label>
                                                            <input class="form-control" type="text" name="last_name"
                                                                value="{{ $lead->last_name }}" placeholder="Last Name"
                                                                required />
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
                                                                <option value="Instant Loan">Instant Loan</option>
                                                                <option value="Personal Loan">Personal Loan</option>
                                                            </select>
                                                            @error('loan_type')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">City*</label>
                                                            <select class="form-select" name="city" required>
                                                                <option selected="">--</option>
                                                                <option value="Mumbai">Mumbai</option>
                                                                <option value="Delhi">Delhi</option>
                                                                <option value="Bangalore">Bangalore</option>
                                                                <option value="Hyderabad">Hyderabad</option>
                                                                <option value="Chennai">Chennai</option>
                                                                <option value="Kolkata">Kolkata</option>
                                                                <option value="Pune">Pune</option>
                                                                <option value="Ahmedabad">Ahmedabad</option>
                                                                <option value="Jaipur">Jaipur</option>
                                                                <option value="Lucknow">Lucknow</option>
                                                                <option value="Surat">Surat</option>
                                                                <option value="Nagpur">Nagpur</option>
                                                                <option value="Indore">Indore</option>
                                                                <option value="Bhopal">Bhopal</option>
                                                                <option value="Vadodara">Vadodara</option>
                                                                <option value="Visakhapatnam">Visakhapatnam</option>
                                                                <option value="Chandigarh">Chandigarh</option>
                                                                <option value="Patna">Patna</option>
                                                                <option value="Ludhiana">Ludhiana</option>
                                                                <option value="Agra">Agra</option>
                                                                <option value="Nashik">Nashik</option>
                                                                <option value="Faridabad">Faridabad</option>
                                                                <option value="Meerut">Meerut</option>
                                                                <option value="Rajkot">Rajkot</option>
                                                                <option value="Kalyan">Kalyan</option>
                                                                <option value="Varanasi">Varanasi</option>
                                                                <option value="Amritsar">Amritsar</option>
                                                                <option value="Aurangabad">Aurangabad</option>
                                                                <option value="Dhanbad">Dhanbad</option>
                                                            </select>
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
                                                                name="duration" placeholder="0 Days" required />
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
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Other">Other</option>
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
                                                                <option value="Single">Single</option>
                                                                <option value="Married">Married</option>
                                                                <option value="Divorced">Divorced</option>
                                                                <option value="Widowed">Widowed</option>
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
                                                                <option value="Pending">Pending</option>
                                                                <option value="Approved">Approved</option>
                                                                <option value="Rejected">Rejected</option>
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

                                        {{-- <table class="table">
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
                                                <tr>
                                                    <td>
                                                        25 Mar, 2025 05:04 PM
                                                    </td>
                                                    <td>XYZ </td>
                                                    <td> Rejected</td>
                                                    <td>Low Salary</td>
                                                    <td>xyz</td>
                                                </tr>
                                            </tbody>
                                        </table> --}}
                                    </div>





                                    {{-- ============================== E-Agreement ============================== --}}
                                    <div class="card p-5">
                                        <h5 class="mb-5">E-agreement</h5>
                                        <form action="{{ route('lead.update.agreement') }}" method="post">
                                            @csrf
                                            <input type="number" name="lead_id"
                                                value="{{ $lead->id }}" hidden>

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
                                                        <label class="form-label">Rate of intrest per day (%)* </label>
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
                                                    <button type="submit" class="btn btn-primary">Approve & Upload Loan
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
