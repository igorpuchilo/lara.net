<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="" type="image/png" />
    <title>{!! MetaTag::tag('title') !!}</title>
	<!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/skins/_all-skins.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/my.css')}}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<style>
    .wrapper{
        overflow:hidden;
    }
</style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{route('shop.admin.index.index')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Admin</b> Panel</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ucfirst (Auth::user()->name) }} </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                                <p>
                                    {{ ucfirst(Auth::user()->name) }}
                                </p>

                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                       class="btn btn-default btn-flat">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ ucfirst (Auth::user()->name) }} </p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Control Panel</li>
                <!-- Optionally, you can add icons to the links -->
                <li><a href="/"><i class="fa fa-home"></i> <span>To Store</span></a></li>
                <li><a href="{{route('shop.admin.index.index')}}"><i class="fa fa-user"></i> <span>Main</span></a></li>
                <li><a href="{{route('shop.admin.orders.index')}}"><i class="fa fa-shopping-cart"></i> <span>Orders</span></a></li>



                <li class="treeview">
                    <a href="#"><i class="fa fa-navicon"></i> <span>Category</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="">Category List</a></li>
                        <li><a href="">Add Category</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-cubes"></i> <span>Products</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="">Product List</a></li>
                        <li><a href="">Add Product</a></li>
                    </ul>
                </li>
                <li><a href=""><i class="fa fa-database"></i> <span>Cache</span></a></li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-users"></i> <span>Users</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="">Users List</a></li>
                        <li><a href="">Add User</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-usd"></i> <span>Currency</span>
                        <span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="">Currency List</a></li>
                        <li><a href="">Add Currency</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-filter"></i> <span>Filter</span>
                        <span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="">Filter Groups</a></li>
                        <li><a href="">Filter</a></li>
                    </ul>
                </li>
            </ul>

            <!-- search form -->

            <form action="" method="get" autocomplete="off"  style="position: absolute;">
                <div class="input-group">
                    <input id="search" name="search" type="text" class="form-control" placeholder="Live Search...." style="color: whitesmoke; background-color:#20262a; border: none;">
                    <span class="input-group-btn">
                        <button type="submit" value="" class="btn btn-flat" style="background-color: #ebeff4;"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>



            <!-- /.search form -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <main id="app">
            @include('shop.admin.components.result_messages')
            @yield('content')
        </main>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 3.0
        </div>
        <strong>Copyright &copy; 2019  All rights reserved.</strong>
    </footer>

    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script>
    var pathd = '{{PATH}}';
</script>
<!-- jQuery 3 -->
<script src="{{asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Validator -->
<script src="{{asset('js/validator.js')}}"></script>
<!-- Search -->

<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>

<!-- === Custom= ===  -->
<script src="{{asset('js/shop.js')}}"></script>

</body>
</html>
