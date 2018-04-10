@extends("admin.layout.layout")
        @section("title","流量分析")
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
                    <b>-流量分析</b>
                    <!--<span class="pull-right">
                        <a href="" class="btn btn-default btn-xs"><i></i>添加会员</a>
                    </span>-->
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel" style="font-weight: normal;font-size: 12px">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" method="get" action="{{route('traffic.index')}}" >
                        <!--日期1-->
                        <div class="form-group">
                            开始日期:
                            <input class="datainp form-control input-sm" id="dateinfo" value="{{$btime}}" type="text" placeholder="请选择" name="btime">
                        </div>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <!--日期2-->
                        {{--<div class="form-group">--}}
                            {{--结束日期:--}}
                            {{--<input class="datainp form-control input-sm" id="datebut" type="text" placeholder="请选择">--}}
                        {{--</div>--}}
                        <button type="submit" id="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <!--统计图-->
            <div class="container-fluid" id="ly-fluid">
                <div class="row">
                    <!-- pv -->
                    <div class="col-md-6 table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr style="font-size: 1.2em;">
                                <td><b>浏览量(pv)</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="chartpv"></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- uv  -->
                    <div class="col-md-6 table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr style="font-size: 1.2em;">
                                <td><b>访客数(uv)</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="chartuv"></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <!--地区分布图-->
                    <div class="col-md-6 table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr style="font-size: 1.2em;">
                                <td><b>地区分布图</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="chartmap" style="width: 100%;height: 400px;"></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--新老访客-->
                    <div class="col-md-6 table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr style="font-size: 1.2em;">
                                <td><b>新老访客</b></td>
                            </tr>
                            <tr>
                                <td id="check" style="height: 415px;vertical-align: middle;">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr style="font-size: 1.2em;">
                                                <td class="text-center" style="border-top: 0;"><img src="{{asset("admin/img/people.png")}}"></td>
                                                <td style="border-top: 0;border-left: 1px solid #f4f4f4;">
                                                    <div>新访客</div>
                                                    <span style="color: #3EA9E1;font-weight: 600;">{{100-$percent}}%</span>
                                                </td>
                                                <td style="border-top: 0;border-left: 1px solid #f4f4f4;">
                                                    <div>老访客</div>
                                                    <span style="font-weight: 600;">{{$percent}}%</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table  class="table">
                                            <tbody>
                                            <tr>
                                                <td class="text-center" style="width: 36%;">浏览量</td>
                                                <td>{{$res_new['items'][1][0][0]}}</td>
                                                <td>{{$res_old['items'][1][0][0]}}</td>
                                            </tr
                                            <tr>
                                                <td class="text-center" style="width: 36%;">访客数</td>
                                                <td>{{$res_new['items'][1][0][1]}}</td>
                                                <td>{{$res_old['items'][1][0][1]}}</td>
                                            </tr>
                                            <tr>

                                                <td class="text-center" style="width: 36%;">跳出率</td>
                                                <td>{{$res_new['items'][1][0][2]}}%</td>
                                                <td>{{$res_old['items'][1][0][2]}}%</td>

                                            </tr>
                                            <tr>
                                                <td class="text-center" style="width: 36%;">平均访问时长</td>
                                                <td>{{gmstrftime('%H:%M:%S',intval($res_new['items'][1][0][3]))}}</td>
                                                <td>{{gmstrftime('%H:%M:%S',intval($res_old['items'][1][0][3]))}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" style="width: 36%;">平均访问页数</td>
                                                <td>{{$res_new['items'][1][0][4]}}</td>
                                                <td>{{$res_old['items'][1][0][4]}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <!--客户访问-->
                    <div class="col-md-6 table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr style="font-size: 1.2em;">
                                <td><b>客户访问页面统计</b></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;">
                                    <div class="table-responsive">
                                        <table class="table" style="margin:15px 0;">
                                            <thead>
                                            <tr>
                                                <td>受访页面</td>
                                                <td>浏览量</td>
                                                <td>占比</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($viewPage['items'][0] as $k=>$v)
                                            <tr>
                                                <td>
                                                    <a href="javascript:;">{{$v[0]['name']}}</a>
                                                </td>
                                                <td>{{$viewPage['items'][1][$k][0]}}</td>
                                                <td><span style="background: #DCEBFE;">{{round($viewPage['items'][1][$k][0]/$viewPage['sum'][0][0]*100,2)}}</span>%</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--来源-->
                    <div class="col-md-6 table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr style="font-size: 1.2em;">
                                <td><b>来源网站</b></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;">
                                    <div class="table-responsive">
                                        <table class="table" style="margin: 15px 0;">
                                            <thead>
                                            <tr>
                                                <td>来源网站</td>
                                                <td>浏览量</td>
                                                <td>占比</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($source_site as $k=>$v)
                                            <tr>
                                                <td>{{$v[0]}}</td>
                                                <td>{{$v[1]}}</td>
                                                <td><span style="background: #DCEBFE;">{{$v[2]}}</span>%</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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


    <script src="{{asset("admin/js/highcharts.js")}}"></script>
    <script src="{{asset("admin/js/echarts.min.js")}}"></script>
    <script src="{{asset("admin/js/china.js")}}"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/drilldown.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>


    <script src="{{asset("admin/js/highchart.config.js")}}"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{asset('admin/js/jedate.min.js')}}"></script>
    <script src="{{asset("admin/js/highchart.config.js")}}" type="text/javascript"></script>
<script>
    // pv
    $(function () {
        $('#chartpv').highcharts({
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
                },
                title:{
                    text:"日期"
               }
            },
            legend:{
                enabled: false
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
                    text: '浏览量',
                    style: {
                        fontFamily: '宋体'
                    }
                }
                ,
                gridLineColor: '#eee', //横向网格线颜色
                gridLineDashStyle: 'solid', //横向网格线样式
                gridLineWidth: 1, //横向网格线宽度
                max:{{$pvMax}},
                min: 0,
                tickInterval: {{floor($pvMax/10)}}
            }
            ,
            exporting: {
                enabled: false
            }
            ,
            plotOptions: {
                area: {
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 2
                        }
                    },
                    threshold: null
                }
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
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                type:'area',
                name: '浏览量',
                //     数据
                data: [
                   @foreach($resPvUvEnd as $k=>$v)
                        [parseInt({{strtotime($k)}}000),{{$v['pv']}}],
                    @endforeach
                ]
            }]
        })
    });

    // uv
    $(function () {
        $('#chartuv').highcharts({
            title: {
                text: null,
                align:'left',
                style:{
                    fontWeight:'bold',
                    fontSize:'14px'
                }
            },
            credits:{
                enabled:false
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
                },
                title:{
                    text:"日期"
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
//            xAxis: {
//                categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26,27,28,29,30],
//                min: 0,
//                max: 31,
//                labels: {
//                    step: 2
//                },
//                title:{
//                    text:"日期"
//                }
//            },
            yAxis: {
                title: {
                    text: '访客数'
                },
                gridLineColor: '#eee', //横向网格线颜色
                gridLineDashStyle: 'solid', //横向网格线样式
                gridLineWidth: 1, //横向网格线宽度
                max: {{$uvMax}},
                min: 0,
                tickInterval: {{floor($uvMax/10)}}
            },
            legend: {
                enabled: false
            },
            exporting: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[2]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[2]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
                type: 'area',
                name: '访客数',
                data: [
                        @foreach($resPvUvEnd as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v['uv']}}],
                    @endforeach
                ]
            }]
        });
    });

    // 地区分布图
    var myChart = echarts.init(document.getElementById('chartmap'));
    option = {
        tooltip: {
//            trigger: 'item'
        },
        visualMap: {
            min: 0,
            max: {{$mapMax}},
            left: 'left',
            top: 'bottom',
            text: ['高','低'],           // 文本，默认为数值文本
            calculable: true,
            inRange: {
                color: ['#e0ffff', '#006edd']
            },
            outOfRange:{
                color:['#f00']
            }
        },
        toolbox: {
            show: false,
            orient: 'vertical',
            left: 'right',
            top: 'center',
            feature: {
                dataView: {readOnly: false},
                restore: {},
                saveAsImage: {}
            }
        },
        itemStyle:{
            emphasis:{
                areaColor:'#000',
                color:'#000'
            }
        },
        series: [
            {
                name: '浏览量',
                type: 'map',
                mapType: 'china',
                roam: false,
                data:[
                    @foreach($resMapEnd as $k=>$v)
                    {name:'{{$k}}',value:{{$v}}},
                    @endforeach
                    {name:'南海诸岛',value:0}
//                    {name: '北京',value: 20},
//                    {name: '天津', value:0 },
//                    {name: '上海', value:0 },
//                    {name: '重庆',value:0 },
//                    {name: '河北',value:0 },
//                    {name: '河南',value: 200 },
//                    {name: '云南',value: 0 },
//                    {name: '辽宁',value: 0 },
//                    {name: '黑龙江',value:0 },
//                    {name: '湖南',value: 0 },
//                    {name: '安徽',value: 0 },
//                    {name: '山东',value: 150 },
//                    {name: '新疆',value: 0 },
//                    {name: '江苏',value: 60 },
//                    {name: '浙江',value: 0 },
//                    {name: '江西',value: 0 },
//                    {name: '湖北',value: 0 },
//                    {name: '广西',value: 0 },
//                    {name: '甘肃',value: 0 },
//                    {name: '山西',value: 0 },
//                    {name: '内蒙古',value: 0 },
//                    {name: '陕西',value: 0},
//                    {name: '吉林',value: 0 },
//                    {name: '福建',value: 0 },
//                    {name: '贵州',value: 0 },
//                    {name: '广东',value: 300 },
//                    {name: '青海',value: 30 },
//                    {name: '西藏',value: 0 },
//                    {name: '四川',value: 0 },
//                    {name: '宁夏',value: 0 },
//                    {name: '海南',value: 0 },
//                    {name: '台湾',value: 0 },
//                    {name: '香港',value: 0 },
//                    {name: '澳门',value: 0 }
                ]
            }
        ]
    };
    myChart.setOption(option);



    // 表格高度
    $(function(){
        if($(window).width()<996){
            $('#check').height('auto');
        }
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


        // 获取搜索时间
        {{--$('#submit').click(function() {--}}

            {{--var begintime = $('#dateinfo').val();--}}

            {{--var endtime = $('#datebut').val();--}}
            {{--console.log(begintime);--}}
            {{--window.location.href =  "{{asset('admin/census/traffic')}}"+'?btime='+begintime+'&etime='+endtime;--}}

        {{--});--}}


</script>
@endsection