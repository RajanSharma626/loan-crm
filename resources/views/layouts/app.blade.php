<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Daterangepicker CSS -->
    <link href="{{ asset('vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />

    <!-- Data Table CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <link href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />

    <!-- CSS -->
    <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <!-- Wrapper -->
    <div class="hk-wrapper" data-layout="vertical" data-layout-style="default" data-menu="light" data-footer="simple">
        <!-- Top Navbar -->
        <nav class="hk-navbar navbar navbar-expand-xl navbar-light fixed-top">
            <div class="container-fluid">
                <!-- Start Nav -->
                <div class="nav-start-wrap">
                    <button
                        class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle d-xl-none"><span
                            class="icon"><span class="feather-icon"><i
                                    data-feather="align-left"></i></span></span></button>
                </div>
                <!-- /Start Nav -->

                <!-- End Nav -->
                <div class="nav-end-wrap">
                    <ul class="navbar-nav flex-row">

                        <li class="nav-item">
                            <div class="dropdown ps-2">
                                <a class="dropdown-toggle no-caret d-flex align-items-center" href="#"
                                    role="button" data-bs-display="static" data-bs-toggle="dropdown"
                                    data-dropdown-animation data-bs-auto-close="outside" aria-expanded="false">
                                    <div class="avatar avatar-rounded rounded-circle avatar-xs me-2"
                                        style="background-color: #007d88;">
                                        <span
                                            class="initial-wrap text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-lg border-1 rounded-3">
                                    <div class="dropdown-header">
                                        <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                                        <small class="text-muted">ID: {{ Auth::user()->users_id }}</small>
                                    </div>
                                    <div class="dropdown-divider"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item d-flex align-items-center text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /End Nav -->
            </div>
        </nav>
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
        <div class="hk-menu">
            <!-- Brand -->
            <div class="menu-header">
                <span>
                    <a class="navbar-brand" href="/leads">
                        <h5 class="fw-bold mb-0">Money Portal</h5>
                    </a>
                    <button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle">
                        <span class="icon">
                            <span class="svg-icon fs-5">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-arrow-bar-to-left" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="10" y1="12" x2="20" y2="12"></line>
                                    <line x1="10" y1="12" x2="14" y2="16"></line>
                                    <line x1="10" y1="12" x2="14" y2="8"></line>
                                    <line x1="4" y1="4" x2="4" y2="20"></line>
                                </svg>
                            </span>
                        </span>
                    </button>
                </span>
            </div>
            <!-- /Brand -->

            <!-- Main Menu -->
            <div data-simplebar class="nicescroll-bar">
                <div class="menu-content-wrap">
                    <div class="menu-group">
                        <ul class="navbar-nav flex-column">
                            @if (Auth::check() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Manager' || Auth::user()->role === 'Agent'))
                            <li
                                class="nav-item mb-2 {{ Route::currentRouteName() == 'leads' ? 'active' : '' }} {{ Route::currentRouteName() == 'lead.info' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('leads') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-users" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <circle cx="9" cy="7" r="4" />
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Leads</span>
                                    {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                </a>
                            </li>
                            @endif
                            @if (Auth::check())
                            <li
                                class="nav-item mb-2 {{ Route::currentRouteName() == 'upload.docs' ? 'active' : '' }} {{ Route::currentRouteName() == 'document.info' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('upload.docs') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-upload" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                <polyline points="7 9 12 4 17 9" />
                                                <line x1="12" y1="4" x2="12" y2="16" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Upload Docs</span>
                                    {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                </a>
                            </li>
                            @endif
                            @if (Auth::check() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Manager' || Auth::user()->role === 'Underwriter'))
                            <li
                                class="nav-item mb-2 {{ Route::currentRouteName() == 'underwriting' ? 'active' : '' }} {{ Route::currentRouteName() == 'underwriting.review' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('underwriting') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-clipboard-check" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                                <rect x="9" y="3" width="6" height="4" rx="2" />
                                                <path d="M9 12l2 2l4 -4" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Underwriting</span>
                                    {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                </a>
                            </li>
                            @endif
                            @if (Auth::check() && in_array(Auth::user()->role, ['Admin', 'Manager', 'Underwriter']))
                            <li
                                class="nav-item mb-2 {{ Route::currentRouteName() == 'disbursal' ? 'active' : '' }} {{ Route::currentRouteName() == 'disbursal.info' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('disbursal') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-cash" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="7" y="9" width="14" height="10" rx="2" />
                                                <circle cx="14" cy="14" r="2" />
                                                <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" />
                                            </svg> 
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Disbursal</span>
                                    {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                </a>
                            </li>
                            @endif
                            @if (Auth::check() && in_array(Auth::user()->role, ['Admin', 'Manager', 'Underwriter', 'Collection']))
                            <li
                                class="nav-item mb-2 {{ Route::currentRouteName() == 'collection' ? 'active' : '' }} {{ Route::currentRouteName() == 'collection.info' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('collection') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-wallet" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 3v0m-5 4h7a3 3 0 0 0 3 -3v-10a3 3 0 0 0 -3 -3h-10a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3z" />
                                                <path d="M6 12l4 -4l4 4" />
                                            </svg> 
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Collection</span>
                                    {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                </a>
                            </li>
                            @endif
                            @if (Auth::check() && Auth::user()->role === 'Admin')
                                <li class="nav-item mb-2 {{ Route::currentRouteName() == 'deleted.leads' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('deleted.leads') }}">
                                        <span class="nav-icon-wrap">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-trash" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="nav-link-text">Deleted Leads</span>
                                        {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                    </a>
                                </li>
                                <li class="nav-item mb-3 {{ Route::currentRouteName() == 'emp' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('emp') }}">
                                        <span class="nav-icon-wrap">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-users-group" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="nav-link-text">Users</span>
                                        {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                    </a>
                                </li>
                            @endif
                            {{-- @if (Auth::check() && Auth::user()->role === 'Admin')
                            <li class="nav-item mb-2 {{ Route::currentRouteName() == 'reports' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('reports') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-chart-bar" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="3" y="12" width="6" height="8" rx="1" />
                                                <rect x="9" y="8" width="6" height="12" rx="1" />
                                                <rect x="15" y="4" width="6" height="16" rx="1" />
                                                <line x1="4" y1="20" x2="18" y2="20" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Reports</span>
                                </a>
                            </li>
                            @endif --}}
                        </ul>
                    </div>

                </div>
            </div>
            <!-- /Main Menu -->
        </div>
        <div id="hk_menu_backdrop" class="hk-menu-backdrop"></div>
        <!-- /Vertical Nav -->


        <!-- Main Content -->
        @yield('content')
        <!-- /Main Content -->
    </div>
    <!-- /Wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Bootstrap Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>

    </script>

    <script>
        $(document).ready(function() {
            $('.edit-users-btn').on('click', function() {
                let empId = $(this).data('emp-id');

                $.ajax({
                    url: '/user/edit/' + empId,
                    type: 'GET',
                    success: function(data) {
                        // Populate modal fields
                        $('#emp_name').val(data.name);
                        $('#emp_email').val(data.email);
                        $('#emp_position').val(data.role);
                        $('#emp_status').val(data.status);
                        $('#emp_password').val(''); // Optional: empty for security

                        // Optionally store users ID for update
                        $('<input>').attr({
                            type: 'hidden',
                            id: 'emp_id',
                            name: 'id',
                            value: data.id
                        }).appendTo('form');
                    },
                    error: function() {
                        alert('Failed to fetch users data.');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.assignAgentModal').on('click', function(e) {
                e.preventDefault();

                // Get leadId from data attribute
                var leadId = $(this).data('leadid');

                // Set value in modal input/display
                $('#lead_id').val(leadId);

                // Show the modal
                var modal = new bootstrap.Modal(document.getElementById('assignAgentModal'));
                modal.show();
            });
        });
    </script>



    <!-- FeatherIcons JS -->
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('vendors/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Data Table JS -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <script>
        // Initialize DataTable only if EmpTable exists
        if ($('#EmpTable').length) {
        $('#EmpTable').DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Search",
                sLengthMenu: "_MENU_items",
                paginate: {
                    next: '', // or '→'
                    previous: '' // or '←'
                }
            },
            "drawCallback": function() {
                $('.dataTables_paginate > .pagination').addClass('custom-pagination pagination-simple');
            }
        });
        }
    </script>

    <!-- Daterangepicker JS -->
    <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('dist/js/daterangepicker-data.js') }}"></script>

    <!-- Amcharts Maps JS -->
    {{-- <script src="../../../../cdn.amcharts.com/lib/5/index.js"></script>
    <script src="../../../../cdn.amcharts.com/lib/5/map.js"></script>
    <script src="../../../../cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="../../../../cdn.amcharts.com/lib/5/themes/Animated.js"></script> --}}

    <!-- Apex JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Init JS -->
    <script src="{{ asset('dist/js/init.js') }}"></script>
    <script src="{{ asset('dist/js/chips-init.js') }}"></script>
    {{-- <script src="{{ asset('dist/js/dashboard-data.js') }}"></script> --}}
</body>

</html>
