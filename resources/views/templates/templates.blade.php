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
        content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />

    <title>CalSys</title>

    <meta name="description" content="web kalibrasi dan validasi" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/fonts/boxicons.css" rel="preload" as="style" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/css/core.css" class="template-customizer-core-css" rel="preload" as="style" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" rel="preload" as="style" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/css/demo.css" rel="preload" as="style" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/added.css" rel="preload" as="style" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" rel="preload" as="style" />
    <link rel="stylesheet" href="{{ asset('font/css/all.css') }}" rel="preload" as="style" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/libs/apex-charts/apex-charts.css" rel="preload" as="style" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/helpers.js" defer></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets') }}/sneat/assets/js/config.js" defer></script>

    <script type="text/javascript" src="{{ asset('assets') }}/dist/sweetalert2.all.min.js" defer></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.0.slim.js" integrity="sha256-7GO+jepT9gJe9LB4XFf8snVOjX3iYNb0FHYr5LI1N5c=" crossorigin="anonymous" defer></script>

    <!-- Script dari perpus -->
    <script type="text/javascript" src="{{ asset('assets') }}/js/jquery-3.2.1.min.js" defer></script>
    <script type="text/javascript" src="{{ asset('assets') }}/js/bootstrap.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>

</head>
<style>
    body {
        background-color: #FFF6EA !important;
    }

    .custom-sidebar-text {
        color: #C14600;
        font-weight: 500;
    }

    .custom-sidebar {
        background-color: #FFDE95;
    }

    .menu-toggle::after {
        color: #C14600 !important;
        font-weight: bold;
    }

    .fade {
        width: 100% !important;
        height: 100% !important;
    }

    .modal {
        text-align: left;
    }

    .card-header {
        font-size: 1.7rem;
        margin-bottom: 3rem !important;
    }
</style>

@yield('style')

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu custom-sidebar">
                <div class="app-brand demo">
                    <a class="app-brand-link" href="{{route('dashboard')}}">
                        <img src="{{ url('/image/icon.png') }}" alt="icon" style="width: 200px;">
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1" style="margin-top: 2rem;">
                    <!--***********************************
                        ---------- Button Dashboard ----------
                        ************************************-->
                    <li class="menu-item">
                        <a href="{{route('dashboard')}}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle custom-sidebar-text"></i>
                            <div data-i18n="Analytics" class="custom-sidebar-text" style="font-size: 18px">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-item mt-2 {{ request()->is('user*') || request()->is('plant*') || request()->is('department*') || request()->is('category*') || request()->is('machine*') || request()->is('weight*') || request()->is('asset*') || request()->is('validation_asset*') ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon bx bxs-data custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Database</div>
                        </a>
                        <ul class="menu-sub" style="margin-left: -.1rem;">

                            <!--***********************************
                                ---------- Menu Data User -------
                                ************************************-->
                            <li class="menu-item {{ request()->is('user*') ? 'active' : '' }}">
                                <a href="{{ route('user') }}" class="menu-link">
                                    <i class="menu-icon bx bxs-bot custom-sidebar-text"></i>
                                    <div class="custom-sidebar-text" style="font-size: 18px">Data User</div>
                                </a>
                            </li>

                            <!--***********************************
                                ---------- Menu Data Plant -------
                                ************************************-->
                            <li class="menu-item {{ request()->is('plant*') ? 'active' : '' }}">
                                <a href="{{ route('plant.index') }}" class="menu-link">
                                    <i class="menu-icon bx bxs-institution custom-sidebar-text"></i>
                                    <div class="custom-sidebar-text" style="font-size: 18px">Data Plant</div>
                                </a>
                            </li>

                            <!--***********************************
                                ---------- Menu Data Department -------
                                ************************************-->
                            <li class="menu-item {{ request()->is('department*') ? 'active' : '' }}">
                                <a href="{{ route('department.index') }}" class="menu-link">
                                    <i class="menu-icon bx bxs-home custom-sidebar-text"></i>
                                    <div class="custom-sidebar-text" style="font-size: 18px">Data Department</div>
                                </a>
                            </li>

                            <!--***********************************
                                ---------- Menu Data Category -------
                                ************************************-->
                            <li class="menu-item {{ request()->is('category*') ? 'active' : '' }}">
                                <a href="{{ route('category.index') }}" class="menu-link">
                                    <i class="menu-icon bx bx-category custom-sidebar-text"></i>
                                    <div class="custom-sidebar-text" style="font-size: 18px">Kategori Alat Ukur</div>
                                </a>
                            </li>

                            <li class="menu-item {{ request()->is('machine*') ? 'active' : '' }}">
                                <a href="{{ route('machine.index') }}" class="menu-link">
                                    <i class="menu-icon bx bx-dish custom-sidebar-text"></i>
                                    <div class="custom-sidebar-text" style="font-size: 18px">Mesin</div>
                                </a>
                            </li>

                            <li class="menu-item {{ request()->is('weight*') ? 'active' : '' }}">
                                <a href="{{ route('weight.index') }}" class="menu-link">
                                    <i class="menu-icon bx bx-layer custom-sidebar-text"></i>
                                    <div class="custom-sidebar-text" style="font-size: 18px">Anak Timbang</div>
                                </a>
                            </li>

                            <!--***********************************
                                ---------- Menu Aset Alat Ukur --------
                                ************************************-->
                            <li class="menu-item {{ request()->is('asset*') || request()->is('validation_asset*') ? 'open' : '' }}">
                                <a href="javascript:void(0)" class="menu-link menu-toggle">
                                    <i class="menu-icon tf-icons bx bxs-cog custom-sidebar-text"></i>
                                    <div class="custom-sidebar-text" style="font-size: 18px">Aset</div>
                                </a>
                                <ul class="menu-sub" style="margin-left: -.1rem;">
                                    <li class="menu-item {{ request()->is('asset*') ? 'active' : '' }}">
                                        <a href="{{ route('asset.index') }}" class="menu-link">
                                            <div class="custom-sidebar-text" style="font-size: 18px">Aset Alat Ukur</div>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('validation_asset*') ? 'active' : '' }}">
                                        <a href="{{ route('validation_asset.index') }}" class="menu-link">
                                            <div class="custom-sidebar-text" style="font-size: 18px">Aset Mesin Pemasakan</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item mt-2 {{ request()->is('calibration/late-calibration*') || request()->is('calibration/calibrated-assets*') ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon bx bx-desktop custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Monitoring</div>
                        </a>
                        <ul class="menu-sub" style="margin-left: -.1rem;">
                            <!--***********************************
                                ---------- Menu Total Alat Telat Kalibrasi --------
                                ************************************-->
                            <li class="menu-item {{ request()->is('calibration/late-calibration*') ? 'active' : '' }}">
                                <a href="{{ route('late-calibration') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bxs-time custom-sidebar-text"></i>
                                    <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Total Alat Telat Kalibrasi</div>
                                </a>
                            </li>

                            <!--***********************************
                                ---------- Menu Total Alat Terkalibrasi --------
                                ************************************-->
                            <li class="menu-item {{ request()->is('calibration/calibrated-assets*') ? 'active' : '' }}">
                                <a href="{{ route('calibrated-assets') }}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bx-check-double custom-sidebar-text"></i>
                                    <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Total Alat Terkalibrasi</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item mt-2 {{ request()->is('report/temperature*') || request()->is('report/display*') || request()->is('report/scale*') || request()->is('validation/slaughterhouse/screwchiller*') || request()->is('validation/slaughterhouse/ABF*') || request()->is('validation/slaughterhouse/IQF*') || request()->is('validation/further/fryer-1*') || request()->is('validation/further/fryer-2*') || request()->is('validation/further/fryer-marel*') || request()->is('validation/further/hi-cook*') || request()->is('validation/sausage/smoke-house*') || request()->is('validation/breadcrumb/aging*') || request()->is('validation/laboratory/autoclave1*') || request()->is('validation/laboratory/autoclave2*') || request()->is('validation/laboratory/ovenmemert1*') || request()->is('validation/laboratory/ovenmemert2*') ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon bx bxs-report custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Report</div>
                        </a>
                        <ul class="menu-sub" style="margin-left: -.1rem;">
                            <li class="menu-item {{ request()->is('report/temperature*') || request()->is('report/display*') || request()->is('report/scale*') ? 'open' : '' }}">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <i class="menu-icon bx bxs-brain custom-sidebar-text"></i>
                                    <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Report Kalibrasi Internal</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item {{ request()->is('report/temperature*') ? 'active' : '' }}">
                                        <a href="{{ route('report.temperature') }}" class="menu-link">
                                            <div data-i18n="report.temperature" class="custom-sidebar-text" style="font-size: 18px">Report Temperatur</div>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('report/display*') ? 'active' : '' }}">
                                        <a href="{{ route('report.display') }}" class="menu-link">
                                            <div data-i18n="report.display" class="custom-sidebar-text" style="font-size: 18px">Report Display Suhu</div>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('report/scale*') ? 'active' : '' }}">
                                        <a href="{{ route('report.scale') }}" class="menu-link">
                                            <div data-i18n="report.scale" class="custom-sidebar-text" style="font-size: 18px">Report Timbangan</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <i class="menu-icon bx bxs-check-shield custom-sidebar-text"></i>
                                    <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Report Validasi</div>
                                </a>
                                <ul class="menu-sub">
                                    @foreach($departments as $department)
                                    <li class="menu-item">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">{{$department->department}}</div>
                                        </a>
                                    </li>
                                    @endforeach
                                    <!-- <li class="menu-item {{ request()->is('validation/slaughterhouse/screwchiller*') || request()->is('validation/slaughterhouse/ABF*') || request()->is('validation/slaughterhouse/IQF*')  ? 'open' : '' }}">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                            <i class="menu-icon bx bxs-home custom-sidebar-text"></i>
                                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Slaughterhouse</div>
                                        </a>
                                        <ul class="menu-sub">
                                            <li class="menu-item {{ request()->is('validation/slaughterhouse/screwchiller*') ? 'active' : '' }}">
                                                <a href="{{ route('slaughterhouse-screwchiller') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Screwchiller</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/slaughterhouse/ABF*') ? 'active' : '' }}">
                                                <a href="{{ route('slaughterhouse-ABF') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">ABF</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/slaughterhouse/IQF*') ? 'active' : '' }}">
                                                <a href="{{ route('slaughterhouse-IQF') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">IQF</div>
                                                </a>
                                            </li>
                                        </ul>
                                    

                                    <li class="menu-item {{ request()->is('validation/further/fryer-1*') || request()->is('validation/further/fryer-2*') || request()->is('validation/further/fryer-marel*') || request()->is('validation/further/hi-cook*') ? 'open' : '' }}">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                            <i class="menu-icon bx bxs-brain custom-sidebar-text"></i>
                                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Further</div>
                                        </a>
                                        <ul class="menu-sub">
                                            <li class="menu-item {{ request()->is('validation/further/fryer-1*') ? 'active' : '' }}">
                                                <a href="{{ route('further-fryer-1') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Fryer CFS 1</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/further/fryer-2*') ? 'active' : '' }}">
                                                <a href="{{ route('further-fryer-2') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Fryer CFS 2</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/further/fryer-marel*') ? 'active' : '' }}">
                                                <a href="{{ route('further-fryer-marel') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Fryer Marel</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/further/hi-cook*') ? 'active' : '' }}">
                                                <a href="{{ route('further-hi-cook') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Hi Cook</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="menu-item {{ request()->is('validation/sausage/smoke-house*') || request()->is('validation/sausage/smoke-house-fessmann*') ? 'open' : '' }}">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                            <i class="menu-icon bx bxs-baguette custom-sidebar-text"></i>
                                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Sausage</div>
                                        </a>
                                        <ul class="menu-sub">
                                            <li class="menu-item {{ request()->is('validation/sausage/smoke-house*') ? 'active' : '' }}">
                                                <a href="{{ route('sausage-smoke-house') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Smokehouse Maurer Atmos</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/sausage/smoke-house-fessmann*') ? 'active' : '' }}">
                                                <a href="{{ route('sausage-smoke-house-fessmann') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Smokehouse Fessmann</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="menu-item {{ request()->is('validation/breadcrumb/aging*') ? 'open' : '' }}">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                            <i class="menu-icon bx bxs-brain custom-sidebar-text"></i>
                                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Breadcrumb</div>
                                        </a>
                                        <ul class="menu-sub { request()->is('validation/breadcrumb/aging*') ? 'active' : '' }}">
                                            <li class="menu-item">
                                                <a href="{{ route('breadcrumb-aging') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Aging</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="menu-item {{ request()->is('validation/laboratory/autoclave1*') || request()->is('validation/laboratory/autoclave2*') || request()->is('validation/laboratory/ovenmemert1*') || request()->is('validation/laboratory/ovenmemert2*') ? 'open' : '' }}">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                                            <i class="menu-icon bx bx-atom custom-sidebar-text"></i>
                                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Laboratory</div>
                                        </a>
                                        <ul class="menu-sub">
                                            <li class="menu-item {{ request()->is('validation/laboratory/autoclave1*') ? 'active' : '' }}">
                                                <a href="{{ route('laboratory-autoclave1') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Autoclave HL-36-AE</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/laboratory/autoclave2*') ? 'active' : '' }}">
                                                <a href="{{ route('laboratory-autoclave2') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Autoclave HVE-50</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/laboratory/ovenmemert1*') ? 'active' : '' }}">
                                                <a href="{{ route('laboratory-ovenmemert1') }}" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Oven Memert 1</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('validation/laboratory/ovenmemert2*') ? 'active' : '' }}">
                                                <a href="ovenmemert2" class="menu-link">
                                                    <div class="custom-sidebar-text" style="font-size: 18px">Oven Memert 2</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li> -->
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item mt-2 {{ request()->is('internal*') || request()->is('sertifikat/eksternal*') || request()->is('referensi*') || request()->is('sertifikat/internal/temperature*') || request()->is('sertifikat/internal/display*') || request()->is('sertifikat/internal/scale*') ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon bx bxs-file-pdf custom-sidebar-text"></i>
                            <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Sertifikat</div>
                        </a>
                        <ul class="menu-sub" style="margin-left: -.1rem;">
                            <!--***********************************
                                ---------- Menu E-Sertifikat Kalibrasi Internal --------
                                ************************************-->
                            <li class="menu-item {{ request()->is('internal*') || request()->is('sertifikat/internal/temperature*') || request()->is('sertifikat/internal/display*') || request()->is('sertifikat/internal/scale*') ? 'open' : '' }}">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <i class="menu-icon tf-icons bx bxs-blanket custom-sidebar-text"></i>
                                    <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Sertifikat Kalibrasi Internal</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item {{ request()->is('sertifikat/internal/temperature*') ? 'active' : '' }}">
                                        <a href="{{ route('Internal_calibration.temperature') }}" class="menu-link">
                                            <div data-i18n="report.temperature" class="custom-sidebar-text" style="font-size: 18px">Temperatur</div>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('sertifikat/internal/display*') ? 'active' : '' }}">
                                        <a href="{{ route('Internal_calibration.display') }}" class="menu-link">
                                            <div data-i18n="report.display" class="custom-sidebar-text" style="font-size: 18px">Display Suhu</div>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('sertifikat/internal/scale*') ? 'active' : '' }}">
                                        <a href="{{ route('Internal_calibration.scale') }}" class="menu-link">
                                            <div data-i18n="report.scale" class="custom-sidebar-text" style="font-size: 18px">Timbangan</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!--***********************************
                                ---------- Menu Sertifikat Kalibrasi Eksternal --------
                                ************************************-->
                            <li class="menu-item {{ request()->is('sertifikat/eksternal*') ? 'active' : '' }}">
                                <a href="{{route('External_calibration')}}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bxs-blanket custom-sidebar-text"></i>
                                    <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Sertifikat Kalibrasi Eksternal</div>
                                </a>
                            </li>

                            <!--***********************************
                                ---------- Menu Reference --------
                                ************************************-->
                            <li class="menu-item {{ request()->is('referensi*') ? 'active' : '' }}">
                                <a href="{{route('references')}}" class="menu-link">
                                    <i class="menu-icon tf-icons bx bxs-file-blank custom-sidebar-text"></i>
                                    <div data-i18n="Basic" class="custom-sidebar-text" style="font-size: 18px">Referensi</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" aria-label="hamburger">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <div> Hai, {{Auth::user()->name}}! You are logged in.
                                </div>
                            </div>
                        </div>

                        <div class="navbar-nav flex-row align-items-center ms-auto" style="width:150px">
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
                        </div>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y justify-content-center items-center">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
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
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/jquery/jquery.js" defer></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/popper/popper.js" defer></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/bootstrap.js" defer></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js" defer></script>
    <script type="text/javascript" src="{{ asset('assets') }}/dist/sweetalert2.all.min.js" defer></script>

    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/menu.js" defer></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    {{-- <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/apex-charts/apexcharts.js"></script> --}}

    <!-- Main JS -->
    <script src="{{ asset('assets') }}/sneat/assets/js/main.js" defer></script>

    <!-- Page JS -->
    <script src="{{ asset('assets') }}/sneat/assets/js/dashboards-analytics.js" defer></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @yield('script')
</body>

</html>