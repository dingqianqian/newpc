@extends("admin.layout.layout")
	@section("title","后台首页")
@section("content")

	<div class="content-wrapper">
		<!-- Content Header -->
		<section class="content-header">
			<div class="panel panel-default">
				<div class="panel-body">
					<b>
						<a href="javascript:;">宜优速 管理中心</a>
					</b>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--表格-->
			<div class="table-responsive">
				<!--订单统计信息-->
				<table class="table table-bordered table-hover">
					<thead>
					<tr class="active">
						<th colspan="4">订单统计信息</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td class="col-xs-3"><a href="javascript:;">待发货订单</a></td>
						<td class="col-xs-3 coloR">{{$orderInfo[1]}}</td>
						<td class="col-xs-3"><a href="javascript:;">待支付订单</a></td>
						<td class="col-xs-3">{{$orderInfo[2]}}</td>
					</tr>
					<tr>
						<td class="col-xs-3"><a href="javascript:;">已成交订单数</a></td>
						<td class="col-xs-3">{{$orderInfo[3]}}</td>
						<td class="col-xs-3"><a href="javascript:;">退/换货申请</a></td>
						<td class="col-xs-3">{{$orderInfo[4]}}</td>
					</tr>
					<tr>
						{{--<td class="col-xs-3"><a href="javascript:;">发票申请</a></td>
						<td class="col-xs-3">{{$orderInfo[5]}}</td>--}}
						<td class="col-xs-3"><a href="javascript:;">催单申请</a></td>
						<td class="col-xs-3">{{$orderInfo[6]}}</td>
					</tr>
					</tbody>
				</table>
				<!--实体商品统计信息-->
				<table class="table table-bordered table-hover">
					<thead>
					<tr class="active">
						<th colspan="4">实体商品统计信息</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td class="col-xs-3"><a href="javascript:;">商品类目总数</a></td>
						<td class="col-xs-3">14</td>
						<td class="col-xs-3"><a href="javascript:;">商品数量</a></td>
						<td class="col-xs-3">{{$goodsInfo[2]}}</td>
					</tr>
					{{--<tr>
						<td class="col-xs-3"><a href="javascript:;">已成交订单数</a></td>
						<td class="col-xs-3">1</td>
						<td class="col-xs-3"><a href="javascript:;">退/换货申请</a></td>
						<td class="col-xs-3">2</td>
					</tr>
					<tr>
						<td class="col-xs-3"><a href="javascript:;">库存警告数</a></td>
						<td class="col-xs-3 coloR">1</td>
						<td class="col-xs-3"><a href="javascript:;">催单申请</a></td>
						<td class="col-xs-3">2</td>
					</tr>--}}
					</tbody>
				</table>
				<!--销售统计信息-->
				<table class="table table-bordered table-hover">
					<thead>
					<tr class="active">
						<th colspan="4">销售统计信息</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td class="col-xs-3"><a href="javascript:;">销售总额</a></td>
						<td class="col-xs-3">{{number_format($sellInfo[1],2,".","")}}</td>
						<td class="col-xs-3"><a href="javascript:;">新增用户数</a></td>
						<td class="col-xs-3">{{$sellInfo[2]}}</td>
					</tr>
					{{--<tr>
						<td class="col-xs-3"><a href="javascript:;">新增会员数</a></td>
						<td class="col-xs-3">{{$sellInfo[3]}}</td>
						--}}{{--<td class="col-xs-3"><a href="javascript:;">退/换货申请</a></td>
						<td class="col-xs-3">2</td>--}}{{--
					</tr>--}}
					{{--<tr>
						<td class="col-xs-3"><a href="javascript:;">新增会员数</a></td>
						<td class="col-xs-3 coloR">1</td>
						<td class="col-xs-3"><a href="javascript:;"></a></td>
						<td class="col-xs-3">2</td>
					</tr>--}}
					</tbody>
				</table>
				<!--访问统计-->
				<table class="table table-bordered table-hover">
					<thead>
					<tr class="active">
						<th colspan="4">访问统计</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td class="col-xs-3"><a href="javascript:;">浏览量</a></td>
						<td class="col-xs-3">{{$result["sum"][0][0]}}</td>
						<td class="col-xs-3"><a href="javascript:;">访客数</a></td>
						<td class="col-xs-3">{{$result["sum"][0][1]}}</td>
					</tr>
					{{--<tr>
						<td class="col-xs-3"><a href="javascript:;">已成交订单数</a></td>
						<td class="col-xs-3">1</td>
						<td class="col-xs-3"><a href="javascript:;">退/换货申请</a></td>
						<td class="col-xs-3">2</td>
					</tr>
					<tr>
						<td class="col-xs-3"><a href="javascript:;">新增会员数</a></td>
						<td class="col-xs-3 coloR">1</td>
						<td class="col-xs-3"><a href="javascript:;"></a></td>
						<td class="col-xs-3">2</td>
					</tr>--}}
					</tbody>
				</table>
			</div>
			<div class="table-responsive">
				<!--统计信息-->
				<table class="table table-bordered table-hover">
					<thead>
					<tr class="active">
						<th colspan="4">统计信息</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td class="col-xs-3">服务器操作系统:</td>
						<td class="col-xs-3">Linux</td>
						<td class="col-xs-3">Web 服务器:</td>
						<td class="col-xs-3">{{$_SERVER['SERVER_SOFTWARE']}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">服务器端口:</td>
						<td class="col-xs-3">{{$_SERVER['SERVER_PORT']}}</td>
						<td class="col-xs-3">服务器域名:</td>
						<td class="col-xs-3">{{$_SERVER['SERVER_NAME']}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">数据库类型:</td>
						<td class="col-xs-3">{{$_SERVER['DB_CONNECTION']}}</td>
						<td class="col-xs-3">服务器IP:</td>
						<td class="col-xs-3">{{$_SERVER['SERVER_ADDR']}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">编码:</td>
						<td class="col-xs-3">UTF-8</td>
						<td class="col-xs-3">PHP版本:</td>
						<td class="col-xs-3">5.6.3</td>
					</tr>
					</tbody>
				</table>
			</div>
		</section>

		@component("admin.layout.footer")
			@endcomponent

	</div>
	<!-- /.content-wrapper -->
@endsection
