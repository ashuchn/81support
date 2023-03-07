<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
       
      </ul>
  
     
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
  
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="{{url('assets/adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">81 Support</span>
      </a>
  
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          
          <div class="info">
            <a href="#" class="d-block">Welcome Shane</a>
          </div>
        </div>
  
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           
              <li class="nav-item">
                <a href="{{url('/')}}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <!--<i class="nav-icon fas fa-tachometer-alt"></i>-->
                 <p>Dashboard</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('user.index')}}" class="nav-link {{ Route::is('user.index') ? 'active' : '' }}">
                    <!--<i class="nav-icon fa-regular fa-user"></i>-->
                    <p>User</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{route('ridingcharter.index')}}" class="nav-link {{ Route::is('ridingcharter.index') ? 'active' : '' }}">
                    <!--<i class="nav-icon fa-solid fa-shop"></i>-->
                    <!--<i class="fa-sharp fa-solid fa-shop"></i>-->
                 <p>Riding Charter</p>
                </a>
              </li>
            

              <li class="nav-item {{ Route::is('admin.notification') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Route::is('admin.notification') ? 'active' : '' }}">
                    <!--<i class="nav-icon far fa-envelope"></i>-->
                    <p>Notifications<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview" >
                    <li class="nav-item">
                        <a href="{{ route('admin.notification') }}" class="nav-link {{ Route::is('admin.notification') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>App Notifications</p>
                        </a>
                    </li>
                </ul>
              </li>

              <li class="nav-item {{ (Route::is('admin.notification') || 1) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <!--<i class="nav-icon far fa-envelope"></i>-->
                    <!--<i class="fa-regular fa-list-check"></i>-->
                    <p>Management<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview" >
                  
                  <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link {{ Route::is('category.index') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                     <p>Category Management</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ route('product.index') }}" class="nav-link {{ Route::is('product.index') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                     <p>Products Management</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('static_content.index') }}" class="nav-link {{ Route::is('static_content.index') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                     <p>Static Content</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('filter.index') }}" class="nav-link {{ Route::is('filter.*') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                     <p>Filters</p>
                    </a>
                  </li>

                </ul>
                <li class="nav-item">
                    <a href="{{route('admin.logout')}}" class="nav-link">
                        <p>Logout</p>
                    </a>
                </li>
              </li>
            
           
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>