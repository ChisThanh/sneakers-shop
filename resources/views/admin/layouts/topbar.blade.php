    <!-- Topbar Start -->
    <div class="navbar-custom topnav-navbar topnav-navbar-dark">
        <div class="container-fluid">

            <!-- LOGO -->
            <a href="/admin" class="topnav-logo">
                <span class="topnav-logo-lg">
                    <img src="{{ asset('assets_admin/images/logo-light.png') }}" alt="" height="16">
                </span>
                <span class="topnav-logo-sm">
                    <img src="{{ asset('assets_admin/images/logo_sm.png') }}" alt="" height="16">
                </span>
            </a>

            <ul class="list-unstyled topbar-right-menu float-right mb-0">

                <li class="dropdown notification-list d-lg-none">
                    <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <i class="dripicons-search noti-icon"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                        <form class="p-3">
                            <input type="text" class="form-control" placeholder="Search ..."
                                aria-label="Recipient's username">
                        </form>
                    </div>
                </li>

                <li class="dropdown notification-list topbar-dropdown d-none d-lg-block">
                    <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" id="topbar-languagedrop"
                        href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('assets_admin/images/flags/us.jpg') }}" alt="user-image" class="mr-1"
                            height="12"> <span class="align-middle">English</span> <i
                            class="mdi mdi-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu"
                        aria-labelledby="topbar-languagedrop">

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ asset('assets_admin/images/flags/germany.jpg') }}" alt="user-image"
                                class="mr-1" height="12">
                            <span class="align-middle">German</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <img src="{{ asset('assets_admin/images/flags/italy.jpg') }}" alt="user-image"
                                class="mr-1" height="12">
                            <span class="align-middle">Italian</span>
                        </a>


                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#"
                        id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="dripicons-bell noti-icon"></i>
                        <span class="noti-icon-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg"
                        aria-labelledby="topbar-notifydrop">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-right">
                                    <a href="javascript: void(0);" class="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div style="max-height: 230px;" data-simplebar>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-primary">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details">Caleb Flakelar commented on Admin
                                    <small class="text-muted">1 min ago</small>
                                </p>
                            </a>

                        </div>

                        <!-- All-->
                        <a href="javascript:void(0);"
                            class="dropdown-item text-center text-primary notify-item notify-all">
                            View All
                        </a>

                    </div>
                </li>

                <li class="dropdown notification-list d-none d-sm-inline-block">
                    <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="false" aria-expanded="false">
                        <i class="dripicons-view-apps noti-icon"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg p-0">

                        <div class="p-2">
                            <div class="row no-gutters">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{ asset('assets_admin/images/brands/slack.png') }}" alt="slack">
                                        <span>Slack</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{ asset('assets_admin/images/brands/github.png') }}"
                                            alt="Github">
                                        <span>GitHub</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{ asset('assets_admin/images/brands/dribbble.png') }}"
                                            alt="dribbble">
                                        <span>Dribbble</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown"
                        id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <span class="account-user-avatar">
                            <img src="{{ asset('assets_admin/images/users/avatar-1.jpg') }}" alt="user-image"
                                class="rounded-circle">
                        </span>
                        <span>
                            {{-- <span class="account-user-name"
                                style="text-transform: capitalize;">{{ Auth::user()->name }}</span>
                            <span class="account-position">Founder</span> --}}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                        aria-labelledby="topbar-userdrop">
                        <!-- item-->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-circle mr-1"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-account-edit mr-1"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-lifebuoy mr-1"></i>
                            <span>Support</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="mdi mdi-lock-outline mr-1"></i>
                            <span>Lock Screen</span>
                        </a>

                        <!-- item-->
                        <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout mr-1"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>

            </ul>
            <a class="button-menu-mobile disable-btn">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </a>
            <div class="app-search dropdown">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search..." id="top-search">
                        <span class="mdi mdi-magnify search-icon"></span>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h5 class="text-overflow mb-2">Found <span class="text-danger">17</span> results</h5>
                    </div>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="uil-notes font-16 mr-1"></i>
                        <span>Analytics Report</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="uil-life-ring font-16 mr-1"></i>
                        <span>How can I help you?</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="uil-cog font-16 mr-1"></i>
                        <span>User profile settings</span>
                    </a>

                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow mb-2 text-uppercase">Users</h6>
                    </div>

                    <div class="notification-list">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="media">
                                <img class="d-flex mr-2 rounded-circle"
                                    src="{{ asset('assets_admin/images/users/avatar-2.jpg') }}"
                                    alt="Generic placeholder image" height="32">
                                <div class="media-body">
                                    <h5 class="m-0 font-14">Erwin Brown</h5>
                                    <span class="font-12 mb-0">UI Designer</span>
                                </div>
                            </div>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="media">
                                <img class="d-flex mr-2 rounded-circle"
                                    src="{{ asset('assets_admin/images/users/avatar-5.jpg') }}"
                                    alt="Generic placeholder image" height="32">
                                <div class="media-body">
                                    <h5 class="m-0 font-14">Jacob Deo</h5>
                                    <span class="font-12 mb-0">Developer</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Topbar -->
