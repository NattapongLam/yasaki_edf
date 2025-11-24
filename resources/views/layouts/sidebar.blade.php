<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">เคมี</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow" key="t-vertical">ตั้งค่า</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{route('chemicalgroups.index')}}" key="t-default">กลุ่มเคมี</a></li> 
                                <li><a href="{{route('chemicallists.index')}}" key="t-default">รายชื่อเคมี</a></li> 
                            </ul>
                        </li>
                    </ul>                 
                </li>
                <li class="menu-title" key="t-apps">Report</li>   
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงาน</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="#">
                                <i class="bx bx-calendar"></i>
                                <span key="t-users">แผนรวม</span>
                            </a>
                            </li> 
                    </ul>                    
                </li>                                           
                <li class="menu-title" key="t-pages">Setting</li>   
                <li>
                    <a href="{{route('profiles.index')}}">
                        <i class="bx bx-user"></i>
                        <span key="t-users">ผู้ใช้งาน</span>
                    </a>
                </li>                    
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>