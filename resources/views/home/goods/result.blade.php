@extends("home.layout.layout")
@section("title","搜索结果")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/goods/searResult.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>搜索内容</span></p>
    </div>
    {{--暂无优惠券--}}
    @if(!$goodsInfo)
        <div class="conZ">
            <p class="noTh">
                <img src="{{asset('home/images/comment/zzwu.png')}}" alt="">
                <span>抱歉，没有找到与"<i>{{$name}}</i>"相关的商品~</span>
            </p>
        </div>
    @else
    <ul class="searList clear">
        @foreach($goodsInfo as $k=>$v)
            <li>
                <a href="{{url("goods/index")}}/{{$v['id']}}">
                    <img src="" alt="" trueImg="{{$v['image_url']}}">
                </a>
                <div class="liBot">
                    <p>
                        @if(is_11121())
                            <span class="spanT">1.11.21价 : <i
                                        style="font-weight: 600;">{{$v['show_sale_price']}}</i>元</span>
                            <span class="spanB">宜购价 : <i>{{$v['show_price']}}</i>元</span>
                        @else
                            <span class="spanT">宜购价 : <i style="font-weight: 600;">{{$v['show_price']}}</i>元</span>
                            <span class="spanB"
                                  style="text-decoration: none;">1.11.21价 : <i>{{$v['show_sale_price']}}</i>元</span>
                        @endif
                    </p>
                    <div>
                        <h4>
                            <p>
                                <em>{{$v['name']}}</em>
                            </p>
                        </h4>
                        <a href="{{url("goods/index")}}/{{$v['id']}}">立即购买</a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @endif
@endsection
@section("js")
    <script src="{{asset('home/js/common/clamp.min.js')}}"></script>
    <script>
        //h4一行水平垂直居中显示，两行自适应，溢出省略号
        $('.liBot em').each(function (j, l) {
            var t = 40 / $(l).height();
            $(l).css({
                lineHeight: t * 21 + "px"
                //height: t * $(l).height()加高度clamp不好使，clamp兼容火狐及其它浏览器
            });
            if (parseFloat($(l).css('lineHeight')) <= 20) {
                $(l).css({'lineHeight': '20px'});
                $clamp($(l)[0], {clamp: 2});
            }
        });
        //图片延迟加载
        function loadImg(curImg) {
            var tempImg = new Image;
            tempImg.src = curImg.getAttribute('trueImg');
            tempImg.onload = function () {
                curImg.src = this.src;
                $(curImg).fadeIn();
                tempImg = null;
            };
            curImg.isLoad = true;
        }
        function xun() {
            $('.searList>li>a>img').each(function (k, v) {
                var bHeight = $(window).height() + $(window).scrollTop(),
                    vHeight = $(v).parent().outerHeight() / 2 + $(v).parent().offset().top;
                if ($(v).attr('isLoad')) {
                    return;
                }
                if (bHeight > vHeight) {
                    loadImg($(v)[0]);
                }
            });
        }
        window.setTimeout(xun, 500);
        window.onscroll = xun;
    </script>
@endsection