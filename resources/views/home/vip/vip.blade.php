@extends("home.layout.layout")
@section("title","黄金会员")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/vip/putong.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>会员特权</span></p>
    </div>
    <div class="oStep clear">
        <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <!--右侧内容-->
        <div class="tStepCont">
            <div class="touXia">
                @if(file_exists(env("HEADIMG")."/".session("userInfo")["id"].".jpg"))
                    <p><img src="{{env("YYSURL")}}/Public/UserHeadImg/{{session('userInfo')['id']}}.jpg" alt=""></p>
                @else
                    <p><img src="{{asset('home/images/vip/huiyuanP.png')}}"></p>
                @endif
                <div>
                    <p style="margin-bottom:10px;">用户名</p>
                    <p>尊敬的黄金会员您好~</p>
                </div>
            </div>
            <p class="biao">
                <img src="{{asset('home/images/vip/huangjin.png')}}" alt="">
                <span>黄金会员</span>
                <a href="javascript:;">立即充值</a>
            </p>
            <!--<p class="muqian">目前可享受众多充值优惠，充值说明如下 : </p>-->
            <!--<p class="zhiyao">只要您充值满两万元，就能成为尊贵的黄金会员！充值更能享受高额返现优惠！</p>-->
            <p class="zhiyao" style="margin-top:11px;">目前可享受众多充值优惠。充值金额更多能享受更高额返现优惠！</p>
            <p class="shuoming">充值说明</p>
            <ul>
                <li>
                    <img src="{{asset('home/images/vip/weidian.png')}}" alt="">
                    <span>充值20000元-赠送1000元</span>
                </li>
                <li>
                    <img src="{{asset('home/images/vip/weidian.png')}}" alt="">
                    <span>充值50000元-赠送3000元</span>
                </li>
                <li>
                    <img src="{{asset('home/images/vip/weidian.png')}}" alt="">
                    <span>充值100000元-赠送7000元</span>
                </li>
                {{--<li>
                    <img src="{{asset('home/images/vip/weidian.png')}}" alt="">
                    <span>充值200000元-赠送20000元</span>
                </li>
                <li style="margin-bottom:0;">
                    <img src="{{asset('home/images/vip/weidian.png')}}" alt="">
                    <span>充值500000元-赠送50000元</span>
                </li>--}}
            </ul>
            <p class="zuizhong">最终解释权归宜优速电子商务科技有限责任公司所有</p>
        </div>
    </div>
@endsection