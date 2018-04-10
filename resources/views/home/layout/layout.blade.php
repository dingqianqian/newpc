<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>@yield("title")</title>
    <meta name="description" content="宜优速yiyousu.com—专业的酒店用品、饭店用品直供平台。国内最大的易耗品采购平台，数万种品牌商品，便捷、诚信的服务，为您提供全新的企业采购体验。">
    <meta name="keywords" content="酒店用品,酒店用品批发,酒店一次性用品,酒店清洁用品,酒店客房用品,酒店易耗品,酒店饭店用品,饭店一次性用品,饭店易耗品,一次性用品批发,酒店采购批发">
    <link rel="stylesheet" href="{{asset('home/css/common/reset.min.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/common/head.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/common/footer.css')}}">
    @yield("css")
    <script>
        var _hmt = _hmt || [];
        (function () {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?6cffa9d94b7bf72c17b5200b7f164c2f";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body style="font-size: 0;">
@yield("alert")
<div class="contai">
    <!--头部-->
    <div style="background-color:#fff;">
        <div class="head">
            <div class="head_l">
                <div>
                    <img src="{{asset('home/images/dingwei.png')}}" alt="定位">
                    <span id="wspan">{{session("f_area_info")['name']}}</span>
                    <span id="chang_city">[切换城市]</span>
                    {{--<i class="ixia"></i>
                    <ul class="city">
                        <li>北京</li>
                        <li>天津</li>
                        <li>上海</li>
                        <li>重庆</li>
                        <li>河北</li>
                        <li>山西</li>
                        <li>辽宁</li>
                        <li>吉林</li>
                        <li>黑龙江</li>
                        <li>江苏</li>
                        <li>浙江</li>
                        <li>安徽</li>
                        <li>福建</li>
                        <li>江西</li>
                        <li>山东</li>
                        <li>河南</li>
                        <li>湖北</li>
                        <li>湖南</li>
                        <li>广东</li>
                        <li>海南</li>
                        <li>四川</li>
                        <li>贵州</li>
                        <li>云南</li>
                        <li>陕西</li>
                        <li>甘肃</li>
                        <li>青海</li>
                        <li>内蒙古</li>
                        <li>广西</li>
                        <li>西藏</li>
                        <li>宁夏</li>
                        <li>新疆</li>
                        <li>香港</li>
                        <li>澳门</li>
                        <li>台湾</li>
                        <li>钓鱼岛</li>
                    </ul>--}}
                </div>
                <em>欢迎访问宜优速商城 !</em>
            </div>
            <div class="head_m">
                @if(session("userInfo"))
                    <a href="{{url('person/index')}}">{{session("userInfo")["username"]}}</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{url('logout')}}">[退出]</a>
                @else
                    <span>您好，请</span>
                    <a href="{{url('login')}}">[登录]</a>
                    <a href="{{url('register')}}">[快速注册]</a>
                @endif
            </div>
            <div class="head_r">
            <span class="r-fir">
                <a href="{{url('shopCart/index')}}">
                    <img src="{{asset('home/images/shopC.png')}}" alt="">
                    <span style="display: inline-block;vertical-align: middle">购物车</span>
                </a>
            </span>
                <span class="r_one">
                    <a href="{{url('order/index')}}" style="display: block;color:#333;">
                        我的订单
            <img src="{{asset('home/images/xia.png')}}" alt="">
                    </a>
            <ul>
                <li><a href="{{url('order/index/3')}}">待付款</a></li>
                <li><a href="{{url('order/index/4')}}">待收货</a></li>
                <li><a href="{{url('order/index/14')}}">待评价</a></li>
                <!--<li><a href="javascript:;">修改订单</a></li>-->
            </ul>
        </span>
                <span class="shou"><a href="{{url('collect/index')}}">收藏的商品</a></span>
                <span class="myi"><a href="{{url("person/index")}}">我的宜优速</a></span>
                <span class="r-two">
            <img src="{{asset('home/images/shouiji.png')}}" alt="">掌上宜优速
            <img class="bot" src="{{asset('home/images/app.gif')}}" alt="">
        </span>
            </div>
        </div>
    </div>
@yield("content")

<!--底部商标-->
    <div class="las">
        <ul class="lasts">
            <li>
                <img src="{{asset('home/images/banquantubiao1.png')}}" alt="">
                <span></span>
                <h4>品质保证</h4>
                <p>正品保障、提供发票</p>
            </li>
            <li>
                <img src="{{asset('home/images/banquantubiao2.png')}}" alt="">
                <span></span>
                <h4>专业配送</h4>
                <p>风驰电掣、不知所由</p>
            </li>
            <li>
                <img src="{{asset('home/images/banquantubiao3.png')}}" alt="">
                <span></span>
                <h4>全场免邮</h4>
                <p>全场免邮、值得信赖</p>
            </li>
            <li>
                <img src="{{asset('home/images/banquantubiao4.png')}}" alt="">
                <span></span>
                <h4>优质服务</h4>
                <p>私人定制、退换无忧</p>
            </li>
        </ul>
    </div>
    <div class="lllasBot" style="padding-top:18px;background-color: #fff;">
        <!--底部导航-->
        <div class="llas clear">
            <dl>
                <dt>
                    <img src="{{asset('home/images/llo.png')}}" alt="">
                    <span>新手指南</span>
                </dt>
                <dd><a href="{{url("footer/shop")}}">购物流程</a></dd>
                <dd>会员政策</dd>
                <dd><a href="{{url('contact')}}">联系客服</a></dd>
                <dd>积分政策</dd>
                <dd>加入我们</dd>
            </dl>
            <dl>
                <dt>
                    <img src="{{asset('home/images/llt.png')}}" alt="">
                    <span>配送方式</span>
                </dt>
                <dd>优质服务</dd>
                <dd>配送时间</dd>
                <dd>配送范围</dd>
                <dd><a href="{{url("footer/about")}}">关于我们</a></dd>
            </dl>
            <dl>
                <dt>
                    <img src="{{asset('home/images/lls.png')}}" alt="">
                    <span>支付方式</span>
                </dt>
                <dd>在线支付</dd>
                <dd>其它支付方式</dd>
                <dd>优惠券使用</dd>
                <dd>速立付</dd>
            </dl>
            <dl>
                <dt>
                    <img src="{{asset('home/images/llff.png')}}" alt="">
                    <span>售后服务</span>
                </dt>
                {{--<dd>验货与拒收政策</dd>--}}
                <dd><a href="{{url("footer/returnPolicy")}}">退换货政策</a></dd>
                <dd><a href="{{url("footer/returnSale")}}">退换货流程</a></dd>
                <dd><a href="{{url("footer/refund")}}">退款说明</a></dd>
                <dd><a href="{{url('footer/invoice')}}">发票制度</a></dd>
            </dl>
        </div>
        <!--最底部-->
        <div class="lt">
            {{--<span style="display:inline-block;vertical-align:middle;font-size: 14px;color: #6a6a6a;line-height: 125px;">北京宜优速电子商务科技有限责任公司Copynight@
                2016-2017yiyousu.com版权所有京ICP备17040749号-1</span>--}}
            <span style="display:inline-block;vertical-align:middle;font-size: 14px;color: #6a6a6a;">宜优速电子商务科技有限责任公司Copynight@
                2016-2017yiyousu.com版权所有京ICP备17040749号-1<br>地址:北京市石景山区京原路19号院4号楼9层901房间&nbsp;&nbsp;电话:40018-11121<br>增值电信业务经营许可证编号:京B2-20171507</span>
            <img style="display:inline-block;vertical-align:middle;width:125px;height:125px;"
                 src="{{asset('home/images/er.jpg')}}" alt="">
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('home/js/common/jquery-1.11.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/layer/layer.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //老版点击切换城市
    /*$('.city li').click(function () {
        $('#wspan').text($(this).text());
        var val = $(this).text();
        $.ajax({
            type: 'get',
            data: {city: val},
            url: "{{url('setCity')}}",
            success: function (res) {

            }
        });
    });*/
    $('#chang_city').click(function () {
        location.href="{{url("area/index")}}"
    })
</script>
@yield("js")
</body>
</html>