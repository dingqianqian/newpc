@extends("home.layout.layout")
@section("title")
    {{$goodsTypeInfo['name']}}
@endsection
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/brand/erji.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<a href="{{url('brand')}}">连锁品牌</a>/<span>{{$goodsTypeInfo['name']}}</span></p>
    </div>
    {{--<div class="erView">
        <img src="" data-trueImg="" alt="">
    </div>--}}
    <div class="Dcon">
        @if(!$goodsInfo)
            {{--暂无相关商品--}}
            <p style="width: 100%;text-align: center;padding: 264px 0 0 0;">
                <img src="{{asset('home/images/comment/zzwu.png')}}"
                     style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">暂无相关商品~</span>
            </p>
        @else
            <ul class="erDetail clear">
                @foreach($goodsInfo as $k=>$v)
                    <li>
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <div>
                                <img src="" data-trueImg="http://{{$v['image_url']}}" alt="">
                            </div>
                        </a>
                        @if(is_11121())
                            <div class="erBot clear">
                                <div class="erBL">
                                    <p>1.11.21冰点价 : <i>{{$v["show_sale_price"]}}</i>元</p>
                                    <span>宜购价 : <em>{{$v["show_price"]}}</em>元</span>
                                </div>
                            </div>
                        @else
                            <div class="erBot clear">
                                <div class="erBL">
                                    <p>宜购价 : <i>{{$v["show_price"]}}</i>元</p>
                                    <span style="text-decoration: none;">1.11.21冰点价 : <em>{{$v["show_sale_price"]}}</em>元</span>
                                </div>
                            </div>
                        @endif
                        <h4>
                            <p>
                                <em>{{$v["name"]}}</em>
                            </p>
                        </h4>
                        <a href="{{url('goods/index')}}/{{$v['id']}}" class="erBR">立即购买</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
@section("js")
    <script src="{{asset('home/js/common/clamp.min.js')}}"></script>
    <script type="text/javascript">
        $('.showUl li').click(function () {
            if ($(this).text() == '更多>>') {
                $('.hideUl').slideToggle('fast');
                $('.hideUl ul').animate({width: 'toggle'}, 600)
            }
        });
        //h4一行水平垂直居中显示，两行自适应，溢出省略号
        // 只能给外层h4宽高，内容不能有
        $('.erDetail li > h4 p em').each(function (j, l) {  // l是em
            var t = 44 / $(l).height();  // h4高度
            $(l).css({
                lineHeight: t * 19 + "px"  // 根据h4高度调整  / 2
            });
            // h4高度的一半
            if (parseFloat($(l).css('lineHeight')) <= 20) {
                $(l).css({'lineHeight': '20px'});
                $clamp($(l)[0], {clamp: 2})  //clamp显示行数溢出省略号
            }
        });
        //图片延迟加载
        function loadImg(curImg) {
            var tempImg = new Image;
            tempImg.src = curImg.getAttribute('data-trueImg');
            tempImg.onload = function () {
                curImg.src = this.src;
                $(curImg).fadeIn();
                tempImg = null;
            };
            curImg.isLoad = true;
        }
        function xun() {
            $('.erDetail li > a:first-child > div > img').each(function (k, v) {
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
        window.setTimeout(xun, 200);
        window.onscroll = xun;

        // 点击事件
        $('.img li:not(".no")').each(function (k, v) {
            $(v).click(function () {
                $('.img li.sec').removeClass('sec');
                $(this).addClass('sec');
            });
        });
    </script>
@endsection