@extends("home.layout.layout")
        @section("title","申请退款")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/refund/tuiOne.css')}}">
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
        <h3>申请退款</h3>
        <img src="{{asset('home/images/refund/tuiOne.png')}}" alt="">
        <div class="top">
            <p>
                <span>订单编号 : <i>{{$orderInfo['no']}}</i></span>
                <span style="margin: 0 150px;">退款进度 ： 提交申请</span>
                <span>申请退款金额 : <i>¥<em>{{number_format($orderInfo['price'],2,".","")}}</em></i></span>
            </p>
            <p>温馨提示 : 退款成功后，支付金额将原路退回至您的支付账号中，请耐心等待！</p>
        </div>
        {{--<h4>退款处理进度</h4>
        <div class="mid">
            <p>
                <span>处理时间</span>
                <span>处理信息</span>
                <span>申请人</span>
            </p>
            <p>
                <span>2017-06-21 16:13:56</span>
                <span>您的退款申请已提交</span>
                <span>小胖子啦啦啦啦</span>
            </p>
        </div>
        <h4>申请单详细信息</h4>--}}
        <h4></h4>
        <form method="post" action="{{url('refund/manage')}}">
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
                    <div>
                        <p>
                            <label style="margin-right: 96px;">
                                <input type="radio"  value="做工粗糙，有瑕疵" name="cuoW">
                                <span>做工粗糙，有瑕疵</span>
                            </label>
                            <label>
                                <input type="radio" value="买家发错货" name="cuoW">
                                <span>买家发错货</span>
                            </label>
                        </p>
                        <p>
                            <label style="margin-right: 48px;">
                                <input type="radio"  value="收到商品时有破损、污渍" name="cuoW">
                                <span>收到商品时有破损、污渍</span>
                            </label>
                            <label>
                                <input type="radio" value="未按约定时间发货" name="cuoW">
                                <span>未按约定时间发货</span>
                            </label>
                        </p>
                    </div>
                </li>
                <li>
                    <span>退款说明</span>
                    <p>
                        <input id="shuoming" class="mowe" name="explain" type="text" placeholder="请在此处填写退款说明">
                    </p>
                </li>
            </ul>
            {{csrf_field()}}
            <input type="hidden" name="no" value="{{$orderInfo['no']}}">
            <input type="submit" value="提交退款">
        </form>
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        $('.tStepCont form>input').click(function () {
            var xuan = 0;
            $('input[name="cuoW"]').each(function (k, v) {
                if (!$(v).prop('checked')) {
                    xuan++;
                }
            });
            if (xuan == 4) {
                layer.msg('请选择退款原因');
                return false;
            } else {
                if ($('#shuoming').val().length == 0) {
                    layer.msg('请填写退款说明');
                    return false;
                } else {

                }
            }
        })
        @if(session("msg"))
            layer.msg("{{session("msg")}}");
            @endif
    </script>
@endsection