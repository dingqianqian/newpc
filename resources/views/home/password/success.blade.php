@extends("home.layout.layout")
        @section("title","找回成功")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/password/success.css')}}">
        @endsection
@section("content")
<div class="goB">
    <div class="find-con">
        <a class="shou" href="{{url('/')}}">
            <img src="{{asset('home/images/login/logo.pn')}}g" alt="">
        </a>
        <span>找回密码</span>
        <a class="goS" href="{{url('/')}}">
            <span>返回首页</span>
            <img src="{{asset('home/images/login/youjian.png')}}" alt="">
        </a>
    </div>
</div>
<p class="forgot-Jin">
    <img src="{{asset('home/images/login/forgot-thr.png')}}" alt="">
</p>
<img id="xiao" src="{{asset('home/images/login/wancheng.png')}}" alt="">
<a id="suLi" href="{{url('login')}}">立即登录</a>
@endsection