@extends("admin.layout.layout")
		@section("title","充值信息")
		@section("css")
			<link rel="stylesheet" href="{{asset('admin/css/ly_memberDetail.css')}}">
		@endsection

@section("content")


			<div class="content-wrapper">
				<section class="content-header">
					<div class="panel panel-default">
						<div class="panel-body">
							<b>
						<a href="javascript:;">宜优速 管理中心</a>
					</b>
							<b>-充值查询</b>
							<span class="pull-right">
			<a href="{{route("recharge.list")}}" class="btn btn-sm btn-default"><i></i>充值列表</a>
		</span>
						</div>
					</div>
				</section>
				<!-- 内容 -->
				<section class="content container-fluid">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="fontSize">
							<tbody>
							<tr>
								<td class="col-xs-3">用户酒店:</td>
								<td class="col-xs-3">{{$rechargeInfo['user']['hotel_name']?$rechargeInfo['user']['hotel_name']:"未填写"}}</td>
								<td class="col-xs-3">用户手机号:</td>
								<td class="col-xs-3">{{$rechargeInfo['user']['signin_name']}}</td>
							</tr>
							<tr>
								<td class="col-xs-3">充值金额:</td>
								<td class="col-xs-3">{{number_format($rechargeInfo['price'],2,".","")}}</td>
								<td class="col-xs-3">返现金额:</td>
								<td class="col-xs-3">{{number_format($rechargeInfo['give_back'],2,".","")}}</td>
							</tr>
							<tr>
								<td class="col-xs-3">支付方式:</td>
								<td class="col-xs-3">{{$rechargeInfo['pay_type']['name']}}</td>
								<td class="col-xs-3">支付时间:</td>
								<td class="col-xs-3">{{date("Y-m-d H:i:s",$rechargeInfo['pay_time'])}}</td>
							</tr>
							<tr>
								<td class="col-xs-3">创建时间:</td>
								<td class="col-xs-3">{{date("Y-m-d H:i:s",$rechargeInfo['create_time'])}}</td>
								<td class="col-xs-3">充值单号:</td>
								<td class="col-xs-3">{{$rechargeInfo['no']}}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</section>
				<!-- Footer -->
				@component("admin.layout.footer")
					@endcomponent
			</div>
@endsection