@extends("home.layout.layout")
@section("title","退货处理中")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/returnsale/huoTwo.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>退货</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <h3>退货记录</h3>
        <img src="{{asset("home/images/returnsale/tuiTwo.png")}}" alt="">
        <div class="top">
            <p>
                <span>订单编号 : <i>{{$orderInfo['no']}}</i></span>
                <span style="margin: 0 150px;">退货进度 ： 退货处理</span>
                <span>申请退货金额 : <i>¥<em>{{number_format($orderInfo['price'],2,".","")}}</em></i></span>
            </p>
            <p>温馨提示 : 您的退货申请处理中，请耐心等待！</p>
        </div>
        <h4>退货处理进度</h4>
        <div class="mid">
            <p>
                <span>处理时间</span>
                <span>处理信息</span>
                <span>申请人</span>
            </p>
            <p>
                <span>{{date("Y-m-d H:i:s",$orderInfo['return_goods_time'])}}</span>
                <span>您的退货申请已提交</span>
                <span>{{session("userInfo")["username"]}}</span>
            </p>
        </div>
        <h4>退货处理信息</h4>
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
                <li>
                    <span>申请凭据</span>
                    <p>
                        {{--<input type="radio" checked disabled="disabled">--}}
                        @if($orderInfo['is_fixed_invoice']==1)
                            <span><i>此订单已索取发票,请将已开发票一并寄回</i><em>(注:发票丢失不予处理退货流程,敬请谅解!)</em></span>
                            @else
                            <span><i>此订单未索取发票,请保证货品完好无损的寄回</i><em></em></span>
                        @endif
                    </p>
                </li>
                <li>
                    <span>快递方式</span>
                    <p>
                        {{--<input type="radio" checked disabled="disabled">--}}
                        @if($orderInfo['return_goods_style']=="速立派")
                        <span><i>{{$orderInfo['return_goods_style']}}</i><em>(速立派将在3～5天内上门取件-免快递费)</em></span>
                            @else
                            <span><i>{{$orderInfo['return_goods_style']}}</i><em></em></span>
                        @endif
                    </p>
                </li>
                <li class="san">
                    <span>退货原因</span>
                    <p>
                        {{--<input type="radio" checked disabled="disabled">--}}
                        <span>{{$orderInfo['return_goods_reason']}}</span>
                    </p>
                </li>
                <li>
                    <span>退货说明</span>
                    <p>{{$orderInfo['return_goods_explain']}}</p>
                </li>
            </ul>
            <input class="deleteAd" type="button" onclick="fun1()" value="撤销退货">
        </form>
    </div>
</div>
<!--点击确定删除-->
<div class="delHide">
    <div class="zhaozhao">
        <p class="btiao">撤销退货</p>
        <p class="gan">
            <img src="{{asset('home/images/returnsale/gantanhao.png')}}" alt="">
            <span>您确定要撤销退货吗？</span>
        </p>
        <a class="laL" href="javascript:;">确定</a>
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
                location.href="{{url('returnSale/repeal')}}/{{$orderInfo['no']}}";
                $('.delHide').fadeOut(300);
            });
            $('.noDel').click(function () {  // 取消
                $('.delHide').fadeOut(300);
            });
        });
        @if(session("msg"))
            layer.msg("{{session("msg")}}");
            @endif
    </script>
@endsection