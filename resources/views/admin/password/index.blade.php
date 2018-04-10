<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>密码找回</title>
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
                <form action="{{url('admin/sendMail')}}" method="post">
                    <h2 class="text-center">管理员密码找回</h2>
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
                                <input type="email" id="password" name="email" class="form-control" placeholder="邮箱">
                            </div>
                        </div>
                    </div>
                    {{csrf_field()}}
                    <div class="form-group form-actions">
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-info footer-btn"><span
                                        class="glyphicon glyphicon-apple"></span>找回
                            </button>
                            <a type="reset" href="{{url('admin/login')}}" class="btn btn-sm btn-danger footer-btn"><span
                                        class="glyphicon glyphicon-adjust"></span>返回登录</a>
                        </div>
                    </div>

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
    @if(session("msg"))
		layer.msg("{{session("msg")}}");
    @endif
</script>