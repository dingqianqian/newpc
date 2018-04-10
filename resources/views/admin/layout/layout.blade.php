<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield("title")</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('admin/css/ly_load.css')}}">
    <link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('admin/bower_components/Ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/dist/css/skins/skin-blue.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/jquery.searchableSelect.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/ly_comm.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/reset.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/zfstyle.css')}}" />
@yield("css")
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{url('admin/index')}}" class="logo">
            <span class="logo-mini"><b>yys</b></span>
            <span class="logo-lg">宜优速后台管理系统</span>
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
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="">{{session("employeeInfo")['username']}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-footer loginOut">
                                <a href="{{url("admin/changePwd")}}" class="">修改密码</a>
                                <a href="{{url('admin/logout')}}" class="">退出登陆</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <!-- Left Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">菜单</li>
                <!--商品管理-->
                @foreach(session("employeeInfo")['access'] as $k=>$v)
                    <?php $id=$v['id'];?>
                    @if(in_array(session("current_tag"),session("current_tags")[$id]))
                <li class="treeview active menu-open">
                    <a href="#"><i class="fa {{$v['icon']}}"></i> <span>{{$v['name']}}</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        @if(isset($v['child']))
                        @foreach($v['child'] as $k1=>$v1)
                            @if($v1['is_show']==1)
                                @if(explode(".",session("current_tag"))[0]==explode(".",$v1['route_name'])[0])
                            <li class="active">
                                <a href="{{route("{$v1['route_name']}")}}"><i class="fa {{$v1['icon']}}"></i>{{$v1['name']}}</a>
                            </li>
                                    @else
                                    <li>
                                        <a href="{{route("{$v1['route_name']}")}}"><i class="fa {{$v1['icon']}}"></i>{{$v1['name']}}</a>
                                    </li>
                                    @endif
                            @endif
                            @endforeach
                            @endif
                    </ul>
                </li>
                    @else
                        <li class="treeview">
                            <a href="#"><i class="fa {{$v['icon']}}"></i> <span>{{$v['name']}}</span>
                                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                            </a>
                            <ul class="treeview-menu">
                                @if(isset($v['child']))
                                @foreach($v['child'] as $k1=>$v1)
                                    @if($v1['is_show']==1)
                                        <li>
                                            <a href="{{route("{$v1['route_name']}")}}"><i class="fa {{$v1['icon']}}"></i>{{$v1['name']}}</a>
                                        </li>
                                    @endif
                                @endforeach
                                    @endif
                            </ul>
                        </li>
                        @endif
                @endforeach
            </ul>
            <!-- /.sidebar-menu -->
        </section>
    </aside>
    @yield("content")
</div>
<div id="_mask">
    <div class="loader">
        <div class="load5"></div>
    </div>
</div>
<!-- jQuery 3 -->
<script src="{{asset('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('admin/js/jquery.searchableSelect.js')}}"></script>
<script src="{{asset('lib/layer/layer.js')}}"></script>
@yield("js")
<script type="text/javascript">
    $(function(){
        $('#_mask').css('display','none');
    });
    @if(session("msg"))
        layer.msg("{{session("msg")}}");
        @endif
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
</script>
</body>
</html>