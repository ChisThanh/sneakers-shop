 <!-- Start Header Area -->
 <header class="header_area sticky-header">
     <div class="main_menu">
         <nav class="navbar navbar-expand-lg navbar-light main_box">
             <div class="container">
                 <!-- Brand and toggle get grouped for better mobile display -->
                 <a class="navbar-brand logo_h" href="/home"><img src="{{ asset('assets_home/img/logo.png') }}"
                         alt=""></a>
                 <button class="navbar-toggler" type="button" data-toggle="collapse"
                     data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                     aria-label="Toggle navigation">
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                 </button>
                 <!-- Collect the nav links, forms, and other content for toggling -->
                 <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                     <ul class="nav navbar-nav menu_nav ml-auto">
                         <li class="nav-item active">
                             <a class="nav-link" href="/home">{{ __('homepage.home') }}</a>
                         </li>
                         <li class="nav-item"><a class="nav-link" href="{{ route('product.index') }}">Shop</a></li>
                         <li class="nav-item submenu dropdown">
                             <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                 aria-haspopup="true" aria-expanded="false">Blog</a>
                             <ul class="dropdown-menu">
                                 <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
                                 <li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a>
                                 </li>
                             </ul>
                         </li>
                         <li class="nav-item submenu dropdown">
                             <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                 aria-haspopup="true" aria-expanded="false">{{ __('homepage.languages') }}</a>
                             <ul class="dropdown-menu">
                                 <li class="nav-item">
                                     <a class="nav-link"
                                         href="{{ route('locale', 'vi') }}">{{ __('homepage.vietnamese') }}</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link"
                                         href="{{ route('locale', 'en') }}">{{ __('homepage.english') }}</a>
                                 </li>
                             </ul>
                         </li>
                         <li class="nav-item submenu dropdown">
                             <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                 aria-haspopup="true" aria-expanded="false">
                                 @auth
                                     {{ Auth::user()->name }}
                                 @else
                                     Pages
                                 @endauth
                             </a>
                             <ul class="dropdown-menu">
                                 @auth
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('show-user') }}">{{ Auth::user()->name }}</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('logout') }}">{{ __('homepage.logout') }}</a>
                                     </li>
                                 @endauth
                                 @guest
                                     <li class="nav-item">
                                         <a class="nav-link" href="{{ route('login') }}">{{ __('homepage.login') }}</a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link"
                                             href="{{ route('register') }}">{{ __('homepage.register') }}</a>
                                     </li>
                                 @endguest
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('password.change') }}">Đổi mật khẩu</a>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                     <ul class="nav navbar-nav navbar-right">
                         <li class="nav-item">
                             <a href="{{ route('cart-show') }}" class="cart">
                                 <span class="ti-bag"><span class="text-number"
                                         id="total-quantity-header">{{ getCart()->totalQuantity }}</span></span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
                         </li>
                         <li class="nav-item">
                             <button id="btn-search-image" class="search"><span><svg xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1"
                                         id="Capa_1" width="14px" height="14px" viewBox="0 0 445.742 445.742"
                                         xml:space="preserve">
                                         <g>
                                             <g>
                                                 <g>
                                                     <path
                                                         d="M323.453,400.555l-4.644-4.642c-12.298,6.174-25.911,9.404-39.839,9.404c-16.355,0-32.023-4.387-45.658-12.593H65.384     l0.014-299.903h53.791c5.596,0,10.131-4.533,10.131-10.132V27.273h198.906v215.583c4.793,3.21,9.306,6.908,13.472,11.076     c5.375,5.373,10.004,11.404,13.801,17.906V24.543C355.499,11.008,344.489,0,330.954,0H115.869c-2.174,0-4.252,0.862-5.785,2.395     l-69.563,69.56c-1.533,1.54-2.396,3.619-2.396,5.787v317.715c0,13.534,11.012,24.543,24.545,24.543h268.283     c1.188,0,2.354-0.089,3.498-0.253l-1.748-1.749C327.919,413.214,324.714,407.134,323.453,400.555z" />
                                                     <path
                                                         d="M401.347,409.204l-34.768-34.771c-3.838-3.837-8.771-5.903-13.791-6.222l-11.809-11.811     c17.545-27.896,14.188-65.271-10.076-89.534c-28.168-28.167-73.996-28.166-102.162,0c-28.166,28.165-28.166,73.995,0,102.161     c24.266,24.266,61.639,27.621,89.535,10.075l11.811,11.811c0.314,5.021,2.385,9.952,6.221,13.79l34.77,34.77     c8.361,8.359,21.914,8.357,30.271-0.001C409.707,431.116,409.708,417.565,401.347,409.204z M315.767,353.895     c-19.819,19.818-52.071,19.818-71.892,0c-19.819-19.82-19.819-52.069,0-71.892c19.818-19.819,52.066-19.819,71.892,0.001     C335.587,301.825,335.587,334.074,315.767,353.895z" />
                                                     <path
                                                         d="M275.23,88.782c-0.061,0-0.119,0.001-0.18,0.002c-2.842,0.05-5.525,1.307-7.387,3.456l-18.08,20.905l-40.177-65.163     c-1.809-2.935-5.002-4.73-8.449-4.751c-0.021,0-0.041,0-0.063,0c-3.424,0-6.611,1.751-8.445,4.645l-48.668,76.77     c-1.951,3.08-2.072,6.979-0.314,10.174c1.758,3.195,5.115,5.181,8.762,5.181h152c0,0,0.014,0,0.018,0c5.525,0,10-4.478,10-10     c0-2.824-1.168-5.374-3.053-7.192l-28.641-30.831C280.662,89.937,278.007,88.782,275.23,88.782z" />
                                                 </g>
                                             </g>
                                         </g>
                                     </svg></span>
                             </button>
                         </li>
                     </ul>
                 </div>
             </div>
         </nav>
     </div>
     <div class="search_input" id="search_input_box">
         <div class="container">
             <form class="d-flex justify-content-between" method="GET" action="/product">
                 <input type="text" class="form-control" id="search_input" placeholder="Search Here"
                     name="q">
                 <button type="submit" class="btn"></button>
                 <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
             </form>
         </div>
     </div>
 </header>
 <!-- End Header Area -->
