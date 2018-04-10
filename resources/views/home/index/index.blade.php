@extends("home.layout.layout")
@section("title","宜优速--一站式消耗品采购平台")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/index/swiper.min.css')}}">
    <link rel="stylesheet" href="{{asset('home/images/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/index/base.css')}}">
    <script>
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 1349 * 100 + 'px';
    </script>
    <link rel="stylesheet" href="{{asset('home/css/index/index.css')}}">
    <script type='text/javascript' src="{{asset('home/images/js/modernizr.min.js?ver=2.6.1')}}"></script>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var CSSettings = {"pluginPath": "{{asset('home/images')}}"};
        /* ]]> */
    </script>
    <script type='text/javascript' src='{{asset("home/images/js/cute.slider.js?ver=2.0.0")}}'></script>
    <script type='text/javascript' src="{{asset('home/images/js/cute.transitions.all.js?ver=2.0.0')}}"></script>
@endsection

@section("content")
    <!--广告位-->
    <div class="guang">
        <img src="{{asset('home/images/index/top.jpg')}}" alt="">
    </div>
    <!--logo位置-->
    <div class="tit">
        <h1>
            <a href="{{url('')}}">
                <img src="{{asset('home/images/logo.png')}}" alt="">
            </a>
        </h1>
        <div class="search">
            <p>
                <input type="text" id="search" placeholder="请输入商品名称">
                <span onclick="goodSearch()">
            <img src="{{asset('home/images/sousuo.png')}}" alt="">搜索
                </span>
            </p>
            <div>热门搜索 :
                <a href="{{url('goods/search')}}?name=锦特">锦特</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{url('goods/search')}}?name=杏叶">杏叶</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{url('goods/search')}}?name=垃圾袋">垃圾袋</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{url('goods/search')}}?name=拖鞋">拖鞋</a>
            </div>
        </div>
        <div class="right_d">
            <a class="d_o" href="{{url('person/index')}}">
                <img src="{{asset('home/images/huiyuan.png')}}" alt="">会员中心
            </a>
            <a class="d_t" href="{{url('shopCart/index')}}">
                <img src="{{asset('home/images/gouwuche-.png')}}" alt="">购物车
            </a>
        </div>
    </div>
    <!--分类-->
    <div class="con">
        <ul class="fenlei clear">
            <li>
                <img src="{{asset('home/images/shangpinfenlei.png')}}" alt="">全部商品分类
                <!--定位在banner上的分类-->
                <div class="fDing">
                    <ul class="fd-t">
                        <li>
                            <a href="{{url('category/hotel/5')}}">
                                <img src="{{asset('home/images/jiudian.png')}}" class="fdl" alt="">
                                <span>酒店用品</span>
                                <img class="mo" src="{{asset('home/images/heijiantou.png')}}" alt="">
                                <img class="yi" src="{{asset('home/images/baijiantou.png')}}" alt="">
                                <div class="hid">
                                    <a href="{{url('category/hotel/5')}}"><p><img
                                                    src="{{asset('home/images/jiudian/客房卷纸.png')}}" alt="">客房卷纸</p></a>
                                    <a href="{{url('category/hotel/6')}}"><p><img
                                                    src="{{asset('home/images/jiudian/客房用品.png')}}" alt="">客房用品</p></a>
                                    <a href="{{url('category/hotel/7')}}"><p><img
                                                    src="{{asset('home/images/jiudian/清洁用品.png')}}" alt="">清洁用品</p></a>
                                    <a href="{{url('category/hotel/10')}}"><p><img
                                                    src="{{asset('home/images/jiudian/电器专区.png')}}" alt="">电器专区</p></a>
                                    <a href="{{url('category/hotel/149')}}"><p><img
                                                    src="{{asset('home/images/jiudian/针织布草.png')}}" alt="">针织布草</p></a>
                                    <a href="{{url('category/hotel/9')}}"><p><img
                                                    src="{{asset('home/images/jiudian/有偿用品.png')}}" alt="">有偿用品</p></a>
                                    <a href="{{url('category/hotel/160')}}"><p><img
                                                    src="{{asset('home/images/jiudian/布草洗涤.png')}}" alt="">布草洗涤</p></a>
                                    <a href="{{url('category/hotel/216')}}"><p><img
                                                    src="{{asset('home/images/jiudian/私人定制.png')}}" alt="">私人定制</p></a>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('category/house/11')}}">
                                <img src="{{asset('home/images/canyin.png')}}" class="fdl" alt="">
                                <span>饭店用品</span>
                                <img class="mo" src="{{asset('home/images/heijiantou.png')}}" alt="">
                                <img class="yi" src="{{asset('home/images/baijiantou.png')}}" alt="">
                                <div class="hid">
                                    <a href="{{url('category/house/11')}}"><p><img
                                                    src="{{asset('home/images/canting/餐厅用纸.png')}}" alt="">餐厅用纸</p></a>
                                    <a href="{{url('category/house/12')}}"><p><img
                                                    src="{{asset('home/images/canting/餐厅用品.png')}}" alt="">餐厅用品</p></a>
                                    <a href="{{url('category/house/13')}}"><p><img
                                                    src="{{asset('home/images/canting/清洁用品.png')}}" alt="">清洁用品</p></a>
                                    <a href="{{url('category/house/161')}}"><p><img
                                                    src="{{asset('home/images/canting/厨房用品.png')}}" alt="">厨房用品</p></a>
                                    <a href="{{url('category/house/14')}}"><p><img
                                                    src="{{asset('home/images/canting/针织布草.png')}}" alt="">针织布草</p></a>
                                    <a href="{{url('category/house/153')}}"><p><img
                                                    src="{{asset('home/images/canting/装修专区.png')}}" alt="">装修专区</p></a>
                                    <a href="{{url('category/house/162')}}"><p><img
                                                    src="{{asset('home/images/canting/布草洗涤.png')}}" alt="">布草洗涤</p></a>
                                    <a href="{{url('category/house/217')}}"><p><img
                                                    src="{{asset('home/images/jiudian/私人定制.png')}}" alt="">私人定制</p></a>
                                </div>
                            </a>
                        </li>
                        {{--<li>
                            <a href="{{url('category/home/53')}}">
                                <img src="{{asset('home/images/jujia.png')}}" class="fdl" alt="">
                                <span>居家用品</span>
                                <img class="mo" src="{{asset('home/images/heijiantou.png')}}" alt="">
                                <img class="yi" src="{{asset('home/images/baijiantou.png')}}" alt="">
                                <div class="hid">
                                    <a href="{{url('category/home/53')}}"><p><img
                                                    src="{{asset('home/images/jujia/居家用纸.png')}}" alt="">居家用纸</p></a>

                                    <a href="{{url('category/home/52')}}"><p><img
                                                    src="{{asset('home/images/jujia/针织家纺.png')}}" alt="">针织家纺</p></a>
                                    <a href="{{url('category/home/164')}}"><p><img
                                                    src="{{asset('home/images/jujia/清洁用品.png')}}" alt="">清洁用品</p></a>
                                    <a href="{{url('category/home/158')}}"><p><img
                                                    src="{{asset('home/images/jujia/居家装修.png')}}" alt="">居家装修</p></a>
                                    <a href="{{url('category/home/54')}}"><p><img
                                                    src="{{asset('home/images/jujia/洗护专区.png')}}" alt="">洗护专区</p></a>
                                </div>
                            </a>
                        </li>--}}
                    </ul>
                    @if(session("userInfo"))
                        <div class="fd-m">
                            @if(file_exists(env("HEADIMG")."/".session("userInfo")["id"].".jpg"))
                                <img src="{{env("YYSURL")}}/Public/UserHeadImg/{{session('userInfo')['id']}}.jpg" alt=""
                                     class="zeng">
                            @else
                                <img src="{{asset('home/images/vip/tou.jpg')}}" alt="" class="zeng">
                            @endif
                            @if(session("userInfo")["f_vip_level_id"]==1)
                                <p class="fdTwo" style="color: #666;"><img
                                            src="{{asset('home/images/vip/huiyuan.png')}}" alt="">普通会员</p>
                            @else
                                <p class="fdTwo" style="color: #666;"><img src="{{asset('home/images/huangguan.png')}}"
                                                                           alt="">黄金会员</p>
                            @endif
                            <p class="dengg" onclick="logout()">退出</p>
                            <p>
                                <a href="{{url('integral/person')}}" class="pl"><img
                                            src="{{asset('home/images/jifen.png')}}" alt="">查看积分</a>
                                <a href="{{url("collect/index")}}" class="pr"><img
                                            src="{{asset('home/images/shoucang.png')}}" alt="">查看收藏</a>
                            </p>
                        </div>
                    @else
                        <div class="fd-m">
                            <img src="{{asset('home/images/vip/tou.jpg')}}" alt="" class="zeng">
                            <p class="deng"><a href="{{url("login")}}">登录</a></p>
                            <p class="deng"><a href="{{url('register')}}">注册</a></p>
                            <p>
                                <a href="{{url('integral/person')}}" class="pl"><img
                                            src="{{asset('home/images/jifen.png')}}" alt="">查看积分</a>
                                <a href="{{asset('collect/index')}}" class="pr"><img
                                            src="{{asset('home/images/shoucang.png')}}" alt="">查看收藏</a>
                            </p>
                        </div>
                    @endif
                    <ul class="fd-b carousel">
                        <li>
                            <a href="{{url('new/1')}}">
                                <img src="{{asset('home/images/laba.png')}}" alt="">
                                <span style="color:#980e3f;">[<i>公告</i>]宜优速成立河南分公司</span>
                            </a>
                        </li>
                        @foreach($newsInfo as $k=>$v)
                            <li>
                                <a href="{{$v['url']}}/{{$v['id']}}">
                                    <img src="{{asset('home/images/laba.png')}}" alt="">
                                    <span style="color:#980e3f;">[<i>公告</i>]{{$v['title']}}</span>
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{url('new/8')}}">
                                <img src="{{asset('home/images/laba.png')}}" alt="">
                                <span style="color:#980e3f;">[<i>公告</i>]关于近期送货时间波动的通知</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('new/7')}}">
                                <img src="{{asset('home/images/laba.png')}}" alt="">
                                <span style="color:#980e3f;">[<i>公告</i>]宜优速常州分公司成立</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('new/3')}}">
                                <img src="{{asset('home/images/laba.png')}}" alt="">
                                <span style="color:#980e3f;">[<i>公告</i>]易耗狂购日活动</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('new/2')}}">
                                <img src="{{asset('home/images/laba.png')}}" alt="">
                                <span style="color:#980e3f;">[<i>公告</i>]积分商城火热上线</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('new/6')}}">
                                <img src="{{asset('home/images/laba.png')}}" alt="">
                                <span style="color:#980e3f;">[<i>公告</i>]注重便捷化体验 宜优速全新采购平台上线</span>
                            </a>
                        </li>
                    </ul>
                    <a href="{{url('news/list')}}">更多</a>
                </div>
            </li>
            <li><a href="{{url('/')}}">首页</a></li>
            {{--<li><a href="{{url('integral/shop/index')}}">积分商城</a></li>--}}
            {{--<li><a href="{{url("temp/vip")}}">会员充值</a></li>--}}
            <li><a href="{{url('checkIn/index')}}">签到</a></li>
            <li><a href="{{url('purchase')}}">企业采购</a></li>
            <li><a href="{{url('brand')}}">连锁品牌</a></li>
            <li><a href="{{url('recharge/index')}}">立即充值</a></li>
            {{--<li><a href="{{url("temp/info")}}">信息资讯</a></li>--}}
            <li><a href="{{url('news/list')}}">新闻中心</a></li>
            <li><a href="{{url('contact')}}">联系我们</a></li>
        </ul>
    </div>
    <!--轮播图-->
    <div class="c-860 c-demoslider">
        <div id="cuteslider_3_wrapper" class="cs-circleslight">
            <div id="cuteslider_3" class="cute-slider" data-width="1920" data-height="730" data-overpause="true">
                <ul data-type="slides">
                    <li data-delay="1" data-src="5"
                        data-trans3d="tr6,tr17,tr22,tr23,tr29,tr27,tr32,tr34,tr35,tr53,tr54,tr62,tr63,tr4,tr13,tr45"
                        data-trans2d="tr3,tr8,tr12,tr19,tr22,tr25,tr27,tr29,tr31,tr34,tr35,tr38,tr39,tr41"><img
                                src="{{asset('home/images/banner1.jpg')}}" data-thumb=""><a data-type="link"
                                                                                            href="{{url('recharge/index')}}"
                        ></a>
                    </li>
                    <li data-delay="1" data-src="5"
                        data-trans3d="tr6,tr17,tr22,tr23,tr26,tr27,tr29,tr32,tr34,tr35,tr53,tr54,tr62,tr63,tr4,tr13"
                        data-trans2d="tr3,tr8,tr12,tr19,tr22,tr25,tr27,tr29,tr31,tr34,tr35,tr38,tr39,tr41"><img src=""
                                                                                                                data-src="{{asset('home/images/banner2.jpg')}}"
                                                                                                                data-thumb=""><a
                                data-type="link" href="{{url('register')}}"></a>
                    </li>
                    <li data-delay="1" data-src="5"
                        data-trans3d="tr6,tr17,tr22,tr23,tr26,tr27,tr29,tr32,tr34,tr35,tr53,tr54,tr62,tr63,tr4,tr13"
                        data-trans2d="tr3,tr8,tr12,tr19,tr22,tr25,tr27,tr29,tr31,tr34,tr35,tr38,tr41"><img src=""
                                                                                                           data-src="{{asset('home/images/banner3.png')}}"
                                                                                                           data-thumb=""><a
                                data-type="link" href="{{url('checkIn/index')}}"></a>
                    </li>

                </ul>
                <ul data-type="controls">
                    <li data-type="captions"></li>
                    <li data-type="link"></li>
                    <li data-type="video"></li>
                    <li data-type="slideinfo"></li>
                    <li data-type="circletimer"></li>
                    <li data-type="previous"></li>
                    <li data-type="next"></li>
                    <li data-type="bartimer"></li>
                    <li data-type="slidecontrol" data-thumb="true" data-thumbalign="up"></li>
                </ul>
            </div>
        </div>
        -->
        <script type="text/javascript">var cuteslider3 = new Cute.Slider();
            cuteslider3.setup("cuteslider_3", "cuteslider_3_wrapper", "{{asset('home/images/css/slider-style.css')}}");
            cuteslider3.api.addEventListener(Cute.SliderEvent.CHANGE_START, function (event) {
            });
            cuteslider3.api.addEventListener(Cute.SliderEvent.CHANGE_END, function (event) {
            });
            cuteslider3.api.addEventListener(Cute.SliderEvent.WATING, function (event) {
            });
            cuteslider3.api.addEventListener(Cute.SliderEvent.CHANGE_NEXT_SLIDE, function (event) {
            });
            cuteslider3.api.addEventListener(Cute.SliderEvent.WATING_FOR_NEXT, function (event) {
            });</script>
    </div><!-- wrapper -->
    </div>
    <!--倒计时-->
    <div class="count">
        <div class="ccon clear">
            <img src="{{asset('home/images/wenzi.png')}}" alt="">
            <div class="news_Home_Bot">

                <!--<p id="gHuan">全场冰点倒计时</p>-->
                <div style="float:right;">
                    <span id="t_d">00</span>天
                    <span id="t_h">00</span>时
                    <span id="t_m">00</span>分
                    <span id="t_s">00</span>秒
                </div>
                <p id="gHuan" style="float:right;margin-right: 10px;font-size: 20px;color: #fff;">距离1.11.21狂购日活动还有</p>
            </div>
        </div>
    </div>
    <!--活动内容-->
    @if(is_11121())
        <div class="huodong clear">
            <img src="{{asset('home/images/huo.png')}}" alt="">
            <div class="conn">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($goodsInfo as $k=>$v)
                            <div class="swiper-slide" style="width: 243px;height: 234px;background-color:rgba(0,0,0,0)">
                                <a href="{{url('goods/index')}}/{{$v['id']}}"><img src="{{$v['image_url']}}" alt=""></a>
                                <div class="wenzi">
                                    <p class="ming"><span>{{$v['name']}}</span></p>
                                    <p class="jia">￥{{$v['show_sale_price']}}<em>￥{{$v['show_price']}}</em></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- 如果需要分页器 -->
                    <!--<div class="swiper-pagination"></div>-->
                    <!-- 如果需要滚动条 -->
                    <!--<div class="swiper-scrollbar"></div>-->
                </div>
                <!-- 如果需要导航按钮 -->
                <div class="swiper-button-prev" style="left:25px;" onselectstart="return false;"></div>
                <div class="swiper-button-next" style="right:25px;" onselectstart="return false;"></div>
            </div>
            {{--<div class="dleft"></div>
            <div class="dmid"></div>
            <div class="dright"></div>--}}
        </div>
    @endif
    <!--楼层内容-->
    <ul class="louceng">
        <li>
            <img class="last-img" src="{{asset('home/images/index/1f.jpg')}}" alt="">
            <h2>1F 酒店专区</h2>
            <ul class="neiulT">
                <li class="sec">客房卷纸</li>
                <li>客房用品</li>
                <li>清洁用品</li>
                <li>电器专区</li>
                <li>针织布草</li>
                <li>有偿用品</li>
                <li>布草洗涤</li>
                {{--<li>私人定制</li>--}}
                <li><a href="{{url('category/hotel/5')}}" style="display:block;color: #980c3f;">更多>></a></li>
                <!--<li>品牌定制</li>-->
            </ul>
            <div class="line"></div>
            <img src="{{asset('home/images/1fs.jpg')}}" alt="" class="img_O">
            <div class="xuan">
                <ul class="selec">
                    @foreach($hotel["kfjz"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$hotel['kfjz'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($hotel["kfyp"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$hotel['kfyp'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($hotel["qjyp"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$hotel['qjyp'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($hotel["dqzq"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$hotel['dqzq'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($hotel["zzbc"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$hotel['zzbc'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($hotel["ycyp"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$hotel['ycyp'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($hotel["bcxd"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$hotel['bcxd'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
            </div>
        </li>
        <li>
            <img class="last-img" src="{{asset('home/images/index/3f.jpg')}}" alt="">
            <h2>2F 饭店专区</h2>
            <ul class="neiulT">
                <li class="sec">餐厅用纸</li>
                <li>餐厅用品</li>
                <li>清洁用品</li>
                <li>厨房用品</li>
                <li>针织布草</li>
                <li>装修专区</li>
                <li>布草洗涤</li>
               {{--}} <li>私人定制</li>{{--}}
                <li><a href="{{url('category/house/11')}}" style="display:block;color: #980c3f;">更多>></a></li>
            </ul>
            <div class="line"></div>
            <img src="{{asset('home/images/3fs.jpg')}}" alt="" class="img_O">
            <div class="xuan">
                {{--有商品时的内容--}}
                <ul class="selec">
                    @foreach($house["ctyz"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$house['ctyz'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($house["ctyp"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$house['ctyp'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($house["qjyp"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$house['qjyp'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($house["cfyp"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$house['cfyp'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($house["zzbc"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$house['zzbc'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($house["zxzq"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$house['zxzq'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
                <ul>
                    @foreach($house["bcxd"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    @if(!$house['bcxd'])
                        {{--暂无商品时的提示--}}
                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">
                    @endif
                </ul>
            </div>
        </li>
        {{--<li>
            <img class="last-img" src="{{asset('home/images/index/2f.jpg')}}" alt="">
            <h2>3F 居家专区</h2>
            <ul class="neiulT">
                <li class="sec">居家用纸</li>
                <li>针织家纺</li>
                <li>清洁用品</li>
                <li>居家装修</li>
                <li>洗护专区</li>
                --}}{{--<li>更多>></li>--}}{{--
            </ul>
            <div class="line"></div>
            <img src="{{asset('home/images/2fs.jpg')}}" alt="" class="img_O">
            <div class="xuan">
                <ul class="selec">
                    @foreach($home["jjyz"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                </ul>
                <ul>
                    @foreach($home["zzjf"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                </ul>
                <ul>
                    @foreach($home["qjyp"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                </ul>
                <ul>
                    @foreach($home["jjzx"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                </ul>
                <ul>
                    @foreach($home["xhzq"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        </li>--}}
        <li>
            <img class="last-img" src="{{asset('home/images/index/4f.jpg')}}" alt="">
            <h2>3F 定制专区</h2>
            <ul class="neiulT">
                <li class="sec">七天连锁</li>
                <li>速8连锁</li>
                <li>城市便捷</li>
                <li>格林豪泰</li>
                <li>东方圣达</li>
                <li>汉庭快捷</li>
                <li>京恒宾馆</li>
                <li><a href="{{url('brand')}}" style="display:block;color: #980c3f;">更多>></a></li>
            </ul>
            <div class="line"></div>
            <img src="{{asset('home/images/4fs.jpg')}}" alt="" class="img_O">
            <div class="xuan">
                <ul class="selec">
                    @foreach($custom["qtlx"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    {{--暂无商品时的提示--}}
                    {{--<img src="{{asset('home/images/shouWu1.jpg')}}" alt="">--}}
                </ul>

                <ul>
                    @foreach($custom["sblx"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    {{--暂无商品时的提示--}}
                    {{--                        <img src="{{asset('home/images/shouWu1.jpg')}}" alt="">--}}
                </ul>
                <ul>
                    @foreach($custom["csbj"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    {{--暂无商品时的提示--}}
                    {{--<img src="{{asset('home/images/shouWu1.jpg')}}" alt="">--}}
                </ul>
                <ul>
                    @foreach($custom["glht"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    {{--暂无商品时的提示--}}
                    {{--<img src="{{asset('home/images/shouWu1.jpg')}}" alt="">--}}
                </ul>
                <ul>
                    @foreach($custom["dfsd"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    {{--暂无商品时的提示--}}
                    {{--<img src="{{asset('home/images/shouWu1.jpg')}}" alt="">--}}
                </ul>
                <ul>
                    @foreach($custom["htkj"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    {{--暂无商品时的提示--}}
                    {{--<img src="{{asset('home/images/shouWu1.jpg')}}" alt="">--}}
                </ul>
                <ul>
                    @foreach($custom["jhbg"] as $k=>$v)
                        <a href="{{url('goods/index')}}/{{$v['id']}}">
                            <li>
                                <div><img src="{{asset('home/images/index')}}/{{$v['id']}}.jpg" alt=""></div>
                                <p class="p-t" title="{{$v['name']}}">{{$v["name"]}}</p>
                                @if(is_11121())
                                    <p class="p-b">
                                        <span>￥ {{$v['show_sale_price']}}</span><em>￥ {{$v['show_price']}}</em>
                                    </p>
                                @else
                                    <p class="p-b"><span>￥ {{$v['show_price']}}</span></p>
                                @endif
                            </li>
                        </a>
                    @endforeach
                    {{--暂无商品时的提示--}}
                    {{--<img src="{{asset('home/images/shouWu1.jpg')}}" alt="">--}}
                </ul>
            </div>
        </li>
    </ul>
    <ul class="floor">
        <li class="bg">酒店<br>专区</li>
        <li>饭店<br>专区</li>
        {{--<li>居家<br>专区</li>--}}
        <li>定制<br>专区</li>
        <li class="back">返回<br>顶部</li>
    </ul>
    <!--右侧贴边导航quick_links.js控制-->
    <div class="mui-mbar-tabs">
        <div class="quick_link_mian">
            <div class="quick_links_panel">

                <div id="quick_links" class="quick_links">
                    <div class="COmmodity ">
                        <li class="li-a">
                            <span class="li-img1"></span>
                            <div class="mp_tooltip">
                                <ol>
                                    <li><a href="{{url('category/hotel/5')}}">客房卷纸</a></li>
                                    <li><a href="{{url('category/hotel/6')}}">客房用品</a></li>
                                    <li><a href="{{url('category/hotel/7')}}">清洁用品</a></li>
                                    <li><a href="{{url('category/hotel/10')}}">电器专区</a></li>
                                    <li><a href="{{url('category/hotel/149')}}">针织布草</a></li>
                                    <li><a href="{{url('category/hotel/9')}}">有偿用品</a></li>
                                    <li><a href="{{url('category/hotel/160')}}">布草洗涤</a></li>
                                    <li><a href="{{url('category/hotel/216')}}">私人定制</a></li>
                                </ol>
                                <i class="icon_arrow_right_black"></i>
                            </div>
                        </li>
                        <li class="li-i">
                            <span class="li-img2"></span>
                            <div class="mp_tooltip">
                                <ol>
                                    <li><a href="{{url('category/house/11')}}">餐厅用纸</a></li>
                                    <li><a href="{{url('category/house/12')}}">餐厅用品</a></li>
                                    <li><a href="{{url('category/house/13')}}">清洁用品</a></li>
                                    <li><a href="{{url('category/house/161')}}">厨房用品</a></li>
                                    <li><a href="{{url('category/house/14')}}">针织布草</a></li>
                                    <li><a href="{{url('category/house/153')}}">装修专区</a></li>
                                    <li><a href="{{url('category/house/162')}}">布草洗涤</a></li>
                                    <li><a href="{{url('category/house/217')}}">私人定制</a></li>
                                </ol>
                                <i class="icon_arrow_right_black"></i>
                            </div>
                        </li>
                        {{--<li class="li-k">
                            <span class="li-img4"></span>
                            <div class="mp_tooltip">
                                <ol>
                                    <li><a href="{{url('category/home/53')}}">居家用纸</a></li>
                                    <li><a href="{{url('category/home/52')}}">针织家纺</a></li>
                                    <li><a href="{{url('category/home/164')}}">清洁用品</a></li>
                                    <li><a href="{{url('category/home/158')}}">装修专区</a></li>
                                    <li><a href="{{url('category/home/54')}}">洗护专区</a></li>
                                </ol>
                                <i class="icon_arrow_right_black"></i>
                            </div>
                        </li>--}}

                    </div>
                    <li id="shopCart" onclick="fnGetShoppingCart()">
                        <a href="{{url('shopCart/index')}}" class="message_list"><i class="message"></i>
                            <div class="span">购物车</div>
                            <span class="cart_num" id="spanShoppingCartCount">0</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('person/index')}}" class="my_qlinks"><i
                                    class="setting"></i></a>
                        <div class="mp_tooltip"><a href="{{url('person/index')}}">个人中心</a><i
                                    class="icon_arrow_right_black"></i></div>
                    </li>
                    <li>
                        <a href="{{url('recharge/index')}}" class="mpbtn_recharge"><i
                                    class="chongzhi"></i></a>
                        <div class="mp_tooltip"><a href="{{url('recharge/index')}}">我要充值</a><i
                                    class="icon_arrow_right_black"></i></div>
                    </li>
                    <li>
                        <a href="{{url('browseHistory/index')}}" class="mpbtn_histroy"><i
                                    class="zuji"></i></a>
                        <div class="mp_tooltip"><a href="{{url('browseHistory/index')}}">我的足迹</a><i
                                    class="icon_arrow_right_black"></i></div>
                    </li>
                    <li>
                        <a href="{{url('collect/index')}}" class="mpbtn_wdsc"><i class="wdsc"></i></a>
                        <div class="mp_tooltip"><a href="{{url('collect/index')}}"
                                                   style="padding: 0px 10px;">我的收藏</a><i
                                    class="icon_arrow_right_black"></i>
                        </div>
                    </li>
                    <li>
                        <a href="{{url('checkIn/index')}}" class="mpbtn_recharge"><i class="chongzhi sign"></i></a>
                        <div class="mp_tooltip"><a href="{{url('checkIn/index')}}">每日签到</a><i
                                    class="icon_arrow_right_black"></i></div>
                    </li>
                </div>
                <div class="quick_toggle">
                    <li>
                        <a href="#" class="return_top"><i class="top"></i></a>
                        <div class="mp_tooltip">返回顶部<i class="icon_arrow_right_black"></i></div>
                    </li>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{asset('home/js/index/jquery.cookie.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/index/swiper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/index/common.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/index/quick_links.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/index/parabola.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/index/index.js')}}"></script>
    <script type="text/javascript">

        /*获取购物车数量*/
        $(function () {
            $.ajax({
                url: "{{url('shopCart/getCount')}}",
                async: false,
                success: function (res) {
                    if (res.err === 0) {
                        $("#spanShoppingCartCount").text(res.count);
                    }
                }
            });
        });


        $(".quick_links_panel li").mouseenter(function () {
            $(this).children(".mp_tooltip").animate({left: -92, queue: true});
            $(this).children(".mp_tooltip").css("visibility", "visible");
            $(this).children(".ibar_login_box").css("display", "block");
        });

        $(".COmmodity ul li").mouseenter(function () {
            $(this).children(".mp_tooltip").animate({left: -121, queue: true});

        });

        $(".quick_links_panel li").mouseleave(function () {
            $(this).children(".mp_tooltip").css("visibility", "hidden");
            $(this).children(".mp_tooltip").animate({left: -121, queue: true});
            $(this).children(".ibar_login_box").css("display", "none");
        });
        $(".quick_toggle li").mouseover(function () {
            $(this).children(".mp_qrcode").show();
        });
        $(".quick_toggle li").mouseleave(function () {
            $(this).children(".mp_qrcode").hide();
        });
        // 元素以及其他一些变量
        var eleFlyElement = document.querySelector("#flyItem"), eleShopCart = document.querySelector("#shopCart");
        var numberItem = 0;
        // 抛物线运动
        var myParabola = funParabola(eleFlyElement, eleShopCart, {
            speed: 400, //抛物线速度
            curvature: 0.0008, //控制抛物线弧度
            complete: function () {
                eleFlyElement.style.visibility = "hidden";
                eleShopCart.querySelector("span").innerHTML = ++numberItem;
            }
        });
        // 绑定点击事件
        if (eleFlyElement && eleShopCart) {

            [].slice.call(document.getElementsByClassName("btnCart")).forEach(function (button) {
                button.addEventListener("click", function (event) {
                    // 滚动大小
                    var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,
                        scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
                    eleFlyElement.style.left = event.clientX + scrollLeft + "px";
                    eleFlyElement.style.top = event.clientY + scrollTop + "px";
                    eleFlyElement.style.visibility = "visible";

                    // 需要重定位
                    myParabola.position().move();
                });
            });
        }
        function goodSearch() {
            var name = $("#search").val();
            location.href = "{{url('goods/search')}}?name=" + name;
        }
        function logout() {
            $.ajax({
                url: "{{url('logout')}}",
                success: function () {
                    location.href = "{{url('/')}}";
                }
            });
        }
        //选择城市
    </script>
    <script type="text/javascript">
        $(function () {
            if ($.cookie("isClose") != 'yes') {

//                var winWid = $(window).width() / 2 - $('.alert_windows').width() / 2;
//                var winWid = $(window).width() / 2 - 1920 / 2;
                //var winWid = 0;

                var winWid = $(window).width() / 2 - $('.alert_windows').width() / 2;
//                var winWid = $(window).width() / 2 - 1920 / 2;

                var winHig = $(window).height() / 2 - $('.alert_windows').height() / 2;
                $('#zhez').css({'width': $(window).width(), 'height': $(window).height()});
                $(".alert_windows").css({"left": winWid, "top": -winHig * 2});	//自上而下
                $(".alert_windows").show();
                $('#zhez').fadeIn(500);
                $(".alert_windows").animate({"left": winWid, "top": winHig}, 500);
                $(".alert_windows #close,#ok").click(function () {
                    $(this).parent().fadeOut(500);
                    $('#zhez').fadeOut(500);
                    $.cookie("isClose", 'yes', {expires: 1});		//一天
                });
            }
        });
    </script>

@endsection
@section("alert")
    <!--首页弹框-->
    <div id="zhez"></div>
    <div class="alert_windows">
        <span id="close"></span>
        <img src="{{asset('home/images/shouTan.png')}}" alt="">
    </div>
@endsection