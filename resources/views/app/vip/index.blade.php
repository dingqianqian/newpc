<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>会员特权</title>
    <link rel="stylesheet" href="{{asset("app/css/reset.min.css")}}">
    <link rel="stylesheet" href="{{asset("app/css/app.css")}}">
    <script>
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 750 * 100 + 'px';
    </script>
</head>
<body>
<!--logo部分-->
<div class="appHead">
    <img src="{{asset("app/img/logo.png")}}" alt="">
</div>
<!--个人信息部分-->
<div class="appBody">
    <p class="top">{{$userInfo['username']}}</p>
    <div>
        @if($userInfo['f_vip_level_id']==2)
        <!--黄金会员-->
        <img src="{{asset("app/img/huangjin.png")}}" alt="">
        @else
        <!--普通会员-->
        <img src="{{asset("app/img/putong.png")}}" alt="">
            @endif
    </div>
    <p class="bot">您是宜优速尊贵的黄金会员，可享受众多优惠充值</p>
</div>
<!--充值说明-->
<div class="appContent">
    <p>针对黄金会员特权说明:</p>
    <p>只要您充值满两万，就能成为尊贵的黄金会员！</p>
    <p>充值更能享受高额返现优惠</p>
    <ul>
        {{--@foreach($rechargeTypeInfo as $k=>$v)
        <li>
            <i></i>
            <span>{{$v['description']}}</span>
        </li>
            @endforeach--}}
        <li>
            <i></i>
            <span>充值20000元赠送1800瓶冰露矿泉水</span>
        </li>
        <li>
            <i></i>
            <span>充值50000元赠送4800瓶冰露矿泉水</span>
        </li>
        <li>
            <i></i>
            <span>充值100000元赠送12000瓶冰露矿泉水</span>
        </li>
    </ul>
</div>
<p class="appFooter">最终解释权归北京宜优速电子商务科技有限责任公司所有</p>
</body>
</html>