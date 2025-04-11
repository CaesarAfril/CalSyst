<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/sneat/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login || CalSys </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/sneat/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets') }}/sneat/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets') }}/sneat/assets/js/config.js"></script>
</head>

<style>
    body {
        background-color: #FFF7D1;
    }

    .input-custom {
        background-color: #fff;
        /* Light yellow */
        border: none;
        border-radius: 50px;
        /* Rounded shape */
        padding: 12px 20px;
        font-size: 18px;
        text-align: center;
        color: #b0a35a;
        /* Soft brown */
        font-weight: bold;
        width: 100%;
        outline: none;
        height: 50px;
        /* Match button height */
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.2);
        /* Soft inset shadow for wavy effect */
    }

    .card {
        background: transparent !important;
        box-shadow: none !important;
        border: none !important;
    }

    .btn-custom {
        background-color: #1E4D2B;
        /* Dark green */
        color: #FFF7D1;
        /* Light yellow */
        border: none;
        border-radius: 50px;
        /* Creates the pill shape */
        padding: 12px 40px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        width: auto;
        display: inline-block;
        box-shadow: inset 0px 0px 5px rgba(0, 0, 0, 0.2);
    }

    .btn-custom:hover {
        background-color: #163D22;
        /* Slightly darker green for hover effect */
        color: #FFF7D1;
    }

    .center-button {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        /* Ensures it takes the full row width */
    }
</style>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="container-p-y">
            <div class="authentication-inner">
                @if(session('error'))
                <div class="alert alert-danger">
                    <b>Opps!</b> {{session('error')}}
                </div>
                @endif
                <!-- Register -->
                <div class="card" style="color: #FFF7D1;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <img src="{{ url('/image/title.png') }}" alt="icon" class="w-100 h-auto">
                                </div>
                                <form id="formAuthentication" class="mb-3" action="{{route('actionLogin')}}" method="POST">
                                    @csrf
                                    <div class="row mb-4">
                                        <div class="col-sm-6">
                                            <input
                                                type="text"
                                                class="form-control input-custom"
                                                id="email"
                                                name="email"
                                                placeholder="Masukkan Email atau Username"
                                                autofocus />
                                        </div>
                                        <div class="col-sm-6">
                                            <input
                                                type="password"
                                                id="password"
                                                class="form-control input-custom"
                                                name="password"
                                                placeholder="Masukkan Password"
                                                aria-describedby="password" />
                                        </div>
                                    </div>
                                    <div class="row center-button">
                                        <button class="btn btn-custom" type="submit">Masuk</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ url('/image/image.png') }}" alt="icon" class="w-100 h-auto">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('assets') }}/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('assets') }}/sneat/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets') }}/sneat/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>