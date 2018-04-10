@extends("admin.layout.layout")
		@section("title","新闻列表")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
			<link rel="stylesheet" href="{{asset("admin/css/z_special.css")}}">
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
					<b>-新闻列表</b>
					<span class="pull-right">
<a href="{{route("news.create")}}" class="btn btn-default btn-xs"><i></i>添加新闻</a>
</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--搜索-->
			<div class="panel panel-default dl_Commodity_panel" style="font-weight: normal;font-size:12px;">
				<div class="panel panel-body">
					<form class="form-inline" id="xiugaiInput" action="{{route("news.list")}}">
						<!--开始时间-->
						<div class="form-group">
							{{--<label for="" style="margin-top: 4px; margin-right: 5px;">开始日期</label>--}}
							<span>开始日期：</span>
							<input type="text" class="form-control input-sm" id="dateinfo" name="min_time" value="{{$info['min_time']}}">--
							<input type="text" class="form-control input-sm" id="datebut" placeholder="结束日期" onClick="jeDate({dateCell:'#datebut',isTime:true,format:'YYYY年MM月DD日'})" name="max_time" value="{{$info['max_time']}}">
						</div>
						<!--关键字-->
						<div class="form-group">
							<input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="关键字" name="name" value="{{$info['name']}}">
						</div>
						<button type="submit" class="btn btn-success btn-sm">搜索</button>
					</form>
				</div>
			</div>
			<!--表格-->
			<div class="panel panel-default">
			<form class="form-inline table-responsive">
				<table class="table table-bordered table-hover text-center zf_table">
					<thead>
						<tr>
							<th>
								<label class=" z_first text-center">
			{{--<input type="checkbox" id="checkAll" value="option1">--}}编号
					</label>
							</th>
							<th><label for="">新闻标题</label></th>
							<th class="z_type"><label for="">新闻描述</label></th>
							<th><label for="">PC图片</label></th>
							<th><label for="">手机图片</label></th>
							<th><label for="">时间</label></th>
							<th class="z_type"><label for="">新闻类型</label></th>
							<th><label for="">操作</label></th>
						</tr>
					</thead>
					<tbody>
					@foreach($newsInfo['data'] as $k=>$v)
						<tr>
							<td>
								{{$v['id']}}
							</td>
							<td class="z_col" title="{{$v['title']}}">{{$v['title']}}</td>
							<td class="z_type">{{$v['description']?$v['description']:"暂无"}}</td>
							<td>
								<div class="demo z-dome z_div">
									<a path="{{$v['image_url']}}" class="preview" href="javascript:;">
										{{$v['image_url']}}</a>
								</div>
							</td>
							<td>
								<div class="demo z_div">
									<a path="{{$v['small_image_url']}}" class="preview" href="javascript:;">
										{{$v['small_image_url']}}</a>
								</div>
							</td>
							<td class="z_time">{{date("Y-m-d H:i:s",$v['add_time'])}}</td>
							<td class="z_type">
								@if($v['type']==0)
									新闻
									@elseif($v['type']==1)
									公告
								@else
									新闻|公告
								@endif
							</td>
							<td class="z_last">

								<a href="{{route('news.info',['id'=>$v['id']])}}" class="edit" title="查看详情"><img src="{{asset("admin/img/details.png")}}" alt=""></a>

								<a href="{{route("news.edit",["id"=>$v['id']])}}" class="z_a_color"><img src="{{asset("admin/img/edit.png")}}" alt=""></a>


								<span class="dele" style="margin-left: 5px; cursor: pointer;" title="删除" ids="{{$v['id']}}"><img src="{{asset("admin/img/delete.png")}}" alt=""></span>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				{{$newsInfos->appends(["min_time"=>$info['min_time'],"max_time"=>$info['max_time'],"name"=>"{$info['name']}"])->links()}}
			</form>
			</div>
		</section>

		@component("admin.layout.footer")
			@endcomponent

	</div>
@endsection
@section("js")
<script src="{{asset("admin/js/jedate.min.js")}}"></script>
<script src="{{asset("admin/js/previewshow.js")}}"></script>
<script>
	//	弹出框
	$(".dele").each(function(k, v) {
		$(v).click(function() {
		    var id=$(this).attr("ids");
			layer.confirm("是否确定删除此条新闻推送？", {
				btn: ['确定', '取消'], //按钮，
				title: '删除新闻推送',
			}, function() {
				$.ajax({
					url: "{{url("admin/news/delete")}}/"+id,
					success: function(res) {
						layer.msg(res.msg);
						location.reload();
					},
					error: function(res) {
						layer.msg(res.responseText);
					}
				});
			}, function() {
			    layer.msg("取消成功");
			});
		});
	});// 下拉搜索

	$(function() {
		// 日期
		jeDate({
			dateCell: "#dateinfo",
			format: "YYYY年MM月DD日",
			isinitVal: true,
			isTime: true, //isClear:false,
			minDate: "1901-1-1",
			okfun: function(val) {
				alert(val)
			}
		})
	});

	$(function() {
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
    //	展示图片
    $(function(){
        if($('a.preview').length){
            var img = preloadIm();
            imagePreview(img);
        }
    })
</script>
@endsection