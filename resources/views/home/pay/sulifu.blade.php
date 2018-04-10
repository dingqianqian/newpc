@extends("home.layout.layout")
        @section("title","速立付")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/pay/sulifu.css')}}">
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
            <img src="{{asset('home/images/shopcart/hongsan.png')}}" alt="">
            <img src="{{asset('home/images/shopcart/huisi.png')}}" alt="">
        </p>
    </div>
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
            <p style="padding-left:16px;">收货人 : <i>{{$orderInfo['take_over_name']}}</i>&nbsp;&nbsp;&nbsp;&nbsp;<em>{{$orderInfo['take_over_tel_no']}}</em></p>
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
    {{--<p class="fash">选择付款方式</p>--}}
    <div class="ddetail">
        <p>速立付支付平台</p>
        <div class="fanshi">
            <img src="{{asset('home/images/shopcart/sufu.png')}}" alt="">
        </div>
        <div class="mimi">
            <span>支付密码 : </span>
            <div class="alieditContainer" id="payPassword_container">
                <input minlength="6" maxlength="6" tabindex="1" id="payPassword_rsainput" name="payPassword_rsainput"
                       class="ui-input i-text" oncontextmenu="return false" onpaste="return false" oncopy="return false"
                       oncut="return false" value="" onclick="this.type='password'" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')">
                <div class="sixDigitPassword" tabindex="0">
                    <i><b></b></i>
                    <i><b></b></i>
                    <i><b></b></i>
                    <i><b></b></i>
                    <i><b></b></i>
                    <i><b></b></i>
                </div>
            </div>
            <span class="bian"><a style="color: #666;" href="{{url('safe/paycode/checkInfo')}}" target="_blank">忘记密码?</a></span>
        </div>
        <!--确认支付方式-->
        <div class="yes">提交订单</div>
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
        //订单详情隐藏或者显示
        $('.youDetail').click(function () {
            if ($(this).children('img').hasClass('cli')) {
                $(this).children('img').removeClass('cli');
            } else {
                $(this).children('img').addClass('cli');
            }
            $('.orderD').slideToggle();
        });
        //支付密码
        $(window).ready(function () {
            $(".i-text").keyup(function () {
                var inp_v = $(this).val();
                var inp_l = inp_v.length;
                for (var x = 0; x <= 6; x++) {
                    $(".sixDigitPassword").find("i").eq(inp_l).addClass("active").siblings("i").removeClass("active");
                    $(".sixDigitPassword").find("i").eq(inp_l).prevAll("i").find("b").css({"display": "block"});
                    $(".sixDigitPassword").find("i").eq(inp_l - 1).nextAll("i").find("b").css({"display": "none"});
                    if (inp_l == 0) {
                        $(".sixDigitPassword").find("i").eq(0).addClass("active").siblings("i").removeClass("active");
                        $(".sixDigitPassword").find("b").css({"display": "none"});
                    }
                    else if (inp_l == 6) {
                        $(".sixDigitPassword").find("b").css({"display": "block"});
                        $(".sixDigitPassword").find("i").eq(5).addClass("active").siblings("i").removeClass("active");
                    }
                }
            });
        });
        //点击密码框出现光标
        $('#payPassword_rsainput').focus(function () {
            var nu = $(this).val().length==6?5:$(this).val().length;
            $('.sixDigitPassword i').eq(nu).addClass('active');
        });
        $('#payPassword_rsainput').blur(function () {
            $('.sixDigitPassword i').each(function (k,v) {
                $(v).removeClass('active');
            })
        });
        //点击确认支付方式
        $('.yes').click(function () {
            var mima = $('#payPassword_rsainput').val();
            if(mima.length==6){
                $.ajax({
                    type:'post',
                    url:'{{url("pay/sulifuPay")}}',
                    data:{no:"{{$orderInfo['no']}}",pay_code:mima},
                    success:function (res) {
                            if(res.err==200)
                            {
                                //layer.msg(res.msg);
                                location.href="{{url('pay/success')}}/{{$orderInfo['no']}}";
                            }else
                                {
                                    layer.msg(res.msg);
                                }
                    },
                    error:function (res) {
                            console.log(res);
                    }
                })
            }else
                {
                    layer.msg("支付密码必须是6位纯数字");
                }
        });
    </script>
@endsection