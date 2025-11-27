<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Set up</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-duplicate"></i>
                        <span key="t-layouts">ลูกค้า</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{route('customergroups.create')}}" key="t-default">กลุ่มลูกค้า</a></li>     
                        <li><a href="{{route('customerlists.index')}}" key="t-default">ลูกค้า</a></li>                      
                    </ul>                 
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-duplicate"></i>
                        <span key="t-layouts">ผู้จำหน่าย</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="#" key="t-default">กลุ่มผู้จำหน่าย</a></li>     
                        <li><a href="#" key="t-default">ผู้จำหน่าย</a></li>                      
                    </ul>                 
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-duplicate"></i>
                        <span key="t-layouts">สินค้า</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="#" key="t-default">ประเภทสินค้า</a></li>     
                        <li><a href="#" key="t-default">กลุ่มสินค้า</a></li>     
                        <li><a href="#" key="t-default">หน่วยนับ</a></li>          
                        <li><a href="#" key="t-default">สินค้า</a></li>              
                    </ul>                 
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-duplicate"></i>
                        <span key="t-layouts">คลัง</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="#" key="t-default">คลังสินค้า</a></li>     
                        <li><a href="#" key="t-default">สถานที่เก็บ</a></li>                
                    </ul>                 
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-duplicate"></i>
                        <span key="t-layouts">บัญชี</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{route('companys.create')}}" key="t-default">ชื่อบริษัท</a></li> 
                        <li><a href="#" key="t-default">ธนาคาร</a></li>  
                        <li><a href="{{route('periods.create')}}" key="t-default">งวดบัญชี</a></li>  
                        <li><a href="#" key="t-default">รหัสบัญชี</a></li>
                        <li><a href="{{route('typevats.create')}}" key="t-default">ประเภทภาษี</a></li>                            
                        <li><a href="#" key="t-default">หัก ณ ที่จ่าย</a></li>   
                        <li><a href="{{route('currencys.create')}}" key="t-default">สกุลเงิน</a></li>             
                    </ul>                 
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-duplicate"></i>
                        <span key="t-layouts">ทั่วไป</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{route('countrys.create')}}" key="t-default">ประเทศ</a></li>     
                        <li><a href="{{route('provinces.create')}}" key="t-default">จังหวัด</a></li>       
                        <li><a href="{{route('districts.create')}}" key="t-default">เขต</a></li>    
                        <li><a href="{{route('sub-districts.create')}}" key="t-default">แขวง</a></li>      
                    </ul>                 
                </li>
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">งานทดสอบและพัฒนา</span>
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
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">ฝ่ายขาย</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="#" key="t-default">ใบเสนอราคา</a></li> 
                        <li><a href="#" key="t-default">ใบแจ้งหนี้</a></li> 
                        <li><a href="#" key="t-default">บิลขาย</a></li> 
                        <li><a href="#" key="t-default">รับมัดจำ/ล่วงหน้า</a></li>
                    </ul>   
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">ฝ่ายจัดซื้อ</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="#" key="t-default">ใบขอสั่งซื้อ</a></li> 
                        <li><a href="#" key="t-default">ใบสั่งซื้อ</a></li> 
                        <li><a href="#" key="t-default">รับสินค้า/ตั้งหนี้</a></li> 
                        <li><a href="#" key="t-default">จ่ายมัดจำ/ล่วงหน้า</a></li>
                    </ul>   
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">ฝ่ายคลัง</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="#" key="t-default">ใบเบิก</a></li> 
                        <li><a href="#" key="t-default">ใบรับคืน</a></li> 
                        <li><a href="#" key="t-default">ใบโอนย้าย</a></li> 
                        <li><a href="#" key="t-default">ใบปรับปรุงสต็อค</a></li>
                    </ul>   
                </li>
                <li class="menu-title" key="t-apps">Report</li>   
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงานฝ่ายขาย</span>
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
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงานฝ่ายจัดซื้อ</span>
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
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงานฝ่ายคลัง</span>
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