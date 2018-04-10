@extends("admin.layout.layout")
		@section("title","添加管理员")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
			<link rel="stylesheet" href="{{asset("admin/css/ly_addAdmin.css")}}">
		@endsection
@section("content")
	<div class="content-wrapper">
		<!--header-->
		<section class="content-header">
			<div class="panel panel-default">
				<div class="panel-body">
					<b>
						<a href="javascript:;">宜优速 管理中心</a>
					</b>
					<b>-添加管管理员</b>
		<span class="pull-right">
			<a href="{{route('employee.list')}}" class="btn btn-default btn-xs"><i></i>管理员列表</a>
		</span>
				</div>
			</div>
		</section>
		<!-- 内容 -->
		<section class="content container-fluid">
			<form class="form-horizontal" action="{{url('admin/employee/update')}}/{{$employeeInfo['id']}}" method="post">
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<!--用户名-->
				<div class="form-group">
					<label for="username" class="control-label col-xs-4">用户名</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="username" name="signin_name" value="{{$employeeInfo['signin_name']}}">
					</div>
				</div>
				{{--<!--密码-->
				<div class="form-group">
					<label for="passward" class="control-label col-xs-4">密码</label>
					<div class="col-xs-6 col-sm-4">
						<input type="password" class="form-control" id="passward" name="pwd">
					</div>
				</div>
				<!--确认密码-->
				<div class="form-group">
					<label for="surepassward" class="control-label col-xs-4">确认密码</label>
					<div class="col-xs-6 col-sm-4">
						<input type="password" class="form-control" id="surepassward" name="pwd_confirmation">
					</div>
				</div>--}}
				<!--姓名-->
				<div class="form-group">
					<label for="name" class="control-label col-xs-4">姓名</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="name" name="username" value="{{$employeeInfo['username']}}">
					</div>
				</div>
				<!--手机号-->
				{{--<div class="form-group">
					<label for="phone" class="control-label col-xs-4">手机号</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="phone" >
					</div>
				</div>--}}
				<!--</div>邮箱-->
				<div class="form-group">
					<label for="email" class="control-label col-xs-4">邮箱</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="email" name="email" value="{{$employeeInfo['email']}}">
					</div>
				</div>
					<!--身份证号-->
				<div class="form-group">
					<label for="idcard" class="control-label col-xs-4">身份证号</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="idcard" name="pid" value="{{$employeeInfo['pid']}}">
					</div>
				</div>
					<!--微信号-->
				<div class="form-group">
					<label for="wcart" class="control-label col-xs-4">微信号</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="wcart" name="wechat_id" value="{{$employeeInfo['wechat_id']}}">
					</div>
				</div>
					<!--QQ-->
				<div class="form-group">
					<label for="qq" class="control-label col-xs-4">Q Q</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="qq" name="qq_id" value="{{$employeeInfo['qq_id']}}">
					</div>
				</div>
					<!--生日-->
				<div class="form-group">
					<label for="dateinfo" class="control-label col-xs-4">生日</label>
					<div class="col-xs-6 col-sm-4 datep">
						<input type="text" class="form-control datainp" id="dateinfo" name="birthday_time" value="{{date("Y年m月d日",$employeeInfo['birthday_time'])}}">
					</div>
				</div>
					<!--性别-->
				<div class="form-group">
					<label for="sex" class="control-label col-xs-4">性别</label>
					<div class="col-xs-4 radio" id="sex">
						<label>
							<input type="radio" name="e_gender" value="M" @if($employeeInfo['e_gender']=="M") checked @endif><span>男</span>
						</label>
						<label>
							<input type="radio" name="e_gender" value="F" @if($employeeInfo['e_gender']=="F") checked @endif><span>女</span>
						</label>
					</div>
				</div>
					<!--部门-->
				<div class="form-group">
					<label for="" class="col-xs-4">部门</label>
					<select class="from-control col-ly-4" name="f_department_id">
						<option>选择部门</option>
						@foreach($departmentInfo as $k=>$v)
							<option value="{{$v['id']}}" @if($employeeInfo['f_department_id']==$v['id']) selected @endif>{{$v['name']}}</option>
						@endforeach
					</select>
				</div>
					<!--员工类型-->
				<div class="form-group">
					<label for="type" class="control-label col-xs-4">员工类型</label>
					<select class="col-ly-4" name="f_employee_type_id">
						<option>选择员工类型</option>
						@foreach($employeeTypeInfo as $k=>$v)
							<option value="{{$v['id']}}" @if($employeeInfo['f_employee_type_id']==$v['id']) selected @endif>{{$v['name']}}</option>
						@endforeach
					</select>
				</div>
				<!--地区搜索-->
				<div class="form-group">
					<label class="control-label col-xs-4">地区</label>
					<select id="select" class="col-ly-4" name="f_area_id">
						<option value="地区">地区</option>
						@foreach($areaInfo as $k=>$v)
							<option value="{{$v['id']}}" @if($employeeInfo['f_area_id']==$v['id']) selected @endif>{{$v['name']}}</option>
						@endforeach
					</select>
				</div>
				<!--员工状态-->
				<div class="form-group">
					<label for="status" class="control-label col-xs-4">员工状态</label>
					<select class="col-ly-4" name="f_employee_status_id">
						<option>请选择员工状态</option>
						@foreach($employeeStatusInfo as $k=>$v)
							<option value="{{$v['id']}}" @if($employeeInfo['f_employee_status_id']==$v['id']) selected @endif>{{$v['name']}}</option>
						@endforeach
					</select>
				</div>
				<!--选择省市-->
				<div class="form-group">
					<label for="status" class="control-label col-xs-4">住址</label>
					<div data-toggle="distpicker" id="cacon" class="clear">
						<select name="addr_provinc" class="col-xs-1" id="province2" data-province="{{$employeeInfo['addr_provinc']}}"></select>
						<select name="addr_city" class="col-xs-1" id="city2" data-city="{{$employeeInfo['addr_city']}}"></select>
						<select class="col-xs-1" name="addr_town" id="district2" data-district="{{$employeeInfo['addr_town']}}"></select>
					</div>
				</div>
				{{csrf_field()}}
				<!--提交-->
				<div class="submitBtn text-center">
					<button type="submit" class="btn btn-success">确定</button>
					<button type="reset" class="btn btn-primary">重置</button>
				</div>
			</form>
		</section>
		@component("admin.layout.footer")
			@endcomponent
	</div>
@endsection
@section("js")
<script src="{{asset("admin/js/distpicker.data.js")}}"></script>
<script src="{{asset("admin/js/distpicker.js")}}"></script>
<script src="{{asset("admin/js/jedate.min.js")}}"></script>
<script>
	// 省级联动
	$('#cacon').distpicker({
		autoSelect: false
	});
	// 下拉搜索
	$(function(){
		$('#select').searchableSelect();
	});

	// 日期
	jeDate({
		dateCell:"#dateinfo",
		format:"YYYY年MM月DD日",
		isinitVal:true,
		isTime:true, //isClear:false,
		minDate:"1901-1-1",
		okfun:function(val){alert(val)}
	})

	$(window).resize(function(){
		if($(window).width()<768){
			$('div.searchable-select').css('width','45.88%');
			$('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%');
			$('#cacon>select').css('width','18%');
		}else{
			$('div.searchable-select').css('width','160px');
			$('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto');
			$('#cacon>select').css('width','10%');
		}
	});
	$(function(){
		if($(window).width()<768){
			$('div.searchable-select').css('width','45.88%');
			$('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%');
			$('#cacon>select').css('width','18%');
		}else{
			$('div.searchable-select').css('width','160px');
			$('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto');
			$('#cacon>select').css('width','10%');
		}
	})
</script>
@endsection