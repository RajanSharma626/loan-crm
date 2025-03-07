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
    <link href="vendors/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />

    <!-- Data Table CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />
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
                                <a class=" dropdown-toggle no-caret" href="#" role="button"
                                    data-bs-display="static" data-bs-toggle="dropdown" data-dropdown-animation
                                    data-bs-auto-close="outside" aria-expanded="false">
                                    <div class="avatar avatar-rounded avatar-xs">
                                        <img src="dist/img/avatar12.jpg" alt="user" class="avatar-img">
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="p-2">
                                        <div class="media">
                                            <div class="media-head me-2">
                                                <div class="avatar avatar-primary avatar-sm avatar-rounded">
                                                    <span class="initial-wrap">Hk</span>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="dropdown">
                                                    <a href="#"
                                                        class="d-block dropdown-toggle link-dark fw-medium"
                                                        data-bs-toggle="dropdown" data-dropdown-animation
                                                        data-bs-auto-close="inside">Hencework</a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <div class="p-2">
                                                            <div class="media align-items-center active-user mb-3">
                                                                <div class="media-head me-2">
                                                                    <div
                                                                        class="avatar avatar-primary avatar-xs avatar-rounded">
                                                                        <span class="initial-wrap">Hk</span>
                                                                    </div>
                                                                </div>
                                                                <div class="media-body">
                                                                    <a href="#"
                                                                        class="d-flex align-items-center link-dark">Hencework
                                                                        <i
                                                                            class="ri-checkbox-circle-fill fs-7 text-primary ms-1"></i></a>
                                                                    <a href="#"
                                                                        class="d-block fs-8 link-secondary"><u>Manage
                                                                            your account</u></a>
                                                                </div>
                                                            </div>
                                                            <div class="media align-items-center mb-3">
                                                                <div class="media-head me-2">
                                                                    <div class="avatar avatar-xs avatar-rounded">
                                                                        <img src="dist/img/avatar12.jpg" alt="user"
                                                                            class="avatar-img">
                                                                    </div>
                                                                </div>
                                                                <div class="media-body">
                                                                    <a href="#" class="d-block link-dark">Jampack
                                                                        Team</a>
                                                                    <a href="#"
                                                                        class="d-block fs-8 link-secondary">contact@hencework.com</a>
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-block btn-outline-light btn-sm">
                                                                <span><span class="icon"><span class="feather-icon"><i
                                                                                data-feather="plus"></i></span></span>
                                                                    <span>Add Account</span></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="fs-7">contact@hencework.com</div>
                                                <a href="#" class="d-block fs-8 link-secondary"><u>Sign
                                                        Out</u></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="profile.html">Profile</a>
                                    <a class="dropdown-item" href="#"><span class="me-2">Offers</span><span
                                            class="badge badge-sm badge-soft-pink">2</span></a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">Manage Account</h6>
                                    <a class="dropdown-item" href="#"><span
                                            class="dropdown-icon feather-icon"><i
                                                data-feather="credit-card"></i></span><span>Payment methods</span></a>
                                    <a class="dropdown-item" href="#"><span
                                            class="dropdown-icon feather-icon"><i
                                                data-feather="check-square"></i></span><span>Subscriptions</span></a>
                                    <a class="dropdown-item" href="#"><span
                                            class="dropdown-icon feather-icon"><i
                                                data-feather="settings"></i></span><span>Settings</span></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#"><span
                                            class="dropdown-icon feather-icon"><i
                                                data-feather="tag"></i></span><span>Raise a ticket</span></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Terms & Conditions</a>
                                    <a class="dropdown-item" href="#">Help & Support</a>
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
                    <a class="navbar-brand" href="index.html">
                        <img class="brand-img img-fluid" src="dist/img/brand-sm.svg" alt="brand" />
                        <img class="brand-img img-fluid" src="dist/img/Jampack.svg" alt="brand" />
                    </a>
                    <button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle">
                        <span class="icon">
                            <span class="svg-icon fs-5">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-arrow-bar-to-left" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="index.html">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-template" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="4" y="4" width="16" height="4" rx="1" />
                                                <rect x="4" y="12" width="6" height="8" rx="1" />
                                                <line x1="14" y1="12" x2="20" y2="12" />
                                                <line x1="14" y1="16" x2="20" y2="16" />
                                                <line x1="14" y1="20" x2="20" y2="20" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Leads</span>
                                    {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                </a>
                            </li>
                            <li class="nav-item mb-3 {{ Route::currentRouteName() == 'emp' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('emp') }}">
                                    <span class="nav-icon-wrap">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-template" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="4" y="4" width="16" height="4" rx="1" />
                                                <rect x="4" y="12" width="6" height="8" rx="1" />
                                                <line x1="14" y1="12" x2="20" y2="12" />
                                                <line x1="14" y1="16" x2="20" y2="16" />
                                                <line x1="14" y1="20" x2="20" y2="20" />
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="nav-link-text">Employees</span>
                                    {{-- <span class="badge badge-sm badge-soft-pink ms-auto">Hot</span> --}}
                                </a>
                            </li>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- FeatherIcons JS -->
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('vendors/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Data Table JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

    <script>
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
    <script src="{{ asset('dist/js/dashboard-data.js') }}"></script>
</body>

</html>
