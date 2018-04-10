@extends("home.layout.layout")
@section("title","饭店用品")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/category/erji.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>饭店用品</span></p>
    </div>
    <ul class="showUl clear">
        <li @if($id==11)class="sec"@endif><a href="{{url('category/house/11')}}">餐厅用纸</a></li>
        <li @if($id==12)class="sec"@endif><a href="{{url('category/house/12')}}">餐厅用品</a></li>
        <li @if($id==13)class="sec"@endif><a href="{{url('category/house/13')}}">清洁用品</a></li>
        <li @if($id==161)class="sec"@endif><a href="{{url('category/house/161')}}">厨房用品</a></li>
        <li @if($id==14)class="sec"@endif><a href="{{url('category/house/14')}}">针织布草</a></li>
        <li @if($id==153)class="sec"@endif><a href="{{url('category/house/153')}}">装修专区</a></li>
        <li @if($id==162)class="sec"@endif><a href="{{url('category/house/162')}}">布草洗涤</a></li>
        <li @if($id==217)class="sec"@endif><a href="{{url('category/house/217')}}">私人定制</a></li>
        {{--<li><a href="javascript:;">品牌定制</a></li>--}}
    </ul>
    {{--<div class="hideUl">
        <ul class="clear">
            <li><a href="javascript:;">得劲得劲</a></li>
            <li><a href="javascript:;">得劲得劲</a></li>
            <li><a href="javascript:;">得劲得劲</a></li>
        </ul>
    </div>--}}
    <div class="erView">
        <img src="{{asset("home/images/category/$id.jpg")}}" alt="">
    </div>
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
                            <img src="" trueImg="http://{{$v['image_url']}}" alt="">
                        </a>
                        @if(is_11121())
                            <div class="erBL">
                                <p>1.11.21冰点价 : <i>{{$v["show_sale_price"]}}</i>元</p>
                                <span>宜购价 : <em>{{$v["show_price"]}}</em>元</span>
                            </div>
                        @else
                            <div class="erBL">
                                <p>宜购价 : <i>{{$v["show_price"]}}</i>元</p>
                                <span style="text-decoration: none;">1.11.21冰点价 : <em>{{$v["show_sale_price"]}}</em>元</span>
                            </div>
                        @endif
                        <div class="erBot clear">
                            <h4>
                                <p>
                                    <em>{{$v["name"]}}</em>
                                </p>
                            </h4>
                            <a href="{{url('goods/index')}}/{{$v['id']}}" class="erBR">立即购买</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{asset('home/js/common/clamp.min.js')}}"></script>
    <script type="text/javascript">
        $('.showUl li').click(function () {
            if ($(this).text() == '更多>>') {
                $('.hideUl').slideToggle('fast');
                $('.hideUl ul').animate({width: 'toggle'}, 600)
            }
        });
        //h4一行水平垂直居中显示，两行自适应，溢出省略号
        $('.erBot em').each(function (k, v) {
            var t = 44 / ($(v).height());
            $(v).css({
                lineHeight: t * 20 + "px"
//            height: t * $(v).height()
            });
            if (parseFloat($(v).css('lineHeight')) <= 24) {
                $(v).css({'lineHeight': '22px'});
                $clamp($(v)[0], {clamp: 2});
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
            $('.erDetail li img').each(function (k, v) {
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
    </script>
@endsection