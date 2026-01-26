<!doctype html>
<html lang="en">
    <head>        
        <meta charset="utf-8" />
        <title>Login | KK&C PART CO.,LTD</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="KK&C PART CO.,LTD" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{URL::asset('assets/images/favicon.ico')}}">
        <!-- Bootstrap Css -->
        <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-soft">
                                <div class="row">
                                        <center>
                                            <img src="{{URL::asset('assets/images/KK-C.png')}}" alt="" height="150">
                                            @if (session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-check-all me-2"></i>
                                                    {{ session('success') }}
                                                    <button unit="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                @elseif(session('error'))
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <i class="mdi mdi-block-helper me-2"></i>
                                                    {{ session('error') }}
                                                    <button unit="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif
                                        </center>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                {{-- <div class="auth-logo">
                                    <a href="index.html" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{URL::asset('assets/images/logo_yasaki.png')}}"alt="" class="rounded-circle" height="68">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="index.html" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{URL::asset('assets/images/nozomi.png')}}" alt="" class="rounded-circle" height="30">
                                            </span>
                                        </div>
                                    </a>
                                </div> --}}
                                <div class="p-2">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">ชื่อผู้ใช้</label>
                                            <input id="username" class="form-control" type="text" name="username" :value="old('username')" required autofocus />
                                        </div>
                
                                        <div class="mb-3">
                                            <label class="form-label">รหัสผ่าน</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input id="password" class="form-control" type="password"name="password" required autocomplete="current-password" />
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-check">
                                            <label class="form-check-label" for="remember-check">
                                                จำรหัสผ่าน
                                            </label>
                                        </div>
                                        
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">เข้าสู่ระบบ</button>
                                        </div>       
                                        {{-- <div class="mt-4 text-center">
                                            <a href="{{ route('register') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i>สมัครสมาชิก</a>
                                        </div> --}}
                                    </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">                           
                            <div>
                                <p>© <script>document.write(new Date().getFullYear())</script>By<i class="mdi mdi-heart text-danger"></i> KK&C PART CO.,LTD</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
        <!-- JAVASCRIPT -->
        <script src="{{URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>        
         <!-- toastr plugin -->
        <script src="{{ asset('/assets/libs/toastr/toastr.min.js') }}"></script>
        <!-- toastr init -->
        <script src="{{ asset('/assets/js/pages/toastr.init.js') }}"></script>   
         <!-- Sweet Alerts js -->
         <script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
         <!-- Sweet alert init js-->
         <script src="{{ asset('/assets/js/pages/sweet-alerts.init.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
        <!-- App js -->
        <script src="{{URL::asset('assets/js/app.js')}}"></script>
    </body>
</html>
