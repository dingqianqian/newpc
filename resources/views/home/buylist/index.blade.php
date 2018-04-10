@extends("home.layout.layout")
@section("title","常购清单")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/buylist/purList.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>常购清单</span></p>
    </div>
    <div class="oStep clear">
        <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <!--右侧内容-->
        <div class="tStepCont">
            <ul class="footTile">
                <li class="sec">全部商品</li>
                <li>酒店用品<span>({{$count['jdyp']}})</span></li>
                <li>饭店用品<span>({{$count['fdyp']}})</span></li>
                <li>连锁品牌<span>({{$count['lspp']}})</span></li>
            </ul>
            <div class="shouLine"></div>
            <!--      右侧 ++++++++++        LY      -->
            <!--dl 设置跳转：-->
            <!--<dl onclick="window.open('http://')">在新窗口跳转</dl>-->
            <!--<dl onclick="window.open('http://','_self')">在当前窗口跳转</dl>-->
            //有商品
            <div class="footCont">
                <div class="allShangpin sec">
                    @if(!$goodsInfos)
                        //无商品
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您的常购清单暂无商品~</span>
                        </p>
                    @else
                        <div>
                            @foreach($goodsInfos as $k=>$v)
                                <dl>
                                    <dt>
                    <span>
                        <a href="{{url('goods/index')}}/{{$v['id']}}"><img src="" data-trueImg="{{$v['name_url']}}"></a>
                    </span>
                                    </dt>
                                    <dd class="title">{{$v["name"]}}</dd>
                                    <dd class="num">
                                        <!--价格-->
                                        <span class="price">
                        ￥
                        <b>
                            @if(is_11121())
                                {{$v['show_price']}}
                            @else
                                {{$v['show_sale_price']}}
                            @endif
                        </b>
                        (元)
                    </span>
                                        <!--购买-->
                                        <span class="buyNumber" style="margin-right:0;">
                        已购
                        <b>{{$v["count"]}}</b>
                        次
                    </span>
                                    </dd>
                                    <dd class="clickBtn">
                                        @if($v["is_collection"])
                                            <button class="addCartt" id="{{$v['id']}}">取消收藏</button>
                                        @else
                                            <button class="addCart" id="{{$v['id']}}">添加收藏</button>
                                        @endif
                                        <button class="buyNow"><a href="{{url('goods/index')}}/{{$v['id']}}">立即购买</a>
                                        </button>
                                    </dd>
                                </dl>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="allShangpin">
                    @if($count['jdyp']<=0)
                        //无商品
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您的常购清单暂无商品~</span>
                        </p>
                    @else
                        <div>
                            @foreach($goodsInfos as $k=>$v)
                                @if(in_array($v["f_goods_type_id"],[5,6,7,10,149,9,160]))
                                    <dl>
                                        <dt>
                    <span>
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <img src="" data-trueImg="{{$v['name_url']}}">
                        </a>
                    </span>
                                        </dt>
                                        <dd class="title">{{$v["name"]}}</dd>
                                        <dd class="num">
                                            <!--价格-->
                                            <span class="price">
                        ￥
                        <b>
                            @if(is_11121())
                                {{$v['show_price']}}
                            @else
                                {{$v['show_sale_price']}}
                            @endif
                        </b>
                        (元)
                    </span>
                                            <!--购买-->
                                            <span class="buyNumber" style="margin-right:0;">
                        已购
                        <b>{{$v["count"]}}</b>
                        次
                    </span>
                                        </dd>
                                        <dd class="clickBtn">
                                            @if($v["is_collection"])
                                                <button class="addCartt" id="{{$v['id']}}">取消收藏</button>
                                            @else
                                                <button class="addCart" id="{{$v['id']}}">添加收藏</button>
                                            @endif
                                            <button class="buyNow"><a
                                                        href="{{url('goods/index')}}/{{$v['id']}}">立即购买</a></button>
                                        </dd>
                                    </dl>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="allShangpin">
                    @if($count['fdyp']<=0)
                        //无商品
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您的常购清单暂无商品~</span>
                        </p>
                    @else
                        <div>
                            @foreach($goodsInfos as $k=>$v)
                                @if(in_array($v["f_goods_type_id"],[11,12,13,161,14,153,162]))
                                    <dl>
                                        <dt>
                    <span>
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                        <img src="" data-trueImg="{{$v['name_url']}}">
                        </a>
                    </span>
                                        </dt>
                                        <dd class="title">{{$v["name"]}}</dd>
                                        <dd class="num">
                                            <!--价格-->
                                            <span class="price">
                        ￥
                        <b>
                            @if(is_11121())
                                {{$v['show_price']}}
                            @else
                                {{$v['show_sale_price']}}
                            @endif
                        </b>
                        (元)
                    </span>
                                            <!--购买-->
                                            <span class="buyNumber" style="margin-right:0;">
                        已购
                        <b>{{$v["count"]}}</b>
                        次
                    </span>
                                        </dd>
                                        <dd class="clickBtn">
                                            @if($v["is_collection"])
                                                <button class="addCartt" id="{{$v['id']}}">取消收藏</button>
                                            @else
                                                <button class="addCart" id="{{$v['id']}}">添加收藏</button>
                                            @endif
                                            <button class="buyNow"><a
                                                        href="{{url('goods/index')}}/{{$v['id']}}">立即购买</a></button>
                                        </dd>
                                    </dl>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="allShangpin">
                    @if($count['lspp']<=0)
                        //无商品
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您的常购清单暂无商品~</span>
                        </p>
                    @else
                        <div>
                            @foreach($goodsInfos as $k=>$v)
                                @if(!in_array($v["f_goods_type_id"],[52,53,164,158,54,11,12,13,161,14,153,162,5,6,7,10,149,9,160]))
                                    <dl>
                                        <dt>
                    <span>
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                        <img src="" data-trueImg="{{$v['name_url']}}">
                        </a>
                    </span>
                                        </dt>
                                        <dd class="title">{{$v["name"]}}</dd>
                                        <dd class="num">
                                            <!--价格-->
                                            <span class="price">
                        ￥
                        <b>
                            @if(is_11121())
                                {{$v['show_price']}}
                            @else
                                {{$v['show_sale_price']}}
                            @endif
                        </b>
                        (元)
                    </span>
                                            <!--购买-->
                                            <span class="buyNumber" style="margin-right:0;">
                        已购
                        <b>{{$v["count"]}}</b>
                        次
                    </span>
                                        </dd>
                                        <dd class="clickBtn">
                                            @if($v["is_collection"])
                                                <button class="addCartt" id="{{$v['id']}}">取消收藏</button>
                                            @else
                                                <button class="addCart" id="{{$v['id']}}">添加收藏</button>
                                            @endif
                                            <button class="buyNow"><a
                                                        href="{{url('goods/index')}}/{{$v['id']}}">立即购买</a>
                                            </button>
                                        </dd>
                                    </dl>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" charset="utf-8">
        //选项卡
        $('.footTile li').click(function () {
            $('.footTile li,.footCont > div').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            $('.footCont > div').eq($(this).prevAll().length).addClass('sec');
        });
        // 懒加载
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
            $('.allShangpin>div>dl>dt img').each(function (k, v) {
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
        //点击收藏
        $('.addCart').click(function () {
            var id = $(this).attr("id");
            $.ajax({
                url: "{{url('goods/collect')}}",
                type: "post",
                data: {"id": id},
                success: function (res) {
                    console.log(res);
                },
                error: function (res) {
                    console.log(res);
                }
            });
            if ($(this).text() == '添加收藏') {
                $(this).css('background', "url('{{asset('home/images/goods/shouHong.png')}}') no-repeat 15% 55%").text('取消收藏');
            } else {
                $(this).css('background', "url('{{asset('home/images/goods/shouHui.png')}}') no-repeat 15% 55%").text('添加收藏');
            }
        });
        $('.addCartt').click(function () {
            var id = $(this).attr("id");
            $.ajax({
                url: "{{url('goods/collect')}}",
                type: "post",
                data: {"id": id},
                success: function (res) {
                    console.log(res);
                },
                error: function (res) {
                    console.log(res);
                }
            });
            if ($(this).text() == '添加收藏') {
                $(this).css('background', "url('{{asset('home/images/goods/shouHong.png')}}') no-repeat 15% 55%").text('取消收藏');

            } else {
                $(this).css('background', "url('{{asset('home/images/goods/shouHui.png')}}') no-repeat 15% 55%").text('添加收藏');
            }
        });
    </script>
@endsection