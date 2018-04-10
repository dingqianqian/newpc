@extends("admin.layout.layout")
		@section("title","权限列表")
		@section("css")
			<link rel="stylesheet" href="{{asset('admin/css/reset.min.css')}}">
			<link rel="stylesheet" href="{{asset("admin/css/ly_limitsList.css")}}">
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
					<b>-权限列表</b>
		<span class="pull-right">
			<a href="{{route('access.create')}}" class="btn btn-default btn-sm"><i></i>添加权限</a>
		</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<div class="p">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default top">
						<div class="panel-heading" role="tab" id="">
							<!--标题-->
							<ul class="panel-title row text-center">
								<li class="col-xs-2">权限名
								</li>
								<li class="col-xs-2">权限路由</li>
								<li class="col-xs-2">权限ID</li>
								<li class="col-xs-2">权限描述</li>
								<li class="col-xs-2">权限排序</li>
								<li class="col-xs-2">是否显示</li>
								<li class="col-xs-2">操作</li>
							</ul>
						</div>
					</div>
					@foreach($accessInfo as $k=>$v)
						<div class="panel panel-default">
							<!--爸爸-->
							<div class="panel-heading" role="tab" id="heading1">
								<ul class="panel-title row text-center">
									<li class="col-xs-2 text-left">
										{{--href aria-controls 添加id--}}
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$loop->iteration}}" aria-expanded="true" aria-controls="collapse{{$loop->iteration}}"><img src="{{asset('admin/img/plus.gif')}}" alt=""></a>
										{{$v['name']}}
									</li>
									<li class="col-xs-2">{{$v['route_name']}}</li>
									<li class="col-xs-2">{{$v['id']}}</li>
									<li class="col-xs-2">{{$v['description']}}</li>
									<li class="col-xs-2 tabInput" ids="{{$v['id']}}">
										<span class="need" style="display: inline-block;">{{$v['sort']}}</span>
										<input type="text" class="shuru" style="display: none;">
									</li>
									@if($v['is_show']==1)
										<li class="col-xs-2 yOn"><a href="javascript:;"><img src="{{asset('admin/img/yes.gif')}}" alt=""></a></li>
									@else
										<li class="col-xs-2 yOn"><a href="javascript:;"><img src="{{asset('admin/img/no.gif')}}" alt=""></a></li>
									@endif
									<li class="col-xs-2">
										<a href="javascript:;" class="edit" title="编辑"><img src="{{asset('admin/img/edit.png')}}" alt=""></a>
										<a href="javascript:;"class="delete" title="删除"><img src="{{asset('admin/img/delete.png')}}" alt=""></a>
									</li>
								</ul>
							</div>
                        <?php $i=$loop->iteration;?>
						@if(isset($v['child']))
							<!--儿子-->

								{{--与父亲同样的id--}}
								<div id="collapse{{$i}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$i}}">
									<div class="panel-body">
										@foreach($v['child'] as $k1=>$v1)
											<ul class="panel-title row text-center">
												<li class="col-xs-2 text-left">
													<img src="{{asset('admin/img/minus.gif')}}" alt="">
													{{$v1['name']}}
												</li>
												<li class="col-xs-2">{{$v1['route_name']}}</li>
												<li class="col-xs-2">{{$v1['id']}}</li>
												<li class="col-xs-2">{{$v1['description']}}</li>
												<li class="col-xs-2 tabInput" ids="{{$v1['id']}}">
													<span class="need" style="display: inline-block;">{{$v1['sort']}}</span>
													<input type="text" class="shuru" style="display: none;">
												</li>
												@if($v1['is_show']==1)
													<li class="col-xs-2 yOn"><a href="javascript:;"><img src="{{asset('admin/img/yes.gif')}}" alt=""></a></li>
												@else
													<li class="col-xs-2 yOn"><a href="javascript:;"><img src="{{asset('admin/img/no.gif')}}" alt=""></a></li>
												@endif
												<li class="col-xs-2">
													<a href="{{route('access.edit',['id'=>$v1['id']])}}" class="edit" title="编辑"><img src="{{asset('admin/img/edit.png')}}" alt=""></a>
													<a href="{{route('access.delete',['id'=>$v1['id']])}}"class="delete" title="刪除"><img src="{{asset('admin/img/delete.png')}}" alt=""></a>
												</li>
											</ul>
										@endforeach
									</div>
								</div>
							@endif
						</div>
					@endforeach
				</div>
			</div>

		</section>
		@component("admin.layout.footer")
			@endcomponent

	</div>
@endsection

@section("js")
<script>
	// 点击yes OR no
	$('.yOn img').each(function(k,v){
		$(v).click(function(){
		    var num = null;
		    var id = $(this).parent().parent().prev('.tabInput').attr('ids');
			if($(this).attr('src') == '{{asset('admin/img/yes.gif')}}'){
				$(this).attr('src','{{asset('admin/img/no.gif')}}')
				num = 0;
			}else{
				$(this).attr('src','{{asset('admin/img/yes.gif')}}');
				num = 1;
			}
            $.ajax({
                type:'post',
                url:'{{url('admin/access/showAjax')}}',
                data:{num:num,id:id},
				success:function(res){
                    console.log(res)
				}
            })
		});
	});

	// 点击输入内容
	$('.tabInput>.need').each(function(k,v){
		$(v).click(function(){
			// 获取内容
			var text = $(this).text();
			// 隐藏当前
			$(this).css('display','none');
			// 显示input 与内容
			$(this).parent().children('.shuru').css('display','inline-block').val(text).focus();
		})
	})
	// 输入框
	$('.tabInput>.shuru').blur(function(){
		// 保存值
		$(this).css('display','none').parent().children('.need').css('display','inline-block').text($(this).val());
		var text = $(this).val();
		var id = $(this).parent().attr('ids');
        $.ajax({
            type:'post',
            url:'{{url('admin/access/sortAjax')}}',
            data:{num:text,id:id},
            success:function(res){
                console.log(res)
            }
        })
	});

	// 折叠图片
	$('.panel-heading .panel-title>li:first-child>a>img').each(function(k,v){
		$(v).click(function(){
			if($(this).attr('src') == '{{asset('admin/img/minus.gif')}}'){
				$(this).attr('src','{{asset('admin/img/plus.gif')}}')
			}else{
				$(this).attr('src','{{asset('admin/img/minus.gif')}}')
			}
		});
	});

</script>
@endsection