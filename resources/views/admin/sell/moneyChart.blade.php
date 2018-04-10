@extends("admin.layout.layout")
        @section("title","成交额排行")
        @section("css")
            <link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
            <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
            <link rel="stylesheet" href="{{asset("admin/css/ly_registerNum.css")}}">
            {{--<link rel="stylesheet" href="{{asset("admin/css/dl_css.css")}}">--}}
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
                    <b>-成交额排行</b>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{url("admin/sell/moneyChart")}}" id="export">
                        <!--日期1-->
                        <div class="form-group">
                            开始日期:
                            <input class="datainp form-control input-sm" id="dateinfo" type="text" placeholder="请选择" value="{{$info['min_time']}}" name="min_time">
                        </div>
                        {{--<span>&nbsp;&nbsp;&nbsp;</span>--}}
                        <!--日期2-->
                        <div class="form-group">
                            结束日期:
                            <input class="datainp form-control input-sm" id="datebut" type="text" placeholder="请选择" name="max_time" value="{{$info['max_time']}}">
                        </div>
                        <!--地区搜索-->
                        <div class="form-group">
                            <select class="selectpicker" data-live-search="true" name="area">
                                <option value="0">所有地区</option>
                                @foreach($areaInfo as $k=>$v)
                                    <option value="{{$v['id']}}" @if($v['id']==$info['area']) selected @endif>{{$v['name']}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="exports()">导出</button>
                    </form>
                </div>
            </div>
            <!--统计图-->
            <div class="c">
                    <!-- 员工销售成交额排行  -->
                    <div class="table-responsive">
                        <div class="panel panel-default">
                        <table class="table table-bordered">
                            <tbody>
                            <tr style="font-size: 1.2em;">
                                <td><b>员工销售成交额排行</b></td>
                            </tr>
                            <tr>
                                <td class="table-responsive">
                                    <table class="table ly_table">
                                        <thead>
                                        <tr>
                                            <th class="col-md-3">排行</th>
                                            <th class="col-md-3 text-center">成交额</th>
                                            <th class="col-md-3 text-center">地区</th>
                                            <th class="col-md-3 text-center">员工姓名</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @foreach($employeeInfo['data'] as $k=>$v)
                                            <tr>
                                                <?php $index=$loop->iteration+($page-1)*15;?>
                                                <td class="text-left">
                                                <span>
                                                    {{$index}}
                                                </span>
                                                    @if($index==1)
                                                        <i><img src="{{asset("admin/img/jin.png")}}" alt=""></i>
                                                    @elseif($index==2)
                                                        <i><img src="{{asset("admin/img/yin.png")}}" alt=""></i>
                                                    @elseif($index==3)
                                                        <i><img src="{{asset("admin/img/tong.png")}}" alt=""></i>
                                                    @else
                                                        <i></i>
                                                    @endif
                                                </td>
                                                    <?php $employeeId=$v['id'];?>
                                                <td>{{number_format($price[$employeeId]/100,2,".","")}}</td>
                                                    <td>@if($v['f_area_id']==0)
                                                            未绑定
                                                        @else
                                                            @foreach($areaInfo as $k1=>$v1)
                                                                @if($v['f_area_id']==$v1['id'])
                                                                    {{$v1['name']}}
                                                                @endif
                                                            @endforeach
                                                        @endif</td>
                                                <td>
                                                    <a href="{{url("admin/sell/personMoneyChart")}}/{{$v['id']}}">{{$v['username']}}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!--分页-->
                                    {{$employeeInfos->appends(["min_time"=>"{$info['min_time']}","max_time"=>"{$info['max_time']}","area"=>$info['area']])->links()}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
            </div>
        </section>

        @component("admin.layout.footer")
            @endcomponent

    </div>
    <!-- /.content-wrapper -->

@endsection
@section("js")
<script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
<script src="{{asset("admin/js/defaults-zh_CN.js")}}"></script>
<script src="{{asset("admin/js/jedate.min.js")}}"></script>
<script src="{{asset("admin/js/highcharts.js")}}"></script>


<script src="https://img.hcharts.cn/highcharts/modules/drilldown.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
<script src="{{asset("admin/js/echarts.min.js")}}"></script>
<script src="{{asset("admin/js/china.js")}}"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script>
    //方法
    function exports()
    {
        var data = $("#export").serialize();
        location.href="{{url("admin/sell/moneyChartExport")}}?"+data;
    }

    // 日期
    jeDate({
        dateCell:"#dateinfo",
        format:"YYYY年MM月DD日",
        isinitVal:true,
        isTime:true, //isClear:false,
        minDate:"1970-01-01"
//		okfun:function(val){alert(val)}
    });
    jeDate({
        dateCell:"#datebut",
        format:"YYYY年MM月DD日",
        isinitVal:true,
        isTime:true, //isClear:false,
        minDate:"1970-01-01"
//		okfun:function(val){alert(val)}
    });

</script>
@endsection