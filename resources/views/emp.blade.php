@extends('layouts.app')

@section('title', 'Home Page')

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
                                        <h1>Employees List</h1>
                                    </a>
                                    <button class="btn btn-sm btn-outline-secondary flex-shrink-0 d-lg-inline-block d-none"
                                        data-bs-toggle="modal" data-bs-target="#add_new_contact">+ Create New</button>
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
                                                <th>EMP ID</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Date Created</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($emp as $employee)
                                                <tr>
                                                    <td>
                                                        #{{ $employee->employee_id }}
                                                    </td>
                                                    <td>
                                                        <div class="media align-items-center">
                                                            <div class="media-body">
                                                                <span
                                                                    class="d-block text-high-em">{{ $employee->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $employee->role }}</td>
                                                    <td>{{ $employee->created_at }}</td>
                                                    <td>
                                                        @if ($employee->status == 'Active')
                                                            <span class="badge badge-soft-success">Active</span>
                                                        @elseif($employee->status == 'Inactive')
                                                            <span class="badge badge-soft-danger">Deactive</span>
                                                        @endif

                                                    </td>

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
                    <!-- Edit Info -->
                    <div id="add_new_contact" class="modal fade add-new-contact" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{ route('employees.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="mb-5">Create New Employee</h5>

                                        <div class="row gx-3">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Full Name</label>
                                                    <input class="form-control" type="text" name="name"
                                                        placeholder="Full Name" required />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Position</label>
                                                    <select class="form-select" name="position" required>
                                                        <option selected="">--</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Manager">Manager</option>
                                                        <option value="Agent">Agent</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Password</label>
                                                    <input class="form-control" type="text" name="password"
                                                        placeholder="Set New Password" required />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer align-items-center">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Discard</button>
                                        <button type="submit" class="btn btn-primary">Create
                                            Employee</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Edit Info -->

                </div>
            </div>
        </div>
        <!-- /Page Body -->
    </div>
@endsection
