@extends("home.layout.layout")
        @section("title","充值")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/recharge/recharge.css')}}">
        @endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>充值中心</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
@component("home.layout.sidebar",["index"=>$index])
@endcomponent
    <div class="tStepCont">
        <p>充值金额如下 : </p>
        {{--<ul class="clear">
            @foreach($rechargeTypeInfo as $k=>$v)
            <li money="{{$v['money']}}">
                <span></span>
                <img src="{{$v['url']}}" alt="">
            </li>
            @endforeach
        </ul>--}}
        <ul class="clear">
            <li money="2000">
                <span></span>
                <img src="{{asset("home/images/recharge/2001.png")}}" alt="">
            </li>
            <li money="5000">
                <span></span>
                <img src="{{asset("home/images/recharge/5001.png")}}" alt="">
            </li>
            <li money="10000">
                <span></span>
                <img src="{{asset("home/images/recharge/10001.png")}}" alt="">
            </li>
            <li money="20000">
                <span></span>
                <img src="{{asset("home/images/recharge/200001.png")}}" alt="">
            </li>
            <li money="50000">
                <span></span>
                <img src="{{asset("home/images/recharge/500001.png")}}" alt="">
            </li>
            <li money="100000">
                <span></span>
                <img src="{{asset("home/images/recharge/1000001.png")}}" alt="">
            </li>
        </ul>
        <div class="zhiFan">
            <span>选择支付方式 : </span>
            <p style="padding-right:24px;" fang="1">
                <i class="zhi"></i>
                <img src="{{asset('home/images/recharge/zhifubao.png')}}" alt="">
                <em>支付宝支付</em>
            </p>
            <p fang="2">
                <i class="wei"></i>
                <img src="{{asset('home/images/recharge/weixin.png')}}" alt="">
                <em>微信支付</em>
            </p>
        </div>
        <a href="javascript:;">确定充值</a>
    </div>
</div>
@endsection
@section("js")
    <script>
        $('.tStepCont li').click(function () {
            $('.tStepCont li').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            if(($(this).attr('money') == 200000)||($(this).attr('money') == 500000)){
                layer.msg('该充值方式暂不支持大额交易，如需加入合约计划，请拨打 : 40018-11121',{time:5000});
                $('.zhiFan').fadeOut();
            }else{
                $('.zhiFan').fadeIn();
            }
        });
        $('.zhiFan>p').click(function () {
            $('.zhiFan>p').each(function (e, i) {
                $(i).removeClass('sec');
            });
            $(this).addClass('sec');
            $('.tStepCont>a').css('display', 'block');
        });
        //点击跳转支付接口
        $('.tStepCont>a').click(function () {
            var mon = null,
                type = null;
            $('.tStepCont>ul>li').each(function (k,v) {
                if($(v).hasClass('sec')){
                    mon = $(v).attr('money');
                    return false;
                }
            });
            $('.zhiFan>p').each(function (m,n) {
                if($(n).hasClass('sec')){
                    type = $(n).attr('fang');
                    return false;
                }
            });
            location.href="{{url('recharge/create')}}?type="+type+"&price="+mon;
        })
    </script>
    @endsection