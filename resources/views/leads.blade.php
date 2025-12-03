@extends('layouts.app')

@section('title', 'Leads | Money Portal')

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
                                        <h1>Leads List</h1>
                                    </a>
                                </div>
                            </div>

                        </header>
                        <div class="contact-body">
                            <div data-simplebar class="nicescroll-bar">
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

                                <form method="GET" action="{{ route('leads') }}" class="mb-3">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-2">
                                            <input type="text" name="search" class="form-control form-control-sm" 
                                                placeholder="Search by Name, Mobile No., or PAN No." 
                                                value="{{ request('search') }}" />
                                        </div>
                                        <div class="col-md-2">
                                            <select name="loan_type" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="">-- Loan Types --</option>
                                                <option value="Personal Loan"
                                                    {{ request('loan_type') == 'Personal Loan' ? 'selected' : '' }}>Personal Loan</option>
                                                <option value="Short Term Loan"
                                                    {{ request('loan_type') == 'Short Term Loan' ? 'selected' : '' }}>Short Term Loan</option>
                                                <option value="Other Loan"
                                                    {{ request('loan_type') == 'Other Loan' ? 'selected' : '' }}>Other Loan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="disposition" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="">-- Filter by Disposition --</option>
                                                <option value="Open"
                                                    {{ request('disposition') == 'Open' ? 'selected' : '' }}>Open</option>
                                                <option value="Closed"
                                                    {{ request('disposition') == 'Closed' ? 'selected' : '' }}>Closed
                                                </option>
                                                <option value="Ringing"
                                                    {{ request('disposition') == 'Ringing' ? 'selected' : '' }}>Ringing
                                                </option>
                                                <option value="Busy"
                                                    {{ request('disposition') == 'Busy' ? 'selected' : '' }}>Busy</option>
                                                <option value="Not reachable"
                                                    {{ request('disposition') == 'Not reachable' ? 'selected' : '' }}>Not
                                                    reachable</option>
                                                <option value="Wrong number"
                                                    {{ request('disposition') == 'Wrong number' ? 'selected' : '' }}>Wrong
                                                    number</option>
                                                <option value="Out of scope"
                                                    {{ request('disposition') == 'Out of scope' ? 'selected' : '' }}>Out of
                                                    scope</option>
                                                <option value="Call back"
                                                    {{ request('disposition') == 'Call back' ? 'selected' : '' }}>Call back
                                                </option>
                                                <option value="Follow up"
                                                    {{ request('disposition') == 'Follow up' ? 'selected' : '' }}>Follow up
                                                </option>
                                                <option value="Rejected"
                                                    {{ request('disposition') == 'Rejected' ? 'selected' : '' }}>Rejected
                                                </option>
                                                <option value="Language barrier"
                                                    {{ request('disposition') == 'Language barrier' ? 'selected' : '' }}>
                                                    Language barrier</option>
                                                <option value="Nc Rejected"
                                                    {{ request('disposition') == 'Nc Rejected' ? 'selected' : '' }}>Nc
                                                    Rejected</option>
                                                <option value="Docs received"
                                                    {{ request('disposition') == 'Docs received' ? 'selected' : '' }}>Docs received</option>
                                                <option value="Approved"
                                                    {{ request('disposition') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="Disbursed"
                                                    {{ request('disposition') == 'Disbursed' ? 'selected' : '' }}>Disbursed</option>
                                                <option value="Reopen"
                                                    {{ request('disposition') == 'Reopen' ? 'selected' : '' }}>Reopen</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select name="date_filter" id="date_filter" class="form-select form-select-sm">
                                                <option value="">-- Date: All --</option>
                                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                                <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                                <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 days</option>
                                                <option value="last_30_days" {{ request('date_filter') == 'last_30_days' ? 'selected' : '' }}>Last 30 days</option>
                                                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This month</option>
                                                <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last month</option>
                                                <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom range</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3" id="custom_range_group" style="display: none;">
                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
                                                <span class="small">to</span>
                                                <input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-auto">
                                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                        </div>
                                    </div>
                                </form>


                                @if (in_array(Auth::user()->role, ['Admin', 'Manager']))
                                <div class="mb-3 d-flex gap-2 align-items-center">
                                    <button type="button" class="btn btn-sm btn-primary" id="selectAllBtn" onclick="selectAll()">Select All</button>
                                    <button type="button" class="btn btn-sm btn-secondary" id="deselectAllBtn" onclick="deselectAll()" style="display: none;">Deselect All</button>
                                    <button type="button" class="btn btn-sm btn-success" id="bulkAssignBtn" onclick="showBulkAssignModal()" disabled>Bulk Assign</button>
                                    @if (Auth::user()->role == 'Admin')
                                    <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn" onclick="bulkDelete()" disabled>Bulk Delete</button>
                                    @endif
                                </div>
                                @endif

                                <div class="contact-list-view">
                                    <table class="table table-striped table-bordered w-100 mb-5">
                                        <thead>
                                            <tr>
                                                @if (in_array(Auth::user()->role, ['Admin', 'Manager']))
                                                <th width="50">
                                                    <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)">
                                                </th>
                                                @endif
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Loan Amount (INR)</th>
                                                <th>Phone</th>
                                                <th>City</th>
                                                <th>Salary(mth)</th>
                                                <th>Created On</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($leads as $lead)
                                                <tr>
                                                    @if (in_array(Auth::user()->role, ['Admin', 'Manager']))
                                                    <td>
                                                        <input type="checkbox" class="lead-checkbox" name="lead_ids[]" value="{{ $lead->id }}" onchange="updateBulkButtons()">
                                                    </td>
                                                    @endif
                                                    <td>#{{ $lead->id }}</td>
                                                    <td>
                                                        <div class="media align-items-center">
                                                            <div class="media-body">
                                                                <a href="{{ route('lead.info', $lead->id) }}">
                                                                    <span
                                                                        class="d-block text-high-em text-primary">{{ $lead->first_name . ' ' . $lead->last_name }}</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-nowrap">@inr($lead->loan_amount)</td>
                                                    <td>{{ $lead->mobile }}</td>
                                                    <td>{{ $lead->city }}</td>
                                                    <td class="text-nowrap">@inr($lead->monthly_salary)</td>
                                                    <td>{{ $lead->created_at->format('j M, Y h:i A') }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex">
                                                                @if ($lead->agent_id != null)
                                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                        data-bs-toggle="tooltip" data-placement="top"
                                                                        title=""
                                                                        data-bs-original-title="{{ $lead->agent->name . ' (' . $lead->agent->users_id . ')' }}"
                                                                        href="#"><span class="icon"><span
                                                                                class="feather-icon"><i
                                                                                    data-feather="user"></i></span></span></a>
                                                                @else
                                                                    <a data-leadId="{{ $lead->id }}"
                                                                        class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover assignAgentModal"
                                                                        data-bs-toggle="tooltip" data-placement="top"
                                                                        title="" data-bs-original-title="Assign Agent"
                                                                        href="#"><span class="icon"><span
                                                                                class="feather-icon"><i
                                                                                    data-feather="user-plus"></i></span></span></a>
                                                                @endif
                                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Edit" data-bs-original-title="Edit"
                                                                    href="{{ route('lead.info', $lead->id) }}"><span
                                                                        class="icon"><span class="feather-icon"><i
                                                                                data-feather="edit"></i></span></span></a>

                                                                @if (Auth::user()->role == 'Admin')
                                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                                        data-bs-toggle="tooltip" data-placement="top"
                                                                        title="" data-bs-original-title="Delete"
                                                                        href="{{ route('lead.delete', $lead->id) }}"
                                                                        onclick="return confirm('Are you sure you want to delete this lead?');"><span
                                                                            class="icon"><span class="feather-icon"><i
                                                                                    data-feather="trash"></i></span></span></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="{{ in_array(Auth::user()->role, ['Admin', 'Manager']) ? '9' : '8' }}" class="text-center">No leads found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center">
                                        {{ $leads->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="assignAgentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Assign Agent</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('lead.assign.agent') }}" method="POST">
                        @csrf
                        <input type="hidden" name="lead_id" id="lead_id" value="">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Agent</label>
                                <select name="agent_id" class="form-select" required>
                                    <option value="">Select Agent</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">
                                            {{ "{$agent->name} ({$agent->users_id})" }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bulk Assign Modal -->
        <div class="modal fade" id="bulkAssignModal" tabindex="-1" aria-labelledby="bulkAssignModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="bulkAssignModalLabel">Bulk Assign Agent</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('lead.bulk.assign') }}" method="POST" id="bulkAssignForm">
                        @csrf
                        <div class="modal-body">
                            <p>Assign selected leads to an agent:</p>
                            <div class="mb-3">
                                <label for="bulk-agent" class="col-form-label">Agent</label>
                                <select name="agent_id" id="bulk-agent" class="form-select" required>
                                    <option value="">Select Agent</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">
                                            {{ "{$agent->name} ({$agent->users_id})" }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Page Body -->
        @include('layouts.footer')

    </div>
    <script>
        (function() {
            var dateFilter = document.getElementById('date_filter');
            var rangeGroup = document.getElementById('custom_range_group');
            function updateRangeVisibility(shouldSubmit) {
                if (!dateFilter) return;
                var isCustom = dateFilter.value === 'custom';
                if (rangeGroup) {
                    rangeGroup.style.display = isCustom ? 'block' : 'none';
                }
                if (shouldSubmit) {
                    var form = dateFilter.form;
                    if (!form) return;
                    // If "All" selected, clear all filters
                    if (dateFilter.value === '') {
                        // Navigate to base route without any query params
                        window.location.href = form.getAttribute('action');
                        return;
                    }
                    // For non-custom predefined ranges, submit immediately
                    if (!isCustom) {
                        form.submit();
                    }
                }
            }
            if (dateFilter) {
                dateFilter.addEventListener('change', function() { updateRangeVisibility(true); });
                // Initialize on load without submitting
                updateRangeVisibility(false);
            }
        })();

        // Bulk operations functions
        function toggleSelectAll(checkbox) {
            var checkboxes = document.querySelectorAll('.lead-checkbox');
            checkboxes.forEach(function(cb) {
                cb.checked = checkbox.checked;
            });
            updateBulkButtons();
            if (checkbox.checked) {
                document.getElementById('selectAllBtn').style.display = 'none';
                document.getElementById('deselectAllBtn').style.display = 'inline-block';
            } else {
                document.getElementById('selectAllBtn').style.display = 'inline-block';
                document.getElementById('deselectAllBtn').style.display = 'none';
            }
        }

        function selectAll() {
            var checkboxes = document.querySelectorAll('.lead-checkbox');
            var selectAllCheckbox = document.getElementById('selectAllCheckbox');
            checkboxes.forEach(function(cb) {
                cb.checked = true;
            });
            if (selectAllCheckbox) selectAllCheckbox.checked = true;
            updateBulkButtons();
            document.getElementById('selectAllBtn').style.display = 'none';
            document.getElementById('deselectAllBtn').style.display = 'inline-block';
        }

        function deselectAll() {
            var checkboxes = document.querySelectorAll('.lead-checkbox');
            var selectAllCheckbox = document.getElementById('selectAllCheckbox');
            checkboxes.forEach(function(cb) {
                cb.checked = false;
            });
            if (selectAllCheckbox) selectAllCheckbox.checked = false;
            updateBulkButtons();
            document.getElementById('selectAllBtn').style.display = 'inline-block';
            document.getElementById('deselectAllBtn').style.display = 'none';
        }

        function updateBulkButtons() {
            var checked = document.querySelectorAll('.lead-checkbox:checked');
            var bulkAssignBtn = document.getElementById('bulkAssignBtn');
            var bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            
            if (bulkAssignBtn) {
                bulkAssignBtn.disabled = checked.length === 0;
            }
            if (bulkDeleteBtn) {
                bulkDeleteBtn.disabled = checked.length === 0;
            }
        }

        function showBulkAssignModal() {
            var checked = document.querySelectorAll('.lead-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one lead.');
                return;
            }
            var modal = new bootstrap.Modal(document.getElementById('bulkAssignModal'));
            modal.show();
        }

        function bulkDelete() {
            var checked = document.querySelectorAll('.lead-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one lead.');
                return;
            }
            
            if (!confirm('Are you sure you want to delete ' + checked.length + ' lead(s)?')) {
                return;
            }

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("lead.bulk.delete") }}';
            
            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            checked.forEach(function(checkbox) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'lead_ids[]';
                input.value = checkbox.value;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }

        // Update bulk assign form with selected lead IDs
        document.getElementById('bulkAssignForm')?.addEventListener('submit', function(e) {
            var checked = document.querySelectorAll('.lead-checkbox:checked');
            checked.forEach(function(checkbox) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'lead_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            }.bind(this));
        });
    </script>
@endsection
