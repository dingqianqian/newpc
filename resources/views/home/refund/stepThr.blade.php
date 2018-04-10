@extends("home.layout.layout")
        @section("title","退款完成")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/refund/tuiThr.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>退款</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <h3>退款记录</h3>
        <img src="{{asset('home/images/refund/tuiThr.png')}}" alt="">
        <div class="top">
            <p>
                <span>订单编号 : <i>{{$orderInfo['no']}}</i></span>
                <span style="margin: 0 150px;">退款进度 ： 退款完成</span>
                <span>申请退款金额 : <i>¥<em>{{number_format($orderInfo['price'],2,".","")}}</em></i></span>
            </p>
            <p>温馨提示 : 此订单已退款完成，不同支付方式的到账时间不同，请到您的原支付账户中进行查询，如有疑问请拨打:40018-11121</p>
        </div>
        <h4>退款处理进度</h4>
        <div class="mid">
            <p>
                <span>处理时间</span>
                <span>处理信息</span>
                <span>申请人</span>
            </p>
            <p>
                <span>{{date("Y-m-d H:i:s",$orderInfo['refund_time'])}}</span>
                <span>完成</span>
                <span>{{session("userInfo")['username']}}</span>
            </p>
        </div>
        <a href="{{url('/')}}">返回商城首页</a>
    </div>
</div>
@endsection