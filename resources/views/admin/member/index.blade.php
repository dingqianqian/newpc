@extends("admin.layout.layout")
		@section("title","会员列表")
		@section("css")
			<link rel="stylesheet" href="{{asset('admin/css/reset.min.css')}}">
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
					<b>-会员列表</b>
		<!--<span class="pull-right">
			<a href="" class="btn btn-default btn-xs"><i></i>添加会员</a>
		</span>-->
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			{{--统计--}}
			<div class="panel panel-default dl_Commodity_panel">
				<div class="panel panel-body">
					<ul class="z-ul">
						<li>注册会员数: <span>{{$count['user']}}</span></li>
						<li>黄金会员数: <span>{{$count['user2']}}</span></li>
						<li>普通会员数: <span>{{$count['user1']}}</span></li>
						<li>钱包金额: <span>{{$count['wallet']}}</span></li>
					</ul>
				</div>
			</div>
			<!--搜索-->
			<div class="panel panel-default dl_Commodity_panel" style="font-weight: normal">
				<div class="panel panel-body" id="xiugaiInput">
					<form class="form-inline" action="{{route("member.list")}}" method="get">
						<div class="form-group">
							<input type="text" class="form-control input-sm" id="exampleInputName2" name="phone" placeholder="用户手机号" value="{{$info['phone']}}">
						</div>
						<div class="form-group">
							<input type="text" class="form-control input-sm" id="exampleInputEmail2" name="hotel_name" placeholder="酒店名称" value="{{$info['hotel_name']}}">
						</div>
						<div class="form-group">
							酒店金额:
							<input type="text" class="form-control input-sm" name="min_wallet" value="{{$info['min_wallet']}}"> -- <input type="text" class="form-control input-sm" name="max_wallet" value="{{$info['max_wallet']}}">
						</div>
						<div class="form-group">
							<select id="select" name="level">
								<option value="0">会员等级</option>
								<option value="1" @if($info['level']==1) selected @endif>普通会员</option>
								<option value="2" @if($info['level']==2) selected @endif>黄金会员</option>
							</select>
						</div>
						{{--<div class="form-group">
							<input type="text" class="form-control input-sm" placeholder="绑定员工">
						</div>--}}
						{{csrf_field()}}
						<button type="submit" class="btn btn-success btn-sm">搜索</button>
					</form>
				</div>
			</div>
			<!--表格-->
			<div class="panel panel-default">
			<form class="form-inline table-responsive">
				<table class="table table-bordered table-hover text-center">
					<thead>
					<tr>
						<th>用户ID</th>
						<th>用户名</th>
						<th>注册时间</th>
						<th>钱包金额</th>
						<th>充值金额</th>
						<th>返现金额</th>
						<th>签到金额</th>
						<th>所剩积分</th>
						<th>会员等级</th>
						<th>酒店名称</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					@foreach($userInfo['data'] as $k=>$v)
					<tr>
						<td>{{$v['id']}}</td>
						<td>{{$v['signin_name']}}</td>
						<td>{{date("Y-m-d H:i:s",$v['create_time'])}}</td>
						<td>{{number_format($v['wallet'],2,".","")}}</td>
						<td>{{number_format($v['recharge_price'],2,".","")}}</td>
						<td>{{number_format($v['give_back'],2,".","")}}</td>
						<td>{{number_format($v['check_price'],2,".","")}}</td>
						<td>{{$v['integral']}}</td>
						@if($v['f_vip_level_id']==1)
						<td><img src="{{asset("admin/img/putong.png")}}" title="普通会员" alt=""></td>
						@else
						<td><img src="{{asset("admin/img/huangjin.png")}}" title="黄金会员" alt=""></td>
						@endif
						<td>{{$v['hotel_name']}}</td>
						<td>
							<a href="{{route('member.info',['id'=>$v['id']])}}" class="edit" title="查看详情"><img src="{{asset("admin/img/details.png")}}" alt=""></a>
						</td>
					</tr>
						@endforeach
					</tbody>
				</table>
				{{$userInfos->appends(['phone'=>$info['phone'],'hotel_name'=>$info['hotel_name'],"min_wallet"=>$info['min_wallet'],'max_wallet'=>$info['max_wallet'],'level'=>$info['level']])->links()}}
			</form>
			</div>
		</section>

		@component("admin.layout.footer")
			@endcomponent

	</div>
	<!-- /.content-wrapper -->
@endsection
@section("js")
<script>
	// 下拉搜索
	$(function(){
		$('#select').searchableSelect();
		$('#ly_select').searchableSelect();
	});
    $(window).resize(function() {
        if($(window).width() < 768) {
            $('div.searchable-select').css('width', '100%');
            $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%');

        }else {
            $('div.searchable-select').css('width', '140px');
            $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto');
        }
    });
    $(function() {
        if($(window).width() < 768) {
            $('div.searchable-select').css('width', '100%')
            $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%');
        }else {
            $('div.searchable-select').css('width', '160px');
            $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto');
        }
    })
</script>
@endsection