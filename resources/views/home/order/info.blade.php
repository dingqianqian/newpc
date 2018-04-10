@extends("home.layout.layout")
        @section("title","订单详情")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/order/daifukuan.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<a href="{{url("order/index")}}">所有订单</a>/<span>查看详情</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont clear">
        <h4>订单状态：{{$orderInfo['order_form_status']['name']}}</h4>
        <div class="a clear">
            <table class="oneTa">
                <thead style="height:50px;line-height: 50px;">
                <tr>
                    <th>商品名称</th>
                    <th>商品规格</th>
                    @foreach($orderInfo['order_goods'] as $k=>$v)
                        @if($v['f_custom_id'] !== 0)
                    <th>定制信息
                        @endif
                    @endforeach
                    <th>数量</th>
                    <th>单价</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orderInfo['order_goods'] as $k=>$v)
                <tr>
                    <td>
                        <p>
                            <em>{{$v['info']['goods']['name']}}</em>
                        </p>
                    </td>
                    <td>
                        @if($v['f_custom_id'] !== 0)
                            {{$v['info']['name']}}
                        @else
                           @foreach($v['info']['norms_name'] as $k1=>$v1)
                             @if($loop->index==2)
                                {{$v1['name']}}
                             @else
                                {{$v1['name']}},
                                @endif
                            @endforeach
                       @endif
                    </td>
                        @if($v['f_custom_id'] !== 0)
                    <td>{{$v['custom_name']}}</td>
                        @endif
                    <td>{{$v['number']}}</td>
                    <td>¥<span>{{number_format($v['deal_min_price'],2,".","")}}</span></td>
                </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- <p>
                <span>操作</span>
                <a href="javascript:;">立即评价</a>
                <a href="javascript:;">删除订单</a>
                <a href="javascript:;">申请退货</a>
            </p> -->
        </div>
        <h5 class="clear">订单信息</h5>
        <ul class="topUl clear">
            <li>
                <span>订单编号</span>
                <p>{{$orderInfo['no']}}</p>
            </li>
            <li>
                <span>支付方式</span>
                <p>在线支付</p>
            </li>
            <li>
                <span>配送方式</span>
                <p>速立派</p>
            </li>
            <li>
                <span>付款时间</span>
                @if($orderInfo['pay_time']==0)
                    <p>未支付</p>
                    @else
                    <p>{{date("Y-m-d H:i:s",$orderInfo['pay_time'])}}</p>
                @endif
            </li>
            {{--<li>
                <span>发货时间</span>
                <p>2017-05-12</p>
            </li>
            <li>
                <span>签收时间</span>
                <p>2017-05-12</p>
            </li>--}}
        </ul>
        <h5>收货人信息</h5>
        <ul class="midUl">
            <li>
                <span>收货人姓名</span>
                <p>{{$orderInfo['take_over_name']}}</p>
            </li>
            <li>
                <span>收货人地址</span>
                <p>{{$orderInfo['take_over_addr']}}</p>
            </li>
            <li>
                <span>联系方式</span>
                <p>{{$orderInfo['take_over_tel_no']}}</p>
            </li>
        </ul>
        {{--<h5>发票信息</h5>
        <ul class="botUl">
            <li>
                <span>发票类型</span>
                <p>普通发票</p>
            </li>
            <li>
                <span>发票抬头</span>
                <p>小盘子自</p>
            </li>
        </ul>--}}
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript" src="{{asset('home/js/common/clamp.min.js')}}"></script>
    <script type="text/javascript">
        //h4一行水平垂直居中显示，两行自适应，溢出省略号
        $('p em').each(function (j, l) {
            var t = 40 / $(l).height();
            $(l).css({
                lineHeight: t * 21 + "px"
            });
            if (parseFloat($(l).css('lineHeight')) <= 20) {
                $(l).css({'lineHeight': '20px'});
                $clamp($(l)[0], {clamp: 2});
            }
        });
        //表格边框
        $('.oneTa th,.oneTa td').css('border','1px solid #ccc')
    </script>
    @endsection