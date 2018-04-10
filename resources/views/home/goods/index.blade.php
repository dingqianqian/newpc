@extends("home.layout.layout")
@section("title","商品详情页")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/goods/shDetail.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<a
                    @if($goodsInfo['goods_type']['parent_id']==1) href="{{url('category/hotel')}}/{{$goodsInfo['goods_type']['id']}}"
                    @elseif($goodsInfo['goods_type']['parent_id']==2)  href="{{url('category/house')}}/{{$goodsInfo['goods_type']['id']}}"
                    @else href="{{url('category/brand')}}/{{$goodsInfo['goods_type']['id']}}" @endif>{{$goodsInfo['goods_type']['name']}}</a>/<span>商品详情</span>
        </p>
    </div>
    <!--放大镜，和筛选规格，购买数量，收藏商品-->
    <div class="fanDetail clear">
        <!--放大镜-->
        <div class="preview">
            <div id="vertical" class="bigImg">
                @foreach($goodsImgInfo as $k=>$v)
                    @if($loop->first)
                        <img src="{{$v['name_url']}}" bigSrc="{{$v['name_url']}}" width="460" height="460" alt=""
                             id="midimg"/>
                    @endif
                @endforeach
                <div style="display:none;" id="winSelector"></div>
            </div>
            <div class="smallImg">
                <div class="scrollbutton smallImgUp disabled"></div>
                <div id="imageMenu">
                    <ul>
                        @foreach($goodsImgInfo as $k=>$v)
                            @if($loop->first)
                                <li id="onlickImg"><img src="{{$v['thumb_url']}}" mid-Src="{{$v['name_url']}}"
                                                        big-Src="{{$v['name_url']}}" width="94"
                                                        height="94" alt=""/></li>
                            @else
                                <li><img src="{{$v['thumb_url']}}" mid-Src="{{$v['name_url']}}"
                                         big-Src="{{$v['name_url']}}" width="94" height="94"
                                         alt=""/></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="scrollbutton smallImgDown" onselectstart="return false;"></div>
            </div>
            <div id="bigView" style="display:none;"><img width="800" height="800" alt="" src=""/></div>
        </div>
        <!--筛选规格，购买数量，加入购物车，预计送达-->
        <div class="fanDright">
            <p class="goodsName">
                {{$goodsInfo['name']}}
            </p>
            @if(is_11121())
                <p class="goodsHui">宜购价 : <span>{{$goodsInfo['show_price']}}</span>元</p>
                <div class="goodsHong clear">
                    <div class="goodsHl">1.11.21冰点价 : <i>{{$goodsInfo['show_sale_price']}}</i>元(活动日仅限速立付支付)</div>
                    <div class="goodsHr" style="display: none;">狂购日单价 : <em></em></div>
                </div>
            @else
                <p class="goodsHui" style="text-decoration: none;">1.11.21冰点价 :
                    <span>{{$goodsInfo['show_sale_price']}}</span>元(活动日仅限速立付支付)</p>
                <div class="goodsHong clear">
                    <div class="goodsHl">宜购价 : <i>{{$goodsInfo['show_price']}}</i>元</div>
                    <div class="goodsHr" style="display: none;">单价 : <em></em></div>
                </div>
            @endif
            @if($goodsInfo['goods_type']['id'] == 216 || $goodsInfo['goods_type']['id'] == 217 )
                <div id="customized" >
                    <span>规格</span>
                    <div class="clear">
                        <ul class="clear">
                            @foreach($normsComboInfo as $k=>$v)
                                <li idff="{{$v["f_norms_id"]}}">{{$v["norms_name"]}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="clear" id="diy">
                        <span>定制信息</span>
                        <select id="mo_ch">
                            <option value="0">请选择定制信息</option>
                            <option value="-1">添加+</option>
                            @foreach($customInfo as $k=>$v)
                            <option value="{{$v['id']}}">{{$v["hotel_name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                 </div>
                @else
                 <div class="container" ng-app="skuApp" ng-cloak>
                    <div class="row">
                        <section ng-controller="skuController" class="m-detail">
                            <div class="m-detail">
                                <div ui-sku split-str="#" init-sku="" sku-data="skuInfo" on-ok="callback($event)">
                                    @foreach($normsGroupInfo as $k=>$v)
                                        <div class="row f-cb">
                                            <div class="l-col">{{$v['name']}}</div>
                                            <div class="r-col">
                                                <ul class="m-sku f-cb">
                                                    @foreach($v["norms"] as $k1=>$v1)
                                                        <li onclick="xuan(this)"><span norms="{{$v1['id']}}"
                                                                                       ng-class="{'js-seleted': keyMap['{{$v1["id"]}}'].selected, 'js-disabled': keyMap['{{$v1["id"]}}'].disabled}"
                                                                                       ng-click="onSelect('{{$v1["id"]}}')">{{$v1["name"]}}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    </div>
                  </div>
                @endif
            <!--数量，加入购物车，立即购买-->
            <div class="numH clear">
                <div class="numHl">
                    <span>购买数量</span>
                    <input type="text" max="99" min="{{$goodsInfo['min_sale']}}" value="{{$goodsInfo['min_sale']}}">
                    <p>
                        <img class="jia" src="{{asset('home/images/goods/img')}}/jia.png" alt="">
                        <img class="jian" src="{{asset('home/images/goods/img')}}/jian.png" alt="">
                    </p>
                </div>
                <div class="numHr">
                    <button class="jGo" value="{{$goodsInfo['goods_type']['id']}}"><i></i>加入购物车</button>
                    <button class="lMai"><i></i>立即购买</button>
                </div>
            </div>
            <!--预计送达时间-->
            <p class="yuji">
                预计 : <i>{{date("Y-m-d",strtotime("+3 days"))}}</i> ~ <em>{{date("Y-m-d",strtotime("+5 days"))}}</em>送达
            </p>
            <p class="peisong">送货服务 : 由宜优速平台发货,并提供售后服务</p>
        </div>
        <!--收藏商品，满意度-->
        <div class="manyi clear">
            <p class="manyiL">满意度 : <span>
                    @if($goodsEvaluateAvg)
                        {{$goodsEvaluateAvg}}
                    @else
                        5.0
                    @endif
                </span>分</p>
            <p class="manyiR" goods="{{$goodsInfo["id"]}}">
                @if($isCollection)
                    <img src="{{asset('home/images/goods/img/shouHong.png')}}" alt="">
                    <span>取消收藏</span>
                @else
                    <img src="{{asset('home/images/goods/img/shouHui.png')}}" alt="">
                    <span>收藏商品</span>
                @endif

            </p>
        </div>
    </div>
    <!--商城热销-->
    <div class="rexiao">
        <div class="reTitle">
            <span>商城热销</span>
        </div>
        <ul>
            @foreach($hotGoods as $k=>$v)
                <li>
                    <a href="{{url('goods/index')}}/{{$v['id']}}">
                        <span>
                            <img src="http://{{$v['image_url']}}" alt="">
                        </span>
                        <h5 class="reHfive">
                            <p>
                                <em>{{$v["name"]}}</em>
                            </p>
                        </h5>
                        @if(is_11121())
                            <p class="reHi">宜购价 : <i>{{$v["show_price"]}}</i>元</p>
                            <p class="reHon">1.11.21冰点价 : <i>{{$v["show_sale_price"]}}</i>元</p>
                        @else
                            <p class="reHi" style="text-decoration: none;">1.11.21冰点价 : <i>{{$v["show_sale_price"]}}</i>元
                            </p>
                            <p class="reHon">宜购价 : <i>{{$v["show_price"]}}</i>元</p>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <!--详情描述，商品评价，售后服务-->
    <ul class="goodsU">
        <li class="sec"><a href="javascript:;">详情描述</a></li>
        <li><a href="javascript:;"><span>商品评价</span></a></li>
        <li><a href="javascript:;">售后服务</a></li>
    </ul>
    <!--内容切换-->
    <div class="goodsNei">
        <div class="sec">
            <img src="{{asset('home/images/goods/img/goodsTitleOne.png')}}" alt="">
            <img src="http://{{$goodsDetailsImgInfo["name_url"]}}" alt="">
        </div>
        <div>
            <img src="{{asset('home/images/goods/img/goodsTitleTwo.png')}}" alt="">
            @if(!$goodsEvaluateInfo)
                {{--暂无优惠券--}}
                <p style="width: 100%;text-align: center;margin: 264px 0 264px 0;">
                    <img src="{{asset('home/images/comment/zzwu.png')}}"
                         style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                    <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">该商品暂无评价~</span>
                </p>
            @else
                <ul>
                    @foreach($goodsEvaluateInfo as $k=>$v)
                        <li class="outL clear">
                            <div class="goodsLiL">
                                @if(file_exists(env("HEADIMG")."/".$v['user']['id'].".jpg"))
                                    <img src="http://www.yiyousu.cn/Public/UserHeadImg/{{$v['user']['id']}}.jpg" alt=""
                                         class="zeng">
                                @else
                                    <img src="{{asset('home/images/vip/tou.jpg')}}" alt="" class="zeng">
                                @endif
                                <div class="goodsTouX">
                                    <p class="goodsTp">{{substr_replace($v["user"]['signin_name'],"****",3,4)}}</p>
                                    <em class="goodsBp">
                                        {{$v['content']}}</em>
                                </div>
                            </div>
                            <div class="goodsLiR">
                                <ul class="inUl clear">
                                    @for($i=0;$i<5;$i++)
                                        @if($i<$v["favor_degree"])
                                            <li class="inLi">
                                                <img src="{{asset('home/images/goods/img/10.png')}}" alt="">
                                            </li>
                                        @else
                                            <li class="inLi">
                                                <img src="{{asset('home/images/goods/img/0.png')}}" alt="">
                                            </li>
                                        @endif
                                    @endfor
                                </ul>
                                <p>日期 : <span>{{date("Y-m-d",$v['create_time'])}}</span></p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div>
            <img src="{{asset('home/images/goods/img')}}/goodsTitleThr.png" alt="">
            <img id="gShou" src="{{asset('home/images/goods/img')}}/goodsShou.png" alt="">
        </div>
    </div>
        <!--定制信息遮罩层-->
<div class="popup-detail">
    <div class="popup-detail-inner">
        <form id="c_modify" action="{{url('custom/addCustom')}}" method="post"  enctype="multipart/form-data">
            <p class="form_p">添加定制信息</p>
            <label>
                <span><i>*</i>名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称:</span>
                <input class="one" type="text" name="hotel_name" placeholder="请输入酒店或饭店名称">
            </label>
            <label>
                <span class="twoSapn"><i>*</i>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址:</span>
                <textarea class="two" name="hotel_address" id="" cols="30" rows="10" placeholder="请输入您的地址" style="resize:none"></textarea>
            </label>
            <label>
                <span><i>*</i>联系热线:</span>
                <input type="text" name="area_name" class="thr" placeholder="区号" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                <b>-</b>
                <input type="text" name="phone_name" class="thrr" placeholder="固话" maxlength="8" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
            </label>
            <label>
                <span><i style="opacity:0">*</i>上传logo:</span>
                <input class="four" readonly="readonly" type="text" placeholder="未选择任何文件">
                <span class="onSpan">浏览...
                    <input type="file" id="up" name="logo">
                </span>
            </label>
            <div class="oDiv">
                <img id="ImgPr" src="" alt="">
            </div>
            {{csrf_field()}}
            <div class="btn">
                <button type="submit">确定</button>
                <em>取消</em>
            </div>
        </form>
        <img src="{{asset("home/images/custom/guanbi.png")}}" alt="">
    </div>
</div>
<!--读取定制信息-->
<div class="read_detail">
    <div class="read_in">
        <h4>定制信息</h4>
        <p>名称:<span class="read_name"></span></p>
        <p>地址:<span class="read_addr"></span></p>
        <p>联系热线:<span class="read_pho"></span></p>
        <p class="logo">logo:<img class="read_img" src=""/></p>
        <div>
            <i>删除</i>
            <em>取消</em>
            <b>确定</b>
        </div>
        <img src="{{asset("home/images/custom/guanbi.png")}}" alt="">
    </div>
</div>
        <!--删除收货地址遮罩层-->
<div class="delHide">
<div class="zhaozhao">
    <p class="btiao">删除定制信息</p>
    <p class="gan">
        <img src="{{asset("home/images/custom/gantanhao.png")}}" alt="">
        <span>您确定要删除该定制信息吗？</span>
    </p>
    <a class="laL" href="javascript:;">确定</a>
    <a class="noDel" href="javascript:;">取消</a>
</div>
</div>
@endsection
@section("js")
    <script type="text/javascript" src="{{asset('home/js/goods/angular.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/goods/angular-sku.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/goods/clamp.min.js')}}"></script>
    <script type="text/javascript" src="{{asset("home/js/custom/uploadView.js")}}"></script>

    <script type="text/javascript">
        //初始化上传图片
        $(function () {
            $("#up").uploadPreview({Img: "ImgPr", Width: 90, Height: 90});
        });
        //放大镜
        $(document).ready(function () {
            // 图片上下滚动
            var count = $("#imageMenu li").length - 3;
            /* 显示 6 个 li标签内容 */
            var interval = $("#imageMenu li:first").outerHeight() + 7;
            var curIndex = 0;
            $('.scrollbutton').unbind('click').click(function () {
                if ($('#imageMenu li').length <= 4) return false;
                if ($(this).hasClass('disabled')) return false;
                if ($(this).hasClass('smallImgUp')) --curIndex;
                else ++curIndex;
                $('.scrollbutton').removeClass('disabled');
                if (curIndex == 0) $('.smallImgUp').addClass('disabled');
                if (curIndex == count - 1) $('.smallImgDown').addClass('disabled');
                $("#imageMenu ul").stop(false, true).animate({"marginTop": -curIndex * interval + "px"}, 600);

            });
            // 解决 ie6 select框 问题
            $.fn.decorateIframe = function (options) {
                if ($.support.msie && $.support.version < 7) {
                    var opts = $.extend({}, $.fn.decorateIframe.defaults, options);
                    $(this).each(function () {
                        var $myThis = $(this);
                        //创建一个IFRAME
                        var divIframe = $("<iframe />");
                        divIframe.attr("id", opts.iframeId);
                        divIframe.css("position", "absolute");
                        divIframe.css("display", "none");
                        divIframe.css("display", "block");
                        divIframe.css("z-index", opts.iframeZIndex);
                        divIframe.css("border");
                        divIframe.css("top", "0");
                        divIframe.css("left", "0");
                        if (opts.width == 0) {
                            divIframe.css("width", $myThis.width() + parseInt($myThis.css("padding")) * 2 + "px");
                        }
                        if (opts.height == 0) {
                            divIframe.css("height", $myThis.height() + parseInt($myThis.css("padding")) * 2 + "px");
                        }
                        divIframe.css("filter", "mask(color=#fff)");
                        $myThis.append(divIframe);
                    });
                }
            };
            $.fn.decorateIframe.defaults = {
                iframeId: "decorateIframe1",
                iframeZIndex: -1,
                width: 0,
                height: 0
            };
            //放大镜视窗
            $("#bigView").decorateIframe();
            //点击到中图
            var midChangeHandler = null;
            $("#imageMenu li").bind("mouseover", function () {
                if ($(this).attr("id") != "onlickImg") {
                    var midImg = $(this).children('img').attr('mid-Src'),
                        bigIm = $(this).children('img').attr('big-Src');
                    midChange(midImg, bigIm);
                    $("#imageMenu li").removeAttr("id");
                    $(this).attr("id", "onlickImg");
                    $(this).css({"border": "1px solid #980c3f"});
                }
            }).bind("mouseout", function () {
                if ($(this).attr("id") == "onlickImg") {
                    $(this).removeAttr("style");
                }
            });
            function midChange(midsrc, bigsrc) {
                $("#midimg").attr("src", midsrc).attr('bigSrc', bigsrc).load(function () {
                    changeViewImg();
                });
            }

            //大视窗看图
            function mouseover(e) {
                if ($("#winSelector").css("display") == "none") {
                    $("#winSelector,#bigView").show();
                }
                $("#winSelector").css(fixedPosition(e));
                e.stopPropagation();
            }

            function mouseOut(e) {
                if ($("#winSelector").css("display") != "none") {
                    $("#winSelector,#bigView").hide();
                }
                e.stopPropagation();
            }

            $("#midimg").mouseover(mouseover); //中图事件
            $("#midimg,#winSelector").mousemove(mouseover).mouseout(mouseOut); //选择器事件

            var $divWidth = $("#winSelector").width(); //选择器宽度
            var $divHeight = $("#winSelector").height(); //选择器高度
            var $imgWidth = $("#midimg").width(); //中图宽度
            var $imgHeight = $("#midimg").height(); //中图高度
            var $viewImgWidth = $viewImgHeight = $height = null; //IE加载后才能得到 大图宽度 大图高度 大图视窗高度
            function changeViewImg() {
                $("#bigView img").attr("src", $("#midimg").attr("bigSrc"));
            }

            changeViewImg();
            $("#bigView").scrollLeft(0).scrollTop(0);
            function fixedPosition(e) {
                if (e == null) {
                    return;
                }
                var $imgLeft = $("#midimg").offset().left; //中图左边距
                var $imgTop = $("#midimg").offset().top; //中图上边距
                X = e.pageX - $imgLeft - $divWidth / 2; //selector顶点坐标 X
                Y = e.pageY - $imgTop - $divHeight / 2; //selector顶点坐标 Y
                X = X < 0 ? 0 : X;
                Y = Y < 0 ? 0 : Y;
                X = X + $divWidth > $imgWidth ? $imgWidth - $divWidth : X;
                Y = Y + $divHeight > $imgHeight ? $imgHeight - $divHeight : Y;
                if ($viewImgWidth == null) {
                    $viewImgWidth = $("#bigView img").outerWidth();
                    $viewImgHeight = $("#bigView img").height();
                    if ($viewImgWidth < 460 || $viewImgHeight < 460) {
                        $viewImgWidth = $viewImgHeight = 800;
                    }
                    $height = $divHeight * $viewImgHeight / $imgHeight;
                    $("#bigView").width($divWidth * $viewImgWidth / $imgWidth);
                    $("#bigView").height($height);
                }
                var scrollX = X * $viewImgWidth / $imgWidth;
                var scrollY = Y * $viewImgHeight / $imgHeight;
                $("#bigView img").css({"left": scrollX * -1, "top": scrollY * -1});
                $("#bigView").css({"top": 0, "left": 580});
                return {left: X, top: Y};
            }
        });
        //筛选规格
        var myapp = angular.module('skuApp', ['ui.angularSku']);
        myapp.controller('skuController', function ($scope) {
            'use strict';
            $scope.type = 'parent';
            $scope.callback = function (count) {
                $scope.count = count;
            };
            $scope.skuInfo = {
                @foreach($normsComboInfo as $k=>$v)
                '{{$v["f_norms_id"][0]}}#{{$v["f_norms_id"][1]}}#{{$v["f_norms_id"][2]}}': {
                    count: 10
                },
                @endforeach
            }
        });
        //私人定制商品详情
        $('#customized li').on('click',function(){
            $('#customized li').each(function(){
                $(this).removeClass('sec')
            })
            $(this).addClass('sec')
            var a = $('.manyiR').attr('goods'),
                    b = $(this).attr('idff');
            $.ajax({
                url: "{{url('normsCombo/info')}}",
                type: "post",
                data: {"id": a, 'norms': b},
                success: function (res) {
                    $('#imageMenu img').each(function (k, v) {
                        $(v).parent().removeAttr('id');
                        console.log($(v).attr('src'));
                        if ($(v).attr('src') == res.thumb_url) {
                            console.log(1);
                            $(v).parent().attr('id', 'onlickImg')
                        }
                    });
                    $('#midimg').attr({'src': res.name_url, 'bigSrc': res.name_url});
                    $("#bigView img").attr("src", $("#midimg").attr("bigSrc"));
                    $('.goodsHr').css('display', 'block').children('em').text(res.piece_price);
                    $('.numHl input').attr('max', res.sale_stock);
                    if (res.flag == 1) {
                        $('.goodsHl i').text(res.small_price);
                        $('.goodsHui span').text(res.price);
                    } else {
                        $('.goodsHl i').text(res.price);
                        $('.goodsHui span').text(res.small_price);
                    }
                }
            });
        })
        //h4一行水平垂直居中显示，两行自适应，溢出省略号
        $('.reHfive em').each(function (j, l) {
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
        //点击切换
        $('.goodsU>li').click(function () {
            $('.goodsU>li').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $('.goodsNei>div').each(function (m, n) {
                $(n).removeClass('sec');
            });
            $(this).addClass('sec');
            var leng = $(this).prevAll().length;
            $('.goodsNei>div').eq(leng).addClass('sec');
            if (leng == 1) {
                //商品评价，溢出省略号
                $('.goodsBp').each(function (e, t) {
                    $clamp($(t)[0], {clamp: 2});
                });
            }
        });
        //调整购买数量
        $('.jia').click(function () {
            var jVal = parseFloat($('.numHl>input').val()),
                maxPri = parseFloat($('.numHl>input').attr('max'));
            ++jVal;
            if (jVal > maxPri) {
                jVal = maxPri;
            }
            $('.numHl>input').val(jVal);
        });
        $('.jian').click(function () {
            var jiVal = parseFloat($('.numHl>input').val()),
                minPri = parseFloat($('.numHl>input').attr('min'));
            --jiVal;
            if (jiVal < minPri) {
                jiVal = minPri;
            }
            $('.numHl>input').val(jiVal);
        });
        $('.numHl>input').keyup(function () {
            var that = $(this);
            if(dlTimer){
                clearTimeout(dlTimer)
            }
            var dlTimer = setTimeout(time,700)
            function time(){
                var jVal = parseFloat(that.val()),
                        maxPri = parseFloat(that.attr('max')),
                        minPri = parseFloat(that.attr('min'));
                if (jVal > maxPri) {
                    jVal = maxPri;
                }
                if (jVal < minPri) {
                    jVal = minPri;
                }
                if (isNaN(jVal)) {
                    jVal = minPri;
                }
                that.val(jVal);
            }
        });
        //收藏商品
        $('.manyiR').click(function () {
            var _this = $(this);
            @if(!session('userInfo'))
                location.href = "{{url('login')}}";
            return false;
            @endif
                id = $(".manyiR").attr("goods");
            $.ajax({
                url: "{{url('goods/collect')}}",
                type: "post",
                data: {"id": id},
                success: function (res) {
                    if (_this.children('img').attr('src') == '{{asset('home/images/goods/img')}}/shouHui.png') {
                        _this.children('img').attr('src', '{{asset('home/images/goods/img')}}/shouHong.png');
                        _this.children('span').text('取消收藏').css('color', '#980c3f');
                        layer.msg('收藏商品成功');
                    } else {
                        _this.children('img').attr('src', '{{asset('home/images/goods/img')}}/shouHui.png');
                        _this.children('span').text('收藏商品').css('color', '#333');
                        layer.msg('取消收藏成功');
                    }
                },
                error: function (res) {

                }
            });
        });
        //点击筛选规格
        var ary2 = [];
        xuan = function (c) {
            $('.r-col span').each(function (k, v) {
                //先删除再添加，防止重复点击出现，同样数据
                if ($(v).hasClass('js-seleted')) {
                    $(ary2).each(function (index, item) {
                        if (item == $(v).attr('norms')) {
                            ary2.splice(index, 1);
                        }
                    });
                    if ($(v).attr('norms') !== 'undefined') {
                        ary2.push($(v).attr('norms'));
                    }
                } else {
                    $(ary2).each(function (index, item) {
                        if (item == $(v).attr('norms')) {
                            ary2.splice(index, 1);
                        }
                    });
                }
            });
            if (ary2.length == 3) {
                var a = $('.manyiR').attr('goods'),
                    b = ary2[0] + ',' + ary2[1] + ',' + ary2[2];
                $.ajax({
                    url: "{{url('normsCombo/info')}}",
                    type: "post",
                    data: {"id": a, 'norms': b},
                    success: function (res) {
                        $('#imageMenu img').each(function (k, v) {
                            $(v).parent().removeAttr('id');
                            if ($(v).attr('src') == res.thumb_url) {
                                $(v).parent().attr('id', 'onlickImg')
                            }
                        });
                        $('#midimg').attr({'src': res.name_url, 'bigSrc': res.name_url});
                        $("#bigView img").attr("src", $("#midimg").attr("bigSrc"));
                        $('.goodsHr').css('display', 'block').children('em').text(res.piece_price);
                        $('.numHl input').attr('max', res.sale_stock);
                        if (res.flag == 1) {
                            $('.goodsHl i').text(res.small_price);
                            $('.goodsHui span').text(res.price);
                        } else {
                            $('.goodsHl i').text(res.price);
                            $('.goodsHui span').text(res.small_price);
                        }
                    }
                });
            }
        };
        //选择定制信息
        $('#mo_ch').on('change',function(){
            var that = $(this)
            if($(this).val() == -1){
                $('.popup-detail').fadeIn()
            }else if($(this).val()>0){
                var id = $('#mo_ch').val()
                $.ajax({
                    url:"{{url("custom/chooseCustom")}}",
                    type:'post',
                    data:{id:id},
                    success:function(res){
                        if(res.err == 200){
                            var img_url = res.msg.img_info;
                            if(!img_url){
                                img_url = "{{asset('home/images/goods/noinfo.png')}}"
                            }
                            $('.read_name').text(res.msg.hotel_name)
                            $('.read_addr').text(res.msg.hotel_address)
                            $('.read_pho').text(res.msg.hotel_phone)
                            $('.read_img').attr('src',img_url)
                            $('.read_in i').attr('idd',that.val())
                            $('.read_detail').fadeIn()
                        }
                    }
                })
            }
        })
        //显示定制信息的取消
        $('.read_in em,.read_in>img').on('click',function(){
            $('.read_detail').fadeOut().find('i').removeAttr('idd')
            $('#mo_ch').val('0')
        })
        //显示定制信息确定
        $('.read_in b').on('click',function(){
            $('.read_detail').fadeOut()
        })
        //点击确定提交
        $('.btn>button').off('click').on('click',function () {
            var flag = true
            if($('.one').val()==='') {
                flag = false
                layer.msg('请填写酒店或饭店名称')
                return false
            }
            if($('.two').val()===''){
                flag = false
                layer.msg('请输入您的地址')
                return false
            }
            if(($('.thr').val()+$('.thrr').val()).length !== 11){
                flag = false
                layer.msg('请输入正确的联系热线')
                return false
            }
            if(flag){
                return true
            }
        })
        //关闭定制信息遮罩层
        $('.popup-detail-inner>img,.btn em').off('click').on('click', function () {
            $('.popup-detail').fadeOut('normal',function(){
                $('.one').val('')
                $('.two').val('')
                $('.thr').val('')
                $('.four').val('')
                $('#ImgPr').attr('src','')
                $('#mo_ch').val('0')
            })
        })
        //定制信息点击删除
        $('.read_in i').on('click',function(){
            $('.delHide').fadeIn()
        })
        //定制信息删除取消
        $('.noDel').on('click',function(){
            $('.delHide').fadeOut()
        })
        //定制信息确定
        $('.laL').on('click',function(){
            var id = $('.read_in i').attr('idd');
            $.ajax({
                url:"{{url("custom/delCustom")}}",
                type:'post',
                data:{id:id},
                success:function(res){
                    if(res.err == 200){
                        location.reload(true)
                    }
                }
            })
        })
        //加入购物车
        $('.jGo').click(function () {
            @if(!session('userInfo'))
                location.href = "{{url('login')}}";
            return false;
            @endif
            @if($goodsInfo['goods_type']['id'] == 216 || $goodsInfo['goods_type']['id'] == 217)
                var id = $('.manyiR').attr('goods'),
                        strt = '',
                        numt = $('.numHl>input').val(),
                    info_id = $('#mo_ch').val();
            $('#customized li').each(function(){
                    if($(this).hasClass('sec')){
                        strt = $(this).attr('idff')
                    }
                })
            if(info_id == '0' || strt == '' ||info_id=='-1'){
                    layer.msg('请完善规格或定制信息')
                    return
                }
            $.ajax({
                    url: "{{url('shopCart/create')}}",
                    type: "post",
                    data: {"f_custom_id":info_id,"number": numt, "f_goods_id": id, "f_norms_combo_id": strt, "is_show": 0},
                    success: function (res) {
                        if (res.err == '200') {
                            layer.msg(res.msg);
                        } else {
                            layer.msg(res.msg);
                        }
                    }
                });

            @else
                if (ary2.length == 3) {
                    var a = $('.manyiR').attr('goods'),
                            b = ary2[0] + ',' + ary2[1] + ',' + ary2[2],
                            num = $('.numHl>input').val();
                    $.ajax({
                        url: "{{url('shopCart/create')}}",
                        type: "post",
                        data: {"number": num, "f_goods_id": a, "f_norms_combo_id": b, "is_show": 0},
                        success: function (res) {
                            if (res.err == 200) {
                                layer.msg(res.msg);
                            } else {
                                layer.msg(res.msg);
                            }
                        }
                    });
                } else {
                    layer.msg('请选择商品规格');
              }
            @endif

        });
        //立即购买
        $('.lMai').click(function () {
            @if(!session('userInfo'))
                location.href = "{{url('login')}}";
            return false;
            @endif
            @if($goodsInfo['goods_type']['id'] == 216 || $goodsInfo['goods_type']['id'] == 217)
                var id = $('.manyiR').attr('goods'),
                        strt = '',
                        numt = $('.numHl>input').val(),
                        info_id = $('#mo_ch').val();
                $('#customized li').each(function(){
                    if($(this).hasClass('sec')){
                        strt = $(this).attr('idff')
                    }
                })
                if(info_id == '0' || strt == '' ||info_id=='-1'){
                    layer.msg('请完善规格或定制信息')
                    return
                }
                $.ajax({
                    url: "{{url('shopCart/create')}}",
                    type: "post",
                    data: {"f_custom_id":info_id,"number": numt, "f_goods_id": id, "f_norms_combo_id": strt, "is_show": 1},
                    success: function (res) {
                        if (res.err == 200) {
                            location.href = "{{url('order/create')}}?id=" + res.id + ",";
                        } else {
                            layer.msg(res.msg);
                        }
                    }
                });

            @else
                if (ary2.length == 3) {
                    var a = $('.manyiR').attr('goods'),
                            b = ary2[0] + ',' + ary2[1] + ',' + ary2[2],
                            num = $('.numHl>input').val();
                    $.ajax({
                        url: "{{url('shopCart/create')}}",
                        type: "post",
                        data: {"number": num, "f_goods_id": a, "f_norms_combo_id": b, "is_show": 1},
                        success: function (res) {
                            if (res.err == 200) {
                                location.href = "{{url('order/create')}}?id=" + res.id + ",";
                            } else {
                                layer.msg(res.msg);
                            }
                        }
                    });
                } else {
                    layer.msg('请选择商品规格');
                }
            @endif
        })
    </script>
@endsection