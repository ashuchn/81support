<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">
    
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
    
                <li>
                    <a href="{{ route('subadmin.dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('subadmin.products.index') }}" class="waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Products</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('filter.index') }}" class="waves-effect">
                        <i class="ri-account-circle-line"></i>
                        <span>Product Filter</span>
                    </a>
                </li> --}}
    
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-store-2-line"></i>
                        <span>Photos</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">All Photos</a></li>
                        <li><a href="#">Single Photo Upload</a></li>
                        <li><a href="#">Bulk Photo Upload</a></li>
                    </ul>
                </li>
                
                
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-store-2-line"></i>
                        <span>Videos</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">All Videos</a></li>
                        <li><a href="#">Single Videos Upload</a></li>
                        <li><a href="#">Bulk Videos Upload</a></li>
                    </ul>
                </li>
    
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-mail-send-line"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Confiuration</a></li>
                    </ul>
                </li>
    
                
    
                
    
                
    
                
    
                
    
                
    
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    </div>
    <!-- Left Sidebar End -->