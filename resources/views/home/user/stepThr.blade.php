@extends("home.layout.layout")
        @section("title","修改验证手机成功")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/paycode/zhifuThr.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>安全设置</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <ul>
            <li><a href="{{url('safe/password/stepOne')}}">修改登录密码</a></li>
            <li><a href="{{url('safe/paycode/checkInfo')}}">支付密码管理</a></li>
            <li><a href="{{url('safe/username/stepOne')}}" class="sec">修改验证手机</a></li>
        </ul>
        <div class="box">
            <img src="{{asset('home/images/safe/degnThr.png')}}" alt="">
            <div>
                <img src="{{asset('home/images/safe/success.png')}}" alt="">
                <p>修改绑定手机成功，点击<a href="{{url('/')}}">商城首页</a>去逛逛吧</p>
            </div>
        </div>
    </div>
</div>
@endsection