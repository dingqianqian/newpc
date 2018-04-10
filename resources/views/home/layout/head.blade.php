<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>@yield("title")</title>
    <link rel="stylesheet" href="{{asset('home/css/common/reset.min.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/common/head.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/common/footer.css')}}">
    @yield("css")
</head>
<body style="font-size: 0;">
<div class="contai">
    <!--头部-->
    <div style="background-color:#fff;">
        <div class="head">
            <div class="head_l">
                <div>
                    <img src="{{asset('home/images/dingwei.png')}}" alt="定位">
                    <span id="wspan">{{session("city")}}</span>
                    <i class="ixia"></i>
                    <ul class="city">
                        <li>北京</li>
                        <li>天津</li>
                        <li>上海</li>
                        <li>重庆</li>
                        <li>河北</li>
                        <li>山西</li>
                        <li>辽宁</li>
                        <li>吉林</li>
                        <li>黑龙江</li>
                        <li>江苏</li>
                        <li>浙江</li>
                        <li>安徽</li>
                        <li>福建</li>
                        <li>江西</li>
                        <li>山东</li>
                        <li>河南</li>
                        <li>湖北</li>
                        <li>湖南</li>
                        <li>广东</li>
                        <li>海南</li>
                        <li>四川</li>
                        <li>贵州</li>
                        <li>云南</li>
                        <li>陕西</li>
                        <li>甘肃</li>
                        <li>青海</li>
                        <li>内蒙古</li>
                        <li>广西</li>
                        <li>西藏</li>
                        <li>宁夏</li>
                        <li>新疆</li>
                        <li>香港</li>
                        <li>澳门</li>
                        <li>台湾</li>
                        <li>钓鱼岛</li>
                    </ul>
                </div>
                <em>欢迎访问宜优速商城 !</em>
            </div>
            <div class="head_m">
                @if(session("userInfo"))
                    <a href="">{{session("userInfo")["username"]}}</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{url('logout')}}">[退出]</a>
                @else
                    <span>您好，请</span>
                    <a href="{{url('login')}}">[登录]</a>
                    <a href="{{url('register')}}">[快速注册]</a>
                @endif
            </div>
            <div class="head_r">
            <span class="r-fir">
                <a href="{{url('shopCart/index')}}">
                    <img src="{{asset('home/images/shopC.png')}}" alt="">
                    <span>购物车</span>
                </a>
            </span>
                <span class="r_one">我的订单
            <img src="{{asset('home/images/xia.png')}}" alt="">
            <ul>
                <li><a href="http://www.yiyousu.cn/v2.1.8/pc/User/index/order3">待支付</a></li>
                <li><a href="http://www.yiyousu.cn/v2.1.8/pc/User/index/order4">待收货</a></li>
                <li><a href="http://www.yiyousu.cn/v2.1.8/pc/User/index/evaluate">待评价</a></li>
                <!--<li><a href="javascript:;">修改订单</a></li>-->
            </ul>
        </span>
                <span class="shou"><a href="{{url('collect/index')}}">收藏的商品</a></span>
                <span class="myi"><a href="http://www.yiyousu.cn/v2.1.8/pc/User/index">我的宜优速</a></span>
                <span class="r-two">
            <img src="{{asset('home/images/shouiji.png')}}" alt="">掌上宜优速
            <img class="bot" src="{{asset('home/images/app.gif')}}" alt="">
        </span>
            </div>
        </div>
    </div>
    @yield("content")
</div>
<script type="text/javascript" src="{{asset('home/js/common/jquery-1.11.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/layer/layer.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.city li').click(function () {
        $('#wspan').text($(this).text());
        var val = $(this).text();
        $.ajax({
            type: 'get',
            data:{city:val},
            url:"{{url('setCity')}}" ,
            success:function (res) {

            }
        });
    });
</script>
@yield("js")
</body>
</html>