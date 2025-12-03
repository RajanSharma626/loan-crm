@extends('layouts.app')

@section('title', 'Leads Information | Money Portal')

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

                                        @if (Auth::user()->role === 'Agent')
                                            <div class="alert alert-info" role="alert">
                                                <strong>Note:</strong> As an Agent, you can only edit Disposition, Agent Assignment, and Notes. Other fields are view-only.
                                            </div>
                                        @endif

                                        <form action="{{ route('lead.update.info') }}" method="post" id="leadUpdateForm">
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
                                                                {{ Auth::user()->role === 'Agent' ? 'readonly' : 'required' }} />
                                                            @error('first_name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    @php
                                                        $isAgent = Auth::user()->role === 'Agent';
                                                        $readonlyAttr = $isAgent ? 'readonly' : '';
                                                        $disabledAttr = $isAgent ? 'disabled' : '';
                                                    @endphp
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Last Name</label>
                                                            <input class="form-control" type="text" name="last_name"
                                                                value="{{ $lead->last_name }}" placeholder="Last Name" {{ $readonlyAttr }} />
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
                                                                placeholder="00000 00000" {{ $isAgent ? 'readonly' : 'required' }} />
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
                                                                {{ $isAgent ? 'readonly' : 'required' }} />
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
                                                                placeholder="Leade Source" {{ $readonlyAttr }} />
                                                            @error('lead_source')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Keyword</label>
                                                            <input class="form-control" type="text" name="keyword"
                                                                value="{{ $lead->keyword }}" placeholder="Keyword" {{ $readonlyAttr }} />
                                                            @error('keyword')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Loan Type*</label>
                                                            <select class="form-select" name="loan_type" {{ $isAgent ? 'disabled' : 'required' }}>
                                                                <option selected="">--</option>
                                                                <option value="Personal Loan"
                                                                    {{ $lead->loan_type == 'Personal Loan' ? 'Selected' : '' }}>
                                                                    Personal Loan</option>
                                                                <option value="Short Term Loan"
                                                                    {{ $lead->loan_type == 'Short Term Loan' ? 'Selected' : '' }}>
                                                                    Short Term Loan</option>
                                                                <option value="Other Loan"
                                                                    {{ $lead->loan_type == 'Other Loan' ? 'Selected' : '' }}>
                                                                    Other Loan</option>
                                                            </select>
                                                            @if($isAgent)
                                                                <input type="hidden" name="loan_type" value="{{ $lead->loan_type }}">
                                                            @endif
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
                                                                {{ $isAgent ? 'readonly' : 'required' }}>
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
                                                                name="monthly_salary" placeholder="₹0" {{ $isAgent ? 'readonly' : 'required' }} />
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
                                                                value="{{ $lead->loan_amount }}" {{ $isAgent ? 'readonly' : 'required' }} />
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
                                                                {{ $isAgent ? 'readonly' : 'required' }} oninput="if(this.value > 61) this.value = 61;" />
                                                            @error('duration')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">PAN Card*</label>
                                                            <input class="form-control" type="text"
                                                                value="{{ $lead->pancard_number }}" name="pancard_number"
                                                                id="pancard_number"
                                                                placeholder="PAN No." {{ $isAgent ? 'readonly' : 'required' }} 
                                                                style="text-transform: uppercase;"
                                                                oninput="this.value = this.value.toUpperCase();" />
                                                            @error('pancard_number')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Gender*</label>
                                                            <select class="form-select" name="gender" {{ $isAgent ? 'disabled' : 'required' }}>
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
                                                            @if($isAgent)
                                                                <input type="hidden" name="gender" value="{{ $lead->gender }}">
                                                            @endif
                                                            @error('gender')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">DOB*</label>
                                                            <input class="form-control" type="text" name="dob"
                                                                id="dob"
                                                                value="{{ $lead->dob ? \Carbon\Carbon::parse($lead->dob)->format('d/m/Y') : '' }}" 
                                                                placeholder="DD/MM/YYYY" {{ $isAgent ? 'readonly' : 'required' }} 
                                                                pattern="\d{2}/\d{2}/\d{4}" />
                                                            @error('dob')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Marital Status</label>
                                                            <select class="form-select" name="marital_status"
                                                                value="{{ old('marital_status') }}" {{ $disabledAttr }}>
                                                                <option selected="">--</option>
                                                                <option value="Single"
                                                                    {{ $lead->marital_status == 'Single' ? 'Selected' : '' }}>
                                                                    Single</option>
                                                                <option value="Married"
                                                                    {{ $lead->marital_status == 'Married' ? 'Selected' : '' }}>
                                                                    Married</option>
                                                                <option value="Divorced"
                                                                    {{ $lead->marital_status == 'Divorced' ? 'Selected' : '' }}>
                                                                    Divorced</option>
                                                                <option value="Widowed"
                                                                    {{ $lead->marital_status == 'Widowed' ? 'Selected' : '' }}>
                                                                    Widowed</option>
                                                            </select>
                                                            @if($isAgent)
                                                                <input type="hidden" name="marital_status" value="{{ $lead->marital_status }}">
                                                            @endif
                                                            @error('marital_status')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Education</label>
                                                            <input class="form-control" type="text" name="education"
                                                                value="{{ $lead->education }}" placeholder="Education" {{ $readonlyAttr }} />
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
                                                                <option value="Open" {{ $lead->disposition == 'Open' ? 'selected' : '' }}>Open</option>
                                                                <option value="Closed" {{ $lead->disposition == 'Closed' ? 'selected' : '' }}>Closed</option>
                                                                <option value="Ringing" {{ $lead->disposition == 'Ringing' ? 'selected' : '' }}>Ringing</option>
                                                                <option value="Busy" {{ $lead->disposition == 'Busy' ? 'selected' : '' }}>Busy</option>
                                                                <option value="Not reachable" {{ $lead->disposition == 'Not reachable' ? 'selected' : '' }}>Not reachable</option>
                                                                <option value="Wrong number" {{ $lead->disposition == 'Wrong number' ? 'selected' : '' }}>Wrong number</option>
                                                                <option value="Out of scope" {{ $lead->disposition == 'Out of scope' ? 'selected' : '' }}>Out of scope</option>
                                                                <option value="Call back" {{ $lead->disposition == 'Call back' ? 'selected' : '' }} >Call back</option>
                                                                <option value="Follow up" {{ $lead->disposition == 'Follow up' ? 'selected' : '' }} >Follow up</option>
                                                                <option value="Rejected" {{ $lead->disposition == 'Rejected' ? 'selected' : '' }} >Rejected</option>
                                                                <option value="Language barrier" {{ $lead->disposition == 'Language barrier' ? 'selected' : '' }} >Language barrier</option>
                                                                <option value="Nc Rejected" {{ $lead->disposition == 'Nc Rejected' ? 'selected' : '' }} >Nc Rejected</option>
                                                                <option value="Docs received" {{ $lead->disposition == 'Docs received' ? 'selected' : '' }} >Docs received</option>
                                                                <option value="Approved" {{ $lead->disposition == 'Approved' ? 'selected' : '' }} >Approved</option>
                                                                <option value="Disbursed" {{ $lead->disposition == 'Disbursed' ? 'selected' : '' }} >Disbursed</option>
                                                                <option value="Reopen" {{ $lead->disposition == 'Reopen' ? 'selected' : '' }} >Reopen</option>
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

                                                                @foreach ($emp as $users)
                                                                    <option value="{{ $users->id }}"
                                                                        {{ $users->id == $lead->agent_id ? 'selected' : '' }}>
                                                                        {{ $users->name }}
                                                                        ({{ $users->users_id }})
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
                                                            <td>{{ $note->user->name }} ({{ $note->user->users_id }})
                                                            </td>
                                                            <td>{{ $note->disposition }}</td>
                                                            <td>{{ $note->note }}</td>
                                                            <td>{{ $note->assignBy->name }}
                                                                ({{ $note->assignBy->users_id }})
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
        <!-- /Page Body -->
    </div>
    <script>
        // Frontend Form Validation
        document.getElementById('leadUpdateForm')?.addEventListener('submit', function(e) {
            const form = this;
            let isValid = true;
            const errors = [];

            // Validate required fields
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    errors.push(field.previousElementSibling?.textContent?.trim() + ' is required');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            // Validate email format
            const emailField = form.querySelector('input[type="email"]');
            if (emailField && emailField.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    isValid = false;
                    emailField.classList.add('is-invalid');
                    errors.push('Please enter a valid email address');
                }
            }

            // Validate PAN Card format
            const panField = form.querySelector('#pancard_number');
            if (panField && panField.value && !panField.readOnly) {
                const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
                if (!panRegex.test(panField.value)) {
                    isValid = false;
                    panField.classList.add('is-invalid');
                    errors.push('PAN Card must be in format: ABCDE1234F');
                }
            }

            // Validate DOB format
            const dobField = form.querySelector('#dob');
            if (dobField && dobField.value && !dobField.readOnly) {
                const dobRegex = /^\d{2}\/\d{2}\/\d{4}$/;
                if (!dobRegex.test(dobField.value)) {
                    isValid = false;
                    dobField.classList.add('is-invalid');
                    errors.push('Date of Birth must be in DD/MM/YYYY format');
                }
            }

            // Validate numeric fields
            const numericFields = form.querySelectorAll('input[type="number"]');
            numericFields.forEach(function(field) {
                if (field.value && field.min && parseFloat(field.value) < parseFloat(field.min)) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    errors.push(field.previousElementSibling?.textContent?.trim() + ' must be greater than or equal to ' + field.min);
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fix the following errors:\n' + errors.join('\n'));
                return false;
            }
        });

        // DOB Date formatting (DD/MM/YYYY)
        document.addEventListener('DOMContentLoaded', function() {
            const dobInput = document.getElementById('dob');
            if (dobInput) {
                // Format date on input
                dobInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
                    
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2);
                    }
                    if (value.length >= 5) {
                        value = value.substring(0, 5) + '/' + value.substring(5, 9);
                    }
                    
                    e.target.value = value;
                });

                // Convert DD/MM/YYYY to YYYY-MM-DD before form submission
                const form = dobInput.closest('form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const dobValue = dobInput.value;
                        if (dobValue && dobValue.includes('/')) {
                            const parts = dobValue.split('/');
                            if (parts.length === 3) {
                                const day = parts[0].padStart(2, '0');
                                const month = parts[1].padStart(2, '0');
                                const year = parts[2];
                                dobInput.value = `${year}-${month}-${day}`;
                            }
                        }
                    });
                }
            }
        });
    </script>
@endsection
