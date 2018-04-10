@extends("admin.layout.layout")
@section("title","发票列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/ly_comm.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/dl_css.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_rceived.css")}}">
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
                    <b>-- 发票列表</b>
                    <!--<span class="pull-right">
                        <a href="" class="btn btn-default btn-xs"><i></i>添加会员</a>
                    </span>-->
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            {{--统计--}}
            <div class="panel panel-default dl_Commodity_panel">
                <div class="panel panel-body">
                    <ul class="z-ul">
                        <li>发票数目: <span>{{$count}}</span></li>
                        <li>发票金额总计: <span>{{number_format($priceCount,2,".","")}}</span></li>
                    </ul>
                </div>
            </div>
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{route("invoice.list")}}" method="get" id="export">
                        <!--日期1-->
                        <div class="form-group datep">
                            日期:
                            <input class="datainp form-control input-sm" id="dateinfo" type="text" placeholder="请选择" name="min_time" value="{{$info['min_time']}}">-- <input class="datainp form-control input-sm" id="datebut" type="text" placeholder="请选择" name="max_time" value="{{$info['max_time']}}">
                        </div>
                    {{--<span></span>--}}
                    {{--<!--日期2-->--}}
                    {{--<div class="form-group">--}}
                    {{----}}
                    {{--</div>--}}
                    <!--金额-->
                        {{--<div class="form-group">--}}
                            {{--<select name="price" --}}{{--ly:--}}{{--style="height: 30px;line-height: 30px;padding: 0 4px;font-size: 12px;">--}}
                                {{--<option value="0" @if($info['price']==0) selected @endif>不限金额</option>--}}
                                {{--<option value="1" @if($info['price']==1) selected @endif>低于1000</option>--}}
                                {{--<option value="2" @if($info['price']==2) selected @endif>1000~5000</option>--}}
                                {{--<option value="3" @if($info['price']==3) selected @endif>5000~10000</option>--}}
                                {{--<option value="4" @if($info['price']==4) selected @endif>10000以上</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        <!--发票状态-->
                        <div class="form-group">
                            <select  name="status" {{--ly:--}}style="height: 30px;line-height: 30px;padding: 0 4px;font-size: 12px;">
                                <option value="0" @if($info['status']==0) selected @endif>发票状态</option>
                                <option value="1" @if($info['status']==1) selected @endif>未开</option>
                                <option value="2" @if($info['status']==2) selected @endif>已开</option>
                            </select>
                        </div>
                    {{csrf_field()}}
                    <!--搜索-->
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" placeholder="可按订单号/单位名称搜索" name="no" value="{{$info['no']}}">
                        </div>
                        {{--手机搜索--}}
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" placeholder="手机号" name="receive_tel" value="{{$info["receive_tel"]}}">
                        </div>
                        <button type="submit" class="btn btn-success btn-xs">搜索</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="exports()">导出</button>
                    </form>
                </div>
            </div>
            <!--表格-->
            <div class="panel panel-default">
                <form class="form-inline table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th><label for="">编号</label></th>
                            <th><label for="">订单号</label></th>
                            <th><label for="">收货人姓名</label></th>
                            <th><label for="">收货人电话</label></th>
                            <th><label for="">申请开票金额</label></th>
                            <th><label for="">订单总额</label></th>
                            <th><label for="">优惠券抵扣金额</label></th>
                            {{--<th><label for=""></label>当前剩余可开票金额</th>--}}
                            <th><label for="">开票状态</label></th>
                            <th><label for="">申请发票类型</label></th>
                            <th><label for="">操作</label></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoiceOrderInfo['data'] as $k=>$v)
                            <tr>
                                <td>{{$v['id']}}</td>
                                <td>{{$v['no']}}</td>
                                <td>{{$v['receive_name']}}</td>
                                <td>{{$v['receive_tel']}}</td>
                                <td>{{number_format($v['price'],2,".","")}}</td>
                                <td>{{number_format($v['price']+$v['couponPrice'],2,".","")}}</td>
                                <td>{{number_format($v['couponPrice'],2,".","")}}</td>
                                {{--<td>{{number_format($v['allow_price'],2,".","")}}</td>--}}
                                <td>{{$v['is_fixed']?"已处理":"未处理"}}</td>
                                <td>{{$v['invoice_type']}}</td>
                                <td>
                                    <a href="{{route('invoice.info',["id"=>$v['id']])}}" class="edit" title="查看详情"><img src="{{asset("admin/img/details.png")}}" alt=""></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- 分页 -->
                    {{$invoiceOrderInfos->appends(["min_time"=>"{$info['min_time']}","max_time"=>"{$info['max_time']}","price"=>"{$info['price']}","status"=>"{$info['status']}","no"=>"{$info['no']}"])->links()}}

                </form>
            </div>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent

    </div>
    <!-- /.content-wrapper -->

@endsection
@section("js")
    <script src="{{asset("admin/js/jedate.min.js")}}"></script>
    <script>
        //导出方法
        function exports()
        {
            var data = $("#export").serialize();
            location.href = "{{url("admin/invoice/export")}}?"+data;
        }


        jeDate({
            dateCell:"#dateinfo",
            format:"YYYY年MM月DD日",
            isinitVal:true,
            isTime:true, //isClear:false,
            minDate:"2014-09-19"
//		okfun:function(val){alert(val)}
        });
        jeDate({
            dateCell:"#datebut",
            format:"YYYY年MM月DD日",
            isinitVal:true,
            isTime:true, //isClear:false,
            minDate:"2014-09-19"
//		okfun:function(val){alert(val)}
        });
    </script>
@endsection