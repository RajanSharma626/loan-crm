@extends('layouts.app')

@section('title', 'Underwriting Documents List | Money Portal')

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
                                        <h1>Underwriting Documents List</h1>
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
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex">
                                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Review Docs" data-bs-original-title="Review Docs"
                                                                    href="{{ route('underwriting.review', $lead->id) }}"><span
                                                                        class="icon"><span class="feather-icon"><i
                                                                                data-feather="check-square"></i></span></span></a>
                                                                @if($lead->eagreement && !empty($lead->eagreement->acceptance_token) && !$lead->eagreement->is_accepted)
                                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Copy Acceptance Link" data-bs-original-title="Copy Acceptance Link"
                                                                    href="javascript:void(0);"
                                                                    onclick="copyAcceptanceLink(event, '{{ route('acceptance.verify', $lead->eagreement->acceptance_token) }}', '{{ $lead->id }}')"><span
                                                                        class="icon"><span class="feather-icon"><i
                                                                                data-feather="link"></i></span></span></a>
                                                                @elseif($lead->eagreement && $lead->eagreement->is_accepted)
                                                                <a class="btn btn-icon btn-flush-success btn-rounded flush-soft-hover"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="Accepted" data-bs-original-title="Accepted"
                                                                    href="javascript:void(0);"
                                                                    disabled><span
                                                                        class="icon"><span class="feather-icon"><i
                                                                                data-feather="check-circle"></i></span></span></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No leads found.</td>
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

        function copyAcceptanceLink(event, link, leadId) {
            event.preventDefault();
            // Create a temporary input element
            const tempInput = document.createElement('input');
            tempInput.value = link;
            document.body.appendChild(tempInput);
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // For mobile devices
            
            try {
                document.execCommand('copy');
                // Show success notification
                const btn = event.target.closest('a');
                const originalTitle = btn.getAttribute('data-bs-original-title');
                btn.setAttribute('data-bs-original-title', 'Link Copied!');
                
                // Try to update tooltip if Bootstrap is available
                if (typeof bootstrap !== 'undefined') {
                    const tooltip = bootstrap.Tooltip.getInstance(btn);
                    if (tooltip) {
                        tooltip.setContent({ '.tooltip-inner': 'Link Copied!' });
                        tooltip.show();
                        setTimeout(() => {
                            tooltip.hide();
                            btn.setAttribute('data-bs-original-title', originalTitle);
                        }, 2000);
                    } else {
                        alert('Link copied to clipboard!');
                    }
                } else {
                    alert('Link copied to clipboard!');
                }
            } catch (err) {
                // Fallback for browsers that don't support execCommand
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(link).then(function() {
                        alert('Link copied to clipboard!');
                    }, function(err) {
                        alert('Failed to copy. Please copy manually: ' + link);
                    });
                } else {
                    alert('Please copy manually: ' + link);
                }
            }
            
            document.body.removeChild(tempInput);
        }
    </script>
@endsection
