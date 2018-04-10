@extends("admin.layout.layout")
		@section("title","会员详情")
		@section("css")
			<link rel="stylesheet" href="{{asset('admin/css/ly_memberDetail.css')}}">
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
					<b>-会员详情</b>
					<span class="pull-right">
						@if($type==0)
						<a href="{{route("register.list")}}" class="btn btn-default btn-xs"><i></i>注册用户</a>
						@endif
						@if($type==1)
						<a href="{{route("money.list")}}" class="btn btn-default btn-xs"><i></i>成交用户</a>
							@endif
						@if($type==3)
								<a href="{{route("personRegister.list")}}" class="btn btn-default btn-xs"><i></i>成交用户</a>
							@endif
						@if($type==4)
								<a href="{{route("personMoney.list")}}" class="btn btn-default btn-xs"><i></i>成交列表</a>
							@endif
					</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--搜索-->
			<!--<div class="panel panel-default search">
				<div class="panel panel-body" id="xiugaiInput">
					<form class="form-inline">
						<div class="form-group">
							输入评论内容
							<input type="text" class="form-control input-sm" id="exampleInputName2">
						</div>
						<button type="button" class="btn btn-success btn-sm">搜索</button>
					</form>
				</div>
			</div>-->
			<!--表格-->
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="fontSize">
					<tbody>
					<tr>
						<td class="col-xs-3">用户ID:</td>
						<td class="col-xs-3">{{$userInfo['id']}}</td>
						<td class="col-xs-3">注册时间:</td>
						<td class="col-xs-3">{{date("Y-m-d H:i:s",$userInfo['create_time'])}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">用户名:</td>
						<td class="col-xs-3">{{$userInfo['username']}}</td>
						<td class="col-xs-3">钱包金额:</td>
						<td class="col-xs-3">{{number_format($userInfo['wallet'],2,".","")}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">返现金额:</td>
						<td class="col-xs-3">{{number_format($userInfo['give_back'],2,".","")}}</td>
						<td class="col-xs-3">邮箱:</td>
						<td class="col-xs-3">{{$userInfo['email']?$userInfo['email']:"未填写"}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">所剩积分:</td>
						<td class="col-xs-3">{{$userInfo['integral']}}</td>
						<td class="col-xs-3">电话:</td>
						<td class="col-xs-3">{{$userInfo['signin_name']}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">酒店名称:</td>
						<td class="col-xs-3">{{$userInfo['hotel_name']?$userInfo['hotel_name']:"未填写"}}</td>
						<td class="col-xs-3">性别:</td>
						<td class="col-xs-3">{{$userInfo['sex']?"男":"女"}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">充值金额:</td>
						<td class="col-xs-3">{{number_format($userInfo['recharge_price'],2,".","")}}</td>
						<td class="col-xs-3">密码:</td>
						<td class="col-xs-3">{{$userInfo['pwd']}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">签到金额:</td>
						<td class="col-xs-3">{{number_format($userInfo['check_price'],2,".","")}}</td>
						<td class="col-xs-3">生日:</td>
						<td class="col-xs-3">{{date("Y-m-d",$userInfo['birthday'])}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">会员等级:</td>
						<td class="col-xs-3">{{$userInfo['f_vip_level_id']==1?"普通会员":"黄金会员"}}</td>
						<td class="col-xs-3">绑定员工:</td>
						<td class="col-xs-3">{{$userInfo['employee']['username']?$userInfo['employee']['username']:"未绑定"}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">绑定时间:</td>
						<td class="col-xs-3">{{date("Y-m-d H:i:s",$userInfo['bind_employee_time'])}}</td>
						<td>酒店电话:</td>
						<td class="col-xs-3">{{$userInfo['hotel_tel']?$userInfo['hotel_tel']:"未填写"}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">酒店房间数量:</td>
						<td class="col-xs-3">{{$userInfo['hotel_room_num']}}</td>
						<td class="col-xs-3">酒店等级:</td>
						<td class="col-xs-3">{{$userInfo['hotel_level']}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">用户类型:</td>
						<td class="col-xs-3">{{$userInfo['is_company_user']?"企业用户":"个人用户"}}</td>
						<td class="col-xs-3">速立付冻结时间:</td>
						<td class="col-xs-3">{{$userInfo['disable_time']>time()?date("Y-m-d H:i:s",$userInfo['disable_time']):"未被冻结"}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">订单支付总金额:</td>
						<td class="col-xs-3">{{number_format($userInfo['order_price'],2,".","")}}</td>
						<td class="col-xs-3">钱包支付总金额:</td>
						<td class="col-xs-3">{{number_format($userInfo['wallet_price'],2,".","")}}</td>
					</tr>
					<tr>
						<td class="col-xs-3">微信支付总金额:</td>
						<td class="col-xs-3">{{number_format($userInfo['weixin_price'],2,".","")}}</td>
						<td class="col-xs-3">支付宝支付总金额:</td>
						<td class="col-xs-3">{{number_format($userInfo['ali_price'],2,".","")}}</td>
					</tr>
					</tbody>
				</table>
			</div>
		</section>

		<!-- Footer -->
		@component("admin.layout.footer")
			@endcomponent

	</div>
	<!-- /.content-wrapper -->

@endsection
