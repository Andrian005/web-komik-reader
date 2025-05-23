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
    <title>Login Admin</title>
</head>

<body class="theme-light preload-active" id="fullscreen">
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
        <!-- BEGIN Page Wrapper -->
        <div class="wrapper">
            <!-- BEGIN Page Content -->
            <div class="content ">
                <div class="container-fluid">
                    <div class="row no-gutters align-items-center justify-content-center h-100">
                        <div class="col-sm-8 col-md-6 col-lg-4 col-xl-3">
                            <!-- BEGIN Portlet -->
                            <div class="portlet">
                                <div class="portlet-body">
                                    <div class="text-center mb-4">
                                        <!-- BEGIN Avatar -->
                                        <div class="avatar avatar-label-primary avatar-circle widget12">
                                            <div class="avatar-display">
                                                <i class="fa fa-user-alt"></i>
                                            </div>
                                        </div>
                                        <!-- END Avatar -->
                                    </div>
                                    
                                    @if ($errors->has('error'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('error') }}
                                        </div>
                                    @endif

                                    <!-- BEGIN Form -->
                                    <form id="login-form" method="post" action="{{ route('auth-admin') }}">
                                        @csrf
                                        <!-- BEGIN Form Group -->
                                        <div class="form-group">
                                            <div class="float-label float-label-lg">
                                                <input class="form-control form-control-lg" type="text" id="username"
                                                    name="username" value="{{ old('username') }}"
                                                    placeholder="Masukkan Username">
                                                <label for="username">Username</label>
                                            </div>
                                            @error('username')
                                                <span style="color:red;">{{ $message }}</span><br>
                                            @enderror
                                        </div>
                                        <!-- END Form Group -->
                                        <!-- BEGIN Form Group -->
                                        <div class="form-group">
                                            <div class="float-label float-label-lg">
                                                <input class="form-control form-control-lg" type="password"
                                                    id="password" name="password" placeholder="Masukkan Password">
                                                <label for="password">Password</label>
                                            </div>
                                            @error('password')
                                                <span style="color:red;">{{ $message }}</span><br>
                                            @enderror
                                        </div>
                                        <!-- END Form Group -->
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <!-- BEGIN Form Group -->
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-control-lg custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="remember"
                                                        name="remember">
                                                    <label class="custom-control-label" for="remember">Remember
                                                        me</label>
                                                </div>
                                            </div>
                                            <!-- END Form Group -->
                                            <a href="#">Forgot password?</a>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button type="submit"
                                                class="btn btn-label-primary btn-lg btn-widest">Login</button>
                                        </div>
                                    </form>
                                    <!-- END Form -->
                                </div>
                            </div>
                            <!-- END Portlet -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
        </div>
        <!-- END Page Wrapper -->
    </div>
    <!-- END Page Holder -->

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
    <script type="text/javascript" src="{{ asset('panely/assets/app/pages/login.js') }}"></script>
</body>

</html>
