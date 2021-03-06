<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{url('/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url('/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="{{url('/dist/css/skins/skin-red.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <link rel="stylesheet" href="{{url('/css/style.css')}}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @yield('css')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>V</b>A</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><i class="fa fa-facebook-square"></i> Virtual</b>Assistant</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">{{\App\Notification::where('item','message')->count()}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have received {{\App\Notification::where('item','message')->count()}}
                                messages
                            </li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    @foreach(\App\Notification::where('item','message')->take(5)->get() as $msg)
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <img src="{{url('/images/avatar.png')}}" class="img-circle"
                                                         alt="User Image">
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <h4>
                                                    Facebook Message
                                                    <small>
                                                        <i class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($msg->created_at)->diffForHumans()}}
                                                    </small>
                                                </h4>
                                                <!-- The message -->
                                                <p>{{$msg->content}}</p>
                                            </a>
                                        </li>
                                @endforeach
                                <!-- end message -->
                                </ul>
                                <!-- /.menu -->
                            </li>
                            <li class="footer"><a href="{{url('/notifications/message')}}">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- /.messages-menu -->

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">{{\App\Notification::count()}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have {{\App\Notification::count()}} notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    @foreach(\App\Notification::take(5)->orderBy('id','desc')->get() as $notification)
                                        <li><!-- start notification -->
                                            <a href="#">
                                                <i class="fa  @if($notification->type == 'remove') text-red fa-facebook-square @elseif($notification->type == "add" && $notification->item == "message") fa fa-comment text-blue  @elseif($notification->type == "add") text-green fa-facebook-square @else text-aqua fa-facebook-square @endif"></i> {{$notification->content}}
                                            </a>
                                        </li>
                                @endforeach
                                <!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="{{url('/notifications/all')}}">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 50%"
                                                     role="progressbar"
                                                >
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{url('/images/avatar.png')}}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{Auth::user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{url('/images/avatar1.png')}}" class="img-circle" alt="User Image">

                                <p>
                                    {{Auth::user()->name}}
                                    <small>Member
                                        since {{\Carbon\Carbon::createFromTimestamp(strtotime(Auth::user()->created_at))->toDateString()}}</small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{url('/profile')}}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{url('/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{url('/images/avatar1.png')}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::user()->name}}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- search form (Optional) -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
                </div>
            </form>
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MENUS</li>
                <!-- Optionally, you can add icons to the links -->

                <li @if(Request::is('home') || Request::is('/')) class="active" @endif><a href="{{url('/home')}}"><i
                                class="fa fa-home"></i> <span>Home</span></a></li>
                <li @if(Request::is('facebook')) class="active treeview" @else class="treeview" @endif>
                    <a href="#"><i class="fa fa-facebook-square"></i> <span>Facebook</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>

              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Request::is('facebook')) class="active" @endif><a href="{{url('/facebook')}}">My
                                Facebook Pages</a></li>

                    </ul>
                </li>
                {{-- Short codes--}}

                <li @if(Request::is('code') || Request::is('code/create')) class="active treeview"
                    @else class="treeview" @endif >
                    <a href="#"><i class="fa fa-code"></i> <span> Short codes</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>

              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Request::is('code/create')) class="active" @endif><a href="{{url('/code/create')}}">
                                Add new Short code</a></li>

                        <li @if(Request::is('code')) class="active" @endif><a href="{{url('/code')}}">All short coes</a>
                        </li>

                    </ul>
                </li>


                {{-- Spam Defender --}}

                <li @if(Request::is('spam') || Request::is('spam/logs')) class="active treeview"
                    @else class="treeview" @endif >
                    <a href="#"><i class="fa fa-bug"></i> <span> Spam Defender</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>

              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Request::is('spam')) class="active" @endif><a href="{{url('/spam')}}">Spam Defender</a>
                        </li>

                        <li @if(Request::is('spam/logs')) class="active" @endif><a href="{{url('/spam/logs')}}">Spam
                                Logs</a>
                        </li>

                    </ul>
                </li>

                {{-- Replies--}}

                <li @if(Request::is('comment/create') || Request::is('message/create')) class="active treeview"
                    @else class="treeview" @endif >
                    <a href="#"><i class="fa fa-plus"></i> <span> Add new</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>

              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Request::is('comment/create')) class="active" @endif><a
                                    href="{{url('/comment/create')}}">
                                Add Comment</a></li>

                        <li @if(Request::is('message/create')) class="active" @endif><a
                                    href="{{url('/message/create')}}">Add message</a></li>

                    </ul>
                </li>

                {{-- list--}}

                <li @if(Request::is('comment') || Request::is('message')) class="active treeview"
                    @else class="treeview" @endif >
                    <a href="#"><i class="fa fa-list"></i> <span> List</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>

              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Request::is('comment')) class="active" @endif><a href="{{url('/comment')}}">
                                Comment</a></li>

                        <li @if(Request::is('message')) class="active" @endif><a href="{{url('/message')}}">Message</a>
                        </li>

                    </ul>
                </li>

                <li @if(Request::is('profile')) class="active" @endif><a href="{{url('/profile')}}"><i
                                class="fa fa-user"></i> <span>Profile</span></a></li>
                <li @if(Request::is('settings')) class="active" @endif><a href="{{url('/settings')}}"><i
                                class="fa fa-gear"></i> <span>Settings</span></a></li>

                <li><a href="{{url('/logout')}}"><i
                                class="fa fa-sign-out"></i> <span>Logout</span></a></li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Version : 2018.1
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy;
            <script>document.write(new Date().getFullYear())</script>
            <a href="http://srigal.com">Srigal</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->

    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{url('/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('/dist/js/adminlte.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->

@yield('js')
</body>
</html>