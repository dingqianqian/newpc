@extends("admin.layout.layout")
        @section("title","客户统计")
        @section("css")
            <link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
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
                    <b>-客户统计</b>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel" style="font-size: 12px;font-weight: normal">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{route("userCensus.index")}}">
                        <!--日期1-->
                        <div class="form-group">
                            开始日期:
                            <input class="datainp form-control input-sm" id="dateinfo" name="start_time" type="text" placeholder="请选择" value="{{$info['time']}}">
                        </div>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        {{--<!--日期2-->
                        <div class="form-group">
                            结束日期:
                            <input class="datainp form-control input-sm" id="datebut" type="text" placeholder="请选择">
                        </div>--}}
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <!--统计图-->
            <div class="container-fluid" style="padding: 0;" bn >
                <div class="col-md-6 table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr style="font-size: 1.2em;">
                            <td><b>新注册用户</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div id="chart1"></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr style="font-size: 1.2em;">
                            <td><b>会员占比</b></td>
                        </tr>
                        <tr>
                            <td>
                                <div id="chart2"></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

        <!-- Footer -->
       @component("admin.layout.footer")
           @endcomponent

    </div>
 @endsection

@section("js")
    <script src="{{asset("admin/js/highcharts.js")}}"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{asset("admin/js/jedate.min.js")}}"></script>
    <script src="{{asset("admin/js/highchart.config.js")}}" type="text/javascript"></script>
    <script>
        $('#chart1').highcharts({
            title: {
                text: null
            },
            credits: {
                enabled: false
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    /*day: '%m-%d',
                     week: '%m-%d',
                     month: '%Y-%m',
                     year: '%Y'*/
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
                max:{{max($temp)*2>10?max($temp)*2:10}},
                min: 0,
                tickInterval: {{max($temp)*2>10?floor(max($temp)*2/10):1}},
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
                            [0, Highcharts.getOptions().colors[9]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[9]).setOpacity(0).get('rgba')]
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
                        @foreach($temp as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v}}],
                    @endforeach
                ]
            }]
        })
        ;
        $(function () {
            var chart = Highcharts.chart('chart2', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    style: {
                        fontFamily: '宋体'
                    }
                },
                title: {
                    text: null
                },
                tooltip: {
                    headerFormat: '{series.name}<br>',
                    pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
                },
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false // 禁用版权信息
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                return this.point.name + '：' + this.y + '%'
                            },
//                            distance: -70,
                            style: {
                                fontSize: '14px',
                                fontWeight: 'normal'
                            }
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    type: 'pie',
                    name: '会员占比',
                    data: [
                        /*{
                         name: '黄金会员',
                         y: 55.0,
                         sliced: true,
                         selected: true
                         },*/
                        ['普通会员', {{100-$percent}}],
                        ['黄金会员', {{$percent}}]
                    ],
                    colors: ['#00A65A', '#fdd67f']
                }]
            });
        });

    // 日期
    jeDate({
        dateCell:"#dateinfo",
        format:"YYYY年MM月DD日",
        isinitVal:true,
        isTime:true, //isClear:false,
        minDate:"2014-09-19"
//		okfun:function(val){alert(val)}
    });
</script>
    @endsection
