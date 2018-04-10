@extends("admin.layout.layout")
		@section("title","充值类型管理")
		@section("css")
			<link rel="stylesheet" type="text/css" href="{{asset("admin/css/employee.css")}}"/>
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
					<b>-充值返现管理</b>
					<span class="pull-right">
<a href="{{route("rechargeType.create")}}" class="btn btn-default btn-xs"><i></i>添加充值</a>
</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--表格-->
			<div class="panel panel-default">
			<form class="form-inline table-responsive">
				<table class="table table-bordered table-hover text-center">
					<thead>
					<tr>
							<th>
							<label class="checkbox inline">
  					{{--<input type="checkbox" id="checkAll" value="option1">--}}ID
							</label>
							</th>
						<th>充值金额</th>
						<th>返现金额</th>
						<th>添加时间</th>
						<th>排序</th>
						<th>是否显示</th>
						<th>图片</th>
						<th>充值描述</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					@foreach($rechargeTypeInfo as $k=>$v)
					<tr>
						<td>
							{{--<input type="checkbox" />--}}{{$v['id']}}
						</td>
						<td>{{$v['money']}}</td>
						<td>{{$v['give_back']}}</td>
						<td>{{date("Y-m-d H:i:s",$v['create_time'])}}</td>
						<td class="tabInput" ids="{{$v['id']}}">
							<span class="need" style="display: inline-block;">{{$v['sort']}}</span>
							<input type="text" class="outlet" style="display: none;">
						</td>
						<td >
							@if($v['is_show']==0)
								<span class="yOn"><a href="javascript:;"><img src="{{asset('admin/img/yes.gif')}}" alt=""></a></span>
							@else
								<span class="yOn"><a href="javascript:;"><img src="{{asset('admin/img/no.gif')}}" alt=""></a></span>
							@endif
						</td>
						<td>
							<div class="demo">
								<a path="{{$v['url']}}" class="preview" href="javascript:;">
								{{$v['url']}}</a>
							</div>
						</td>
						<td>{{$v['description']}}</td>
						<td>
							<a href="{{route("rechargeType.edit",["id"=>$v['id']])}}" class="z_a_color"><img src="{{asset("admin/img/edit.png")}}" alt=""></a>
							<a href="javascript:;" class="z_a_color dele" ids="{{$v['id']}}">
								<img src="{{asset("admin/img/delete.png")}}" alt="">
							</a>
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
<script src="{{asset("admin/js/previewshow.js")}}" type="text/javascript" charset="utf-8"></script>
<script>
    // 是否显示
    $('.yOn img').each(function(k,v){
        $(v).click(function(){
            var num = null;
            var id = $(this).parent().parent().parent().prev('.tabInput').attr('ids');
            if($(this).attr('src') == '{{asset('admin/img/yes.gif')}}'){
                $(this).attr('src','{{asset('admin/img/no.gif')}}');
                num = 1;
            }else{
                $(this).attr('src','{{asset('admin/img/yes.gif')}}');
                num = 0;
            }
            $.ajax({
                type:'post',
                url:'{{url('admin/rechargeType/show')}}/'+id,
                data:{num:num},
                success:function(res){
                    layer.msg(res.msg);
                }
            })
        });
    });
	//即点即改
    // 点击输入内容
    $('.tabInput>.need').each(function(k,v){
        $(v).click(function(){
            // 获取内容
            var text = $(this).text();
            // 隐藏当前
            $(this).css('display','none');
            // 显示input 与内容
            $(this).parent().children('.outlet').css('display','inline-block').val(text).focus();
        })
    });
    // 输入框
    $('.tabInput>.outlet').blur(function(){
        // 保存值
        $(this).css('display','none').parent().children('.need').css('display','inline-block').text($(this).val());
        var text = $(this).val();
        var id = $(this).parent().attr('ids');
        $.ajax({
            type:'post',
            url:'{{url('admin/rechargeType/sort')}}/'+id,
            data:{val:text},
            success:function(res){
                layer.msg(res.msg);
            }
        })
    });
	//	弹出框
	$(".dele").each(function(k, v) {
		$(v).click(function() {
            var id=$(this).attr("ids");
			layer.confirm("是否确定删除？", {
				btn: ['确定', '取消'], //按钮，
				title: '删除充值',
			}, function() {
				$.ajax({
					url: "{{url('admin/rechargeType/delete')}}/" + id,
					type: "post",
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
	});
	//	展示图片
$(function(){
	if($('a.preview').length){
		var img = preloadIm();
		imagePreview(img);
	}
})
</script>
@endsection