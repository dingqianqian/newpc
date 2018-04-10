@extends("admin.layout.layout")
		@section("title","商品列表")
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
					<b>-商品列表</b>
		<span class="pull-right">
			<a href="{{route("goods.create")}}" class="btn btn-default btn-xs"><i></i>添加新商品</a>
		</span>
				</div>
			</div>
		</section>
		<!-- 内容 -->
		<section class="content container-fluid">
			<!--搜索-->
			<div class="panel panel-default dl_Commodity_panel">
				<div class="panel panel-body" id="xiugaiInput">
					<form class="form-inline" action="{{route("goods.list")}}" method="get" id="export">
						<div class="form-group">
							<input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="商品名称" name="name" value="{{$info['name']}}">
						</div>
						<div class="form-group">
							<input type="text" class="form-control input-sm" id="exampleInputEmail2" placeholder="商品ID" name="id" value="{{$info['id']}}">
						</div>
						<div class="form-group">
							<select id="select" name="category">
								<option value="0">所有分类</option>
								@foreach($goodsTypeInfo as $k=>$v)
									<option value="{{$v['id']}}" @if($info['category']==$v['id']) selected @endif>{{$v['name']}}</option>
									@endforeach
							</select>
						</div>
						{{--<div class="form-group">
							<select id="selecta">
								<option value="订单状态">品牌</option>
								<option value="1">郑州</option>
								<option value="2">郑州</option>
							</select>
						</div>--}}
						<div class="form-group">
							<select id="selectb" name="status">
								<option value="0">所有状态</option>
								@foreach($goodsStatusInfo as $k=>$v)
									<option value="{{$v['id']}}" @if($v['id']==$info['status']) selected @endif>{{$v['name']}}</option>
									@endforeach
							</select>
						</div>
						<button type="submit" class="btn btn-success btn-sm">搜索</button>
						<button type="button" class="btn btn-warning btn-sm" onclick="exports()">导出</button>
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
  								编号
							</label>
							</th>
						<th>商品名称</th>
						<th>所属分类</th>
						<th>录入时间</th>
						<th>商品规格组合</th>
						<th>状态</th>
						<th>商品价格</th>
						<th>11121(价格)</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					@foreach($goodsInfo['data'] as $k=>$v)
					<tr>
						<td>
							{{--<input type="checkbox" />--}}{{$v['id']}}
						</td>
						<td>{{$v['name']}}</td>
						<td>{{$v['goods_type']['name']}}</td>
						<td>{{date("Y-m-d",$v['create_time'])}}</td>
						<td>@foreach($v['norms_group'] as $k1=>$v1)
								{{$v1['name']}}|
						@endforeach
						</td>
						@if($v['goods_status']['name'] == "上架")
						<td>
							<a href="javascript:;" style="color: red;" onclick="status({{$v['id']}})">{{$v['goods_status']['name']}}
							</a>
						</td>
						@elseif($v['goods_status']['name'] == "下架")
							<td>
								<a href="javascript:;" style="color: deepskyblue;" onclick="status({{$v['id']}})">{{$v['goods_status']['name']}}
								</a>
							</td>
						@endif
						<td>{{$v['show_price']}}</td>
						<td>{{$v['show_sale_price']}}</td>
						<td>
							<a href="{{route("goods.edit",['id'=>$v['id']])}}" class="z_a_color">
								<img src="{{asset("admin/img/edit.png")}}" alt="">
							</a>
							<a href="javascript:;" onclick="del({{$v['id']}})">
								<img src="{{asset("admin/img/delete.png")}}" alt="">
							</a>
						</td>
					</tr>
						@endforeach
					</tbody>
				</table>
				{{$goodsInfos->appends(["name"=>"{$info['name']}","id"=>$info['id'],"category"=>$info['category'],"status"=>$info['status']])->links()}}
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
	//商品导出
	function exports()
	{
	    var data = $("#export").serialize();
	    location.href = "{{url("admin/goods/export")}}?"+data;
	}
	// 下拉搜索
	$(function(){
		$('#select').searchableSelect();
		$('#selecta').searchableSelect();
		$('#selectb').searchableSelect();
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
			// 下拉搜索
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
});
	function del(id) {
		layer.confirm("确定要删除该商品吗？",function () {
		    $.ajax(
		        {
					url:"{{url("admin/goods/delete")}}/"+id,
					type:"post",
					success:function (res) {
						layer.msg(res.msg);
						location.reload();
                    },
					error:function (res) {
                        layer.msg(res.responseText);
                    }
				});
        },function () {
			layer.msg("取消成功");
        });
    }
    function status(id) {
		$.ajax(
		    {
				url:"{{url("admin/goods/status")}}/"+id,
                type:"post",
                success:function (res) {
                    layer.msg(res.msg);
                    location.reload();
                },
                error:function (res) {
                    layer.msg(res.responseText);
                }
			});
    }
</script>
@endsection