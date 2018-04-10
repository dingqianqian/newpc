@extends("home.layout.layout")
        @section("title","所有订单")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/order/allOrder.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>所有订单</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <h3>我的订单</h3>
        <div class="sear clear">
            <ul class="outx">
                <li @if($status==0||$status==1010) class="sec" @endif style="border-left:none;" ><a href="{{url('order/index/0')}}">全部订单</a></li>
                <li @if($status==3) class="sec" @endif ><a href="{{url('order/index/3')}}">待付款<span>({{$data[3]}})</span></a></li>
                <li @if($status==2) class="sec" @endif ><a href="{{url('order/index/2')}}">待发货<span>({{$data[2]}})</span></a></li>
                <li @if($status==4) class="sec" @endif ><a href="{{url('order/index/4')}}">待收货<span>({{$data[4]}})</span></a></li>
                <li @if($status==14||$status==15) class="sec" @endif><a href="{{url('order/index/14')}}">已签收<span>({{$data[14]}})</span></a></li>
            </ul>
            <p>
                <input type="text" id="search" placeholder="请输入订单编号或商品编号">
                <a href="javascript:;" onclick="fun1()">搜索</a>
            </p>
        </div>
        @if(!$orderInfo['data'])
        {{--暂无优惠券--}}
        <p style="width: 100%;text-align: center;margin: 264px 0 264px 0;">
            <img src="{{asset('home/images/comment/zzwu.png')}}" style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您的订单暂无商品~</span>
        </p>
        @else
        <div class="xCon">
            <!--全部订单-->
            <div class="sec">
                <div class="xConTit">
                    <div class="xConOne">
                        <p>
                            <span>全部订单</span>
                            {{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}
                        </p>
                        {{--<ul class="inx">
                            <li class="slec">全部订单</li>
                            <li>近三日的订单</li>
                            <li>近一周的订单</li>
                            <li>近一个月的订单</li>
                        </ul>--}}
                    </div>
                    <div class="xConTwo">支付金额</div>
                    <div class="xConThr">数量</div>
                    <div class="xConFour">收货人</div>
                    <div class="xConFive">
                        <p>
                            <span>订单状态</span>
                            {{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}
                        </p>
                        {{--<ul class="zhuTai">
                            <li><a href="javascript:;">待付款</a></li>
                            <li><a href="javascript:;">待发货</a></li>
                            <li><a href="javascript:;">待收货</a></li>
                            <li><a href="javascript:;">已签收</a></li>
                        </ul>--}}
                    </div>
                    <div class="xConSix">操作</div>
                </div>
                <div class="inxCon">
                    <!--全部订单-->
                    <ul class="orList slec">
                        <!--待付款-->
                        @foreach($orderInfo['data'] as $k=>$v)
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>{{date('Y-m-d',$v['create_time'])}}</i></span>
                                <span>订单编号 : <i style="color:#333;">{{$v['no']}}(地区:{{$v['area']?$v['area']['name']:"暂无"}})</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    @foreach($v['order_goods'] as $k1=>$v1)
                                    <li>
                                        <p>
                                            <b>
                                                <img src="{{$v1['img_url']}}" alt="">
                                            </b>
                                            <span>{{$v1['name']}}</span>
                                        </p>
                                        <p>
                                            <span>¥<i>{{number_format($v1['deal_min_price'],2,".","")}}</i></span>
                                        </p>
                                        <p>{{$v1['number']}}</p>
                                    </li>
                                    @endforeach
                                </ul>
                                <p>
                                    <span><i>{{$v['take_over_name']}}</i></span>
                                    <span>
                                    <i>{{$v['order_form_status']['name']}}</i>
                                    <a href="{{url("order/info")}}/{{$v['no']}}/1">查看详情</a>
                                </span>
                                    <span>
                                        {{--订单已取消--}}
                                        @if($v['f_order_form_status_id']==1)
                                            <a class="oneBot deleteAd" style="margin-top:57px;" ids="{{$v['id']}}" href="javascript:;">删除订单</a>
                                        @endif
                                        {{--待付款--}}
                                        @if($v['f_order_form_status_id']==3)
                                    <a class="oneTop" href="{{url('order/pay/')}}/{{$v['no']}}">马上支付</a>
                                    <a class="oneBot deleteAd" ids="{{$v['id']}}" href="javascript:;">删除订单</a>
                                        @endif
                                        {{--待发货--}}
                                        @if($v['f_order_form_status_id']==2)
                                            @if($v["is_reminder"]==0)
                                        <a class="twoTop" ids="{{$v['id']}}" onclick="reminder(this)" href="javascript:;">提醒发货</a>
                                            @endif
                                    <a class="twoBot" href="{{url('refund/info')}}/{{$v['no']}}">申请退款</a>
                                        @endif
                                        {{--待收货--}}
                                        @if($v['f_order_form_status_id']==4||$v['f_order_form_status_id']==5)
                                        <a class="thrTop" ids="{{$v['id']}}" onclick="signIn(this)" href="javascript:;">立即签收</a>
                                        @endif
                                        {{--退款中--}}
                                        @if($v['f_order_form_status_id']==6)
                                            <a class="thrTop" href="{{url('refund/info')}}/{{$v['no']}}" style="color:#980c3f">查看进度</a>
                                            @endif
                                        @if($v['f_order_form_status_id']==7)
                                            <a class="thrTop" href="javascript:;" style="color:#333;">退款完成</a>
                                        @endif
                                        @if($v['f_order_form_status_id']==10)
                                            <a class="thrTop" href="{{url('returnSale/info')}}/{{$v['no']}}" style="color:#980c3f;">查看进度</a>
                                        @endif
                                        @if($v['f_order_form_status_id']==11)
                                            <a class="thrTop" href="{{url('returnSale/info')}}/{{$v['no']}}" style="color:#333;">退货完成</a>
                                        @endif
                                        {{--已签收--}}
                                        @if($v['f_order_form_status_id']==14||$v['f_order_form_status_id']==15)
                                            @if($v['is_evalute']==0)
                                        <a class="fourTop" href="{{url('comment/info')}}/{{$v['no']}}">立即评价</a>
                                            @else
                                        <a class="fourTop" href="{{url('comment/list')}}/{{$v['no']}}">查阅已评</a>
                                            @endif
                                    <a class="fourMid" href="{{url('returnSale/info')}}/{{$v['no']}}">申请退货</a>
                                    <a class="fourBot deleteAd" ids="{{$v['id']}}" href="javascript:;">删除订单</a>
                                            @endif
                                </span>
                                </p>
                            </div>
                        </li>
                        @endforeach
                        {{--<!--待发货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <!--已签收-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>--}}
                    </ul>
                    <!--近三日订单-->
                    {{--<ul class="orList">
                        <!--待收货-->
                        @foreach($orderInfo['data'] as $k=>$v)
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        @endforeach
                        --}}{{--<!--已签收-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>--}}{{--
                    </ul>
                    <!--近一周的订单-->
                    <ul class="orList">
                        <!--待发货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <!--已签收-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近一个月的订单-->
                    <ul class="orList">
                        <!--待付款-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <!--待发货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <!--已签收-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                    </ul>--}}
                </div>
            </div>
            {{--<!--待付款-->
            <div>
                <div class="xConTit">
                    <div class="xConOne">
                        <p>
                            <span>全部订单</span>
                            --}}{{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}{{--
                        </p>
                       --}}{{-- <ul class="inx">
                            <li class="slec">全部订单</li>
                            <li>近三日的订单</li>
                            <li>近一周的订单</li>
                            <li>近一个月的订单</li>
                        </ul>--}}{{--
                    </div>
                    <div class="xConTwo">支付总金额</div>
                    <div class="xConThr">数量</div>
                    <div class="xConFour">收货人</div>
                    <div class="xConFive">
                        <p>
                            <span>订单状态</span>
                            --}}{{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}{{--
                        </p>
                        --}}{{--<ul class="zhuTai">
                            <li><a href="javascript:;">待付款</a></li>
                            <li><a href="javascript:;">待发货</a></li>
                            <li><a href="javascript:;">待收货</a></li>
                            <li><a href="javascript:;">已签收</a></li>
                        </ul>--}}{{--
                    </div>
                    <div class="xConSix">操作</div>
                </div>
                <div class="inxCon">
                    <!--全部订单-->
                    <ul class="orList slec">
                        <!--待付款-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近三日-->
                    <ul class="orList">
                        <!--待付款-->
                        @foreach($orderInfo['data'] as $k=>$v)
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>{{date('Y-m-d',$v['create_time'])}}</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        @endforeach
                        --}}{{--<li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>--}}{{--
                    </ul>
                    <!--近一周-->
                    <ul class="orList">
                        <!--待付款-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近一个月-->
                    <ul class="orList">
                        <!--待付款-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待付款</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">马上支付</a>
                                    <a class="oneBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--待发货-->
            <div>
                <div class="xConTit">
                    <div class="xConOne">
                        <p>
                            <span>全部订单</span>
--}}{{--                            <img src="{{asset('home/images/order/xial.png')}}" alt="">--}}{{--
                        </p>
                        --}}{{--<ul class="inx">
                            <li class="slec">全部订单</li>
                            <li>近三日的订单</li>
                            <li>近一周的订单</li>
                            <li>近一个月的订单</li>
                        </ul>--}}{{--
                    </div>
                    <div class="xConTwo">支付总金额</div>
                    <div class="xConThr">数量</div>
                    <div class="xConFour">收货人</div>
                    <div class="xConFive">
                        <p>
                            <span>订单状态</span>
                            --}}{{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}{{--
                        </p>
                        --}}{{--<ul class="zhuTai">
                            <li><a href="javascript:;">待付款</a></li>
                            <li><a href="javascript:;">待发货</a></li>
                            <li><a href="javascript:;">待收货</a></li>
                            <li><a href="javascript:;">已签收</a></li>
                        </ul>--}}{{--
                    </div>
                    <div class="xConSix">操作</div>
                </div>
                <div class="inxCon">
                    <!--全部订单-->
                    <ul class="orList slec">
                        <!--待发货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近三日-->
                    <ul class="orList">
                        <!--待发货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近一周-->
                    <ul class="orList">
                        <!--待发货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近一个月-->
                    <ul class="orList">
                        <!--待发货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待发货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="twoTop" href="javascript:;">提醒发货</a>
                                    <a class="twoBot" href="javascript:;">申请退款</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--待收货-->
            <div>
                <div class="xConTit">
                    <div class="xConOne">
                        <p>
                            <span>全部订单</span>
                            --}}{{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}{{--
                        </p>
                        --}}{{--<ul class="inx">
                            <li class="slec">全部订单</li>
                            <li>近三日的订单</li>
                            <li>近一周的订单</li>
                            <li>近一个月的订单</li>
                        </ul>--}}{{--
                    </div>
                    <div class="xConTwo">支付总金额</div>
                    <div class="xConThr">数量</div>
                    <div class="xConFour">收货人</div>
                    <div class="xConFive">
                        <p>
                            <span>订单状态</span>
                            --}}{{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}{{--
                        </p>
                        --}}{{--<ul class="zhuTai">
                            <li><a href="javascript:;">待付款</a></li>
                            <li><a href="javascript:;">待发货</a></li>
                            <li><a href="javascript:;">待收货</a></li>
                            <li><a href="javascript:;">已签收</a></li>
                        </ul>--}}{{--
                    </div>
                    <div class="xConSix">操作</div>
                </div>
                <div class="inxCon">
                    <!--全部订单-->
                    <ul class="orList slec">
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近三日的订单-->
                    <ul class="orList">
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近一周的订单-->
                    <ul class="orList">
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近一个月的订单-->
                    <ul class="orList">
                        <!--待收货-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>待收货</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="thrTop" href="javascript:;">立即签收</a></span>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--已签收-->
            <div>
                <div class="xConTit">
                    <div class="xConOne">
                        <p>
                            <span>全部订单</span>
                            --}}{{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}{{--
                        </p>
                        --}}{{--<ul class="inx">
                            <li class="slec">全部订单</li>
                            <li>近三日的订单</li>
                            <li>近一周的订单</li>
                            <li>近一个月的订单</li>
                        </ul>--}}{{--
                    </div>
                    <div class="xConTwo">支付总金额</div>
                    <div class="xConThr">数量</div>
                    <div class="xConFour">收货人</div>
                    <div class="xConFive">
                        <p>
                            <span>订单状态</span>
                            --}}{{--<img src="{{asset('home/images/order/xial.png')}}" alt="">--}}{{--
                        </p>
                        --}}{{--<ul class="zhuTai">
                            <li><a href="javascript:;">待付款</a></li>
                            <li><a href="javascript:;">待发货</a></li>
                            <li><a href="javascript:;">待收货</a></li>
                            <li><a href="javascript:;">已签收</a></li>
                        </ul>--}}{{--
                    </div>
                    <div class="xConSix">操作</div>
                </div>
                <div class="inxCon">
                    <!--全部订单-->
                    <ul class="orList slec">
                        <!--已签收-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                    <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                    <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近三日-->
                    <ul class="orList">
                        <!--已签收-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近一周-->
                    <ul class="orList">
                        <!--已签收-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--近三个月-->
                    <ul class="orList">
                        <!--已签收-->
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <h4>
                                <span style="margin-right:24px;">下单时间 : <i>2017-05-26</i></span>
                                <span>订单编号 : <i style="color:#333;">999999999999999999</i></span>
                            </h4>
                            <div class="listCon clear">
                                <!--循环商品-->
                                <ul>
                                    <li>
                                        <p>
                                            <img src="img/logo.png" alt="">
                                            <span>了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算了山东分局老师的肌肤时数量阿迪分局老师的肌肤洛杉矶阿飞撒打算</span>
                                        </p>
                                        <p>
                                            <span>¥<i>199999.00</i></span>
                                        </p>
                                        <p>9999</p>
                                    </li>
                                </ul>
                                <p>
                                    <span><i>衡水小胖子</i></span>
                                <span>
                                    <i>已签收</i>
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="fourTop" href="javascript:;">立即评价</a>
                                    <a class="fourMid" href="javascript:;">申请退货</a>
                                    <a class="fourBot deleteAd" href="javascript:;">删除订单</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>--}}
        </div>
        <!--分页-->
        <div class="fenY">
            {{$orderInfos->render()}}
        </div>
        @endif
        <!--为您推荐-->
        <div class="tuijian">
            <h3>为您推荐</h3>
            <ul class="clear">
                @foreach($goodsInfo as $k=>$v)
                <li>
                    <a href="{{url('goods/index')}}/{{$v['id']}}">
                        <div>
                            <img src="{{$v['image_url']}}" alt="">
                        </div>
                        <p>{{$v['name']}}</p>
                    </a>
                </li>
                    @endforeach
            </ul>
        </div>
    </div>
</div>
<!--点击确定删除-->
<div class="delHide">
    <div class="zhaozhao">
        <p class="btiao">删除订单</p>
        <p class="gan">
            <img src="{{asset('home/images/order/gantanhao.png')}}" alt="">
            <span>您确定要删除该订单吗？</span>
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
            var id=$(this).attr("ids");
            $('.laL').unbind('click').click(function () {   // 确定
                $.ajax({
                    url:"{{url('order/ajaxDel')}}/"+id,
                    type:"post",
                    success:function (res) {
                       if(res.err==200){
                           location.reload(true);
                       }
                    }
                });
                $('.delHide').fadeOut(300);
            });
            $('.noDel').click(function () {  // 取消
                $('.delHide').fadeOut(300);
            });
        });
        $('.xCon > div .inxCon .orList > li .listCon > p span:nth-child(3) a.twoBot').each(function (k,v) {
            if($(v).prevAll().length == 0){
                $(v).css('marginTop','57px')
            }
        });
        /*//最外层选项卡
        $('.outx li').click(function () {
            $('.xConOne>p>span').text('全部订单');
            $('.outx li,.xCon>div').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            $('.xCon>div').eq($(this).prevAll('li').length).addClass('sec');
        });
        //时间选项卡
        $('.inx li').click(function () {
            $('.xConOne>p>span').text($(this).text());
            $('.inx li').each(function (k, v) {
                $(v).removeClass('slec');
            });
            $(this).parent().parent().parent().parent().find('.inxCon').children('ul.orList').each(function (m, n) {
                $(n).removeClass('slec');
            });
            $(this).addClass('slec');
            $(this).parent().parent().parent().parent().find('.inxCon').children('ul.orList').eq($(this).prevAll('li').length).addClass('slec');
        })*/
        function fun1() {
            var search=$("#search").val();
            if (!search)
            {
                location.href="{{url('order/index/0')}}";
                return;
            }
            location.href="{{url('order/index/1010')}}?search="+search;
        }
        function reminder(obj) {
            var _this = $(obj);
            var id=$(obj).attr("ids");
            $.ajax({
                url:"{{url('order/reminder')}}/"+id,
                type:"post",
                success:function (res) {
                    if(res.err==200){
                        layer.msg('提醒发货成功,我们会尽快为您发货!');
                        _this.parent().children('.twoBot').css('marginTop','57px');
                        $(obj).remove();
                    }
                }
            });
        }
        function signIn(obj) {
            var id=$(obj).attr("ids");
            $.ajax({
                url:"{{url('order/signIn')}}/"+id,
                type:"post",
                success:function (res) {
                    console.log(res);
                    if(res.err==200){
                        location.href="{{url('order/index/14')}}";
                        return false;
                    }
                }
            });
        }
        @if(session("msg"))
            layer.msg("{{session("msg")}}");
            @endif
    </script>
@endsection