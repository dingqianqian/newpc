@extends("admin.layout.layout")
		@section("title","销售统计")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
			<link rel="stylesheet" href="{{asset("admin/css/z_rceived.css")}}">
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
			<b>-销售概况</b>
			<!--<span class="pull-right">
	<a href="#" class="btn btn-default btn-xs"><i></i>用户充值</a>
</span>-->
		</div>
	</div>
</section>

<!-- 内容 -->
<section class="content container-fluid">
	<!--搜索-->
	<div class="panel panel-default dl_Commodity_panel" style="font-weight: normal; font-size: 12px">
		<div class="panel panel-body" id="xiugaiInput">
			<form class="form-inline" method="get" action="{{route("sellCensus.index")}}">
				<!--开始时间-->
				<div class="form-group">
					<span>开始日期：</span>
					<input type="text" class="form-control input-sm" id="dateinfo" name="start_time" value="{{$info['start_time']}}">
				</div>
				<!--所有分类-->
				<div class="form-group" >
					<select id="select" name="area">
						<option value="0">所有地区</option>
						@foreach($areaInfo as $k=>$v)
						<option value="{{$v['id']}}" @if($v['id']==$info['area']) selected @endif>{{$v['name']}}</option>
							@endforeach
					</select>
				</div>
				<button type="submit" class="btn btn-success btn-sm">搜索</button>
			</form>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<!-- 订单走势 -->
			<div class="col-md-6 table-responsive">
				<table class="table table-bordered">
					<tbody>
					<tr style="font-size: 1.2em;">
						<td><b>订单走势图</b></td>
					</tr>
					<tr>
						<td>
							<div id="container"></div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<!-- 销售额度走势图  -->
			<div class="col-md-6 table-responsive">
				<table class="table table-bordered">
					<tbody>
					<tr style="font-size: 1.2em;">
						<td><b>销售额度走势图</b></td>
					</tr>
					<tr>
						<td>
							<div id="containera"></div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<!--销量排行-->
			<div class="col-md-6 table-responsive">
				<table class="table table-bordered">
					<tbody>
					<tr style="font-size: 1.2em;">
						<td><b>销量排行</b></td>
					</tr>
					@if($goodsSellNumber)
					<tr>
						<td style="vertical-align: middle;">
							<div class="table-responsive" style="overflow-y: hidden">
								<table class="table" style="margin:15px 0;">
									<thead>
									<tr>
										<td>商品名称</td>
										<td>购买次数</td>
										<td>占比</td>
									</tr>
									</thead>
									<tbody>
									@foreach($goodsSellNumber as $k=>$v)
									<tr>
										<td>
											{{$v['open_id']}}{{--<a href="javascript:;">http://pcyiyousu.com</a>--}}
										</td>
										<?php $id=$v['id'];?>
										<td>{{$sellNumber[$id]}}</td>
										<td><span style="background: #DCEBFE;">{{$sellNumberPercent[$id]}}</span>%</td>
									</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</td>
					</tr>
					@else
					<tr>
							<td>
								<h1 style="font-size: 24px;color: #aaa;margin: 30px;" class="text-center">
									<i class="fa fa-meh-o"></i>
									暂无数据
								</h1>
							</td>
						</tr>
					@endif
					</tbody>
				</table>
			</div>
			<!--区域内商品销售额排行-->
			<div class="col-md-6 table-responsive">
				<table class="table table-bordered">
					<tbody>
					<tr style="font-size: 1.2em;">
						<td><b>区域内商品销售额排行</b></td>
					</tr>
					@if($goodsSellMoney)
					<tr>
						<td>
							<div id="containerb"></div>
						</td>
					</tr>
						@else
					<tr>
						<td>
							<h1 style="font-size: 24px;color: #aaa;margin: 30px;" class="text-center">
								<i class="fa fa-meh-o"></i>
								暂无数据
							</h1>
						</td>
					</tr>

					@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<!-- Footer -->
@component("admin.layout.footer")
	@endcomponent

</div>
@endsection

@section("js")
<script src="{{asset("admin/js/distpicker.data.js")}}"></script>
<script src="{{asset("admin/js/distpicker.js")}}"></script>
<script src="{{asset("admin/js/jedate.min.js")}}"></script>
<script src="{{asset("admin/js/jquery.searchableSelect.js")}}"></script>
<script src="{{asset("admin/js/highcharts.js")}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset("admin/js/highchart.config.js")}}" type="text/javascript"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!--<script src="js/echarts.min.js" type="text/javascript" charset="utf-8"></script>-->
<!--<script src="js/index.js" type="text/javascript" charset="utf-8"></script>-->
<script>
// 下拉搜索
$(function() {
	$('#select').searchableSelect();
	// 日期
	jeDate({
		dateCell: "#dateinfo",
		format: "YYYY年MM月DD日",
		isinitVal: true,
		isTime: true, //isClear:false,
		minDate: "1901-1-1",
		okfun: function(val) {
			alert(val)
		}
	});
});

$(function() {
	if($(window).width() < 768) {
		$('div.searchable-select').css('width', '100%')
		$('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%');
	} else {
		$('div.searchable-select').css('width', '160px');
		$('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto');
	}
});

//订单走势图
$(function () {
    $('#container').highcharts({

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
                text: '成交订单量'
            },
            gridLineColor: '#eee', //横向网格线颜色
            gridLineDashStyle: 'solid', //横向网格线样式
            gridLineWidth: 1, //横向网格线宽度
            max: {{max($count)*2>10?intval(max($count)*2):10}},
            min: 0,
            tickInterval: {{max($count)*2>10?floor(max($count)*2/10):1}}
        },
        legend: {
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
                        [0, Highcharts.getOptions().colors[9]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[9]).setOpacity(0).get('rgba')]
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
            name: '成交订单量',
            data: [
                @foreach($count as $k=>$v)
					[parseInt({{strtotime($k)}}000),{{$v}}],
				@endforeach
			]
        }]
    });
});

//销售额度走势图
$(function () {
        $('#containera').highcharts({

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
	                text: '销售额度'
	            }, 
	            gridLineColor: '#eee', //横向网格线颜色
				gridLineDashStyle: 'solid', //横向网格线样式
				gridLineWidth: 1, //横向网格线宽度
			    max: {{max($price)*2>10?intval(max($price)*2):10}},
				min: 0,
				tickInterval: {{max($price)*2>10?floor(max($price)*2/10):1}}
            },
            legend: {
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
                type: 'area',
                name: '销售额度',
            	data: [
						@foreach($price as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v}}],
					@endforeach
				]
            }]
    });
});

@if($goodsSellMoney)
//区域内商品
$(function () {
    $('#containerb').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: [
                @foreach($goodsSellMoney as $k=>$v)
					'{{$v['open_id']}}',
				@endforeach
			],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
			max:{{intval(max($sellMoney)*1.5)}},
            title: {
                text: null
            },
            labels: {
                overflow: 'justify'
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true,
                    allowOverlap: true
                }
            },
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}'
                }
            }
        },
        tooltip: {
            pointFormat: "{series.name}: {point.y:.2f}"
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        series: [{
            name: '销售额',
            data: [
				@foreach($goodsSellMoney as $k=>$v)
				{{number_format($sellMoney[$v['id']],2,".","")}},
				@endforeach
			]
        }]
    });
});
@endif


</script>
	@endsection
