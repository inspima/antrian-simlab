<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <a href="{{url('/')}}" class="logo hide-phone">
                    <img class="" src="{{ URL::asset('assets/images/logo-web-itd.png') }}" alt="" height="40">
                </a>
                <a href="{{url('/')}}" class="logo d-block d-sm-none" style="font-size: 16px">
                    {{strtoupper(substr(session('org_name'),0,20))}}
                </a>
            </div>
            <!-- End Logo container-->

            <div class="menu-extras topbar-custom">

                <!-- Search input -->
                <div class="search-wrap " id="search-wrap">
                    <div class="search-bar">
                        <input class="search-input" type="search" placeholder="Search"/>
                        <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                            <i class="mdi mdi-close-circle"></i>
                        </a>
                    </div>
                </div>

                <ul class="list-inline float-right mb-0">
                    <!-- Fullscreen -->
                    <li class="list-inline-item dropdown notification-list hide-phone">
                        <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                            <i class="mdi mdi-fullscreen noti-icon"></i>
                        </a>
                    </li>

                    <!-- User-->
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown"
                           href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="{{ URL::asset('assets/images/users/avatar.png') }}" alt="user"
                                 class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <a class="dropdown-item" href="{{route('account.profile')}}"><i class="dripicons-user text-muted"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="dripicons-exit text-muted"></i> Logout</a>
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
                        <a href="{{url('/')}}"><i class="mdi mdi-view-dashboard"></i>Dashboard</a>
                    </li>
                    @if (session('role')=='Administration')
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-format-list-bulleted-type"></i>Master</a>
                            <ul class="submenu">
                                <li><a href="{{route('master.organization.index')}}">Organisasi</a></li>
                                <li><a href="{{route('master.holiday.index')}}">Hari Libur</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-wrench"></i>Konfigurasi</a>
                            <ul class="submenu">
                                <li><a href="{{route('setting.quota.index')}}">Kuota</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class=" ti-pie-chart"></i>Laporan</a>
                            <ul class="submenu">
                                <li><a href="{{route('report.quota.index')}}">Kuota Harian</a></li>
                            </ul>
                        </li>
                        <li class="pull-right">
                            <a href="#">Administrator</a>
                        </li>

                    @elseif(session('role')=='Organization')

                        <li>
                            <a href="{{route('registration.sample.index')}}"><i class="dripicons-document-edit"></i>Registrasi</a>
                        </li>
                        <li class="pull-right">
                            <a href="#">{{strtoupper(session('org_name'))}}</a>
                        </li>
                    @endif

                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->
