@extends("home.layout.layout")
        @section("title","我的积分")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/integral/myJ.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>我的积分</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <h4>
            <img src="{{asset('home/images/integral/wode.png')}}" alt="">
            <span>我的积分</span>
        </h4>
        <p>
            <span>我的积分 : <i>{{$integrals}}</i></span>
            <a href="{{url('/integral/shop/index')}}">前往积分商城</a>
        </p>
        @if(!$integralInfo)
        {{--暂无优惠券--}}
        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
            <img src="{{asset('home/images/comment/zzwu.png')}}" style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无获取/兑换记录~</span>
        </p>
        @else
        <div class="jiTit">
            <span>积分</span>
            <span>获取说明/兑换商品</span>
            <span>时间</span>
        </div>
        <ul>
            @foreach($integralInfo as $k=>$v)
            <li>
                <span><i></i><em>{{$v['number']}}</em></span>
                <span>{{$v["explain"]}}</span>
                <span>{{date("Y-m-d H:i:s",$v['create_time'])}}</span>
            </li>
                @endforeach
        </ul>
            @endif
    </div>
</div>
@endsection