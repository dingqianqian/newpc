@extends("home.layout.layout")
        @section("title","查看评价")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/comment/pinglun.css')}}">
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
            <span style="margin-right: 24px;">订单号 : <i>{{$orderInfo['no']}}</i></span>
            <span>下单时间 : <i>{{date("Y-m-d H:i:s",$orderInfo['create_time'])}}</i></span>
        </p>
        <ul>
            @foreach($goodsEvaluateInfo as $k=>$v)
            <li>
                <div class="lDiv">
                    <img src="{{$v['image_url']}}" alt="">
                    <h4>
                        <p>
                            <em>{{$v['name']}}</em>
                        </p>
                    </h4>
                    <p>¥<span>{{$v['price']}}</span></p>
                </div>
                <div class="rDiv">
                    <div class="divT">
                        <span>综合评价 : </span>
                        <ul>
                            @for($i=1;$i<=5;$i++)
                                @if($i<=$v['favor_degree'])
                            <li>
                                <b class="sec"></b>
                            </li>
                                @else
                                    <li>
                                        <b></b>
                                    </li>
                                @endif
                                @endfor
                        </ul>
                    </div>
                    <div class="divB">
                        <span>评价反馈 : </span>
                        <p>{{$v['content']}}</p>
                    </div>
                </div>
            </li>
                @endforeach
        </ul>
        {{--<a href="javascript:;">提交评论</a>--}}
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
    </script>
    @endsection