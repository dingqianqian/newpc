@extends("admin.layout.layout")
@section("title","套餐详情")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/z_roleList.css")}}">
@endsection

@section("content")

    <section class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-入驻详情</b>
                    <span class="pull-right">
			<a href="{{route('enter.list')}}" class="btn btn-sm btn-default"><i></i>入驻列表</a>

		</span>
                </div>
            </div>
        </section>

        <section class="content-header">
            <!--基本信息-->
            <div class="z-order">
                <form class="form-inline table-responsive">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th colspan="4" style="font-size: 14px;" class="text-center">套餐信息</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th class="col-md-3">用户手机号:</th>
                            <td class="col-md-3">{{$enterInfo["user"]["signin_name"]}}</td>
                            <th class="col-md-3">名称:</th>
                            <td class="col-md-3">{{$enterInfo["name"]}}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">地址:</th>
                            <td class="col-md-3">{{$enterInfo["address"]}}</td>
                            <th class="col-md-3">电话:</th>
                            <td class="col-md-3">{{$enterInfo["phone"]}}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">用户是否读取:</th>
                            @if($enterInfo["enter_message"]["is_read"] == 1)
                                <td class="col-md-3">用户已读取</td>
                            @else
                                <td class="col-md-3">暂无</td>
                            @endif
                            <th class="col-md-3">创建时间:</th>
                            <td class="col-md-3">{{date("Y-m-d H:i:s",$enterInfo["create_time"])}}</td>
                        </tr>
                        <thead>
                        <tr>
                            <th colspan="4" style="font-size: 14px;" class="text-center">操作信息</th>
                        </tr>
                        </thead>
                        <tr>
                            <th colspan="1" class="col-md-4 text-right">当前可执行操作:</th>
                            <td id="mange">
                                @if(in_array($enterInfo["status"],[0]))
                                    <a href="javascript:;" class="btn btn-success btn-sm" ids="1">标记为已通过</a>
                                    <a href="javascript:;" class="btn btn-danger btn-sm" ids="2">标记为驳回</a>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <!--商品信息-->

            <div class="enter-list">
                <div class="enter-title">外观图</div>
                <div class="row">
                    @foreach($enterImageInfo as $k=>$v)
                        @if($v["type"]==1)
                            <div class="col-sm-6 col-md-4">
                                <a href="#" class="thumbnail">
                                    <img src="{{$v["image_url"]}}"
                                         alt="通用的占位符缩略图">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="enter-list">
                <div class="enter-title">大厅图</div>
                <div class="row">
                    @foreach($enterImageInfo as $k=>$v)
                        @if($v["type"]==2)
                            <div class="col-sm-6 col-md-4">
                                <a href="#" class="thumbnail">
                                    <img src="{{$v["image_url"]}}"
                                         alt="通用的占位符缩略图">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="enter-list">
                <div class="enter-title">大床图</div>
                <div class="row">
                    @foreach($enterImageInfo as $k=>$v)
                        @if($v["type"]==3)
                            <div class="col-sm-6 col-md-4">
                                <a href="#" class="thumbnail">
                                    <img src="{{$v["image_url"]}}"
                                         alt="通用的占位符缩略图">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="enter-list">
                <div class="enter-title">标间</div>
                <div class="row">
                    @foreach($enterImageInfo as $k=>$v)
                        @if($v["type"]==4)
                            <div class="col-sm-6 col-md-4">
                                <a href="#" class="thumbnail">
                                    <img src="{{$v["image_url"]}}"
                                         alt="通用的占位符缩略图">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="enter-list">
                <div class="enter-title">其他</div>
                <div class="row">
                    @foreach($enterImageInfo as $k=>$v)
                        @if($v["type"]==5)
                            <div class="col-sm-6 col-md-4">
                                <a href="#" class="thumbnail">
                                    <img src="{{$v["image_url"]}}"
                                         alt="通用的占位符缩略图">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        <!-- /.content-wrapper -->
        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent
        <div class="control-sidebar-bg"></div>
    </section>
@endsection
@section("js")
    <script  type="text/javascript">
        $("#mange").children().click(
            function () {
                var name=$(this).text();
                console.log(name);
                var href=$(this).attr("href");
                var id=$(this).attr("ids");
                layer.confirm('确定要'+name+"吗？", {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.ajax({
                        url:"{{url("admin/enter/status")}}/{{$enterInfo["id"]}}/"+id,
                        type:"post",
                        success:function (res) {
                            layer.msg(res.msg);
                            location.reload();
                        },
                        error:function (res) {
                            layer.msg(res);
                        }
                    });
                }, function(){
                    layer.msg("取消成功");
                });
                return false;
            }
        );
    </script>
@endsection