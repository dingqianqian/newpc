@extends("home.layout.layout")
        @section("title","退换货流程")
        @section("css")
            <link rel="stylesheet" href="{{asset("home/css/footer/liucheng.css")}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url("/")}}">首页</a>/<span>退换货流程</span></p>
</div>
<!--退换货流程内容-->
<div class="conta">
    <img src="{{asset("home/images/footer/liucheng.png")}}" alt="">
</div>
@endsection