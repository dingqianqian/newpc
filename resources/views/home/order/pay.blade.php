@extends("home.layout.layout")
@section("title","订单支付")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/order/curThr.css')}}">
@endsection
@section("content")
    <div class="con">
        <div class="line"></div>
        <!--进度条-->
        <div class="jindu">
            <a href="{{url('/')}}">
                <img src="{{asset('home/images/shopcart/logo.png')}}" alt="">
            </a>
            <p>
                <img src="{{asset('home/images/shopcart/huiyi.png')}}" alt="">
                <img src="{{asset('home/images/shopcart/huier.png')}}" alt="">
                <img src="{{asset('home/images/shopcart/hongsan.png')}}" alt="">
                <img src="{{asset('home/images/shopcart/huisi.png')}}" alt="">
            </p>
        </div>
        <!--ok手势-->
        <dl class="noFu">
            <dt>
                <img src="{{asset('home/images/shopcart/ok.png')}}" alt="">
            </dt>
            <dd class="top">订单提交成功！只差付款了~</dd>
            <dd class="mid">付款金额(元) : <span>{{number_format($orderInfo['price'],2,".","")}}</span>元</dd>
            <dd class="lass">
                <span>请您在</span>
                <div class="dao">
                    <!--<span id="t_d">00</span>天-->
                    <span id="t_h">00</span>小时
                    <span id="t_m">00</span>分
                    <span id="t_s">00</span>秒
                </div>
                <span>内完成支付，否则订单将自动取消</span>
            </dd>
            <dd class="youDetail">
                <span>订单详情</span>
                <img src="{{asset('home/images/shopcart/sanjiao.png')}}" alt="">
            </dd>
        </dl>
        <!--订单详情-->
        <div class="orderD">
            <div class="orderC">
                <p>收货地址 : <span>{{$orderInfo['take_over_addr']}}</span></p>
                <p style="padding-left:16px;">收货人 :
                    <i>{{$orderInfo['take_over_name']}}</i>&nbsp;&nbsp;&nbsp;&nbsp;<em>{{$orderInfo['take_over_tel_no']}}</em>
                </p>
                <p class="adres">商品名称 : </p>
                <ul class="adres aDiv">
                    @foreach($goodsInfo as $k=>$v)
                        <li>
                            {{$v["name"]}}
                        </li>
                    @endforeach
                </ul>
                <p>订单编号 : <span>{{$orderInfo['no']}}</span></p>
                <p>下单时间 : <span>{{date("Y-m-d H:i:s",$orderInfo['create_time'])}}</span></p>
            </div>
        </div>
        <!--选择付款方式-->
        <p class="fash">选择付款方式</p>
        <div class="ddetail">
            <p>支付平台</p>
            <div class="fanshi">
                @if(is_11121())
                    <p class="thr" style="margin-left: 345px;">
                        <span></span>
                        <img src="{{asset('home/images/shopcart/sufu.png')}}" alt="">
                        {{--@if(is_11121())
                            <b>活动日速立付支付价：<em>￥{{number_format($orderInfo['discount_price'],2,".","")}}</em></b>
                        @endif--}}
                    </p>
                @else
                    <p class="one">
                        <span></span>
                        <img src="{{asset('home/images/shopcart/zhifubao.png')}}" alt="">
                    </p>
                    <p class="two">
                        <span></span>
                        <img src="{{asset('home/images/shopcart/weixin.png')}}" alt="">
                    </p>
                    <p class="thr">
                        <span></span>
                        <img src="{{asset('home/images/shopcart/sufu.png')}}" alt="">
                        {{--@if(is_11121())
                            <b>活动日速立付支付价：<em>￥{{number_format($orderInfo['discount_price'],2,".","")}}</em></b>
                        @endif--}}
                    </p>
                @endif
            </div>
            <!--确认支付方式-->
            <div class="yes">确认支付方式</div>
        </div>
    </div>

@endsection
@section("js")
    <script type="text/javascript">
        //倒计时
        function GetRTime() {
            /*if ($('#t_d').text() == 00 && $('#t_h').text() == 00 && $('#t_m').text() == 00 && $('#t_s').text() == 00) {
             ary.splice(0,1);
             }*/
            var EndTime = new Date("{{$time}}"),
                NowTime = new Date(),
                t = EndTime.getTime() - NowTime.getTime(),
                d = 0,
                h = 0,
                m = 0,
                s = 0;
            if (t >= 0) {
                d = Math.floor(t / 1000 / 60 / 60 / 24);
                h = Math.floor(t / 1000 / 60 / 60 % 24);
                m = Math.floor(t / 1000 / 60 % 60);
                s = Math.floor(t / 1000 % 60);
            }
//        document.getElementById("t_d").innerHTML = d;
            document.getElementById("t_h").innerHTML = h < 10 ? '0' + h : h;
            document.getElementById("t_m").innerHTML = m < 10 ? '0' + m : m;
            document.getElementById("t_s").innerHTML = s < 10 ? '0' + s : s;
        }
        setInterval(GetRTime, 0);
        $('.fanshi>p').click(function () {
            $(this).siblings('p').children('span').removeClass('sel');
            $(this).children('span').addClass('sel');
        });
        //订单详情隐藏或者显示
        $('.youDetail').click(function () {
            if ($(this).children('img').hasClass('cli')) {
                $(this).children('img').removeClass('cli');
            } else {
                $(this).children('img').addClass('cli');
            }
            $('.orderD').slideToggle();
        });
        //点击确认支付方式
        $('.yes').click(function () {
            var num = null;
            $('.fanshi span').each(function (k, v) {
                if ($(v).hasClass('sel')) {
                    num = $(v).parent().attr('class');
                }
            });
            if (num == 'one') {
                location.href = "{{url('pay/ali/create')}}/{{$orderInfo['no']}}";
            } else if (num == 'two') {
                location.href = "{{url('pay/weixin/create')}}/{{$orderInfo['no']}}";
            } else if (num == 'thr') {
                location.href = "{{url('pay/sulifu')}}/" + "{{$orderInfo['no']}}";
            } else {
                layer.msg("请选择支付方式");
                return false;
            }
        })
    </script>
@endsection