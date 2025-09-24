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
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="disposition" class="form-select" onchange="this.form.submit()">
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
                                                    {{ request('disposition') == 'Docs received' ? 'selected' : '' }}>Docs
                                                    received</option>
                                                <option value="Approved"
                                                    {{ request('disposition') == 'Approved' ? 'selected' : '' }}>Approved
                                                </option>
                                                <option value="Disbursed"
                                                    {{ request('disposition') == 'Disbursed' ? 'selected' : '' }}>Disbursed
                                                </option>
                                                <option value="Reopen"
                                                    {{ request('disposition') == 'Reopen' ? 'selected' : '' }}>Reopen
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="date_filter" id="date_filter" class="form-select">
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
                                        <div class="col-md-4" id="custom_range_group" style="display: none;">
                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                                <span class="mx-1">to</span>
                                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                                <button type="submit" class="btn btn-primary">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <div class="contact-list-view">
                                    <table class="table table-striped table-bordered w-100 mb-5">
                                        <thead>
                                            <tr>
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
                                                    <td>{{ $lead->loan_amount }}</td>
                                                    <td>{{ $lead->mobile }}</td>
                                                    <td>{{ $lead->city }}</td>
                                                    <td>{{ $lead->monthly_salary }}</td>
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
                                                    <td colspan="8" class="text-center">No leads found.</td>
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
                        <input type="hidden" name="id" id="lead_id" value="">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Agent</label>
                                <select name="agent" class="form-select" required>
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
    </script>
@endsection
