@extends("admin.layout.layout")
@section("title","修改密码")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/ly_roleList.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/ly_memberList.css")}}">
    <style>
        .form-group {
            margin-bottom: 12px;
        }

        .form-group div {
            padding-left: 0;
        }
    </style>
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
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">
            <!--修改密码内容-->
            <form class="form-horizontal" action="{{url("admin/changePwd")}}" method="post">
                <div class="form-group">
                    <label for="oldPassword" class="col-xs-4 control-label">原密码</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="password" id="oldPassword" class="form-control" placeholder="请输入原密码" name="old_pwd">
                    </div>
                </div>
                <div class="form-group">
                    <label for="newPassword" class="col-xs-4 control-label">新密码</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="password" id="newPassword" class="form-control" placeholder="请输入新密码" name="pwd">
                    </div>
                </div>
                <div class="form-group">
                    <label for="resetPass" class="col-xs-4 control-label">确认新密码</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="password" id="resetPass" class="form-control" placeholder="请确认新密码" name="pwd_confirm">
                    </div>
                </div>
                {{csrf_field()}}
                <div class="form-group text-center">
                    <button type="reset" style="margin-right: 15px;" class="btn btn-primary">取消</button>
                    <button type="submit" class="btn btn-success">确定</button>
                </div>
            </form>
        </section>
        @component("admin.layout.footer")
        @endcomponent
    </div>
    <!-- /.content-wrapper -->

@endsection
@section("js")
    <script type="text/javascript">
        $('button[type="submit"]').click(function () {
            var a = $('#newPassword').val(),
                b = $('#resetPass').val(),
                c = $('#oldPassword').val();
            if (a == '' || b == '' || c == '') {
                layer.msg('密码不能为空!');
                return false;
            } else if (a != b) {
                layer.msg('两次密码输入不一致');
                return false;
            } else {
                return true;
            }
        })
    </script>
@endsection