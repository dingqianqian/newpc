@extends("admin.layout.layout")
		@section("title","注册用户")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
			<link rel="stylesheet" href="{{asset("admin/css/z_rceived.css")}}">
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
						<b>-销售明细</b>
						<!--<span class="pull-right">
		<a href="#" class="btn btn-default btn-xs"><i></i>用户充值</a>
	</span>-->
					</div>
				</div>
			</section>

			<!-- 内容 -->
			<section class="content container-fluid">
				<!--统计-->
				<div class="panel panel-default search">
					<div class="panel panel-body">
						<ul class="z-ul">
							<li>注册用户总量: <span>{{$count}}</span></li>
						</ul>
					</div>
				</div>
				<!--搜索-->
				<div class="panel panel-default search">
					<div class="panel panel-body" id="xiugaiInput">
						<form class="form-inline" action="{{route('register.list')}}" method="get">
							<!--日期-->
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="dateinfo" name="start_time" placeholder="开始时间" value="{{$info['start_time']}}"> --
									<input type="text" class="form-control input-sm" placeholder="结束时间"  id="datebut" onClick="jeDate({dateCell:'#datebut',isTime:true,format:'YYYY年MM月DD日'})" name="end_time" value="{{$info['end_time']}}">
							</div>
							{{--<!--所有分类-->
							<div class="form-group">
								<select id="select" name="area">
									<option value="0">所有地区</option>
									@foreach($areaInfo as $k=>$v)
									<option value="{{$v['id']}}" @if($info['area']==$v['id']) selected @endif>{{$v['name']}}</option>
									@endforeach
								</select>
							</div>
							<!--所有分类-->
							<div class="form-group">
								<select id="selecta" name="employee">
									<option value="0">所有员工</option>
									@foreach($employeeInfo as $k=>$v)
									<option value="{{$v['id']}}" @if($info['employee']==$v['id']) selected @endif>{{$v['username']}}</option>
									@endforeach
								</select>
							</div>--}}
							{{csrf_field()}}
							<button type="submit" class="btn btn-success btn-sm">搜索</button>
						</form>
					</div>
				</div>
				<!--表格-->
				<form class="form-inline table-responsive">
					<table class="table table-bordered table-hover text-center">
						<thead>
							<tr>
								<th>
									<label class="checkbox inline">
				{{--<input type="checkbox" id="checkAll" value="option1">--}}编号
						</label>
								</th>
								<th>账户</th>
								<th>用户名</th>
								<th>酒店名称</th>
								<th>所在地区</th>
								<th>注册时间</th>
								<th>绑定时间</th>
								<th>绑定时所属员工</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
						@foreach($userInfo['data'] as $k=>$v)
							<tr>
								<td>
									{{--<input type="checkbox" />--}}{{$v['id']}}
								</td>
								<td>{{$v['signin_name']}}</td>
								<td>{{$v['username']?$v['username']:"未填写"}}</td>
								<td>{{$v['hotel_name']?$v['hotel_name']:"未填写"}}</td>
								<?php $temp=$v['employee']?$v['employee']['f_area_id']-1:0; ?>
								<td>{{$areaInfo[$temp]['name']}}</td>
								<td>{{date("Y-m-d H:i:s",$v['create_time'])}}</td>
								<td>{{$v['bind_employee_time']?date("Y-m-d H:i:s",$v['bind_employee_time']):"未绑定"}}</td>
								<td>{{$v['employee']?$v['employee']['username']:"未绑定"}}</td>
								<td>
									<a href="{{url("admin/sell/info")}}/{{$v['id']}}/3" class="edit" title="查看详情"><img src="{{asset("admin/img/details.png")}}" alt=""></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</form>
				{{$userInfos->appends(["start_time"=>"{$info['start_time']}","end_time"=>"{$info['end_time']}"])->links()}}
			</section>

			<!-- Footer -->
			@component("admin.layout.footer")
				@endcomponent

		</div>
		<!-- /.content-wrapper -->

@endsection

@section("js")
	<script src="{{asset("admin/js/distpicker.data.js")}}"></script>
	<script src="{{asset("admin/js/distpicker.js")}}"></script>
	<script src="{{asset("admin/js/jedate.min.js")}}"></script>
	<script src="{{asset("admin/js/jquery.searchableSelect.js")}}"></script>
	<script>
		// 下拉搜索
		$(function() {
			$('#select').searchableSelect();
			$('#selecta').searchableSelect();
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
			})
		});
// 屏幕变化，用于测试
$(window).resize(function() {
	if($(window).width() < 768) {
		$('div.searchable-select').css('width', '100%');
		$('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%');
	} else {
		$('div.searchable-select').css('width', '160px');
		$('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto');
	}
});
$(function() {
	if($(window).width() < 768) {
		$('div.searchable-select').css('width', '100%')
		$('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%');
	} else {
		$('div.searchable-select').css('width', '160px');
		$('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto');
	}
})
		// 下拉搜索
		$(function() {
			// 全选
			$('#checkAll').click(function() {
				// 保存当前状态
				var ischecked = $(this).prop('checked');
				// 遍历check
				$('tbody>tr>td>label>input').each(function(k, v) {
					$(v).prop('checked', ischecked);
				});
			});
			// 点击选择
			$('tbody>tr>td>input').unbind('click').click(function() {
				var flag = true;
				if($(this).prop('checked')) {
					$('tbody>tr>td>input').not('#checkAll').each(function(k, v) {
						if($(v).prop('checked') == false) {
							flag = false;
							return false;
						}
					});
				} else {
					flag = false;
				}
				if(flag) {
					$('#checkAll').prop('checked', 'checked');
				} else {
					$('#checkAll').prop('checked', false);
				}
			});
		})
	</script>
@endsection