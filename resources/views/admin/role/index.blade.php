@extends("admin.layout.layout")
		@section("title","角色列表")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/ly_roleList.css")}}">
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
					<b>-角色列表</b>
		<span class="pull-right">
			<a href="{{route("role.create")}}" class="btn btn-default btn-xs"><i></i>添加角色</a>
		</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<div class="panel panel-default">
			<!--表格-->
			<form class="form-inline">
				<table class="table table-bordered table-hover dataTable text-center">
					<thead>
					<tr>
						<th>角色名</th>
						<th>角色描述</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					@foreach($roleInfo as $k=>$v)
					<tr>
						<td>{{$v['name']}}</td>
						<td>{{$v['description']}}</td>
						<td>
							<a href="{{route("role.edit",["id"=>$v['id']])}}" class="edit" title="编辑角色"><img src="{{asset('admin/img/edit.png')}}" alt=""></a>
							<a href="{{route("role.delete",["id"=>$v['id']])}}"class="delete"><img src="{{asset('admin/img/delete.png')}}" alt="" title="删除"></a>
						</td>
					</tr>
						@endforeach
					</tbody>
				</table>
			</form>
			</div>
		</section>

		@component("admin.layout.footer")
			@endcomponent

	</div>
@endsection

@section("js")
<script>
	// 下拉搜索
	$(function(){
		$('#select').searchableSelect();
		$('#ly_select').searchableSelect();
	});
</script>
	@endsection
