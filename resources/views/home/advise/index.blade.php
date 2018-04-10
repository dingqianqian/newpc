@extends("home.layout.layout")
		@section("title","意见建议")
		@section("css")
			<link rel="stylesheet" href="{{asset('home/css/advise/purList.css')}}">
			@endsection
@section("content")
@component("home.layout.headTwo")
	@endcomponent
<div class="er-title">
	<p><a href="{{url('/')}}">首页</a>/<span>意见建议</span></p>
</div>
<div class="oStep clear">
	<!--左侧导航-->
	@component("home.layout.sidebar",["index"=>$index])
		@endcomponent
	<!--右侧内容-->
	<div class="tStepCont">
		<div class="ly_suggest">
			<p>欢迎您随时对我们的网站及商品进行反馈提出宝贵意见 : </p>
			<form action="{{url('advise/add')}}" method="post">
				<textarea name="commit" id="suggestText" style="width: 948px;height: 282px;"></textarea>
				{{csrf_field()}}
				<div>
					<button id="goUp" type="submit">提交</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section("js")
	<script type="text/javascript">
		@if(session("msg"))
			layer.msg("{{session("msg")}}");
			@endif
	</script>
	@endsection

