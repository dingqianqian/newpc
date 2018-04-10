@extends("admin.layout.layout")
		@section("title","新闻详情")
		@section("css")
			<link rel="stylesheet" href="{{asset('admin/css/ly_memberDetail.css')}}">
		@endsection

@section("content")


			<div class="content-wrapper">
				<section class="content-header">
					<div class="panel panel-default">
						<div class="panel-body">
							<b>
						<a href="javascript:;">宜优速 管理中心</a>
					</b>
							<b>-新闻详情</b>
							<span class="pull-right">
			<a href="{{route("news.list")}}" class="btn-sm btn btn-default"><i></i>新闻列表</a>
		</span>
						</div>
					</div>
				</section>
				<!-- 内容 -->
				<section class="content container-fluid">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="fontSize">
							<tbody>
							<tr>
								<td class="col-xs-3">新闻标题:</td>
								<td class="col-xs-3">{{$newsInfo['title']}}</td>
								<td class="col-xs-3">发布时间:</td>
								<td class="col-xs-3">{{date("Y-m-d",$newsInfo['add_time'])}}</td>
							</tr>
							<tr>
								<td class="col-xs-3">新闻描述:</td>
								<td class="col-xs-3">{{$newsInfo['description']?$newsInfo['description']:"暂无"}}</td>
								<td class="col-xs-3">新闻作者:</td>
								<td class="col-xs-3">{{$newsInfo['authour']}}</td>
							</tr>
							<tr>
								<td class="col-xs-3">大图url:</td>
								<td class="col-xs-3"><a href="{{$newsInfo['image_url']}}">{{$newsInfo['image_url']}}</a></td>
								<td class="col-xs-3">小图url:</td>
								<td class="col-xs-3"><a href="{{$newsInfo['small_image_url']}}" target="_blank">{{$newsInfo['small_image_url']}}</a></td>
							</tr>
							<tr>
								<td class="col-xs-3">电脑访问地址:</td>
								<td class="col-xs-3"><a href="{{$newsInfo['url']}}/{{$newsInfo['id']}}">{{$newsInfo['url']}}/{{$newsInfo['id']}}</a></td>
								<td class="col-xs-3">手机访问地址:</td>
								<td class="col-xs-3"><a href="{{$newsInfo['mobile_url']}}/{{$newsInfo['id']}}" target="_blank">{{$newsInfo['mobile_url']}}/{{$newsInfo['id']}}</a></td>
							</tr>
							</tbody>
						</table>
					</div>
				</section>
				<!-- Footer -->
				@component("admin.layout.footer")
					@endcomponent
			</div>
@endsection