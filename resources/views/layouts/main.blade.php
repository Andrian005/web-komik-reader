<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&amp;family=Roboto+Mono&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('panely/assets/build/styles/ltr-core.css') }}" rel="stylesheet">
    <link href="{{ asset('panely/assets/build/styles/ltr-vendor.css') }}" rel="stylesheet">
    <link href="{{ asset('panely/assets/images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon">
    <title>Dashboard | Panely</title>
</head>

<body class="theme-light preload-active aside-active aside-mobile-minimized aside-desktop-maximized" id="fullscreen">
    <!-- BEGIN Preload -->
    <div class="preload">
        <div class="preload-dialog">
            <!-- BEGIN Spinner -->
            <div class="spinner-border text-primary preload-spinner"></div>
            <!-- END Spinner -->
        </div>
    </div>
    <!-- END Preload -->
    <!-- BEGIN Page Holder -->
    <div class="holder">
        <!-- BEGIN Aside -->
        <div class="aside">
            <div class="aside-header">
                <h3 class="aside-title">Andrian</h3>
                <div class="aside-addon">
                    <button class="btn btn-label-primary btn-icon btn-lg" data-toggle="aside">
                        <i class="fa fa-times aside-icon-minimize"></i>
                        <i class="fa fa-thumbtack aside-icon-maximize"></i>
                    </button>
                </div>
            </div>
            <div class="aside-body" data-simplebar="data-simplebar">
                <!-- BEGIN Menu -->
                @include('layouts.sidebar')
                <!-- END Menu -->
            </div>
        </div>
        <!-- END Aside -->
    </div>
    <!-- BEGIN Page Wrapper -->
    <div class="wrapper">
        <!-- BEGIN Header -->
        <div class="header">

            <!-- BEGIN Header Holder -->
            @include('layouts.header')
            <!-- END Header Holder -->

            <!-- BEGIN Header Holder -->
            <div class="header-holder header-holder-desktop">
                <div class="header-container container-fluid">
                    <h4 class="header-title">{{ $title }}</h4>
                    <i class="header-divider"></i>
                    <div class="header-wrap header-wrap-block justify-content-start">
                        <!-- BEGIN Breadcrumb -->
                        <div class="breadcrumb">
                            <div class="breadcrumb-icon">
                                <i data-feather="home"></i>
                            </div>
                            @php
                                $segments = Request::segments();
                            @endphp
                            @foreach($segments as $index => $segment)
                                @php
                                    $url = url(implode('/', array_slice($segments, 0, $index + 1)));
                                    $name = ucwords(str_replace('-', ' ', $segment));
                                @endphp
                                <a href="{{ $url }}" class="breadcrumb-item">
                                    <span class="breadcrumb-text">{{ $name }}</span>
                                </a>
                            @endforeach
                        </div>
                        <!-- END Breadcrumb -->
                    </div>
                    <div class="header-wrap">
                        <button class="btn btn-label-info btn-icon ml-2" id="fullscreen-trigger" data-toggle="tooltip"
                            title="Toggle fullscreen" data-placement="left">
                            <i class="fa fa-expand fullscreen-icon-expand"></i>
                            <i class="fa fa-compress fullscreen-icon-compress"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- END Header Holder -->

            <!-- BEGIN Header Holder -->
            @include('layouts.header2')
            <!-- END Header Holder -->

            <!-- BEGIN Header Holder -->
            <div class="header-holder header-holder-mobile">
                <div class="header-container container-fluid">
                    <div class="header-wrap header-wrap-block justify-content-start w-100">
                        <!-- BEGIN Breadcrumb -->
                        <div class="breadcrumb">
                            <div class="breadcrumb-icon">
                                <i data-feather="home"></i>
                            </div>
                            @php
                                $segments = Request::segments();
                            @endphp
                            @foreach($segments as $index => $segment)
                                @php
                                    $url = url(implode('/', array_slice($segments, 0, $index + 1)));
                                    $name = ucwords(str_replace('-', ' ', $segment));
                                @endphp
                                <a href="{{ $url }}" class="breadcrumb-item">
                                    <span class="breadcrumb-text">{{ $name }}</span>
                                </a>
                            @endforeach
                        </div>
                        <!-- END Breadcrumb -->
                    </div>
                </div>
            </div>
            <!-- END Header Holder -->
        </div>
        <!-- END Header -->
        <!-- BEGIN Page Content -->
        <div class="content ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
        <!-- BEGIN Footer -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-left mb-0">Copyright <i class="far fa-copyright"></i> <span
                                id="copyright-year"></span> Panely. All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Footer -->
    </div>
    <!-- END Page Wrapper -->
    </div>
    <!-- END Page Holder -->

    <!-- BEGIN Scroll To Top -->
    <div class="scrolltop">
        <button class="btn btn-info btn-icon btn-lg">
            <i class="fa fa-angle-up"></i>
        </button>
    </div>
    <!-- END Scroll To Top -->

    <!-- BEGIN Float Button -->
    <div class="float-btn float-btn-right">
        <button class="btn btn-flat-primary btn-icon mb-2" id="theme-toggle" data-toggle="tooltip"
            data-placement="right" title="Change theme">
            <i class="fa fa-moon"></i>
        </button>
    </div>
    <!-- END Float Button -->
    <script type="text/javascript" src="{{ asset('panely/assets/build/scripts/mandatory.js') }}"></script>
    <script type="text/javascript" src="{{ asset('panely/assets/build/scripts/core.js') }}"></script>
    <script type="text/javascript" src="{{ asset('panely/assets/build/scripts/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('panely/assets/build/scripts/vendor.js') }}"></script>
</body>

</html>
