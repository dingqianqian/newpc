@extends("admin.layout.layout")
		@section("title","酒店列表")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/ly_roleList.css")}}">
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
					<b>-酒店列表</b>
		<span class="pull-right">
			<a href="{{route("hotel.create")}}" class="btn btn-default btn-xs"><i></i>添加酒店</a>
		</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--搜索-->
			<div class="panel panel-default dl_Commodity_panel">
				<div class="panel panel-body" id="xiugaiInput">
					<form class="form-inline" method="get" action="{{route("hotel.list")}}">
						<div class="form-group" style="font-size: 12px;font-weight: normal;">
							<span>酒店名称：</span>
							<input  value="{{$info['name']}}" name="name" type="text" class="form-control input-sm" id="exampleInputName2" placeholder="酒店名称">
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
							<th>
							<label class="checkbox inline">
  					{{--<input type="checkbox" id="checkAll" value="option1">--}}编号
							</label>
						</th>
						<th>酒店名称</th>
						<th>酒店图片URL</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					@foreach($goodsTypeInfo['data'] as $k=>$v)
					<tr>
						<td>
  					{{--<input type="checkbox">--}}{{$v['id']}}
						</td>
						<td>{{$v['name']}}</td>
						<td>{{asset($v['image_url'])}}</td>
						<td>
							<a href="{{route("hotel.edit",["id"=>$v['id']])}}" class="z_a_color"><img src="{{asset("admin/img/edit.png")}}" alt=""></a>
							<a href="{{route("hotel.delete",["id"=>$v['id']])}}" class="z_a_color"><img src="{{asset("admin/img/delete.png")}}" alt=""></a>
						</td>
					</tr>
						@endforeach
					</tbody>
				</table>
				{{$goodsTypeInfos->appends(["name"=>"{$info['name']}"])->links()}}
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
	});
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
$(function(){
	// 全选
$('#checkAll').click(function() {
	// 保存当前状态
	var ischecked = $(this).prop('checked');
	// 遍历check
	$('tbody>tr>td>input').each(function(k, v) {
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