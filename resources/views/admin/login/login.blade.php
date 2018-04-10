<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset("favicon.ico")}}" media="screen" />
    <link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/login.css')}}"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="box">
    <div class="login-box">
        <div class="login-title text-center">
            <h1>
                <small><i>宜优速</i></small>
            </h1>
        </div>
        <div class="login-content ">
            <div class="form">
                <form action="{{url('admin/checkLogin')}}" method="post">
                    <div class="form-group">
                        <div class="col-xs-12  ">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                <input type="text" id="username" name="username" class="form-control" placeholder="用户名">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="密码">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-tree-deciduous"></span></span>
                                <input type="text" id="password" name="captcha" class="form-control input-width"
                                       placeholder="验证码">
                                <span class="z_img input-width"><img src="{{captcha_src()}}" alt=""
                                                                     class="captcha"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-6">
                            <input type="checkbox" name="" id="" value=""/><span class="check">请保存我这次的登陆信息</span>
                        </div>
                        <div class="col-xs-6">
                            <p class="text-center remove-margin">
                                <small>忘记密码？</small>
                                <a href="{{url('admin/forgetPassword')}}" class="link-a">
                                    <small>找回</small>
                                </a>
                            </p>
                        </div>
                    </div>
                    {{csrf_field()}}
                    <div class="form-group form-actions">
                        <div class="col-xs-4 col-xs-offset-4 ">
                            <button type="submit" class="btn btn-sm btn-info btn-footer"><span
                                        class="glyphicon glyphicon-off"></span> 登录
                            </button>
                        </div>
                    </div>
                    <!--
                                                <div class="form-group">

                                                </div>-->
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="{{asset('admin/js/jquery-1.11.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset("lib/layer/layer.js")}}"></script>
<script type="text/javascript">
    $(".captcha").click(function () {
        $(".captcha").attr("src", "{{captcha_src()}}/" + Math.random());
    });
    @if(session("msg"))
		layer.msg("{{session("msg")}}");
    @endif
@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        @if($loop->index==0)
layer.msg("{{$error}}");
    @endif
    @endforeach
    @endif
</script>