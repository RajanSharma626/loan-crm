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
                                                                <span
                                                                    class="d-block text-high-em">{{ $lead->first_name . ' ' . $lead->last_name }}</span>
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
                                                                        data-bs-original-title="{{ $lead->agent->name . ' (' . $lead->agent->employee_id . ')' }}"
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
                                                                        onclick="return confirm('Are you sure you want to delete this lead?');"><span class="icon"><span
                                                                            class="feather-icon"><i data-feather="trash"></i></span></span></a>
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
                                        {{ $leads->links('pagination::bootstrap-5') }}
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
                                            {{ "{$agent->name} ({$agent->employee_id})" }}</option>
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
@endsection
