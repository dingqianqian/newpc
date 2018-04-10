@extends("home.layout.layout")
@section("title","评价中心")
@section("css")
    <link rel="stylesheet" href="{{asset("home/css/comment/pinglun.css")}}">
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
            <h3>评价中心</h3>
            <p>
                <span style="margin-right: 24px;">订单号 : <i class="numDel">{{$orderInfo['no']}}</i></span>
                <span>下单时间 : <i>{{date("Y-m-d H:i:s",$orderInfo['create_time'])}}</i></span>
            </p>
            <ul>
                @foreach($orderGoodsInfo as $k=>$v)
                    <li>
                        <div class="lDiv">
                            <img src="{{$v['image_url']}}" alt="">
                            <h4>
                                <p>
                                    <em>{{$v['goods']['name']}}</em>
                                </p>
                            </h4>
                            <p>¥<span>{{number_format($v['deal_min_price'],2,".","")}}</span></p>
                        </div>
                        <div class="rDiv">
                            <div class="divT">
                                <span>综合评价 : </span>
                                <ul>
                                    <li>
                                        <b class="sec"></b>
                                    </li>
                                    <li>
                                        <b></b>
                                    </li>
                                    <li>
                                        <b></b>
                                    <li>
                                        <b></b>
                                    </li>
                                    <li>
                                        <b></b>
                                    </li>
                                </ul>
                            </div>
                            <div class="divB">
                                <span>评价反馈 : </span>
                                <textarea name="" id="" placeholder="快来分享您的购买心得～" ids="{{$v['id']}}"></textarea>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <a href="javascript:;">提交评论</a>
            <!--为您推荐-->
            <div class="tuijian">
                <h3>为您推荐</h3>
                <ul class="clear">
                    @foreach($goodsInfo as $k=>$v)
                        <li>
                            <a href="{{url("goods/index")}}/{{$v['id']}}">
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
@endsection
@section("js")
    <script type="text/javascript" src="{{asset('home/js/common/clamp.min.js')}}"></script>
    <script type="text/javascript">
        //h4一行水平垂直居中显示，两行自适应，溢出省略号
        $('.lDiv em').each(function (j, l) {
            var t = 40 / $(l).height();
            $(l).css({
                lineHeight: t * 19 + "px"
                //height: t * $(l).height()加高度clamp不好使，clamp兼容火狐及其它浏览器
            });
            if (parseFloat($(l).css('lineHeight')) <= 20) {
                $(l).css({'lineHeight': '20px'});
                $clamp($(l)[0], {clamp: 2});
            }
        });
        //评价星星
        $('.divT>Ul>li').click(function () {
            $(this).children('b').addClass('sec');
            $(this).siblings('li').children('b').removeClass('sec');
            $(this).prevAll('li').children('b').addClass('sec');
        })
        //提交评价
        $('.tStepCont>a').click(function () {
            var ary = [],
                obj = {},
                zong= {};
            $('textarea').each(function (k, v) {
                if ($(v).val().length != 0) {
                    obj.xing = $(v).parent().parent().children('.divT').children('ul').find('.sec').length;
                    obj.cont = $(v).val();
                    obj.ids = $(v).attr('ids');
                    ary.push(obj);
                    obj = {};
                }
            });
            if (ary.length == 0) {
                layer.msg('请填写您的购买心得！');
            } else {
                zong.no = $('.numDel').text();
                zong.data = ary;
                $.ajax({
                    url:"{{url('comment/order')}}",
                    type:'post',
                    data:{name:zong},
                    success:function (res) {
                        if (res.err==200){
                            location.href="{{url('comment/index/2')}}";
                        }
                    }
                })
            }
        })
    </script>
@endsection