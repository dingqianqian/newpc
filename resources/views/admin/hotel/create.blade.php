@extends("admin.layout.layout")
		@section("title","添加酒店")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/ly_addCommClass.css")}}">
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
					<b>-添加酒店</b>
		<span class="pull-right">
			<a href="{{route("hotel.list")}}" class="btn btn-default btn-xs"><i></i>酒店列表</a>
		</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<form class="form-horizontal" method="post" action="{{url("admin/hotel/add")}}" enctype="multipart/form-data">
				<!--商品名-->
				<div class="form-group">
					<label for="commname" class="control-label col-xs-4">酒店名称</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="commname" name="name">
					</div>
				</div>
				<!--商品排序-->
				<div class="form-group">
					<label for="commpaixu" class="control-label col-xs-4">酒店排序</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" id="commpaixu" value="0" name="sort">
					</div>
				</div>
				<!--分类标志-->
				<div class="form-group">
					<label for="fenlei" class="control-label col-xs-4">酒店大写首字母</label>
					<div class="col-xs-4">
						<input type="text" class="form-control" id="fenlei" name="index">
					</div>
				</div>
				<!--受否显示-->
				<div class="form-group">
					<label for="show" class="control-label col-xs-4">酒店是否显示</label>
					<div class="col-xs-4 radio" id="show">
						<label>
							<input type="radio" value="0" name="is_show" checked>是
						</label>
						<label>
							<input type="radio" value="1" name="is_show">否
						</label>
					</div>
				</div>
				<!--上传-->
				<div class="form-group">
					<label for="shangchuan" class="control-label col-xs-4">上传酒店LOGO</label>
					<input type="file" class="col-xs-4" id="shangchuan" name="logo">
				</div>
				{{csrf_field()}}
				<!--提交-->
				<div class="submitBtn text-center">
					<button type="submit" class="btn btn-success">确定</button>
					<button type="reset" class="btn btn-primary">重置</button>
				</div>
			</form>
		</section>s

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