@extends("home.layout.layout")
        @section("title","购物流程")
        @section("css")
            <link rel="stylesheet" href="{{asset("home/css/footer//moban.css")}}">
            <style>
                .dlCont {
                    margin: 0 auto 68px;
                    padding: 24px 0 0;
                    width: 1200px;
                }
            </style>
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="javascript:;">首页</a>/<span>帮助中心</span></p>
</div>
<div class="dlCont">
    <img src="{{asset("home/images/footer/jiangjie.png")}}" alt="">
</div>
@endsection