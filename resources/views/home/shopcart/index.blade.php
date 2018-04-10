@extends("home.layout.layout")
@section("title","购物车")
@section("css")
    @if($shopCartInfo)
        <link rel="stylesheet" href="{{asset('home/css/shopcart/cur.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('home/css/shopcart/curNull.css')}}">
    @endif
@endsection
@section("content")
    <div class="line"></div>
    <!--进度条-->
    <div class="jindu">
        <a href="{{url('/')}}">
            <img src="{{asset('home/images/shopcart/logo.png')}}" alt="">
        </a>
        <p>
            <img src="{{asset('home/images/shopcart/hongyi.png')}}" alt="">
            <img src="{{asset('home/images/shopcart/huier.png')}}" alt="">
            <img src="{{asset('home/images/shopcart/huisan.png')}}" alt="">
            <img src="{{asset('home/images/shopcart/huisi.png')}}" alt="">
        </p>
    </div>
    @if($shopCartInfo)
        <!--选择商品-->
        <dl class="only">
            <dt>
        <span>
            {{--<input type="checkbox" checked disabled="disabled">--}}复选框
        </span>
                <span>商品</span>
                <span>单价(元)</span>
                <span>数量</span>
                <span>小计(元)</span>
                <span>操作</span>
            </dt>

            @foreach($shopCartInfo as $k=>$v)
                <dd>
                    <div class="lBu clear">
                        <label for="{{$v['id']}}">
                            <input class="laj" id="{{$v['id']}}" type="checkbox" name="{{$v['cart']['id']}}">
                        </label>
                        <div class="left">
                            <img src="http://{{$v["goodsImgInfo"]["thumb_url"]}}" alt="">
                            <p class="t" title="{{$v["goods"]["name"]}}">{{$v["goods"]["name"]}}</p>
                            <p class="b">
                                规格:<span>
                      @foreach($v["norms_name"] as $k1=>$v1)
                                        {{$v1["name"]}}
                                    @endforeach

                    </span></p>
                            @if($v['cart']['f_custom_id'] !== 0)
                            <p class="b">定制信息:<span>{{$v['cart']['custom_name']}}</span></p>
                            @endif
                        </div>
                            <div class="right">￥<em>{{number_format($v["single_price"],2,".","")}}</em></div>
                    </div>
                    <div class="mBu">
                        <input type="text" value="{{$v["cart"]["number"]}}">
                        <img class="tjian" max="{{$v["stock"]}}" src="{{asset('home/images/shopcart/tjian.png')}}"
                             alt="">
                        <img class="bjian" min="{{$v['goods']['min_sale']}}"
                             src="{{asset('home/images/shopcart/bjian.png')}}" alt="">
                    </div>
                        <div class="pri">￥<span
                                    class="he">{{number_format($v["single_price"]*$v["cart"]["number"],2,".","")}}</span>
                        </div>
                    <div class="del" name="{{$v['cart']['id']}}">删除</div>
                </dd>
            @endforeach
        </dl>
        <div class="bot" id="bot">
            <div class="clear">
                <label class="tp">
                    <input id="all" type="checkbox"><span>全选</span>
                </label>
                <p class="mp" onclick="delShopCartMany()">删除选中商品</p>
                <div class="zCon">去结算</div>
                <div class="rCon">
                    <p>合计(不含运费) : ￥<span class="lj">0.00</span></p>
                    {{--<p>总计 : ￥<span class="rj">0.00</span>节省 : ￥ <i>0.00</i></p>--}}
                </div>
            </div>
        </div>
    @else
        <!--选择商品-->
        <dl class="om">
            <dt style="border-bottom-width: 0;">
        <span>
            复选框
        </span>
                <span>商品</span>
                <span>单价(元)</span>
                <span>数量</span>
                <span>小计(元)</span>
                <span>操作</span>
            </dt>
            <dd>
                <img src="{{asset('home/images/shopcart/xiao.png')}}" alt="">
                <p>亲，您的购物车里还没有物品哦，快去<a href="{{url('/')}}" style="font-size:18px;color: #980c3f;">逛逛</a>吧!</p>
            </dd>
        </dl>
    @endif
    <div class="delHide">
        <div class="zhaozhao">
            <p class="btiao">删除商品</p>
            <p class="gan">
                <img src="{{asset('home/images/shopcart/gantan.png')}}" alt="">
                <span>您确定要删除该商品吗？</span>
            </p>
            <a class="laL" href="javascript:;">确定</a>
            <a class="noDel" href="javascript:;">取消</a>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{asset('home/js/shopcart/cur.js')}}"></script>
    <script type="text/javascript">
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || documnet.body.clientHeight;
        $('.delHide').css({'width': widthP, 'height': heightP});
        $('.del').unbind('click').click(function () {
            var _this = $(this);
            var id = $(this).attr('name');
            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {
                $('.delHide').fadeOut(300);
                //id="str";
                $.ajax({
                    url: "{{url("shopCart/delShopCart")}}",
                    data: {"id": id},
                    type: "post",
                    success: function (res) {
                        if (res.err == 200) {
                            layer.msg('删除成功');
                            _this.parent().remove();
                            if ($('.only dd').length == 0) {
                                location.reload(true);
                            }
                            var zong = 0;
                            $('.lBu>label>input').each(function (m, n) {
                                if ($(n).prop('checked')) {
                                    zong += parseFloat($(n).parent().parent().parent().find('.he').text());
                                }
                            });
                            $('.lj,.rj').text(zong.toFixed(2));
                        } else {
                            layer.msg(res.msg);
                        }
                    },
                    error: function (res) {
//                        console.log(res);
                    }
                });
            });
        });
        $('.noDel').unbind('click').click(function () {
            $('.delHide').fadeOut(300);
        });
        function delShopCartMany() {
            var name = '';
            $('.lBu>label>input').each(function (k, v) {
                if ($(v).prop('checked')) {
                    name += $(v).attr('name') + ',';
                }
            });
            if (name == '') {
                layer.msg('请选择要删除的商品');
            } else {
                $('.delHide').fadeIn(300);
                $('.laL').unbind('click').click(function () {
                    $('.delHide').fadeOut(300);
                    $.ajax({
                        url: "{{url('shopCart/delShopCartMany')}}",
                        type: "post",
                        data: {id: name},
                        success: function (res) {
                            if (res.err == 200) {
                                layer.msg('删除成功');
                                $('.lBu>label>input').each(function (k, v) {
                                    if ($(v).prop('checked')) {
                                        $(v).parent().parent().parent().remove();
                                    }
                                });
                                if ($('.only dd').length == 0) {
                                    location.reload(true);
                                }
                                var zong = 0;
                                $('.lBu>label>input').each(function (m, n) {
                                    if ($(n).prop('checked')) {
                                        zong += parseFloat($(n).parent().parent().parent().find('.he').text());
                                    }
                                });
                                $('.lj,.rj').text(zong.toFixed(2));
                            } else {
                                layer.msg(res.msg);
                            }
                        },
                        error: function (res) {

                        }
                    });
                })
            }
        }
        $('.zCon').unbind('click').click(function () {
            var str = '';
            $('.lBu>label>input').each(function (m, n) {
                if ($(n).prop('checked')) {
                    str += $(n).attr('name') + ',';
                }
            });
            if (str == '') {
                layer.msg('请您至少选择一种商品');
            } else {
                var data = {};
                $('.only dd').each(function (k, v) {
                    var key = $(v).find('.laj').attr('name'),
                        vall = $(v).find('.mBu').children('input').val();
                    data[key] = vall;
                });
                data = JSON.stringify(data);
                $.ajax({
                    url: "{{url('shopCart/ajaxUpdateCart')}}",
                    type: "post",
                    data: {info: data},
                    success: function (res) {
                        if (res.err == 200) {
                            location.href = "{{url("order/create")}}?id=" + str;
                        }
                    }
                });
            }
        });
        var botOffsetTop = $('#bot').offset().top;
        var winHeight = $(window).height();
        var winWidth = $(window).width();
        var botLeft = (winWidth - 1200 )/2;
        $('#bot>div').css('left',botLeft);
        $(window).on('scroll load',function(){
            if($(window).scrollTop()<=(botOffsetTop-winHeight)){
                $('#bot>div').addClass('sec')
            }else{
                $('#bot>div').removeClass('sec')
            }
        })
    </script>
@endsection