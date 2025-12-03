@extends('layouts.app')

@section('title', 'Users List | Money Portal')

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
                                        <h1>Users List</h1>
                                    </a>
                                    @if (Auth::user()->role === 'Admin')
                                    <button class="btn btn-sm btn-outline-secondary flex-shrink-0 d-lg-inline-block d-none"
                                        data-bs-toggle="modal" data-bs-target="#add_new_contact">+ Create New</button>
                                    @endif
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

                                <form method="GET" action="{{ route('emp') }}" class="mb-3">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-4">
                                            <input type="text" name="search" class="form-control form-control-sm" 
                                                placeholder="Search by Name, Email, or Employee ID" 
                                                value="{{ request('search') }}" />
                                        </div>
                                        <div class="col-md-auto">
                                            <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                            @if(request('search'))
                                                <a href="{{ route('emp') }}" class="btn btn-secondary btn-sm">Clear</a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                                <div class="contact-list-view">
                                    <table class="table table-striped table-bordered w-100 mb-5">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Position</th>
                                                <th>Date Created</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($emp as $users)
                                                @if ($users->id != Auth::user()->id)
                                                    <tr>
                                                        <td>
                                                            #{{ $users->users_id }}
                                                        </td>
                                                        <td>
                                                            <div class="media align-items-center">
                                                                <div class="media-body">
                                                                    <span
                                                                        class="d-block text-high-em">{{ $users->name }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $users->email }}</td>
                                                        <td>{{ $users->role }}</td>
                                                        <td>{{ $users->created_at->format('j M, Y h:i A') }}</td>
                                                        <td>
                                                            @if ($users->status == 'Active')
                                                                <span class="badge badge-soft-success">Active</span>
                                                            @elseif($users->status == 'Deactive')
                                                                <span class="badge badge-soft-danger">Deactive</span>
                                                            @endif

                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="d-flex">
                                                                    <a data-emp-id="{{ $users->id }}"
                                                                        class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover edit-users-btn"
                                                                        data-bs-toggle="modal" data-bs-target="#edit_emp"
                                                                        title="Edit">
                                                                        <span class="icon">
                                                                            <span class="feather-icon"><i
                                                                                    data-feather="edit"></i></span>
                                                                        </span>
                                                                    </a>

                                                                    <a class="btn btn-icon btn-flush-dark btn-rounded flush-soft-hover del-button"
                                                                        data-bs-toggle="tooltip" data-placement="top"
                                                                        title="" data-bs-original-title="Delete"
                                                                        href="{{ route('users.delete', $users->id) }}"
                                                                        onclick="return confirm('Are you sure you want to delete this user?');"><span class="icon"><span
                                                                                class="feather-icon"><i
                                                                                    data-feather="trash"></i></span></span></a>
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No users found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center">
                                        {{ $emp->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Info -->
                    <div id="add_new_contact" class="modal fade add-new-contact" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{ route('userss.store') }}" method="post" id="createUserForm">
                                    @csrf
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="mb-5">Create New users</h5>

                                        <div class="row gx-3">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Full Name*</label>
                                                    <input class="form-control" type="text" name="name"
                                                        placeholder="Full Name" required minlength="2" maxlength="255" />
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Email*</label>
                                                    <input class="form-control" type="email" name="email"
                                                        placeholder="Email" required maxlength="255" />
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Position*</label>
                                                    <select class="form-select" name="position" required>
                                                        <option selected="">--</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Manager">Manager</option>
                                                        <option value="Agent">Agent</option>
                                                        <option value="Underwriter">Underwriter</option>
                                                        <option value="Collection">Collection</option>
                                                    </select>
                                                    @error('position')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Password*</label>
                                                    <input class="form-control" type="password" name="password"
                                                        placeholder="Set New Password" required minlength="6" maxlength="255" />
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer align-items-center">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Discard</button>
                                        <button type="submit" class="btn btn-primary">Create
                                            users</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="edit_emp" class="modal fade add-new-contact" tabindex="-1" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <form action="{{ route('users.update') }}" method="post" id="editUserForm">
                                    @csrf
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h5 class="mb-5">Create New users</h5>

                                        <div class="row gx-3">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Full Name</label>
                                                    <input class="form-control" type="text" id="emp_name"
                                                        name="name" placeholder="Full Name" required />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control" type="email" name="email"
                                                        id="emp_email" placeholder="Email" required />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Position</label>
                                                    <select class="form-select" name="position" id="emp_position"
                                                        required>
                                                        <option selected="">--</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Manager">Manager</option>
                                                        <option value="Agent">Agent</option>
                                                        <option value="Underwriter">Underwriter</option>
                                                        <option value="Collection">Collection</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">New Password</label>
                                                    <input class="form-control" type="text" name="password"
                                                        placeholder="Set New Password" id="emp_password" />
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select" name="status" id="emp_status" required>
                                                        <option value="Active">Active</option>
                                                        <option value="Deactive">Deactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer align-items-center">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Discard</button>
                                        <button type="submit" class="btn btn-primary">Update
                                            user</button>
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
    <script>
        // Frontend Form Validation for Create User
        document.getElementById('createUserForm')?.addEventListener('submit', function(e) {
            const form = this;
            let isValid = true;
            const errors = [];

            // Validate name
            const nameField = form.querySelector('input[name="name"]');
            if (nameField && nameField.value.trim().length < 2) {
                isValid = false;
                nameField.classList.add('is-invalid');
                errors.push('Name must be at least 2 characters');
            }

            // Validate email
            const emailField = form.querySelector('input[type="email"]');
            if (emailField && emailField.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    isValid = false;
                    emailField.classList.add('is-invalid');
                    errors.push('Please enter a valid email address');
                }
            }

            // Validate password
            const passwordField = form.querySelector('input[type="password"]');
            if (passwordField && passwordField.value.length < 6) {
                isValid = false;
                passwordField.classList.add('is-invalid');
                errors.push('Password must be at least 6 characters');
            }

            // Validate position
            const positionField = form.querySelector('select[name="position"]');
            if (positionField && !positionField.value) {
                isValid = false;
                positionField.classList.add('is-invalid');
                errors.push('Please select a position/role');
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fix the following errors:\n' + errors.join('\n'));
                return false;
            }
        });

        // Frontend Form Validation for Update User
        document.getElementById('editUserForm')?.addEventListener('submit', function(e) {
            const form = this;
            let isValid = true;
            const errors = [];

            // Validate email
            const emailField = form.querySelector('input[type="email"]');
            if (emailField && emailField.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    isValid = false;
                    emailField.classList.add('is-invalid');
                    errors.push('Please enter a valid email address');
                }
            }

            // Validate password if provided
            const passwordField = form.querySelector('input[type="password"]');
            if (passwordField && passwordField.value && passwordField.value.length < 6) {
                isValid = false;
                passwordField.classList.add('is-invalid');
                errors.push('Password must be at least 6 characters');
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please fix the following errors:\n' + errors.join('\n'));
                return false;
            }
        });
    </script>
@endsection
