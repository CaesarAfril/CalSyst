<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/sneat/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>CalSys</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/sneat/assets/img/favicon/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/css/demo.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/added.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('font/css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets') }}/sneat/assets/js/config.js"></script>

    <script type="text/javascript" src="{{ asset('assets') }}/dist/sweetalert2.all.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.0.slim.js" integrity="sha256-7GO+jepT9gJe9LB4XFf8snVOjX3iYNb0FHYr5LI1N5c=" crossorigin="anonymous"></script>

    <!-- Script dari perpus -->
    <script type="text/javascript" src="{{ asset('assets') }}/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/js/bootstrap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<style>
    body {
        background-color: #FFF6EA !important;
    }

    .custom-sidebar-text {
        color: #C14600;
    }

    .custom-sidebar {
        background-color: #FFDE95;
    }
</style>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu custom-sidebar">
                <div class="app-brand demo">
                    <a class="app-brand-link">
                        <img src="{{ url('/image/icon.png') }}" alt="icon" style="width: 200px;">
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!--***********************************
                    ---------- Button Dashboard ----------
                    ************************************-->
                    <li class="menu-item">
                        <a href="{{route('dashboard')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle custom-sidebar-text"></i>
                            <div data-i18n="Analytics" class="custom-sidebar-text">Dashboard</div>
                        </a>
                    </li>

                    <!------------------- Master Data------------------------->
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text custom-sidebar-text">Master Data</span>
                    </li>

                    <!--***********************************
                    ---------- Menu Data User -------
                    ************************************-->
                    <li class="menu-item">
                        <a href="{{route('user')}}" class="menu-link">
                            <i class="menu-icon bx bxs-bot custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Data User</div>
                        </a>
                    </li>

                    <!--***********************************
                    ---------- Menu Data Plant -------
                    ************************************-->
                    <li class="menu-item">
                        <a href="{{route('plant.index')}}" class="menu-link">
                            <i class="menu-icon bx bxs-institution custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Data Plant</div>
                        </a>
                    </li>

                    <!--***********************************
                    ---------- Menu Data Department -------
                    ************************************-->
                    <li class="menu-item">
                        <a href="{{route('department.index')}}" class="menu-link">
                            <i class="menu-icon bx bxs-home custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Data Department</div>
                        </a>
                    </li>

                    <!--***********************************
                    ---------- Menu Data Category -------
                    ************************************-->
                    <li class="menu-item">
                        <a href="{{route('category.index')}}" class="menu-link">
                            <i class='menu-icon bx bx-category custom-sidebar-text'></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Kategori Alat Ukur</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('machine.index')}}" class="menu-link">
                            <i class='menu-icon bx bx-dish custom-sidebar-text'></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Mesin</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('weight.index')}}" class="menu-link">
                            <i class='menu-icon bx bx-layer custom-sidebar-text'></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Anak Timbang</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text custom-sidebar-text">Details</span>
                    </li>
                    <!--***********************************
                    ---------- Menu E-Report Validasi Internal -------
                    ************************************-->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon bx bxs-brain custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Report Kalibrasi Internal</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('report.temperature') }}" class="menu-link">
                                    <div data-i18n="report.temperature" class="custom-sidebar-text">Report Temperatur</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('report.display') }}" class="menu-link">
                                    <div data-i18n="report.display" class="custom-sidebar-text">Report Display Suhu</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('report.scale') }}" class="menu-link">
                                    <div data-i18n="report.scale" class="custom-sidebar-text">Report Timbangan</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--***********************************
                    ---------- Menu E-Sertifikat Kalibrasi Internal --------
                    ************************************-->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-blanket custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Sertifikat Kalibrasi Internal</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('Internal_calibration.temperature') }}" class="menu-link">
                                    <div data-i18n="report.temperature" class="custom-sidebar-text">Temperatur</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('Internal_calibration.display') }}" class="menu-link">
                                    <div data-i18n="report.display" class="custom-sidebar-text">Display Suhu</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('Internal_calibration.scale') }}" class="menu-link">
                                    <div data-i18n="report.scale" class="custom-sidebar-text">Timbangan</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!--***********************************
                    ---------- Menu Sertifikat Kalibrasi Eksternal --------
                    ************************************-->
                    <li class="menu-item">
                        <a href="{{route('External_calibration')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-blanket custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Sertifikat Kalibrasi Eksternal</div>
                        </a>
                    </li>

                    <!--***********************************
                    ---------- Menu Aset Alat Ukur --------
                    ************************************-->
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bxs-cog custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Aset</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{route('asset.index')}}" class="menu-link">
                                    <div class="custom-sidebar-text">Aset Alat Ukur</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('validation_asset.index')}}" class="menu-link">
                                    <div class="custom-sidebar-text">Aset Mesin Pemasakan</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--***********************************
                    ---------- Menu Reference --------
                    ************************************-->
                    <li class="menu-item">
                        <a href="{{route('references')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-file-blank custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text">Referensi</div>
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <div> Hai, {{Auth::user()->name}}! You are logged in.
                                </div>
                                <!-- <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." /> -->
                            </div>
                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto" style="width:150px">
                            <div class="btn-group dropleft">
                                <button type="button" class="btn btn-primary dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                    Logout
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                        <span class="align-middle">Ganti Password</span>
                                    </a>
                                    <a href="{{ route('actionLogout') }}" class="dropdown-item" type="submit">Logout</a>
                                    <!-- <button class="dropdown-item" href="/sesi/logout" name="submit" type="submit">Logout</button> -->
                                </div>
                            </div>
                            </a>
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel">Ganti Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('user.changePassword')}}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Password Lama</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).click(function() {
            var id_packing = $(this).attr();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus data ini!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "/packing/hapus/" + id_packing + "" //ini nyobaaaa
                    Swal.fire(
                        'Data Terhapus!',
                        'Data berhasil dihapus',
                        'success'
                    )
                }
            })
        })
    </script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script type="text/javascript" src="{{ asset('assets') }}/dist/sweetalert2.all.min.js"></script>

    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets') }}/sneat/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets') }}/sneat/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @yield('script')
</body>

</html>