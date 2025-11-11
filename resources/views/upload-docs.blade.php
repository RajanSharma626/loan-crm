@extends('layouts.app')

@section('title', 'Upload Docs | Money Portal')

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
                                        <h1>Upload Docs</h1>
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

                                <form method="GET" action="{{ route('upload.docs') }}" class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
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
                                        <div class="col-md-5" id="custom_range_group" style="display: none;">
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
                                                <th>Duration(Days)</th>
                                                <th>Pancard</th>
                                                <th>City</th>
                                                <th>Document Status</th>
                                                <th>Salary(mth)</th>
                                                <th>Disposition</th>
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
                                                                <a href="{{ route('document.info', $lead->id) }}">
                                                                    <span
                                                                        class="d-block text-high-em text-primary">{{ $lead->first_name . ' ' . $lead->last_name }}</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-nowrap">@inr($lead->loan_amount)</td>
                                                    <td>{{ $lead->duration }}</td>
                                                    <td>{{ $lead->pancard_number }}</td>
                                                    <td>{{ $lead->city }}</td>
                                                    <td>
                                                        <div class="d-flex flex-wrap">
                                                            @php
                                                                $doc = $lead->document;
                                                                $hasPan =
                                                                    $doc &&
                                                                    !empty($doc->pan_card) &&
                                                                    $doc->pan_card != '[]';
                                                                $hasId =
                                                                    $doc &&
                                                                    !empty($doc->adhar_card) &&
                                                                    $doc->adhar_card != '[]';
                                                                $hasPhoto =
                                                                    $doc &&
                                                                    !empty($doc->photograph) &&
                                                                    $doc->photograph != '[]';
                                                                $hasAddress =
                                                                    $doc &&
                                                                    ((!empty($doc->current_address) &&
                                                                        $doc->current_address != '[]') ||
                                                                        (!empty($doc->permanent_address) &&
                                                                            $doc->permanent_address != '[]'));
                                                                $hasSalary =
                                                                    $doc &&
                                                                    !empty($doc->salary_slip) &&
                                                                    $doc->salary_slip != '[]';
                                                                $hasBank =
                                                                    $doc &&
                                                                    !empty($doc->bank_statement) &&
                                                                    $doc->bank_statement != '[]';
                                                                $hasCibil =
                                                                    $doc && !empty($doc->cibil) && $doc->cibil != '[]';
                                                                $hasOther =
                                                                    $doc &&
                                                                    !empty($doc->other_documents) &&
                                                                    $doc->other_documents != '[]';
                                                            @endphp
                                                            <span
                                                                class="badge rounded-pill {{ $hasPan ? 'badge-success' : 'badge-secondary' }} m-1">Pancard</span>
                                                            <span
                                                                class="badge rounded-pill {{ $hasId ? 'badge-success' : 'badge-secondary' }} m-1">ID
                                                                Proof</span>
                                                            <span
                                                                class="badge rounded-pill {{ $hasPhoto ? 'badge-success' : 'badge-secondary' }} m-1">Photograph</span>
                                                            <span
                                                                class="badge rounded-pill {{ $hasAddress ? 'badge-success' : 'badge-secondary' }} m-1">Address
                                                                Proof</span>
                                                            <span
                                                                class="badge rounded-pill {{ $hasSalary ? 'badge-success' : 'badge-secondary' }} m-1">Salary</span>
                                                            <span
                                                                class="badge rounded-pill {{ $hasBank ? 'badge-success' : 'badge-secondary' }} m-1">Bank</span>
                                                            <span
                                                                class="badge rounded-pill {{ $hasCibil ? 'badge-success' : 'badge-secondary' }} m-1">CIBIL</span>
                                                            <span
                                                                class="badge rounded-pill {{ $hasOther ? 'badge-success' : 'badge-secondary' }} m-1">Other
                                                                Docs</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-nowrap">@inr($lead->monthly_salary)</td>
                                                    <td>{{ $lead->disposition }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex">
                                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Upload" data-bs-original-title="Upload"
                                                                    href="{{ route('document.info', $lead->id) }}"><span
                                                                        class="icon">
                                                                        <span class="feather-icon">
                                                                            <i
                                                                                data-feather="upload"></i>
                                                                            </span></span></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No leads found.</td>
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
                dateFilter.addEventListener('change', function() {
                    updateRangeVisibility(true);
                });
                // Initialize on load without submitting
                updateRangeVisibility(false);
            }
        })();
    </script>
@endsection
