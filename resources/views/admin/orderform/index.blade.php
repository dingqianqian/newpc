@extends("admin.layout.layout")
@section("title","催单列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/z_orderform.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/dl_css.css")}}">
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
                    <b>-催单列表</b>
                    <!--<span class="pull-right">
                        <a href="" class="btn btn-default btn-xs"><i></i>添加会员</a>
                    </span>-->
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{url("admin/orderform/index")}}" method="get">
                        <div class="form-group" style="font-size: 12px;font-weight: normal;margin-right: 1%;">
                            <span>催单状态：</span>
                            <select class="form-control d-select" name="status" style="font-size: 12px;">
                                <option value="0" @if($Info['status']==0) selected @endif>全部</option>
                                <option value="1" @if($Info['status']==1) selected @endif>已处理</option>
                                <option value="2"@if($Info['status']==2) selected @endif>未处理</option>
                            </select>
                        </div>
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <!--表格-->
            <div class="panel panel-default">
            <form class="form-inline table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>订单编号</th>
                        <th>下单时间</th>
                        <th>催单时间</th>
                        <th>是否处理</th>
                        <th>订单状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderInfo['data'] as $k=>$v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['no']}}</td>
                        <td>{{date('Y-m-d',$v['create_time'])}}</td>
                        @if($v['is_reminder']==0)
                            <td>暂无</td>
                        @else
                        <td>{{date('Y-m-d',$v['is_reminder'])}}</td>
                        @endif

                        @if($v['f_order_form_status_id']==2)
                        <td>未处理</td>
                        @elseif($v['f_order_form_status_id']==4)
                            <td>未处理</td>
                            @else
                            <td>已处理</td>
                        @endif

                        @if($v['f_order_form_status_id'] == 999)
                            <td>订单已过期</td>
                        @elseif($v['f_order_form_status_id'] == 0)
                            <td>订单已过期</td>
                        @else
                        <td>{{$v['order_form_status']['name']}}</td>
                        @endif
                        <td>
                            <a href="{{url("admin/orderform/info")}}/{{$v['id']}}/0" class="z_a_color"><span class="glyphicon glyphicon-search" title="查看详情"></span></a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
                <!--分页-->
                <div></div>
                {{$orderInfos->appends(["status"=>$Info["status"]])->links()}}
            </form>
            </div>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent

    </div>
@endsection

<!-- jQuery 3 -->
@section("js")
{{--<script src="bower_components/jquery/dist/jquery.min.js"></script>--}}
{{--<!-- Bootstrap 3.3.7 -->--}}
{{--<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>--}}
{{--<!-- AdminLTE App -->--}}
{{--<script src="dist/js/adminlte.min.js"></script>--}}
@endsection