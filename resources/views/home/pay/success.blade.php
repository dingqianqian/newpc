@extends("home.layout.layout")
        @section("title","支付成功")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/pay/success.css')}}">
        @endsection
@section("content")
<div class="suCon">
    <div class="line"></div>
    <!--进度条-->
    <div class="jindu">
        <a href="{{url('/')}}">
            <img src="{{asset('home/images/shopcart/logo.png')}}" alt="">
        </a>
        <p>
            <img src="{{asset('home/images/shopcart/huiyi.png')}}" alt="">
            <img src="{{asset('home/images/shopcart/huier.png')}}" alt="">
            <img src="{{asset('home/images/shopcart/huisan.png')}}" alt="">
            <img src="{{asset('home/images/shopcart/hongsi.png')}}" alt="">
        </p>
    </div>
    <!--支付成功-->
    <div class="sc">
        <div class="dl">
            <img src="{{asset('home/images/shopcart/suc.png')}}" alt="">
            <div class="w">
                <p class="z">支付成功</p>
                <p>您的订单号 : <span>{{$orderInfo["no"]}}</span>支付金额 : <em>{{number_format($orderInfo["price"],2,".","")}}</em>元</p>
                <p class="b">由速立派为您发货</p>
            </div>
        </div>
    </div>
    <div class="dji">
        <a class="jix" href="{{url('/')}}">继续购物</a>
        <a class="goB" href="{{url('order/index')}}">返回到我的订单</a>
    </div>

</div>
@endsection