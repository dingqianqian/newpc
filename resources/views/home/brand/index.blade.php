@extends("home.layout.layout")
        @section("title","连锁品牌")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/brand/brand.css')}}">
        @endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>连锁品牌</span></p>
</div>
<div class="oStep clear">
    <!--右侧内容  ++LY  -->
    <div class="tStepCont">
        <p>请按品牌首字母进行搜索 :</p>
        <!--  搜索  -->
        <ul class="searchAhp">
            @foreach(range("A","Z") as $item)
            <li>
                <a class="{{$item}}" href="{{url('brand')}}/{{$item}}">{{$item}}</a>
            </li>
                @endforeach
        </ul>
        @if(!$hotelInfo)
        {{--没有相关品牌--}}
        <p style="width: 100%;text-align: center;margin: 132px 0 ;">
            <img src="{{asset('home/images/comment/zzwu.png')}}" style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">暂无相关品牌~</span>
        </p>
        @else
        <!--  加载内容  -->
        <ul class="searchA">
            @foreach($hotelInfo as $k=>$v)
            <li>
                <a href="{{url('category/brand')}}/{{$v['id']}}">
                    <img src="" trueImg="{{env("YYSURL")}}/Public/HotelWineshopCooperationImg/{{$v["id"]}}.png" alt="">
                </a>
            </li>
                @endforeach
        </ul>
            @endif
    </div>
</div>
@endsection
@section("js")
    <script>
        // 切换样式
        $('ul.searchAhp').on('click', 'li', function () {
            $(this).addClass('active').siblings('.active').removeClass('active')
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
            $('.searchA>li>a>img').each(function (k, v) {
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
        // 页面刷新事件
        window.onload = function(){
            // 遍历
            var lis = $('.searchAhp > li>a');
            for(var i=0;i<lis.length;i++){
               if(lis[i].innerHTML == '{{$index}}'){
                   $(lis[i]).parent().addClass('active')
               }
            }
        }
    </script>
@endsection