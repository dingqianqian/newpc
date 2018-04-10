@extends("admin.layout.layout")
@section("title","修改成功")
@section("css")
    <link rel="stylesheet" href="css/ly_roleList.css">
    <link rel="stylesheet" href="css/ly_memberList.css">
    <link rel="stylesheet" href="{{asset("admin/css/dl_Success.css")}}">
@endsection
@section("content")

    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-修改密码</b>
                    <span class="pull-right">
                        <a href="" class="btn btn-default btn-xs"><i></i>用户名</a>
                    </span>
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">

        </section>

    </div>
@endsection
@section("js")
    <script type="text/javascript">
        //自定页
        layer.open({
            type: 1,
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            resize: false,
            shadeClose: true, //开启遮罩关闭
            content: ' <h5><span class="glyphicon glyphicon-ok"></span>密码修改成功，<span id="count">3</span>s后自动跳转登陆，跳过等待<a href="{{url("admin/logout")}}">直接登陆</a></h5>'
        });
        var timer = setInterval(function () {
            var a = parseFloat($('#count').text());
            a = a - 1;
            if (a == -1) {
                clearInterval(timer);
                location.href = '{{url("admin/logout")}}';
                a = 3;
                return
            }
            $('#count').text(a);
        }, 1000)
    </script>
@endsection