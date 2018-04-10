@extends("home.layout.layout")
        @section("title","个人信息")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/person/geInfo.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>个人信息</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <div class="conTop">
            <a class="pic" href="javascript:;">
                @if(file_exists(env("HEADIMG")."/".session("userInfo")["id"].".jpg"))
                    <img src="{{env("YYSURL")}}/Public/UserHeadImg/{{session('userInfo')['id']}}.jpg" alt="">
                @else
                    <img src="{{asset('home/images/vip/gerenP.png')}}" alt="">
                @endif
            </a>
            <div class="titTop">
                <p style="margin-top: -14px;line-height: 40px;">
                    <span>{{session("userInfo")['username']}}</span>
                    <i>{{getStrTime()}}~</i>
                </p>
                <p class="sishi">
                    <span>速立付余额 : ¥<i>{{number_format($userInfo['wallet'],2,".","")}}</i></span>
                    <span>我的积分 : <i>{{$userInfo['integral']}}</i></span>
                </p>
                <p class="huiy">
                    <span>会员等级 : </span>
                    @if($userInfo['f_vip_level_id']==1)
                    <i class="huiO"></i>
                    <em>普通会员</em>
                    @else
                    <i class="huiT"></i>
                    <em>黄金会员</em>
                        @endif
                </p>
                <p class="cuan clear">
                    <a href="{{url('person/update')}}">
                        <i></i>
                        <em>修改个人信息</em>
                    </a>
                    <a href="{{url("takeOver/index")}}">
                        <i></i>
                        <em>收货地址管理</em>
                    </a>
                    <a href="{{url('safe/username/stepOne')}}">
                        <i></i>
                        <em>改绑手机</em>
                    </a>
                </p>
            </div>
            <a href="{{url('person/update')}}" class="chongzhi">立即重置</a>
        </div>
        <div class="conMid">
            <ul>
                <li>
                    <h5>
                        <i></i>
                        <span>当日任务</span>
                    </h5>
                    <p>
                        <span>签到领红包，好礼送不停</span>
                        <a href="{{url('checkIn/index')}}">立即签到 ></a>
                    </p>
                </li>
            </ul>
        </div>
        <ul class="conBot">
            <li>
                <img src="{{asset('home/images/person/priOne.png')}}" alt="">
                <p>待发货的订单 : <span>{{$data[2]}}</span></p>
                <a href="{{url('order/index/2')}}">查看待发货的订单</a>
            </li>
            <li>
                <img src="{{asset('home/images/person/priTwo.png')}}" alt="">
                <p>待收货的订单 : <span>{{$data['4']}}</span></p>
                <a href="{{url('order/index/4')}}">查看待收货的订单</a>
            </li>
            <li>
                <img src="{{asset('home/images/person/priThr.png')}}" alt="">
                <p>待付款的订单 : <span>{{$data['3']}}</span></p>
                <a href="{{url('order/index/3')}}">查看待付款的订单</a>
            </li>
            <li>
                <img src="{{asset('home/images/person/priFour.png')}}" alt="">
                <p>已签收的订单 : <span>{{$data['14']}}</span></p>
                <a href="{{url('order/index/14')}}">查看已签收的订单</a>
            </li>
        </ul>
    </div>
</div>
@endsection