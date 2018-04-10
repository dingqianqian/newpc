@extends("admin.layout.layout")
@section("title","管理员列表")
	@section("css")
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
					<b>-管理员列表</b>
		<span class="pull-right">
			<a href="{{route("employee.create")}}" class="btn btn-default btn-xs"><i></i>添加管理员</a>
		</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--搜索-->
			<div class="panel panel-default dl_Commodity_panel" style="font-weight: normal">
				<div class="panel panel-body" id="xiugaiInput">
					<form class="form-inline" method="get" action="{{route('employee.list')}}">
						<div class="form-group">
							<input type="text" name="name" class="form-control input-sm" id="exampleInputName2" placeholder="姓名" value="{{$info['name']}}">
						</div>
						<div class="form-group">
							<input type="text" name="phone" class="form-control input-sm" id="exampleInputEmail2" placeholder="手机号" value="{{$info['phone']}}">
						</div>
						<div  class="form-group lyselect">
							<select name="department" id="" style="padding:0 4px;">
								<option value="0">全部部门</option>
								@foreach($departmentInfo as $k=>$v)
									<option value="{{$v['id']}}" @if($v['id']==$info['department']) selected @endif>{{$v['name']}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group lyselect">
							<select name="status" id="" style="padding:0 4px;">
								<option value="0">全部状态</option>
								@foreach($employeeStatusInfo as $k=>$v)
									<option value="{{$v['id']}}" @if($v['id']==$info['status']) selected @endif>{{$v['name']}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<select id="select" name="area">
								<option value="0">全部地区</option>
								@foreach($areaInfo as $k=>$v)
									<option value="{{$v['id']}}" @if($v['id']==$info['areas']) selected @endif>{{$v['name']}}</option>
								@endforeach
							</select>
						</div>
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
						<th>ID</th>
						<th>姓名</th>
						<th>用户名</th>
						<th>部门</th>
						<th>录入时间</th>
						<th>权限等级</th>
						<th>状态</th>
						<th>地区</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					@foreach($employeeInfo['data'] as $k=>$v)
					<tr>
						<td>{{$v['id']}}</td>
						<td>{{$v['username']}}</td>
						<td>{{$v['signin_name']}}</td>
						<td>{{$v['department']['name']}}</td>
						<td>{{date("Y-m-d H:i:s",$v['join_time'])}}</td>
						<td>@if(in_array($v['id'],[6,7]))
								<span style="color: #FF0033;">一级权限</span>
								@elseif($v['f_employee_type_id']==2&&!in_array($v['id'],[6,7]))
								<span style="color: #9933CC">二级权限</span>
								@else
								<span style="color: #339999;">三级权限</span>
							@endif
						</td>
						<td>{{$v['employee_status']['name']}}</td>
						<td>{{$v['area']['name']}}</td>
						<td>
							<a href="{{route('role.distribute',['id'=>$v['id']])}}" class="edit"><img src="{{asset('admin/img/role.png')}}" alt="" title="分配角色"></a>
							<a href="{{route('employee.edit',['id'=>$v['id']])}}" class="edit"><img src="{{asset('admin/img/edit.png')}}" alt="" title="编辑"></a>
							<a href="{{route("employee.delete",['id'=>$v['id']])}}" class="edit"><img src="{{asset('admin/img/delete.png')}}" alt="" title="删除"></a>
						</td>
					</tr>
						@endforeach
					</tbody>
				</table>
				{{$employeeInfos->links()}}
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

		/*$(window).resize(function(){
		 if($(window).width()<480){
		 $('div.lyfooter').addClass('small-font')
		 }else{
		 $('div.lyfooter').removeClass('small-font')
		 }
		 });*/
        $(window).resize(function(){
            if($(window).width()<768){
                $('div.searchable-select').css('min-width','100%');
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%')
            }else{
                $('div.searchable-select').css('width','160px');
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto')
            }
        });
        $(function(){
            if($(window).width()<768){
                $('div.searchable-select').css('min-width','100%')
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%')
            }else{
                $('div.searchable-select').css('width','160px');
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto')
            }
        })
	</script>
	@endsection
