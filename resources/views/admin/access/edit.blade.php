@extends("admin.layout.layout")
		@section("title","添加权限")
		@section("css")
			<link rel="stylesheet" href="{{asset('admin/css/ly_addCommClass.css')}}">
			<link rel="stylesheet" href="{{asset('admin/css/ly_addLimits.css')}}">
		@endsection
@section("content")
	<!--内容-->
	<div class="content-wrapper">
		<!-- Content Header -->
		<section class="content-header">
			<div class="panel panel-default">
				<div class="panel-body">
					<b>
						<a href="javascript:;">宜优速 管理中心</a>
					</b>
					<b>-添加权限</b>
		<span class="pull-right">
			<a href="{{route('access.list')}}" class="btn btn-default btn-xs"><i></i>权限列表</a>
		</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<form class="form-horizontal" action="{{url('admin/access/update')}}/{{$accessInfos['id']}}" method="post">
				@if (count($errors) > 0)
					<div class="alert alert-danger" style="color: red;">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<!--权限名-->
				<div class="form-group">
					<label for="commname" class="control-label col-xs-4">权限名</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="commname" name="name" value="{{$accessInfos['name']}}">
					</div>
				</div>
				<!--权限路由-->
				<div class="form-group">
					<label for="commpaixu" class="control-label col-xs-4">权限路由</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="commpaixu" name="route_name" value="{{$accessInfos['route_name']}}">
					</div>
				</div>
				<!--权限描述-->
				<div class="form-group">
					<label class="control-label col-xs-4">权限描述</label>
					<div class="col-xs-6 col-sm-4">
						<textarea class="form-control" rows="5" style="resize: none;" name="description">{{$accessInfos['description']}}</textarea>
					</div>
				</div>

				<!--权限排序-->
				<div class="form-group">
					<label for="fenlei" class="control-label col-xs-4">权限排序</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="fenlei" name="sort" value="{{$accessInfos['sort']}}">
					</div>
				</div>
				<!--权限是否显示-->
				<div class="form-group">
					<label for="show" class="control-label col-xs-4">权限是否显示</label>
					<div class="col-xs-4 radio" id="show">
						<label>
							<input type="radio" name="is_show" @if($accessInfos['is_show']==1) checked @endif value="1">是
						</label>
						<label>
							<input type="radio" name="is_show" @if($accessInfos['is_show']==0) checked @endif value="0">否
						</label>
					</div>
				</div>
				<!--权限等级-->
				<div class="form-group" id="limitsDengji">
					<label for="" class="col-xs-4">权限等级</label>
					<select class="from-control col-xs-4" name="parent_id">
						<option value="0">顶级权限</option>
						@foreach($accessInfo as $k=>$v)
							<option @if($accessInfos['parent_id']==$v['id']) selected @endif value="{{$v['id']}}">{{$v['name']}}</option>
						@endforeach
					</select>
				</div>
				<!--提交-->
				{{csrf_field()}}
				<div class="submitBtn text-center">
					<button type="submit" class="btn btn-success">确定</button>
					<button type="reset" class="btn btn-primary">重置</button>
				</div>
			</form>
		</section>

		<!-- Footer -->
		@component("admin.layout.footer")
			@endcomponent

	</div>
	<!-- /.content-wrapper -->

@endsection

@section("js")

<script>
	$(window).resize(function(){
		if($(window).width()<768){
			$('div.searchable-select').css('width','45.88%');
			$('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%')
		}else{
			$('div.searchable-select').css('width','160px');
			$('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto')
		}
	});
</script>
	@endsection
