<div class="topbar">
    <!-- LOGO -->
	<div class="topbar-left">
      <!--  <a href="#" class="logo"><span style="color: red;">DNC<span>SMS</span></span><i class="mdi mdi-layers"></i></a> --!>
        <!-- Image logo -->
                    <a href="index.html" class="logo">
                        <span>
                            <img src="https://consentform.com/img/logo.png" alt="" height="30">
                        </span>
                        <i>
                            <img src="https://consentform.com/img/logo.png" alt="" height="10">
                        </i>
                    </a>
    </div>
   <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Navbar-left -->
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <button class="button-menu-mobile open-left waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
            </ul>
            <!-- Right(Notification) -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown user-box">
                    <a href="#" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                        <img src="{{ asset('theme/default/assets/images/users/user.png')}}" alt="user-img" class="img-circle user-img">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                        <li>
                            <h5>Hi,{{ Auth::user()->name }}</h5>
                        </li>
                        <li><a href="{{ url('superadmin/profile') }}"><i class="ti-user m-r-5"></i> Profile</a></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off m-r-5"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul> <!-- end navbar-right -->
        </div><!-- end container -->
    </div><!-- end navbar -->
</div>
<!-- Top Bar End -->
<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="{{  url('superadmin/home') }}" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span>Dashboard</span></a>
                </li>
                <li>
                    <a href="{{  route('company.index') }}" class="waves-effect"><i class="mdi mdi-layers"></i><span>Company</span></a>
                </li>
                <li>
                    <a href="{{  route('superemployee.index') }}" class="waves-effect"><i class="fa fa-users"></i><span>Employees</span></a>
                </li>
                <li>
                    <a href="{{  url('superadmin/superadminsms') }}" class="waves-effect"><i class="fa fa-comments"></i><span>SMS</span></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End
