@extends("admin.layout.layout")
@section("title","积分兑换详情")
@section("css")
    <link rel="stylesheet" href="{{asset('admin/css/ly_memberDetail.css')}}">
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
                    <b>-积分兑换详情</b>
                    <span class="pull-right">
						<a href="{{route("integral.list")}}" class="btn btn-default btn-xs"><i></i>积分兑换列表</a>
					</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <!--<div class="panel panel-default search">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline">
                        <div class="form-group">
                            输入评论内容
                            <input type="text" class="form-control input-sm" id="exampleInputName2">
                        </div>
                        <button type="button" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>-->
            <!--表格-->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="fontSize">
                    <tbody>
                    <tr>
                        <td class="col-xs-3">ID:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['id']}}</td>
                        <td class="col-xs-3">用户账号:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['f_user_signin_name']}}</td>
                    </tr>
                    <tr>
                        <td class="col-xs-3">积分:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['use_integral']}}</td>
                        <td class="col-xs-3">留言:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['commit']}}</td>
                    </tr>
                    <tr>
                        <td class="col-xs-3">充值手机号:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['recharge_tel']}}</td>
                        <td class="col-xs-3">积分兑换序号:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['no']}}</td>
                    </tr>
                    <tr>
                        <td class="col-xs-3">处理时间:</td>
                        <td class="col-xs-3">{{date("Y-m-d",$integralExchangeOrderInfos['fixed_time'])}}</td>
                        <td class="col-xs-3">积分商品编号:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['f_integral_goods_id']}}</td>
                    </tr>
                    <tr>
                        <td class="col-xs-3">第三方快递单号:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['expressage']}}</td>
                        <td class="col-xs-3">收件地址:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['receive_addr']}}</td>
                    </tr>
                    <tr>
                        <td class="col-xs-3">收件人姓名:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['receive_name']}}</td>
                        <td class="col-xs-3">收件电话:</td>
                        <td class="col-xs-3">{{$integralExchangeOrderInfos['receive_tel']}}</td>
                    </tr>

                    </tbody>
                </table>
                <div class="submitBtn text-center">
                    <button class="btn btn-success" @if($integralExchangeOrderInfos['fixed_time']!='0') style="display:none" @endif onclick="handle({{$integralExchangeOrderInfos['id']}})">标记为已处理</button>
                </div>
            </div>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent

    </div>
    <!-- /.content-wrapper -->

@endsection
@section('js')
    <script>
            function handle(id) {
                var data = " <div class='form-group d-div'>" +
                "<div>" +
                "<input type='text' name='expressage' placeholder='请输入第三方快递单号或备注' autocomplete='off' class='d_val'>" +
                "</div> </div>";
                layer.confirm("处理积分兑换", {
                    type:1,
                    btn: ['保存', '取消'], //按钮，
                    title: "<span style='font-weight: 900'>请输入第三方快递单号或备注</span>",
                    content: data,
                    area: ['320px', '200px']
                }, function () {
                    var val = $(".d_val").val();
                    console.log();
                    $.ajax({
                        url: "{{url('admin/integral/doinfo')}}/" + id,
                        type: "post",
                        data:{name:val},
                        success: function (res) {
                            layer.msg(res.msg);
                            location.reload();
                        },
                        error: function (res) {
                            layer.msg(res.responseText);
                        }
                    });
                }, function () {
                    layer.msg('取消成功');
                });
                return false;
            };

    </script>
@endsection