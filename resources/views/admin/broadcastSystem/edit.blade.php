@extends("admin.layout.layout")
@section("title","编辑广播")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/ly_addguangbo.css")}}">
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
                    <b>-编辑广播</b>
                    <span class="pull-right">
                <a href="{{route("broadcastSystem.list")}}" class="btn btn-default btn-sm">广播列表</a>
                    </span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <form class="form addguangbo" action="{{url("admin/broadcastSystem/update")}}/{{$broadcastSystemInfo['id']}}" method="post">
                <!--内容-->
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>广播标题 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <input type="text" class="form-control" name="title" value="{{$broadcastSystemInfo['title']}}" placeholder="请输入广播标题">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>广播内容 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <textarea class="form-control" rows="6"  name="commit"  placeholder="请输入广播内容">{{$broadcastSystemInfo['commit']}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>跳转位置 :</b></div>
                    <div class="col-md-5  col-xs-9">
                        <input type="text" class="form-control" name="url" value="{{$broadcastSystemInfo['url']}}" placeholder="请输入跳转位置 可为空">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>Android链接 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <input type="text" class="form-control" name="android_url" value="{{$broadcastSystemInfo['android_url']}}" placeholder="如不跳转则不填写"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>Android参数 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <input type="text" class="form-control" name="android_param" value="{{$broadcastSystemInfo['android_param']}}" placeholder="如不跳转则不填写"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>ios链接 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <input type="text" class="form-control" name="ios_url" value="{{$broadcastSystemInfo['ios_url']}}" placeholder="如不跳转则不填写"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>ios控制器名称 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <input type="text" class="form-control" name="ios_vc_name" value="{{$broadcastSystemInfo['ios_vc_name']}}" placeholder="如不跳转则不填写"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>ios参数 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <input type="text" class="form-control"  name="ios_vc_property" value="{{$broadcastSystemInfo['ios_vc_property']}}" placeholder="如不跳转则不填写"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>图片 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <!--图片上传-->
                        <input type="text" class="form-control" name="img" value="{{$broadcastSystemInfo['img']}}" placeholder="图片链接"/>
                    </div>
                </div>
                {{csrf_field()}}
                <!--提交-->
                <div class="submitBtn text-center">
                    <button type="submit" class="btn btn-success">修改</button>
                    <button type="reset" class="btn btn-primary">重置</button>
                </div>
            </form>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent

    </div>
@endsection
@section("js")
@endsection

