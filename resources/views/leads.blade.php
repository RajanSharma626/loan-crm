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
                                        <h1>Leads List</h1>
                                    </a>
                                    <a href="{{ route('lead.form') }}"
                                        class="btn btn-sm btn-outline-secondary flex-shrink-0 d-lg-inline-block d-none">+
                                        Create New</a>
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
                                    <table id="EmpTable" class="table nowrap w-100 mb-5">
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

                                            @foreach ($leads as $lead)
                                                <tr>
                                                    <td>
                                                        #{{ $lead->id }}
                                                    </td>
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
                                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="" data-bs-original-title="Archive"
                                                                    href="#"><span class="icon"><span
                                                                            class="feather-icon"><i
                                                                                data-feather="archive"></i></span></span></a>
                                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="" data-bs-original-title="Edit"
                                                                    href="edit-contact.html"><span class="icon"><span
                                                                            class="feather-icon"><i
                                                                                data-feather="edit"></i></span></span></a>
                                                                <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                                    data-bs-toggle="tooltip" data-placement="top"
                                                                    title="" data-bs-original-title="Delete"
                                                                    href="#"><span class="icon"><span
                                                                            class="feather-icon"><i
                                                                                data-feather="trash"></i></span></span></a>
                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
@endsection
