@extends("admin.layout.layout")
		@section("title","添加商品分类")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/ly_addCommClass.css")}}">
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
					<b>-添加分类</b>
				<span class="pull-right">
			<a href="{{route('category.list')}}" class="btn btn-default btn-sm">商品分类</a>
				</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<form class="form-horizontal" method="post" action="{{url('admin/category/update')}}/{{$goodsTypeInfoOne['id']}}">
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<!--商品名-->
				<div class="form-group">
					<label for="commname" class="control-label col-xs-4">商品分类名称</label>
					<div class="col-sm-4 col-xs-6">
						<input type="text" class="form-control" id="commname" name="name" value="{{$goodsTypeInfoOne['name']}}">
					</div>
				</div>
				<!--商品排序-->
				<div class="form-group">
					<label for="commpaixu" class="control-label col-xs-4">分类排序</label>
					<div class="col-sm-4 col-xs-6">
						<input type="text" class="form-control" id="commpaixu" name="sort" value="{{$goodsTypeInfoOne['sort']}}">
					</div>
				</div>
				<!--上级分类-->
				<div class="form-group">
					<label for="" class="col-xs-4">所属分类</label>
					<select class="from-control col-sm-4 col-xs-6 lyheight-control" name="parent_id">
						<option value="0">顶级分类</option>
						@foreach($goodsTypeInfo as $k=>$v)
							<option value="{{$v['id']}}" @if($goodsTypeInfoOne['parent_id']==$v['id']) selected @endif>{{$v['name']}}</option>
						@endforeach
					</select>
				</div>
				<!--受否显示-->
				<div class="form-group">
					<label for="show" class="control-label col-xs-4">分类是否显示</label>
					<div class="col-xs-4 radio" id="show">
						<label>
							<input type="radio" name="is_show" @if($goodsTypeInfoOne['is_show']==0) checked @endif value="0">是
						</label>
						<label>
							<input type="radio" name="is_show"@if($goodsTypeInfoOne['is_show']==1) checked @endif value="1">否
						</label>
					</div>
				</div>
				{{--<!--上传-->
				<div class="form-group">
					<label for="shangchuan" class="control-label col-xs-4">上传图片</label>
					<input type="file" class="col-sm-4 col-xs-6" id="shangchuan">
				</div>
				<!--分类标志-->
				<div class="form-group">
					<label for="fenlei" class="control-label col-xs-4">上传图片</label>
					<div class="col-sm-4 col-xs-6">
						<input type="text" class="form-control" id="fenlei">
					</div>
				</div>--}}
				<!--提交-->
				{{csrf_field()}}
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