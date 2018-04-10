@extends("home.layout.layout")
        @section("title","设置支付密码成功")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/paycode/san.css')}}">
        @endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>安全设置</span></p>
</div>
<div class="oStep clear">
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <div class="sStepCon">
        <div class="zhaoJin">
            <img src="{{asset('home/images/paycode/zhaoThr.png')}}" alt="">
        </div>
        <div class="thr-step">
            <img src="{{asset('home/images/paycode/xiugaichenggong.png')}}" alt="">
            <p>修改支付密码成功，点击<a href="{{url('/')}}">商城首页</a>去逛逛吧</p>
        </div>
        <div id="dibu">
            <h5>为什么要进行身份验证？</h5>
            <p>为保障您的账户信息安全，在变更账户中的重要信息时需要进行身份验证，感谢您的理解和支持</p>
        </div>
    </div>
</div>
@endsection