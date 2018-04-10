@extends("admin.layout.layout")
@section("title","员工注册量图表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/ly_registerNum.css")}}">
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
                    <b>-客户统计</b>
                    <span class="pull-right">
                        <a href="{{route("registerChart.list")}}" class="btn btn-default btn-xs"><i></i>注册排行</a>
                    </span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default search">
                <div class="panel panel-body">
                    <form class="form-inline" action="{{url("admin/sell/personRegisterChart")}}/{{$id}}">
                        <!--日期1-->
                        <div class="form-group">
                            日期:
                            <input class="datainp form-control input-sm" id="dateinfo" type="text" placeholder="请选择"
                                   name="time" value="{{$info['time']}}">
                        </div>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        {{--<!--员工姓名-->
                        <div class="form-group">
                            <select class="selectpicker" data-live-search="true">
                                <option mustard>员工姓名</option>
                                <option>张三</option>
                                <option>李四</option>
                                <option>王二</option>
                                <option>张三</option>
                                <option>张三</option>
                                <option>王二</option>
                            </select>
                        </div>--}}
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <!--统计图-->
            <div class="container-fluid" style="padding: 0;">
                <div>
                    <!-- 注册用户量 -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr style="font-size: 1.2em;">
                                <td><b><span>{{$employeeInfo['username']}}</span>----注册用户注册量</b></td>
                            </tr>
                            <tr>
                                <td class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td id="chartregist"></td>
                                        </tr>
                                        </tbody>
                                    </table>
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
    <!--<script src="js/highmaps.js"></script>-->


    <script src="https://img.hcharts.cn/highcharts/modules/drilldown.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
    <script src="{{asset("admin/js/highchart.config.js")}}" type="text/javascript"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        $('#chartregist').highcharts({
            title: {
                text: null
            },
            credits: {
                enabled: false
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    day: '%m/%d',
                    month: '%y年%b月',
                    week: '%b/%e',
                    year: '%Y年',
                    millisecond: '%b/%e'
                }
            },
            tooltip: {
                formatter: function () {
                    var d = new Date(this.x);
                    var s = '<b>' + d.getFullYear() + '年' + (d.getMonth() + 1) + '月' + d.getDate() + '日' + '</b>';
                    s += '<br/><span style="color:' + this.point.series.color + '">' + this.point.series.name + ': ' +
                        parseInt(this.point.y.toFixed(2)) + ' </span>';
                    return s;
                }
            },
            yAxis: {
                title: {
                    text: '成交额',
                    style: {
                        fontFamily: '宋体'
                    }
                }
                ,
                gridLineColor: '#eee', //横向网格线颜色
                gridLineDashStyle: 'solid', //横向网格线样式
                gridLineWidth: 1, //横向网格线宽度
                max: {{max($registerInfos)*2>10?max($registerInfos)*2:10}},
                min: 0,
                tickInterval: {{max($registerInfos)*2>10?floor(max($registerInfos)*2/10):1}}
            }
            ,
            legend: {
                enabled: false
            }
            ,
            exporting: {
                enabled: false
            }
            ,
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        }
                        ,
                        stops: [
                            [0, Highcharts.getOptions().colors[2]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[2]).setOpacity(0).get('rgba')]
                        ]
                    }
                    ,
                    marker: {
                        radius: 2
                    }
                    ,
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    }
                    ,
                    threshold: null
                }
            }
            ,
            series: [{
                type: 'area',
                name: '注册用户数',
                //     数据
                data: [
                        @foreach($registerInfos as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v}}],
                    @endforeach
                ]
            }]
        })
        ;

        // 日期
        jeDate({
            dateCell:"#dateinfo",
            format:"YYYY年MM月DD日",
            isinitVal:true,
            isTime:true, //isClear:false,
            minDate:"1970-01-01"
        });
    </script>
@endsection