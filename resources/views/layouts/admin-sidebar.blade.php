<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('user.home') }}" class="nav-link">Trang Chủ Website</a>
          </li>
        </ul>
    
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->
    
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.home') }}" class="brand-link">
          <img src="{{ asset('asset/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">
            {{-- kiểm tra người dùng đăng nhập có role_id = 1 thì là quản trị viên còn bằng 2 là nhân viên --}}
            {{ (Auth::guard('admin')->user()->role_id == 1) ? 'Quản Trị' : 'Nhân Viên'}}
          </span>
        </a>
    
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ asset('asset/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="javascrip:void(0)" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
          </div>
    
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <li class="nav-header">{{ TextLayoutSidebar("overview") }}</li>
              <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link {{ (Route::is('admin.home')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    {{ TextLayoutSidebar("dashboard") }}
                  </p>
                </a>
              </li>
              <li class="nav-header">{{ TextLayoutSidebar("website_management") }}</li>
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/users*');
                @endphp
                <a href="{{ route('admin.users_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    {{ TextLayoutSidebar("customer") }}
                  </p>
                </a>
              </li>
              {{-- nếu người dùng đang đăng nhập là quản trị viên thì hiển thị chức năng này --}}
              @if (Auth::guard('admin')->user()->role_id == 1)
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/staffs*');
                @endphp
                <a href="{{ route('admin.staffs_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-users-cog"></i>
                  <p>
                    {{ TextLayoutSidebar("administrators") }}
                  </p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/categories*');
                @endphp
                <a href="{{ route('admin.category_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-th-list"></i>
                  <p>
                    {{ TextLayoutSidebar("category") }}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/products*');
                @endphp
                <a href="{{ route('admin.product_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-inbox"></i>
                  <p>
                    {{ TextLayoutSidebar("product") }}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/colors*');
                @endphp
                <a href="{{ route('admin.colors_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-paint-brush"></i>
                  <p>
                    {{ TextLayoutSidebar("color") }}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/sizes*');
                @endphp
                <a href="{{ route('admin.sizes_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tshirt"></i>
                  <p>
                    {{ TextLayoutSidebar("size") }}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/brands*');
                @endphp
                <a href="{{ route('admin.brands_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-building"></i>
                  <p>
                    {{ TextLayoutSidebar("brand") }}
                  </p>
                </a>
              </li>
              {{-- nếu người dùng đang đăng nhập là quản trị viên thì hiển thị chức năng này --}}
              @if (Auth::guard('admin')->user()->role_id == 1)
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/payments*');
                @endphp
                <a href="{{ route('admin.payments_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-money-check-alt"></i>
                  <p>
                    {{ TextLayoutSidebar("payment_method") }}
                  </p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                @php
                    $isRouteUser = request()->is('admin/orders*');
                @endphp
                <a href="{{ route('admin.orders_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>
                    {{ TextLayoutSidebar("order") }}
                  </p>
                </a>
              </li>
              @if (Auth::guard('admin')->user()->role_id == 1)
                <li class="nav-item">
                  @php
                      $isRouteUser = request()->is('admin/setting*');
                  @endphp
                  <a href="{{ route('admin.setting_index') }}" class="nav-link {{ ($isRouteUser) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                      {{ TextLayoutSidebar("setting") }}
                    </p>
                  </a>
                </li>
              @endif
              <li class="nav-header">{{ TextLayoutSidebar("infomations") }}</li>
              <li class="nav-item">
                <a href="{{route('admin.profile_change-profile')}}" class="nav-link {{ (Route::is('admin.profile_change-profile')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    {{ TextLayoutSidebar("profile") }}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.profile_change-password')}}" class="nav-link {{ (Route::is('admin.profile_change-password')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-key"></i>
                  <p>
                    {{ TextLayoutSidebar("change_password") }}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.logout')}}" class="nav-link">
                  <i class="nav-icon fas fa-sign-out-alt"></i>
                  <p>
                    {{ TextLayoutSidebar("logout") }}
                  </p>
                </a>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>