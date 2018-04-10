@extends("admin.layout.layout")
		@section("title","订单统计")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
			<link rel="stylesheet" href="{{asset("admin/css/z_rceived.css")}}">
			<link rel="stylesheet" href="{{asset("admin/css/dl_css.css")}}">
			<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
			<![endif]-->
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
					<b>-订单统计</b>
					<!--<span class="pull-right">
	<a href="#" class="btn btn-default btn-xs"><i></i>用户充值</a>
</span>-->
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--统计-->
			<div class="panel panel-default dl_Commodity_panel">
				<div class="panel panel-body">
					<ul class="z-ul">
						<li>有效订单总金额: <span>¥{{number_format($orderPrice,2,".","")}}</span></li>
						<li>订单有效数量: <span>{{$orderCount}}</span></li>
					</ul>
				</div>
			</div>
			<!--搜索-->
			<div class="panel panel-default dl_Commodity_panel" style="font-size: 12px;font-weight: normal">
				<div class="panel panel-body" id="xiugaiInput">
					<form class="form-inline" action="{{route("orderCensus.index")}}">
						<!--开始时间-->
						<div class="form-group">
							{{--<label for="" style="margin-top: 4px; margin-right: 5px;">开始日期</label>--}}
							<span>开始日期：</span>
							<input type="text" class="form-control input-sm" id="dateinfo" name="start_time" value="{{$info['start_time']}}">
						</div>
						<!--结束时间-->
						{{--<div class="form-group">
							<label for="" style="margin-top: 4px; margin-right: 5px;">开始日期</label>
							<input type="text" class="form-control input-sm" id="datebut">
						</div>--}}

						<!--所有分类-->
						<div class="form-group">
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
			<!--图表-->
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
					<!-- 有效订单金额  -->
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
					<!-- 支付方式占比 -->
					<div class="col-md-6 table-responsive">
						<table class="table table-bordered">
							<tbody>
							<tr style="font-size: 1.2em;">
								<td><b>支付方式占比</b></td>
							</tr>
							<tr>
								<td>
									<div id="containerb"></div>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
					<!-- 有效订单金额  -->
					<div class="col-md-6 table-responsive">
						<table class="table table-bordered">
							<tbody>
							<tr style="font-size: 1.2em;">
								<td><b>支付方式金额</b></td>
							</tr>
							<tr>
								<td>
									<div id="containerc"></div>
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
@endsection

@section("js")
<script src="{{asset("admin/js/distpicker.data.js")}}"></script>
<script src="{{asset("admin/js/distpicker.js")}}"></script>
<script src="{{asset("admin/js/jedate.min.js")}}"></script>
<script src="{{asset("admin/js/jquery.searchableSelect.js")}}"></script>
<script src="{{asset("admin/js/highcharts.js")}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset("admin/js/highchart.config.js")}}" type="text/javascript"></script>
<!--<script src="js/highcharts-3d.js" type="text/javascript" charset="utf-8"></script>-->
<script>
	// 下拉搜索
	$(function() {
        $('#container').highcharts({
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
                    text: '订单数',
                    style: {
                        fontFamily: '宋体'
                    }
                }
                ,
                gridLineColor: '#eee', //横向网格线颜色
                gridLineDashStyle: 'solid', //横向网格线样式
                gridLineWidth: 1, //横向网格线宽度
                max:{{max($count)>10?max($count)*2:10}},
                min: 0,
                tickInterval: {{max($count)>10?floor(max($count)*2/10):1}}
            }
            ,
            legend: {
                enabled: true
            }
            ,
            exporting: {
                enabled: false
            }
            ,
            plotOptions: {
                line: {
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
            series: [{
                name: '全部会员',
                //     数据
                data: [
						@foreach($count as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v}}],
					@endforeach
                ]
            }, {

                    name: '普通会员',
                    //     数据
                    data: [
							@foreach($countP as $k=>$v)
                        [parseInt({{strtotime($k)}}000),{{$v}}],
						@endforeach
                    ]
				}, {
                name: '黄金会员',
                //     数据
                data: [
						@foreach($countH as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v}}],
					@endforeach
                ]
            }]
        })
        ;
	});

	//有效订单金额对比图
	$(function() {
		var chart = new Highcharts.Chart('containera', {
			title: {
				text: null,
				align: 'left',
				style: {
					fontWeight: 'bold',
					fontSize: '14px'
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
					text: '成交订单数'
				},
				max: {{max($price)>10?intval(max($price)*2):10}},
				min: 0,
				tickInterval: {{max($price)>10?intval(max($price)*2/10):1}}
			},
			plotOptions: {
				line: {
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
			},
            series: [{
                name: '全部会员',
                //     数据
                data: [
						@foreach($price as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v}}],
					@endforeach
                ]
            }, {

                name: '普通会员',
                //     数据
                data: [
						@foreach($priceP as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v}}],
					@endforeach
                ]
            }, {
                name: '黄金会员',
                //     数据
                data: [
						@foreach($priceH as $k=>$v)
                    [parseInt({{strtotime($k)}}000),{{$v}}],
					@endforeach
                ]
            }]
		});
	});
	//支付方式占比图
	$(function() {
		$('#containerb').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: {
				text: null,
				align: 'left',
				style: {
					fontWeight: 'bold',
					fontSize: '14px'
				}
			},
			credits:{
				enabled:false
			},
			tooltip: {
				headerFormat: '{series.name}<br>',
				pointFormat: '{point.name}: <b>{point.y:.1f}%</b>'
			},
		plotOptions: {
            pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				depth: 35,
				dataLabels: {
						 color:'black',
						 enabled: true,
						 formatter:function(){
					  		return '<b>'+this.point.name+'</b>:'+this.point.y.toFixed(2)+"%";
					    },
					    connectorWidth:0,
					    connectorPadding:0,
					    distance:-30
				   },
		         showInLegend: true
		    }
        },

			series: [{
				type: 'pie',
				name: '支付方式',
				data: [
					['支付宝', {{$aliPayPercent}}],
					['微信', {{$weixinPercent }}],
					{
						name: '速立付',
						y: {{$walletPercent}},
						sliced: true,
						selected: true
					},
				]
			}]
		});
	});
	//订单状态对比图、
	$(function() {
		$('#containerc').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: {
				text: null,
				align: 'left',
				style: {
					fontWeight: 'bold',
					fontSize: '14px'
				}
			},
			credits:{
				enabled:false // 禁用版权信息
			},
			tooltip: {
				headerFormat: '{series.name}<br>',
				pointFormat: '{point.name}: <b>{point.y:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					depth: 35,
					dataLabels: {
						color: 'black',
						enabled: true,
						formatter: function() {
							return '<b>' + this.point.name + '</b>:' + this.y.toFixed(2) + "%";
						},
						connectorWidth: 0,
						connectorPadding: 0,
						distance: -50,
					},
		         showInLegend: true,
				}
			},
			series: [{
				type: 'pie',
				name: '订单金额',
				data: [
					['微信', {{$weixinPrice}}],
					['支付宝', {{$aliPayPrice}}],
					{
						name: '速立付',
						y:{{$walletPrice}},
						sliced: true,
						selected: true
					}
				]
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
    $("#select").searchableSelect();

    $(window).resize(function() {
        if($(window).width() < 768) {
            $('div.searchable-select').css('min-width', '100%');
            $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%')
        } else {
            $('div.searchable-select').css('width', '160px');
            $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto')
        }
    });
    $(function() {
        if($(window).width() < 768) {
            $('div.searchable-select').css('min-width', '100%')
            $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%')
        } else {
            $('div.searchable-select').css('width', '160px');
            $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto')
        }
    });
</script>
@endsection