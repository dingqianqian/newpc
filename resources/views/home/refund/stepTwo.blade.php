@extends("home.layout.layout")
        @section("title","退款处理中")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/refund/tuiTwo.css')}}">
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
        <img src="{{asset('home/images/refund/tuiTwo.png')}}" alt="">
        <div class="top">
            <p>
                <span>订单编号 : <i>{{$orderInfo['no']}}</i></span>
                <span style="margin: 0 150px;">退款进度 ： 退款处理</span>
                <span>申请退款金额 : <i>¥<em>{{number_format($orderInfo['price'],2,".","")}}</em></i></span>
            </p>
            <p>温馨提示 : 您的退款申请处理中，请耐心等待！</p>
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
                <span>您的退款申请已提交</span>
                <span>{{session("userInfo")['username']}}</span>
            </p>
        </div>
        <h4>退款处理信息</h4>
        <form>
            <ul class="bot">
                <li style="border-top:none;">
                    <span>订单编号</span>
                    <p>{{$orderInfo['no']}}</p>
                </li>
                <li>
                    <span>支付明细</span>
                    <p>支付金额 : <i>¥<em>{{number_format($orderInfo['price'],2,".","")}}</em></i></p>
                </li>
                <li class="san">
                    <span>退款原因</span>
                    <p>
                        <input type="radio" checked disabled="disabled">
                        <span>{{$orderInfo['refund_reason']}}</span>
                    </p>
                </li>
                <li>
                    <span>退款说明</span>
                    <p>{{$orderInfo['refund_explain']}}</p>
                </li>
            </ul>
            <input class="deleteAd" type="button"  value="撤销退款">
        </form>
    </div>
</div>
<!--点击确定删除-->
<div class="delHide">
    <div class="zhaozhao">
        <p class="btiao">撤销退款</p>
        <p class="gan">
            <img src="{{asset('home/images/refund/gantanhao.png')}}" alt="">
            <span>您确定要撤销退款吗？</span>
        </p>
        <a class="laL" href=" ">确定</a>
        <a class="noDel" href="javascript:;">取消</a>
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || document.body.clientHeight;
        $('.delHide').css({'width': widthP, 'height': heightP});
        $('.deleteAd').click(function () {
            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {   // 确定
                $('.delHide').fadeOut(300);
                location.href="{{url('refund/repeal')}}/{{$orderInfo['no']}}";
                return false;
            });
            $('.noDel').click(function () {  // 取消
                $('.delHide').fadeOut(300);
                return false;
            });
        });
    </script>
    @endsection