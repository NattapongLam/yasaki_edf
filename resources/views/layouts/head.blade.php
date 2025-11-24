<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{route('dashboard')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{URL::asset('assets/images/logo.jpg')}}" alt="" height="15">
                    </span>
                    <span class="logo-lg">
                        <img src="{{URL::asset('assets/images/logo.jpg')}}" alt="" height="60">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>
            <div class="dropdown d-inline-block">
                @auth
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">          
                        <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{auth()->user()->name}}</span>                                    
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->               
                    <a class="dropdown-item d-block" href="{{route('profiles.show',auth()->user()->id)}}">
                    <i class="bx bx-user font-size-16 align-middle me-1"></i>
                    <span key="t-profile">เปลี่ยนรหัสผ่าน</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();" 
                    onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
                    <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                    <span key="t-logout">ออกจากระบบ</span></a>
                    <form id="form-logout" action="{{route('logout')}}" method="post" style="display: none;">
                        @csrf          
                    </form>
                    @else
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"aria-expanded="false">
                    <a href="{{route('login')}}" class="d-none d-xl-inline-block ms-1">เข้าสู่ระบบ</a>
                    </button>
                    @endauth  
                </div>
            </div>
        </div>
    </div>
</header>