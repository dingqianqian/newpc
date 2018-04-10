@extends("home.layout.layout")
@section("title","速立付")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/wallet/sulifu.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>速立付</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <h5>
            <img src="{{asset('home/images/wallet/qian.png')}}" alt="">
            <span>速立付</span>
        </h5>
        <p class="myJifen">
            <span>速立付余额 : <i>￥<em>{{number_format($wallet,2,".","")}}</em></i></span>
            <a href="{{url('recharge/index')}}">我要充值</a>
        </p>
        <p class="yiJu">充值记录</p>
        {{--暂无优惠券--}}
        @if(!$rechargeInfo)
        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
            <img src="{{asset('home/images/comment/zzwu.png')}}" style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">暂无充值记录~</span>
        </p>
        @else
        <div class="ulTit">
            <span>充值日期</span>
            <span>充值金额</span>
            <span>赠送金额</span>
            <span>支付方式</span>
        </div>
        <ul>
            @foreach($rechargeInfo as $k=>$v)
            <li>
                <span>{{date("Y-m-d H:i:s",$v['create_time'])}}</span>
                <span>￥<i>{{number_format($v['price'],2,".","")}}</i></span>
                <span>￥<i>{{number_format($v['give_back'],2,".","")}}</i></span>
                <span>{{$v['pay_type']['name']}}</span>
            </li>
                @endforeach
        </ul>
            @endif
    </div>
</div>
@endsection