@extends('layouts.app')

@section('title', 'Deleted Leads | Money Portal')

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
                                        <h1>Deleted Leads</h1>
                                    </a>
                                    <a href="{{ route('leads') }}" class="btn btn-primary btn-sm">Back to Leads</a>
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

                                <form method="GET" action="{{ route('deleted.leads') }}" class="mb-3">
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

                                <div class="mb-3 d-flex gap-2 align-items-center">
                                    <button type="button" class="btn btn-sm btn-primary" id="selectAllBtn" onclick="selectAll()">Select All</button>
                                    <button type="button" class="btn btn-sm btn-secondary" id="deselectAllBtn" onclick="deselectAll()" style="display: none;">Deselect All</button>
                                    <button type="button" class="btn btn-sm btn-success" id="bulkRestoreBtn" onclick="bulkRestore()" disabled>Bulk Restore</button>
                                    <button type="button" class="btn btn-sm btn-danger" id="bulkDeletePermanentBtn" onclick="bulkDeletePermanent()" disabled>Delete Permanently</button>
                                </div>

                                <div class="contact-list-view">
                                    <table class="table table-striped table-bordered w-100 mb-5">
                                        <thead>
                                            <tr>
                                                <th width="50">
                                                    <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)">
                                                </th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Loan Amount (INR)</th>
                                                <th>Phone</th>
                                                <th>City</th>
                                                <th>Salary(mth)</th>
                                                <th>Deleted On</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($leads as $lead)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="lead-checkbox" name="lead_ids[]" value="{{ $lead->id }}" onchange="updateBulkButtons()">
                                                    </td>
                                                    <td>#{{ $lead->id }}</td>
                                                    <td>
                                                        <div class="media align-items-center">
                                                            <div class="media-body">
                                                                <span class="d-block text-high-em">{{ $lead->first_name . ' ' . $lead->last_name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-nowrap">@inr($lead->loan_amount)</td>
                                                    <td>{{ $lead->mobile }}</td>
                                                    <td>{{ $lead->city }}</td>
                                                    <td class="text-nowrap">@inr($lead->monthly_salary)</td>
                                                    <td>{{ $lead->deleted_at ? $lead->deleted_at->format('j M, Y h:i A') : 'N/A' }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex">
                                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Restore" data-bs-original-title="Restore"
                                                                    href="{{ route('lead.restore', $lead->id) }}"
                                                                    onclick="return confirm('Are you sure you want to restore this lead?');">
                                                                    <span class="icon">
                                                                        <span class="feather-icon">
                                                                            <i data-feather="rotate-cw"></i>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No deleted leads found.</td>
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
                    if (dateFilter.value === '') {
                        window.location.href = form.getAttribute('action');
                        return;
                    }
                    if (!isCustom) {
                        form.submit();
                    }
                }
            }
            if (dateFilter) {
                dateFilter.addEventListener('change', function() { updateRangeVisibility(true); });
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
            var bulkRestoreBtn = document.getElementById('bulkRestoreBtn');
            var bulkDeletePermanentBtn = document.getElementById('bulkDeletePermanentBtn');
            
            if (bulkRestoreBtn) {
                bulkRestoreBtn.disabled = checked.length === 0;
            }
            if (bulkDeletePermanentBtn) {
                bulkDeletePermanentBtn.disabled = checked.length === 0;
            }
        }

        function bulkRestore() {
            var checked = document.querySelectorAll('.lead-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one lead.');
                return;
            }
            
            if (!confirm('Are you sure you want to restore ' + checked.length + ' lead(s)?')) {
                return;
            }

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("lead.bulk.restore") }}';
            
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

        function bulkDeletePermanent() {
            var checked = document.querySelectorAll('.lead-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one lead.');
                return;
            }
            
            if (!confirm('WARNING: Are you sure you want to PERMANENTLY delete ' + checked.length + ' lead(s)? This action cannot be undone!')) {
                return;
            }

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("lead.bulk.delete.permanent") }}';
            
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
    </script>
@endsection

