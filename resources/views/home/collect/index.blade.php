@extends("home.layout.layout")
@section("title","我的收藏")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/collect/shoucang.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>收藏</span></p>
    </div>

    <div class="oStep clear">
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <!--右侧内容-->
        <div class="tStepCont">
            <ul>
                <li class="sec">全部商品</li>
                <li>酒店用品<span>({{$count["jdyp"]}})</span></li>
                <li>饭店用品<span>({{$count["fdyp"]}})</span></li>
                <li>连锁品牌<span>({{$count["lspp"]}})</span></li>
            </ul>
            <div class="shouLine"></div>
            <div class="shouCon">
                <div class="shouQuan sec">
                    @if(!$collectionInfo)
                        {{--暂无收藏商品--}}
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无收藏商品~</span>
                        </p>
                    @else
                        <ul class="clear">
                            @foreach($collectionInfo as $k=>$v)
                                <li>
                                    <a href="{{url('goods/index')}}/{{$v['goods']['id']}}">
                                        <div class="sQuanTop">
                                            <div>
                                                <img src="" trueImg="{{$v['name_url']}}" alt="">
                                            </div>
                                            <p class="sQtop">{{$v['goods']['name']}}
                                            @if(is_11121())
                                                <p class="sQBot"><span>{{$v['goods']['show_sale_price']}}</span>(元)</p>
                                            @else
                                                <p class="sQBot"><span>{{$v['goods']['show_price']}}</span>(元)</p>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="sQuanBot">
                                        <button class="jGc">
                                            <i></i>
                                            <span><a href="{{url('goods/index')}}/{{$v['goods']['id']}}">加入购物车</a></span>
                                        </button>
                                        <span>|</span>
                                        <button class="del" goods="{{$v['goods']['id']}}" onselectstart="return false;">
                                            <i></i>
                                            <span>删除收藏</span>
                                        </button>
                                        <span>|</span>
                                        <p>
                                            <i></i>
                                            <span>好评度<i style="font-style: normal;">{{number_format($v['avg'],1)}}</i></span>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="shouQuan">
                    @if($count['jdyp']<=0)
                        {{--暂无收藏商品--}}
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无收藏商品~</span>
                        </p>
                    @else
                        <ul class="clear">
                            @foreach($collectionInfo as $k=>$v)
                                @if(in_array($v['goods']['f_goods_type_id'],[5,6,7,10,149,9,160]))
                                    <li>
                                        <a href="{{url('goods/index')}}/{{$v['goods']['id']}}">
                                            <div class="sQuanTop">
                                                <div>
                                                    <img src="" trueImg="{{$v['name_url']}}" alt="">
                                                </div>
                                                <p class="sQtop">{{$v['goods']['name']}}</p>
                                                @if(is_11121())
                                                    <p class="sQBot"><span>{{$v['goods']['show_sale_price']}}</span>(元)
                                                    </p>
                                                @else
                                                    <p class="sQBot"><span>{{$v['goods']['show_price']}}</span>(元)</p>
                                                @endif
                                            </div>
                                            <div class="sQuanBot">
                                                <button class="jGc">
                                                    <i></i>
                                                    <span><a href="{{url('goods/index')}}/{{$v['goods']['id']}}">加入购物车</a></span>
                                                </button>
                                                <span>|</span>
                                                <button class="del" goods="{{$v['goods']['id']}}"
                                                        onselectstart="return false;">
                                                    <i></i>
                                                    <span>删除收藏</span>
                                                </button>
                                                <span>|</span>
                                                <p>
                                                    <i></i>
                                                    <span>好评度<i style="font-style: normal;">{{number_format($v['avg'],1)}}</i></span>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="shouQuan">
                    @if($count['fdyp']<=0)
                        {{--暂无收藏商品--}}
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无收藏商品~</span>
                        </p>
                    @else
                        <ul class="clear">
                            @foreach($collectionInfo as $k=>$v)
                                @if(in_array($v['goods']['f_goods_type_id'],[11,12,13,161,14,153,162]))
                                    <li>
                                        <a href="{{url('goods/index')}}/{{$v['goods']['id']}}">
                                            <div class="sQuanTop">
                                                <div>
                                                    <img src="" trueImg="{{$v['name_url']}}" alt="">
                                                </div>
                                                <p class="sQtop">{{$v['goods']['name']}}</p>
                                                @if(is_11121())
                                                    <p class="sQBot"><span>{{$v['goods']['show_sale_price']}}</span>(元)
                                                    </p>
                                                @else
                                                    <p class="sQBot"><span>{{$v['goods']['show_price']}}</span>(元)</p>
                                                @endif
                                            </div>
                                            <div class="sQuanBot">
                                                <button class="jGc">
                                                    <i></i>
                                                    <span><a href="{{url('goods/index')}}/{{$v['goods']['id']}}">加入购物车</a></span>
                                                </button>
                                                <span>|</span>
                                                <button class="del" goods="{{$v['goods']['id']}}"
                                                        onselectstart="return false;">
                                                    <i></i>
                                                    <span>删除收藏</span>
                                                </button>
                                                <span>|</span>
                                                <p>
                                                    <i></i>
                                                    <span>好评度<i style="font-style: normal;">{{number_format($v['avg'],1)}}</i></span>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="shouQuan">
                    @if($count['lspp']<=0)
                        {{--暂无收藏商品--}}
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无收藏商品~</span>
                        </p>
                    @else
                        <ul class="clear">
                            @foreach($collectionInfo as $k=>$v)
                                @if(!in_array($v['goods']["f_goods_type_id"],[52,53,164,158,54,11,12,13,161,14,153,162,5,6,7,10,149,9,160]))
                                    <li>
                                        <a href="{{url('goods/index')}}/{{$v['goods']['id']}}">
                                            <div class="sQuanTop">
                                                <div>
                                                    <img src="" trueImg="{{$v['name_url']}}" alt="">
                                                </div>
                                                <p class="sQtop">{{$v['goods']['name']}}</p>
                                                @if(is_11121())
                                                    <p class="sQBot"><span>{{$v['goods']['show_sale_price']}}</span>(元)
                                                    </p>
                                                @else
                                                    <p class="sQBot"><span>{{$v['goods']['show_price']}}</span>(元)</p>
                                                @endif
                                            </div>
                                            <div class="sQuanBot">
                                                <button class="jGc">
                                                    <i></i>
                                                    <span><a href="{{url('goods/index')}}/{{$v['goods']['id']}}">加入购物车</a></span>
                                                </button>
                                                <span>|</span>
                                                <button class="del" goods="{{$v['goods']['id']}}"
                                                        onselectstart="return false;">
                                                    <i></i>
                                                    <span>删除收藏</span>
                                                </button>
                                                <span>|</span>
                                                <p>
                                                    <i></i>
                                                    <span>好评度<i style="font-style: normal;">{{number_format($v['avg'],1)}}</i></span>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--删除收货地址遮罩层-->
    <div class="delHide">
        <div class="zhaozhao">
            <p class="btiao">删除收藏</p>
            <p class="gan">
                <img src="{{asset('home/images/collect/gantanhao.png')}}" alt="">
                <span>您确定要删除该商品的收藏吗？</span>
            </p>
            <a class="laL" href="javascript:;">确定</a>
            <a class="noDel" href="javascript:;">取消</a>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript">
        //选项卡
        $('.tStepCont>ul>li').click(function () {
            $('.tStepCont>ul>li,.shouCon>div').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            $('.shouCon>div').eq($(this).prevAll().length).addClass('sec');
        });
        //图片延迟加载
        function loadImg(curImg) {
            var tempImg = new Image;
            tempImg.src = curImg.getAttribute('trueImg');
            tempImg.onload = function () {
                curImg.src = this.src;
                $(curImg).fadeIn().css('background', 'none');
                tempImg = null;
            };
            curImg.isLoad = true;
        }
        function xun() {
            $('.sQuanTop>div>img').each(function (k, v) {
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
        //删除收货地址
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || documnet.body.clientHeight;
        $('.delHide').css({'width': widthP, 'height': heightP});
        $('.del').unbind('click').click(function () {
            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {
                $('.delHide').fadeOut(300);
            });
        });
        $('.noDel').unbind('click').click(function () {
            $('.delHide').fadeOut(300);
        });
        //删除收藏的商品
        $('.del').unbind('click').click(function () {
            $('.delHide').fadeIn();
            $('.laL').attr('goId', $(this).attr('goods'));
            $('.laL').unbind('click').click(function () {
                var id = $(this).attr('goId');
                $.ajax({
                    url: "{{url('goods/collect')}}",
                    type: "post",
                    data: {"id": id},
                    success: function (res) {
                        location.reload(true)
                    },
                    error: function (res) {
                        console.log(res);
                    }
                });
                $('.delHide').fadeOut();
                $('.laL').removeAttr('goId');
            });
            $('.noDel').unbind().click(function () {
                $('.delHide').fadeOut();
                $('.laL').removeAttr('goId');
            })
        })
    </script>
@endsection