@extends('home.layout.layout')
@section("title","我的足迹")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/browseHistory/joinIn.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>足迹</span></p>
    </div>
    <div class="oStep clear">
        <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <!--右侧内容-->
        <div class="tStepCont">
            <div class="footTile">
                <p>我的足迹</p>
                <ul>
                    <li class="sec">全部商品</li>
                    <li>酒店用品({{$count['jdyp']}})</li>
                    <li>饭店用品({{$count['fdyp']}})</li>
                    <li>连锁品牌({{$count['lspp']}})</li>
                </ul>
            </div>
            <div class="footCont">
                <div class="sec clear">
                    @if(!$browseHistoryInfos)
                        {{--暂无足迹--}}
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">暂无足迹~</span>
                        </p>
                    @else
                        <p>以下是您近30天浏览的商品记录(心仪商品记得要收藏哦)</p>
                        <div class="footHui">
                            <img src="{{asset('home/images/browseHistory/shuitan.png')}}" alt="">
                        </div>
                        <div class="footHong"></div>
                        <ul class="outUl">
                            @foreach($browseHistoryInfos as $k=>$v)
                                <li>
                                    <div class="footDel" id="{{$k}}">
                                        <img src="{{asset('home/images/browseHistory/ljtong.png')}}" alt="">
                                        <span>删除</span>
                                    </div>
                                    <ul class="inUl clear">
                                        @foreach($v as $k1=>$v1)
                                            <li>
                                                <img src="{{asset('home/images/browseHistory/cha.png')}}"
                                                     id="{{$v1['id']}}" alt="">
                                                <a href="{{url('goods/index')}}/{{$v1['goods']['id']}}">

                                    <span>
                                        <img src="" trueImg="{{$v1['name_url']}}" alt="">
                                    </span>
                                                    @if(is_11121())
                                                        <p class="footOne">1.11.21冰点价 : </p>
                                                        <p class="footTwo"><i>{{$v1['goods']['show_sale_price']}}</i>元
                                                        </p>
                                                        <p class="footThr">宜购价 : <i>{{$v1['goods']['show_price']}}</i>元
                                                        </p>
                                                    @else
                                                        <p class="footOne">宜购价 : </p>
                                                        <p class="footTwo"><i>{{$v1['goods']['show_price']}}</i>元</p>
                                                        <p class="footThr" style="text-decoration: none;">1.11.21冰点价 :
                                                            <i>{{$v1['goods']['show_sale_price']}}</i>元</p>
                                                    @endif
                                                </a>
                                                <div class="inUl-zheZhao">删除成功</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <img src="{{asset('home/images/browseHistory/warter.png')}}" alt="">
                                    <div class="bjBen">
                                        @if(getDay($k))
                                            <span><i>{{$k}}</i><em>{{getDay($k)}}</em></span>
                                        @else
                                            <span><i></i><em
                                                        style="font-size:6px;top:33px;inUl clear">{{$k}}</em></span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="clear">
                    @if(!$count['jdyp'])
                        {{--暂无足迹--}}
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">暂无足迹~</span>
                        </p>
                    @else
                        <p>以下是您近30天浏览的商品记录(心仪商品记得要收藏哦)</p>
                        <div class="footHui">
                            <img src="{{asset('home/images/browseHistory/shuitan.png')}}" alt="">
                        </div>
                        <div class="footHong"></div>
                        <ul class="outUl">
                            @foreach($hotel as $k=>$v)
                                <li>
                                    <div class="footDel" id="{{$k}}">
                                        <img src="{{asset('home/images/browseHistory/ljtong.png')}}" alt="">
                                        <span>删除</span>
                                    </div>
                                    <ul class="inUl clear">
                                        @foreach($v as $k1=>$v1)
                                            <li>
                                                <img src="{{asset('home/images/browseHistory/cha.png')}}"
                                                     id="{{$v1['id']}}" alt="">
                                                <a href="{{url('goods/index')}}/{{$v1['goods']['id']}}">

                                    <span>
                                        <img src="" trueImg="{{$v1['name_url']}}" alt="">
                                    </span>
                                                    @if(is_11121())
                                                        <p class="footOne">1.11.21冰点价 : </p>
                                                        <p class="footTwo"><i>{{$v1['goods']['show_sale_price']}}</i>元
                                                        </p>
                                                        <p class="footThr">宜购价 : <i>{{$v1['goods']['show_price']}}</i>元
                                                        </p>
                                                    @else
                                                        <p class="footOne">宜购价 : </p>
                                                        <p class="footTwo"><i>{{$v1['goods']['show_price']}}</i>元</p>
                                                        <p class="footThr" style="text-decoration: none;">1.11.21冰点价 :
                                                            <i>{{$v1['goods']['show_sale_price']}}</i>元</p>
                                                    @endif
                                                </a>
                                                <div class="inUl-zheZhao">删除成功</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <img src="{{asset('home/images/browseHistory/warter.png')}}" alt="">
                                    <div class="bjBen">
                                        @if(getDay($k))
                                            <span><i>{{$k}}</i><em>{{getDay($k)}}</em></span>
                                        @else
                                            <span><i></i><em
                                                        style="font-size:6px;top:33px;inUl clear">{{$k}}</em></span>
                                        @endif
                                    </div>
                                </li>

                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="clear">
                    @if($count['fdyp']<=0)
                        {{--暂无足迹--}}
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">暂无足迹~</span>
                        </p>
                    @else
                        <p>以下是您近30天浏览的商品记录(心仪商品记得要收藏哦)</p>
                        <div class="footHui">
                            <img src="{{asset('home/images/browseHistory/shuitan.png')}}" alt="">
                        </div>
                        <div class="footHong"></div>
                        <ul class="outUl">
                            @foreach($house as $k=>$v)
                                <li>
                                    <div class="footDel" id="{{$k}}">
                                        <img src="{{asset('home/images/browseHistory/ljtong.png')}}" alt="">
                                        <span>删除</span>
                                    </div>
                                    <ul class="inUl clear">
                                        @foreach($v as $k1=>$v1)
                                            <li>
                                                <img src="{{asset('home/images/browseHistory/cha.png')}}"
                                                     id="{{$v1['id']}}" alt="">
                                                <a href="{{url('goods/index')}}/{{$v1['goods']['id']}}">

                                    <span>
                                        <img src="" trueImg="{{$v1['name_url']}}" alt="">
                                    </span>
                                                    @if(is_11121())
                                                        <p class="footOne">1.11.21冰点价 : </p>
                                                        <p class="footTwo"><i>{{$v1['goods']['show_sale_price']}}</i>元
                                                        </p>
                                                        <p class="footThr">宜购价 : <i>{{$v1['goods']['show_price']}}</i>元
                                                        </p>
                                                    @else
                                                        <p class="footOne">宜购价 : </p>
                                                        <p class="footTwo"><i>{{$v1['goods']['show_price']}}</i>元</p>
                                                        <p class="footThr" style="text-decoration: none;">1.11.21冰点价 :
                                                            <i>{{$v1['goods']['show_sale_price']}}</i>元</p>
                                                    @endif
                                                </a>
                                                <div class="inUl-zheZhao">删除成功</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <img src="{{asset('home/images/browseHistory/warter.png')}}" alt="">
                                    <div class="bjBen">
                                        @if(getDay($k))
                                            <span><i>{{$k}}</i><em>{{getDay($k)}}</em></span>
                                        @else
                                            <span><i></i><em
                                                        style="font-size:6px;top:33px;inUl clear">{{$k}}</em></span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="clear">
                    @if($count['lspp']<=0)
                        {{--暂无足迹--}}
                        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                            <img src="{{asset('home/images/comment/zzwu.png')}}"
                                 style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">暂无足迹~</span>
                        </p>
                    @else
                        <p>以下是您近30天浏览的商品记录(心仪商品记得要收藏哦)</p>
                        <div class="footHui">
                            <img src="{{asset('home/images/browseHistory/shuitan.png')}}" alt="">
                        </div>
                        <div class="footHong"></div>
                        <ul class="outUl">
                            @foreach($home as $k=>$v)
                                <li>
                                    <div class="footDel" id="{{$k}}">
                                        <img src="{{asset('home/images/browseHistory/ljtong.png')}}" alt="">
                                        <span>删除</span>
                                    </div>
                                    <ul class="inUl clear">
                                        @foreach($v as $k1=>$v1)
                                            <li>
                                                <img src="{{asset('home/images/browseHistory/cha.png')}}"
                                                     id="{{$v1['id']}}" alt="">
                                                <a href="{{url('goods/index')}}/{{$v1['goods']['id']}}">

                                    <span>
                                        <img src="" trueImg="{{$v1['name_url']}}" alt="">
                                    </span>
                                                    @if(is_11121())
                                                        <p class="footOne">1.11.21冰点价 : </p>
                                                        <p class="footTwo"><i>{{$v1['goods']['show_sale_price']}}</i>元
                                                        </p>
                                                        <p class="footThr">宜购价 : <i>{{$v1['goods']['show_price']}}</i>元
                                                        </p>
                                                    @else
                                                        <p class="footOne">宜购价 : </p>
                                                        <p class="footTwo"><i>{{$v1['goods']['show_price']}}</i>元</p>
                                                        <p class="footThr" style="text-decoration: none;">1.11.21冰点价 :
                                                            <i>{{$v1['goods']['show_sale_price']}}</i>元</p>
                                                    @endif
                                                </a>
                                                <div class="inUl-zheZhao">删除成功</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <img src="{{asset('home/images/browseHistory/warter.png')}}" alt="">
                                    <div class="bjBen">
                                        @if(getDay($k))
                                            <span><i>{{$k}}</i><em>{{getDay($k)}}</em></span>
                                        @else
                                            <span><i></i><em
                                                        style="font-size:6px;top:33px;inUl clear">{{$k}}</em></span>
                                        @endif
                                    </div>
                                </li>
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
            <p class="btiao">删除浏览痕迹</p>
            <p class="gan">
                <img src="{{asset('home/images/browseHistory/gantanhao.png')}}" alt="">
                <span>您确定要删除该天商品浏览痕迹吗？</span>
            </p>
            <a class="laL" href="javascript:;">确定</a>
            <a class="noDel" href="javascript:;">取消</a>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript">
        //点击删除
        $('.footCont .outUl .inUl li > img').click(function (event) {
            var _this = $(this),
                id = _this.attr('id');
            $.ajax({
                url: "{{url('browseHistory/delById')}}",
                type: 'post',
                data: {id: id},
                success: function (res) {
                    if (res.err == 200) {
                        _this.parent().children('.inUl-zheZhao').css('display', 'block');
                    }
                }
            })
        });
        //删除收货地址
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || documnet.body.clientHeight;
        $('.delHide').css({'width': widthP, 'height': heightP});
        $('.footDel').unbind('click').click(function () {
            var _this = $(this);
            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {
                var id = _this.attr('id');
                $.ajax({
                    url: "{{url('browseHistory/delByTime')}}",
                    type: 'post',
                    data: {time: id},
                    success: function (res) {
                        if (res.err == 200) {
                            _this.parent().children('.inUl').find('li').children('.inUl-zheZhao').css('display', 'block');
                        }
                    }
                });
                $('.delHide').fadeOut(300);
            });
            $('.noDel').unbind('click').click(function () {
                $('.delHide').fadeOut(300);
            });
        });
        //延迟加载
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
            $('.footCont .outUl .inUl li > a > span > img').each(function (k, v) {
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
        //滚动灰色线条
        var hongHeight = null;
        if ($('.outUl').height() <= 894) {
            $('.outUl>li').each(function (k, v) {
                hongHeight += $(v).height();
            })
        } else {
            hongHeight = $('.outUl').height();
        }
        $('.footCont .footHui').css('height', hongHeight);
        //红色线条滚动
        $(document).ready(function () {
            var h = $(window).height() / 2;
            var timer = null;
            var topHei = $(window).scrollTop() - 389;
            var hongGao = h + topHei;
            if (hongGao > $('.footCont>div.sec').children('.footHui').height()) {
                hongGao = $('.footCont>div.sec').children('.footHui').height();
            }
            $('.footCont>div.sec').children('.footHong').animate({'height': hongGao}, 400);
            $(document).scroll(function () {
                if (timer) clearTimeout(timer);
                var top = $(window).scrollTop() - 389;
                var hongGao = h + top;
                if (hongGao > $('.footCont>div.sec').children('.footHui').height()) {
                    hongGao = $('.footCont>div.sec').children('.footHui').height();
                }
                timer = setTimeout(function () {
                    $('.footCont>div.sec').children('.footHong').animate({'height': hongGao}, 400);
                }, 150)
            });
        });
        //选项卡
        $('.footTile ul li').click(function () {
            $('.footTile ul li,.footCont > div').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            var dla = $('.footCont > div').eq($(this).prevAll().length);
            dla.addClass('sec');
            //给选项卡里相对应的灰色线条赋值；
            var hongHeight = 0;
            if (dla.find('.outUl').height() <= 894) {
                dla.find('.outUl').children('li').each(function (k, v) {
                    hongHeight += $(v).height();
                })
            } else {
                hongHeight = dla.find('.outUl').height();
            }
            dla.children('.footHui').css('height', hongHeight);
            //给选项卡对应的div的灰色线条做判断；
            var h = $(window).height() / 2;
            var topHei = $(window).scrollTop() - 389;
            var hongGao = h + topHei;
            if (hongGao > dla.children('.footHui').height()) {
                hongGao = dla.children('.footHui').height();
            }
            dla.children('.footHong').animate({'height': hongGao}, 400);
        })
    </script>
@endsection
