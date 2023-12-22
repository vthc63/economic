<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon" href="{{ asset('asset/client/images/favicon.png') }}">
      <title>{{ setting_website()->name }}</title>
      <link href="{{ asset('asset/client/css/bootstrap.css') }}" rel="stylesheet">
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,700,500italic,100italic,100' rel='stylesheet' type='text/css'>
      <link href="{{ asset('asset/client/css/font-awesome.min.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('asset/client/css/flexslider.css') }}" type="text/css" media="screen"/>
      <link href="{{ asset('asset/client/css/sequence-looptheme.css') }}" rel="stylesheet" media="all"/>
      <link href="{{ asset('asset/client/css/style.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('asset/admin/plugins/fontawesome-free/css/all.min.css') }}">
      @vite(['resources/client/css/auth.css', 'resources/client/css/home.css'])
      <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script><script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script><![endif]-->
   </head>
   <style>
      .thumbnail{
          margin: unset;
          height: 260px;
      }
  
      .thumbnail img{
          height: 100% !important;
          width: 100% !important;
          object-fit: cover;
      }
      .productname{
          padding-top: 10px;
      }
  </style>
   <body id="home">
      <div class="wrapper">
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-md-2 col-sm-2">
                     <div class="logo">
                        <a href="{{ route('user.home') }}">
                           <img src="{{ asset("asset/client/images/" . setting_website()->logo) }}" alt="MintShop">
                        </a>
                     </div>
                  </div>
                  <div class="col-md-10 col-sm-10">
                     <div class="header_top">
                        <div class="row">
                           <div class="col-md-6">
                              <ul class="topmenu">
                                 <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                                 <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                 <li><a href="#"><i class="fab fa-instagram-square"></i></a></li>
                                 <li><a href="#"><i class="fab fa-telegram-plane"></i></a></li>
                                 <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                              </ul>
                           </div>
                           <div class="col-md-6">
                              @if (Auth::check())
                              <ul class="nav navbar-nav usermenu">
                                 <li class="dropdown">
                                    <a href="#" class="dropdown-toggle profile" data-toggle="dropdown">
                                       <img src="{{ asset('asset/client/images/loginbg.png') }}" alt="">
                                       <span>{{ Auth::user()->name }}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                       <ul class="mega-menu-links">
                                          <li><a href="{{ route('profile.index') }}">Thông tin cá nhân</a></li>
                                          <li><a href="{{ route('order_history.index') }}">Lịch sử mua hàng</a></li>
                                          <li><a href="{{ route('user.logout') }}">Đăng xuất</a></li>
                                       </ul>
                                    </div>
                                 </li>
                              </ul>
                              @else
                              <ul class="usermenu">
                                 <li><a href="{{ route('user.login') }}" class="log">Đăng Nhập</a></li>
                                 <li><a href="{{ route('user.register') }}" class="reg">Đăng Kí</a></li>
                              </ul>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="header_bottom">
                        <ul class="option">
                           <li id="search" class="search">
                              <form method="GET" action="{{ route('user.search') }}">
                                 <input class="search-submit" type="submit" value="">
                                 <input class="search-input" placeholder="Enter your search term..." type="text" value="" name="keyword">
                              </form>
                           </li>
                           <li class="option-cart">
                              <a href="{{ route('cart.index') }}" class="cart-icon">cart <span class="cart_no"></span></a>
                           </li>
                        </ul>
                        <div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button></div>
                        <div class="navbar-collapse collapse">
                           <ul class="nav navbar-nav">
                              <li class="dropdown {{ (request()->is('/*')) ? 'active' : '' }}">
                                 <a href="{{ route('user.home') }}">Trang Chủ</a>
                              </li>
                              @foreach (category_header() as $category)
                                 <li class="dropdown @php
                                    if (isset($request->slug) && $request->slug == $category->slug) {
                                       echo "active";
                                    }
                                 @endphp">
                                    <a href="{{ route('user.products', $category->slug) }}">{{ $category->name }}</a>
                                 </li>
                              @endforeach
                              <li class="dropdown {{ (request()->is('introduction*')) ? 'active' : '' }}">
                                 <a href="{{ route('user.introduction') }}">Giới Thiệu</a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @yield('content-client')
         <div class="clearfix"></div>
         <div class="footer">
            <div class="footer-info">
               <div class="container">
                  <div class="row">
                     <div class="col-md-3">
                        <div class="footer-logo">
                           <a href="{{ route('user.home') }}">
                              <img src="{{ asset("asset/client/images/" . setting_website()->logo) }}" alt="">
                           </a>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-6">
                        <h4 class="title">Thông tin liên hệ</h4>
                        <p>{{ setting_website()->address }}</p>
                        <p>Số điện thoại : {{ setting_website()->phone_number }}</p>
                        <p>Email : {{ setting_website()->email }}</p>
                     </div>
                     <div class="col-md-3 col-sm-6">
                        <h4 class="title">Về chúng tôi</h4>
                        <p>
                           Chuyên bán thời trang an toàn. Tin cậy nhanh chóng. Chăm sóc khách hàng 24/24
                        </p>
                     </div>
                     <div class="col-md-3">
                        <h4 class="title">Nhận thông tin từ chúng tôi</h4>
                        <p>Cảm ơn rất nhiều</p>
                        <form class="newsletter">
                           <input type="text" name="" placeholder="Email của bạn">
                           <input type="submit" value="Gửi" class="button">
						      </form>
                     </div>
                  </div>
               </div>
            </div>
            {{-- <div class="copyright-info">
               <div class="container">
                  <div class="row">
                     <div class="col-md-6">
                        <p>Copyright © 2012. Designed by <a href="#">Michael Lee</a>. All rights reseved</p>
                     </div>
                     <div class="col-md-6">
                        <ul class="social-icon">
                           <li><a href="#" class="linkedin"></a></li>
                           <li><a href="#" class="google-plus"></a></li>
                           <li><a href="#" class="twitter"></a></li>
                           <li><a href="#" class="facebook"></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div> --}}
         </div>
      </div>
      @if (Session::has('success'))
        <span id="toast__js" message="{{ session('success') }}" type="success"></span>
      @elseif (Session::has('error'))
         <span id="toast__js" message="{{ session('error') }}" type="error"></span>
      @endif
      <!-- Bootstrap core JavaScript==================================================-->
      <script src="{{ asset('asset/admin/plugins/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('asset/admin/plugins/jquery-validation/jquery.validate.js') }}"></script>
      <script type="text/javascript" src="{{ asset('asset/client/js/jquery-1.10.2.min.js') }}"></script>
	  <script type="text/javascript" src="{{ asset('asset/client/js/jquery.easing.1.3.js') }}"></script>
	  <script type="text/javascript" src="{{ asset('asset/client/js/bootstrap.min.js') }}"></script>
	  <script type="text/javascript" src="{{ asset('asset/client/js/jquery.sequence-min.js') }}"></script>
	  <script type="text/javascript" src="{{ asset('asset/client/js/jquery.carouFredSel-6.2.1-packed.js') }}"></script>
     <script type="text/javascript" src="{{ asset('asset/client/js/script.min.js') }}" ></script>
	  <script defer src="{{ asset('asset/client/js/jquery.flexslider.js') }}"></script>
     @vite(['resources/admin/js/toast-message.js'])
   </body>
</html>
