@extends("admin.layout.layout")
		@section("title","修改角色")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/ly_addRole.css")}}">
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
					<b>-修改角色</b>
				<span class="pull-right">
			<a href="{{route('role.list')}}" class="btn btn-default btn-sm">角色列表</a>
				</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<form class="form" id="ly_form" action="{{url("admin/role/update")}}/{{$roleInfo['id']}}" method="post">
				<div>
					<!--描述-->
					<div class="row">
						<div class="col-md-4 col-xs-4 text-right ab"><b>角色名</b></div>
						<div class="col-md-3 col-xs-6 ainput">
							<input type="text"  value="{{$roleInfo['name']}}" name="name" class="form-control input-xs">
						</div>
						<span>*</span>
					</div>
					<div class="row">
						<div class="col-md-4 col-xs-4 text-right ab"><b>角色描述</b></div>
						<div class="col-md-4 col-xs-7 ainput">
							<textarea class="form-control" name="description" rows="4" style="resize: none;">{{$roleInfo['description']}}</textarea>
						</div>
						<span>*</span>
					</div>
				</div>

				<!--内容-->
				@foreach($accessInfo as $k=>$v)
				<div class="row">
					<div class="col-md-2 col-xs-12 checkAll">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="role_id[]" value="{{$v['id']}}" @if(in_array($v['id'],$accessId)) checked @endif><b>{{$v['name']}}</b>
							</label>
						</div>
					</div>
					<div class="col-md-9 col-xs-12 labelCon">
						<div class="checkbox">
							@if(isset($v['child']))
							@foreach($v['child'] as $k1=>$v1)
							<label>
								<input type="checkbox" name="role_id[]" value="{{$v1['id']}}" @if(in_array($v1['id'],$accessId)) checked @endif>{{$v1['name']}}
							</label>
								@endforeach
								@endif
						</div>
					</div>
				</div>
				@endforeach
				<!--提交-->
				<div class="submitBtn text-center">
					<label style="margin-right: 10px;">
						<input type="checkbox">全选
					</label>
					<button type="submit" class="btn btn-success">确定</button>
					<button type="reset" class="btn btn-primary">重置</button>
				</div>
				{{csrf_field()}}
			</form>
		</section>

		@component("admin.layout.footer")
			@endcomponent

	</div>
@endsection


@section("js")

<script>
    // 点击全选
    $('.checkAll label>input').click(function(){
        var checkedAll = $(this).prop('checked');
        $(this).parent().parent().parent('.checkAll').siblings('.labelCon').find('label>input').each(function(k,v){
            $(v).prop('checked',checkedAll);
        });
    });
    // 点击选中类型
    $('.labelCon label>input').each(function(k,v){
        $(v).click(function(){
            $(this).parent().parent().parent('.labelCon').siblings('.checkAll').find('label>input').prop('checked',true);
        });
    });
    // 总全选
    $('.submitBtn>label>input').click(function(){
        var checked = $(this).prop('checked');
        $('.labelCon label>input,.checkAll label>input').each(function(k,v){
            $(v).prop('checked',checked);
        });
    });
</script>
@endsection