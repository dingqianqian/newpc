@extends("home.layout.layout")
        @section("title","全部订单")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/comment/quanBu.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>评价中心</span></p>
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
                <li @if($type==0) class="sec" @endif style="border-left:none;"><a href="{{url('comment/index')}}">全部</a></li>
                <li @if($type==1) class="sec" @endif><a href="{{url('comment/index/1')}}">未评价<span>({{$noComment}})</span></a></li>
                <li @if($type==2) class="sec" @endif><a href="{{url('comment/index/2')}}">已评价<span>({{$isComment}})</span></a></li>
            </ul>
        </div>
        @if(!$orderInfo['data'])
        {{--暂无优惠券--}}
        <p style="width: 100%;text-align: center;margin: 264px 0 264px 0;">
            <img src="{{asset('home/images/comment/zzwu.png')}}" style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无评价商品信息~</span>
        </p>
            @else
        <div class="xCon">
            <!--全部-->
            <div class="sec">
                <div class="xConTit">
                    <div class="xConOne">
                        <!--<p>
                            <span>近一个月的订单</span>
                            <img src="img/xial.png" alt="">
                        </p>
                        <ul class="inx">
                            <li>近三日的订单</li>
                            <li>近一周的订单</li>
                            <li class="slec">近一个月的订单</li>
                        </ul>-->
                    </div>
                    <div class="xConTwo">支付总金额</div>
                    <div class="xConThr">数量</div>
                    <div class="xConFour">收货人</div>
                    <div class="xConFive">
                        <p>
                            <span>订单状态</span>
                            <!--<img src="img/xial.png" alt="">-->
                        </p>
                        <!--<ul class="zhuTai">
                            <li><a href="javascript:;">待付款</a></li>
                            <li><a href="javascript:;">待发货</a></li>
                            <li><a href="javascript:;">待收货</a></li>
                            <li><a href="javascript:;">已签收</a></li>
                        </ul>-->
                    </div>
                    <div class="xConSix">操作</div>
                </div>
                <div class="inxCon">
                    <!--全部-->
                    <ul class="orList">
                        @foreach($orderInfo['data'] as $k=>$v)
                        <!--未评价-->
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
                                            <img src="{{$v1['img_url']}}" alt="">
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
                                    {{--<i>已签收</i>--}}
                                    <a href="{{url("order/info")}}/{{$v['no']}}/0">查看详情</a>
                                </span>
                                <span>
                                    @if($v['is_evaluate']==0)
                                    <a class="oneTop ooTop" href="{{url('comment/info')}}/{{$v['no']}}">立即评价</a>
                                        @else
                                        <a class="oneTop" href="{{url("comment/list")}}/{{$v['no']}}">查阅已评</a>
                                    @endif
                                    <a class="oneBot deleteAd" href="{{url('comment/buy')}}/{{$v['no']}}">再次购买</a>
                                </span>
                                </p>
                            </div>
                        </li>
                        @endforeach
                        {{--<!--已评价-->
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
                                    <!--<i>待付款</i>-->
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">查阅已评</a>
                                    <a class="oneBot deleteAd" href="javascript:;">再次购买</a>
                                </span>
                                </p>
                            </div>
                        </li>--}}
                    </ul>
                </div>
            </div>
            {{--<!--未评价-->
            <div>
                <div class="xConTit">
                    <div class="xConOne">
                        <!--<p>
                            <span>近一个月的订单</span>
                            <img src="img/xial.png" alt="">
                        </p>
                        <ul class="inx">
                            <li>近三日的订单</li>
                            <li>近一周的订单</li>
                            <li class="slec">近一个月的订单</li>
                        </ul>-->
                    </div>
                    <div class="xConTwo">支付总金额</div>
                    <div class="xConThr">数量</div>
                    <div class="xConFour">收货人</div>
                    <div class="xConFive">
                        <p>
                            <span>订单状态</span>
                            <!--<img src="img/xial.png" alt="">-->
                        </p>
                        <!--<ul class="zhuTai">
                            <li><a href="javascript:;">待付款</a></li>
                            <li><a href="javascript:;">待发货</a></li>
                            <li><a href="javascript:;">待收货</a></li>
                            <li><a href="javascript:;">已签收</a></li>
                        </ul>-->
                    </div>
                    <div class="xConSix">操作</div>
                </div>
                <div class="inxCon">
                    <!--未评价-->
                    <ul class="orList">
                        <!--未评价-->
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
                                    <!--<i>待付款</i>-->
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop ooTop" href="javascript:;">立即评价</a>
                                    <a class="oneBot deleteAd" href="javascript:;">再次购买</a>
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
                                    <!--<i>待付款</i>-->
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop ooTop" href="javascript:;">立即评价</a>
                                    <a class="oneBot deleteAd" href="javascript:;">再次购买</a>
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
                                    <!--<i>待付款</i>-->
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop ooTop" href="javascript:;">立即评价</a>
                                    <a class="oneBot deleteAd" href="javascript:;">再次购买</a>
                                </span>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!--已评价-->
            <div>
                <div class="xConTit">
                    <div class="xConOne">
                        <!--<p>
                            <span>近一个月的订单</span>
                            <img src="img/xial.png" alt="">
                        </p>
                        <ul class="inx">
                            <li>近三日的订单</li>
                            <li>近一周的订单</li>
                            <li class="slec">近一个月的订单</li>
                        </ul>-->
                    </div>
                    <div class="xConTwo">支付总金额</div>
                    <div class="xConThr">数量</div>
                    <div class="xConFour">收货人</div>
                    <div class="xConFive">
                        <p>
                            <span>订单状态</span>
                            <!--<img src="img/xial.png" alt="">-->
                        </p>
                        <!--<ul class="zhuTai">
                            <li><a href="javascript:;">待付款</a></li>
                            <li><a href="javascript:;">待发货</a></li>
                            <li><a href="javascript:;">待收货</a></li>
                            <li><a href="javascript:;">已签收</a></li>
                        </ul>-->
                    </div>
                    <div class="xConSix">操作</div>
                </div>
                <div class="inxCon">
                    <!--已评价-->
                    <ul class="orList slec">
                        <!--已评价-->
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
                                    <!--<i>待付款</i>-->
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">查阅已评</a>
                                    <a class="oneBot deleteAd" href="javascript:;">再次购买</a>
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
                                    <!--<i>待付款</i>-->
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">查阅已评</a>
                                    <a class="oneBot deleteAd" href="javascript:;">再次购买</a>
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
                                    <!--<i>待付款</i>-->
                                    <a href="javascript:;">查看详情</a>
                                </span>
                                <span>
                                    <a class="oneTop" href="javascript:;">查阅已评</a>
                                    <a class="oneBot deleteAd" href="javascript:;">再次购买</a>
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
            {{$orderInfos->links()}}
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
        <p class="btiao">删除商品</p>
        <p class="gan">
            <img src="{{asset('home/images/comment/gantanhao.png')}}" alt="">
            <span>您确定要删除该订单吗？</span>
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
        /*$('.deleteAd').click(function () {
            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {   // 确定
                $('.delHide').fadeOut(300);
            });
            $('.noDel').click(function () {  // 取消
                $('.delHide').fadeOut(300);
            });
        });*/
        /*//最外层选项卡
        $('.outx li').click(function () {
            $('.outx li,.xCon>div').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            $('.xCon>div').eq($(this).prevAll('li').length).addClass('sec');
        });*/
    </script>
    @endsection