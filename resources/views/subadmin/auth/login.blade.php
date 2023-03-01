<!doctype html>
<html lang="en">

    
<!-- Mirrored from themesdesign.in/nazox/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Mar 2022 09:06:46 GMT -->
<head>
        
        <meta charset="utf-8" />
        <title>Riding Charter || 81Support</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Support 81" name="description" />
        <meta content="Support 81" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ url('public/assets/dashboard-nazox/assets/images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{ url('public/assets/dashboard-nazox/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ url('public/assets/dashboard-nazox/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ url('public/assets/dashboard-nazox/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="auth-body-bg">
        <div>
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-4">
                        <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                            <div class="w-100">
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                        <div>
                                            <div class="text-center">
                                                {{-- <div>
                                                    <a href="index.html" class="">
                                                        <img src="assets/images/logo-dark.png" alt="" height="20" class="auth-logo logo-dark mx-auto">
                                                        <img src="assets/images/logo-light.png" alt="" height="20" class="auth-logo logo-light mx-auto">
                                                    </a>
                                                </div> --}}
    
                                                <h4 class="font-size-18 mt-4">Welcome Back !</h4>
                                                <p class="text-muted">Sign in to continue to Riding Charter Panel.</p>

                                                @if(session()->has('err_msg'))
                                                <div class="alert alert-danger">{{ session()->get('err_msg') }}</div>
                                                @endif
                                                @php session()->forget('err_msg'); @endphp

                                            </div>

                                            <div class="p-2 mt-5">
                                                <form method="POST" class="" action="{{ route('subadmin.loginPost') }}">
                                                    @csrf
                                                    <div class="mb-3 auth-form-group-custom mb-4">
                                                        <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                        <label for="username">Email</label>
                                                        <input type="text" name="email" class="form-control @error('email') ? ' is-invalid' : '' @enderror" id="username" placeholder="Enter Email">
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="mb-3 auth-form-group-custom mb-4">
                                                        <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                        <label for="userpassword">Password</label>
                                                        <input type="password" name="password" class="form-control @error('password') ? ' is-invalid' : '' @enderror" id="userpassword" placeholder="Enter password">
                                                        @error('password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                            
                                                    {{-- <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="customControlInline">
                                                        <label class="form-check-label" for="customControlInline">Remember me</label>
                                                    </div> --}}

                                                    <div class="mt-4 text-center">
                                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                                    </div>

                                                    {{-- <div class="mt-4 text-center">
                                                        <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                                    </div> --}}
                                                </form>
                                            </div>

                                            <div class="mt-5 text-center">
                                                <p><a href="#" class="fw-medium text-primary"> Forgot Password? </a> </p>
                                                {{-- <p>© <script>document.write(new Date().getFullYear())</script> Nazox. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="authentication-bg">
                            <div class="bg-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        {{-- <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script> --}}

        <script src="assets/js/app.js"></script>

    </body>

<!-- Mirrored from themesdesign.in/nazox/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Mar 2022 09:06:46 GMT -->
</html>
