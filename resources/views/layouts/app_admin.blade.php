<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="#" type="image/png"/>
    <title>{!! MetaTag::tag('title') !!}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{--Favicon--}}
    <link rel="shortcut icon" href="{{ asset('storage/images/favicon.png') }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('storage/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- App -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('storage/adminlte/bower_components/font-awesome/css/font-awesome.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('storage/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('storage/adminlte/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('storage/adminlte/dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{asset('storage/adminlte/bower_components/select2/dist/css/select2.css')}}">
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        .wrapper {
            overflow: hidden;
        }
    </style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <div class="main-header">
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
            <div class="nav-item">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </div>
            <!-- search form -->
            <div class="col-sm-5 col-md-5">
                <form action="{{url('/admin/search/result')}}" method="get" autocomplete="off" class="navbar-form">
                    <div class="input-group">
                        <input id="search" name="search" type="text" class="form-control" placeholder="Live Search....">
                        <span class="input-group-btn">
                        <button type="submit" value="" class="btn btn-flat" style="background-color: #ebeff4;"><i
                                    class="fa fa-search"></i></button>
                    </span>
                    </div>
                </form>
            </div>


            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('storage/adminlte/dist/img/user2-160x160.jpg')}}" class="user-image"
                                 alt="User Image" onerror="this.src = '{{asset("storage/images/no_image.jpg")}}';">
                            <span class="hidden-xs">{{ucfirst (Auth::user()->name) }} </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{asset('storage/adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle"
                                     alt="User Image" onerror="this.src = '{{asset("storage/images/no_image.jpg")}}';">
                                <p>
                                    {{ ucfirst(Auth::user()->name) }}
                                </p>

                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{route('shop.admin.users.edit', Auth::user()->id)}}"
                                       class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                       class="btn btn-default btn-flat">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
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
    </div>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('storage/adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle"
                         alt="User Image"
                         onerror="this.src = '{{asset("storage/images/no_image.jpg")}}';">
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
                <li><a href="{{route('shop.admin.orders.index')}}"><i class="fa fa-shopping-cart"></i>
                        <span>Orders
                            <span class="badge badge-light pull-right">
                                {{\App\Shop\Core\ShopApp::get_Instance()->getProperty('orders_count')}}
                            </span>
                        </span>
                    </a>
                </li>


                <li class="treeview">
                    <a href="#"><i class="fa fa-navicon"></i> <span>Category</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('shop.admin.categories.index')}}">Category List</a></li>
                        <li><a href="{{route('shop.admin.categories.create')}}">Add Category</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-cubes"></i> <span>Products</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('shop.admin.products.index')}}">Product List</a></li>
                        <li><a href="{{route('shop.admin.products.createStep1')}}">Add Product</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-users"></i> <span>Users</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('shop.admin.users.index')}}">Users List</a></li>
                        <li><a href="{{route('shop.admin.users.create')}}">Add User</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-usd"></i> <span>Currency</span>
                        <span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('shop.admin.currency.index')}}">Currency List</a></li>
                        <li><a href="{{url('/admin/currency/add')}}">Add Currency</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-filter"></i> <span>Filter</span>
                        <span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('shop.admin.filter.group-filter')}}">Filter Groups</a></li>
                        <li><a href="{{route('shop.admin.filter.attribute-filter')}}">Filter</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('shop.admin.settings.index')}}">
                        <i class="fa fa-cogs"></i> <span>Store Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('/admin/trash')}}"><i class="fa fa-trash"></i> <span>Temp Files</span></a>
                </li>
            </ul>


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
        <strong>Copyright &copy; 2019 All rights reserved.</strong>
    </footer>

    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<script>
    var pathd = '{{PATH}}';
</script>
<!-- jQuery 3 -->
<script src="{{asset('storage/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('storage/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Validator -->
<script src="{{asset('js/bootstrap-validate.js')}}"></script>
<!-- Search -->


<!-- AdminLTE App -->
<script src="{{asset('storage/adminlte/dist/js/adminlte.min.js')}}"></script>
<!-- Add product content editor -->
<script src="{{asset('storage/adminlte/bower_components/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('storage/adminlte/bower_components/ckeditor/adapters/jquery.js')}}"></script>
<script src="{{asset('storage/adminlte/bower_components/select2/dist/js/select2.full.js')}}"></script>
<!-- App -->
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/ajaxupload.js')}}"></script>
{{--Font Awesome--}}
<script src="https://use.fontawesome.com/c11a257dfe.js"></script>
<!-- Script select2 -->
@include('shop.admin.product.include.script_related_prod')
@include('shop.admin.product.include.script_img')
@include('shop.admin.product.include.script_gallery')
</body>
</html>
