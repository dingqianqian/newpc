@extends("admin.layout.layout")
		@section("title","用户评论")
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
					<b>-用户评论</b>
		<!--<span class="pull-right">
			<a href="ly_addAdmin.html" class="btn btn-default btn-xs"><i></i>添加管理员</a>
		</span>-->
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--搜索-->
			<div class="panel panel-default dl_Commodity_panel">
				<div class="panel panel-body" id="xiugaiInput">
					<form class="form-inline" action="{{route("comment.list")}}" method="get">
						<div class="form-group">
							<input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="评论内容" name="content" value="{{$info['content']}}">
						</div>
						{{csrf_field()}}
						<button type="submit" class="btn btn-success btn-sm">搜索</button>
					</form>
				</div>
			</div>
			<!--表格-->
			<div class="panel panel-default">
			<div class="form-inline table-responsive">
				<table class="table table-bordered table-hover text-center" id="fontSize">
					<thead>
					<tr>
						<th>
							<label class="checkedAll">
								{{--<input type="checkbox">--}}编号
							</label>
						</th>
						<th>用户名</th>
						<th>用户手机号</th>
						<th>商品名</th>
						<th>评论内容</th>
						<th>评论时间</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					@foreach($goodsEvaluateInfo['data'] as $k=>$v)
					<tr>
						<td>
							<label class="checkedChild">
								{{--<input type="checkbox">--}}{{$v['id']}}
							</label>
						</td>
						<td>{{$v['user']['username']}}</td>
						<td>{{$v['user']['signin_name']}}</td>
						<td>{{$v['goods']['open_id']}}</td>
						<td>{{$v['content']}}</td>
						<td>{{date("Y-m-d H:i:s",$v['create_time'])}}</td>
						<td>
							{{--<a href="javascript:;" class="edit"><img src="{{asset("admin/img/edit.png")}}" alt=""></a>--}}
							<a href="{{route('comment.delete',['id'=>$v['id']])}}" class="edit"><img src="{{asset("admin/img/delete.png")}}" alt=""></a>
						</td>
					</tr>
						@endforeach
					</tbody>
				</table>
			</div>
				{{$goodsEvaluateInfos->appends(["content"=>"{$info['content']}"])->links()}}
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

	$(window).resize(function(){
		if($(window).width()<578){
			$('#fontSize').addClass('small-font')
		}else{
			$('#fontSize').removeClass('small-font')
		}
	});

	// 全选
	$('.checkedAll>input').click(function(){
		var checked = $(this).prop('checked');
		$('.checkedChild>input').each(function(k,v){
			$(v).prop('checked',checked);
		});
	});
	// 单选

		/*$('.checkedChild>input').click(function(){
			$('.checkedChild>input').each(function(k,v){
			if($(v).prop('checked')==true){
				$('.checkedAll>input').prop('checked',true)
			}else{
				$('.checkedAll>input').prop('checked',false)
			}
		});
	});*/

	$(window).resize(function(){
		if($(window).width()<768){
			$('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%')
		}else{
			$('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto')
		}
	});

</script>
@endsection