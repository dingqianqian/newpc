@extends("admin.layout.layout")
		@section("title","欢迎页")
		@section("css")
			<link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
		@endsection
@section("content")
<!--   LY 起始页+++++   -->
<div class="adminListTop">
	<b>
		<a href="javascript:;">宜优速 管理中心</a>
	</b>
</div>
<!--  内容  -->
<div class="startCon">
	<table>
		<tbody>
		<tr>
			<th colspan="4">订单统计信息</th>
		</tr>
		<tr>
			<td width="20%"><a href="javascript:;">待发货订单</a></td>
			<td width="30%" class="startRed"><b>{{$orderInfo[1]}}</b></td>
			<td width="20%"><a href="javascript:;">待支付订单</a></td>
			<td width="30%"><b>{{$orderInfo[2]}}</b></td>
		</tr>
		<tr>
			<td width="20%"><a href="javascript:;">已成交订单数</a></td>
			<td width="30%"><b>{{$orderInfo[3]}}</b></td>
			<td width="20%"><a href="javascript:;">退/换货申请</a></td>
			<td width="30%"><b>{{$orderInfo[4]}}</b></td>
		</tr>
		<tr>
			<td width="20%"><a href="javascript:;">发票申请</a></td>
			<td width="30%"><b>{{$orderInfo[5]}}</b></td>
			<td width="20%"><a href="javascript:;">催单申请</a></td>
			<td width="30%"><b>{{$orderInfo[6]}}</b></td>
		</tr>
		</tbody>
	</table>
	<table>
		<tbody>
		<tr>
			<th colspan="4">实体商品统计信息</th>
		</tr>
		<tr>
			<td width="20%">商品类目总数</td>
			<td width="30%"><b>1</b></td>
			<td width="20%">当日入库商品数</td>
			<td width="30%"><b>2</b></td>
		</tr>
		<tr>
			<td width="20%">当日出库商品数</td>
			<td width="30%"><b>3</b></td>
			<td width="20%">热签商品数</td>
			<td width="30%"><b>4</b></td>
		</tr>
		<tr>
			<td width="20%">库存警告商品数</td>
			<td width="30%" class="startRed"><b>5</b></td>
			<td width="20%"></td>
			<td width="30%"><b></b></td>
		</tr>
		</tbody>
	</table>
	<table>
		<tbody>
		<tr>
			<th colspan="4">销售统计信息</th>
		</tr>
		<tr>
			<td width="20%"><a href="javascript:;">销售总额</a></td>
			<td width="30%"><b>1</b></td>
			<td width="20%"><a href="javascript:;">新增用户数</a></td>
			<td width="30%"><b>2</b></td>
		</tr>
		<tr>
			<td width="20%"><a href="javascript:;">新增会员数</a></td>
			<td width="30%"><b>3</b></td>
			<td width="20%"><a href="javascript:;">退/换货申请</a></td>
			<td width="30%"><b>4</b></td>
		</tr>
		<tr>
			<td width="20%"><a href="javascript:;">发票申请</a></td>
			<td width="30%"><b>5</b></td>
			<td width="20%"><a href="javascript:;">催单申请</a></td>
			<td width="30%"><b>6</b></td>
		</tr>
		</tbody>
	</table>
	<table>
		<tbody>
		<tr>
			<th colspan="4">访问统计</th>
		</tr>
		<tr>
			<td width="20%">PV页面访问量</td>
			<td width="30%"><b>1</b></td>
			<td width="20%">UV独立客户访问量</td>
			<td width="30%"><b>2</b></td>
		</tr>
		<tr>
			<td width="20%"><a href="javascript:;">反馈留言</a></td>
			<td width="30%"><b>3</b></td>
			<td width="20%"><a href="javascript:;">不良评论</a></td>
			<td width="30%"><b>4</b></td>
		</tr>
		<tr>
			<td width="20%"><a href="javascript:;">发票申请</a></td>
			<td width="30%"><b>5</b></td>
			<td width="20%"><a href="javascript:;">催单申请</a></td>
			<td width="30%"><b>6</b></td>
		</tr>
		</tbody>
	</table>
	<table>
		<tbody>
		<tr>
			<th colspan="4">系统信息</th>
		</tr>
		<tr>
			<td width="20%">服务器操作系统:</td>
			<td width="30%">Linux</td>
			<td width="20%">Web 服务器:</td>
			<td width="30%">{{$_SERVER['SERVER_SOFTWARE']}}</td>
		</tr>
		<tr>
			<td width="20%">服务器端口:</td>
			<td width="30%">{{$_SERVER['SERVER_PORT']}}</td>
			<td width="20%">服务器域名:</td>
			<td width="30%">{{$_SERVER['SERVER_NAME']}}</td>
		</tr>
		<tr>
			<td width="20%">数据库类型:</td>
			<td width="30%">{{$_SERVER['DB_CONNECTION']}}</td>
			<td width="20%">服务器IP:</td>
			<td width="30%">{{$_SERVER['SERVER_ADDR']}}</td>
		</tr>
		<tr>
			<td width="20%">编码:</td>
			<td width="30%">UTF-8</td>
			<td width="20%">PHP版本:</td>
			<td width="30%">5.6.3</td>
		</tr>
		</tbody>
	</table>
</div>
	@component("admin.layout.footer")
	@endcomponent
@endsection