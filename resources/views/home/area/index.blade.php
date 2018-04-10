@extends("home.layout.layout")
		@section("title","城市列表")
		@section("css")
			<link rel="stylesheet" href="{{asset("home/css/area/modifyAddress.css")}}">
		@endsection
@section("content")
	@component("home.layout.headTwo")
		@endcomponent
	<div class="citySearch">
		<div class="city_top">
			<div class="city_left">
				<img src="{{asset("home/images/area/location.png")}}" alt="">
				<span>猜您在</span>
				<b>北京</b>
			</div>
			<div class="city_right">
				<input id="inputBox" type="text" placeholder="输入收货城市名称快速查看">
				<span id="a">搜索</span>
				<ul>

				</ul>
			</div>
		</div>
		<div class="city_bot">
			<img src="{{asset("home/images/area/hot.png")}}" alt="">
			<span>热门城市</span>
			<b><a href="{{url("area/setCity")}}/1">北京</a></b>
			<b><a href="{{url("area/setCity")}}/183">郑州</a></b>
			<b><a href="{{url("area/setCity")}}/115">常州</a></b>
		</div>
	</div>
	<div class="city_list">
		@foreach($areaInfo as $k=>$v)
		<dl class="clear">
			<dt>
				<a href="####">{{$k}}</a>
			</dt>
			@foreach($v as $k1=>$v1)
				<dd><a href="{{url("area/setCity")}}/{{$v1['id']}}">{{$v1['name']}}</a></dd>
			@endforeach
		</dl>
			@endforeach
	</div>
	@endsection
@section("js")
	<script>
		var url="{{url('/')}}";
	</script>
	<script type="text/javascript" src="{{asset("home/js/area/modifyAddress.js")}}"></script>
@endsection