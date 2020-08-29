<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <a href="{{url('/')}}" class="logo">
                    <img src="{{ URL::asset('assets/images/logo-asaba.png') }}" alt="" height="40">
                </a>

            </div>
            <!-- End Logo container-->

            <div class="menu-extras topbar-custom">

                <!-- Search input -->
                <div class="search-wrap" id="search-wrap">
                    <div class="search-bar">
                        <input class="search-input" type="search" placeholder="Search"/>
                        <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                            <i class="mdi mdi-close-circle"></i>
                        </a>
                    </div>
                </div>

                <ul class="list-inline float-right mb-0">
                    <!-- Search -->
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link waves-effect toggle-search" href="#" data-target="#search-wrap">
                            <i class="mdi mdi-magnify noti-icon"></i>
                        </a>
                    </li>
                    <!-- Fullscreen -->
                    <li class="list-inline-item dropdown notification-list hide-phone">
                        <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                            <i class="mdi mdi-fullscreen noti-icon"></i>
                        </a>
                    </li>

                    <!-- notification-->
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                           role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <i class="ion-ios7-bell noti-icon"></i>
                            <span class="badge badge-danger noti-icon-badge">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5>Notification (3)</h5>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                <p class="notify-details"><b>Your order is placed</b><small class="text-muted">Dummy
                                        text of the printing and typesetting industry.</small></p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-warning"><i class="mdi mdi-message"></i></div>
                                <p class="notify-details"><b>New Message received</b><small class="text-muted">You have
                                        87 unread messages</small></p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info"><i class="mdi mdi-martini"></i></div>
                                <p class="notify-details"><b>Your item is shipped</b><small class="text-muted">It is a
                                        long established fact that a reader will</small></p>
                            </a>

                            <!-- All-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                View All
                            </a>

                        </div>
                    </li>
                    <!-- User-->
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown"
                           href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt="user"
                                 class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <a class="dropdown-item" href="#"><i class="dripicons-user text-muted"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                    class="dripicons-exit text-muted"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="menu-item list-inline-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <!-- MENU Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li>
                        <a class="pl-0" href="{{url('/')}}"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-format-list-bulleted-type"></i>Master</a>
                        <ul class="submenu">
                            <li><a href="{{route('master.company.index')}}">Company</a></li>
                            <li><a href="{{route('master.work-group.index')}}">Work Group</a></li>
                            <li><a href="{{route('master.work-place.index')}}">Work Place</a></li>
                            <li><a href="{{route('master.shift.index')}}">Shift</a></li>
                            <li><a href="{{route('master.staff.index')}}">Staff</a></li>
                            <li><a href="{{route('master.guest.index')}}">Guest</a></li>
                            <li><a href="{{route('master.device.index')}}">User Device</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-wrench"></i>Setting</a>
                        <ul class="submenu">
                            <li><a href="{{route('setting.general.index')}}">General</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('attendance.index')}}" target="_blank"><i class="mdi mdi-fingerprint"></i>Attendance</a>
                    </li>
                    {{--                    <li>--}}
                    {{--                        <a href="{{route('register')}}" target="_blank"><i class="mdi mdi-account-multiple-plus"></i>Guest--}}
                    {{--                            Register</a>--}}
                    {{--                    </li>--}}
                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-format-list-bulleted-type"></i>Report</a>
                        <ul class="submenu">
                            <li><a href="{{route('report.date-range.index')}}">Daterange Report</a></li>
                            <li><a href="{{route('report.daily.index')}}">Daily Report</a></li>
                            <li><a href="{{route('report.yearly.index')}}">Yearly Report</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->
