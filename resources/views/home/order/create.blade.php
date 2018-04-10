@extends("home.layout.layout")
@section("title","确认订单")
@section("css")
    <link href="http://www.jq22.com/jquery/bootstrap-3.3.4.css" rel="stylesheet">
    <!--[if IE]>
    <script src="http://libs.baidu.com/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('home/css/order/address.css')}}">
@endsection

@section("content")
    <div class="cont">
        <div class="line"></div>
        <!--进度条-->
        <div class="jindu">
            <a href="{{url('/')}}">
                <img src="{{asset('home/images/shopcart/logo.png')}}" alt="">
            </a>
            <p>
                <img src="{{asset('home/images/shopcart/huiyi.png')}}" alt="">
                <img src="{{asset('home/images/shopcart/honger.png')}}" alt="">
                <img src="{{asset('home/images/shopcart/huisan.png')}}" alt="">
                <img src="{{asset('home/images/shopcart/huisi.png')}}" alt="">
            </p>
        </div>
    @if($takeOverInfo)
        <!--显示默认三个地址-->
            <ul id="content">
                @foreach($takeOverInfo as $k=>$v)
                    @if($loop->iteration<=3)
                        <li class="oldA" id="{{$v['id']}}" f_area_id="{{$v['f_area_id']}}">
                            <img class="li" src="{{asset('home/images/shopcart/cdingwei.png')}}" alt="">
                            <i>寄送至</i>
                            <label class="oldA_one">
                                @if($v["is_default"]==1&&$v['f_area_id']==session("f_area_info")['id'])
                                    <input type="radio" name="dizhi" checked>
                                @elseif($v['id']==$takeOverID)
                                    <input type="radio" name="dizhi" checked>
                                    @else
                                    <input type="radio" name="dizhi" id="ddzhi">
                                @endif
                                <span class="det"
                                      title="{{$v["province"]}} {{$v["city"]}} {{$v["town"]}} {{$v["ex"]}}">{{city_province($v["province"],$v["city"]).$v["town"].$v["ex"]}}</span>
                            </label>
                            <span class="shou">收货人 : <em>{{$v['name']}}</em></span>
                            <span>电话 : <i class="telp">{{$v["tel_no"]}}</i></span>
                            <div class="oldAR">
                                @if($v["is_default"]==1)
                                    <span>默认地址</span>
                                @endif
                                <span class="xiu" zds="{{$v['company_name']?$v['company_name']:""}}">修改</span>
                                <img src="{{asset('home/images/shopcart/chahao.png')}}" alt="">
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        @if(count($takeOverInfo)>3)
            <!--显示已有地址-->
                <ul id="contentt">
                    @foreach($takeOverInfo as $k=>$v)
                        @if($loop->iteration>3)
                            <li class="oldA" id="{{$v['id']}}" f_area_id="{{$v['f_area_id']}}">
                                <img class="li" src="{{asset('home/images/shopcart/cdingwei.png')}}" alt="">
                                <i>寄送至</i>
                                <label class="oldA_two">
                                    <input type="radio" name="dizhi">
                                    <span class="det"
                                          title="{{$v["province"]}} {{$v["city"]}} {{$v["town"]}} {{$v["ex"]}}">{{city_province($v["province"],$v["city"]).$v["town"].$v["ex"]}}</span>
                                </label>
                                <span class="shou">收货人 : <em>{{$v['name']}}</em></span>
                                <span>电话 : <i class="telp">{{$v["tel_no"]}}</i></span>
                                <div class="oldAR">
                                    @if($v["is_default"]==1)
                                        <span>默认地址</span>
                                    @endif
                                    <span class="xiu" zds="{{$v['company_name']?$v['company_name']:""}}">修改</span>
                                    <img src="{{asset('home/images/shopcart/chahao.png')}}" alt="">
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <!--显示更多收货地址-->
                <div id="dianwo">
                    <span>显示更多收货地址</span>
                    <img src="{{asset('home/images/shopcart/more.png')}}" alt="">
                </div>
        @endif
        <!--添加新的地址-->
            <p class="xin">收货人信息<span id="newA">【使用新地址】</span></p>
    @else
        <!--提示没有地址-->
            <div class="noAdd">您还没有收货地址，马上去<a class="shiyong" href="javascript:;"
                                              style="font-size: 18px;color: #980c3f;">添加</a>吧！
            </div>
    @endif
    <!--商品列表-->
        <dl class="zhi">
            <dt>
                <span>商品</span>
                <span>单价(元)</span>
                <span>数量</span>
                <span>小计(元)</span>
            </dt>
            @foreach($shopCartInfo as $k=>$v)
                <dd id="{{$v['cart']['id']}}">
                    <div class="ld">
                        <img src="http://{{$v["goodsImgInfo"]["thumb_url"]}}" alt="">
                        <p>{{$v["goods"]["name"]}}</p>
                        <div style="margin-bottom:3px;font-size: 12px;">规格 : <span>
                        @foreach($v["norms_name"] as $k1=>$v1)
                                    {{$v1["name"]}}
                                @endforeach
                    </span></div>
                        @if($v["cart"]['f_custom_id']!== 0 )
                            <div style="font-size: 12px;">定制信息 : <span>{{$v['cart']['custom_name']}}</span></div>
                       @endif
                    </div>
                    @if(is_11121())
                        <div class="dan">￥<i>{{number_format($v["sale_single_price"],2,".","")}}</i></div>
                        <div class="num">X<i>{{$v["cart"]["number"]}}</i></div>
                        <div class="zo">￥<i>{{number_format($v["sale_single_price"]*$v["cart"]["number"],2,".","")}}</i>
                        </div>
                    @else
                        <div class="dan">￥<i>{{number_format($v["single_price"],2,".","")}}</i></div>
                        <div class="num">X<i>{{$v["cart"]["number"]}}</i></div>
                        <div class="zo">￥<i>{{number_format($v["single_price"]*$v["cart"]["number"],2,".","")}}</i>
                        </div>
                    @endif

                </dd>
            @endforeach
        </dl>
        <!--订单备注-->
        <div class="beizhu">
            <h4>添加订单备注</h4>
            <input type="text" placeholder="您可以在此处填写对商品的详细需求" maxlength="45">
            <span>提示 : 请勿填写有关支付、收货、发票方面的信息</span>
        </div>
        <!--发票管理-->
        <div class="fapo">
            <h4>发票信息</h4>
            <p>如果您想要获取商品发票，请到个人中心内的发票管理中自行索取</p>
        </div>
        <!--尾部价格总计-->
        <div class="priZ clear">
            <div class="priZl">
                <p id="shiyong">
                    <img class="ccc" src="{{asset('home/images/shopcart/hui.png')}}" alt="">
                    <img class="red" src="{{asset('home/images/shopcart/hong.png')}}" alt="">
                    <span>使用优惠卷(每单只能使用一张优惠券且1.11.21活动当天不可使用优惠券)</span>
                </p>
            @if($couponInfo&&!is_11121())
                <!--有可用的优惠卷-->
                    <ul class="clear juan">
                        @foreach($couponInfo as $k=>$v)
                            <li id="{{$v['id']}}" price="{{$v['use_value']}}">
                                <img src="{{asset("home/images/coupon/{$v['coupon_type']['id']}.png")}}" alt="">
                                <span></span>
                            </li>
                        @endforeach
                    </ul>
            @else
                <!--没有可用的优惠卷-->
                    <div class="nonn">
                        <p>暂无可用优惠卷</p>
                        <p>(关于使用优惠卷，请到个人中心内的<a href="{{url('coupon/index')}}" style="color:#980c3f;">优惠卷管理</a>中查看)</p>
                    </div>
                @endif
            </div>
            <div class="priZr">
                <div class="priZrT">
                    <p>
                        <span>商品总金额:</span>
                        <span>￥<em id="zongJ">{{number_format($count/100,2,".","")}}</em></span>
                    </p>
                    <p>
                        <span>运费:</span>
                        <span>￥<em id="yunJ">0.00</em></span>
                    </p>
                    <p>
                        <span>使用优惠卷:</span>
                        <span>-￥<em id="youJ">0.00</em></span>
                    </p>
                    <!--<p>-->
                    <!--<span>发票</span>-->
                    <!--<span>普通发票</span>-->
                    <!--</p>-->
                    <p style="margin: 10px 0 24px 0">
                        <span>是否1.11.21活动</span>
                        @if(is_11121())
                            <span>是</span>
                        @else
                            <span>否</span>
                        @endif
                    </p>
                </div>
                <div class="priZrB">
                    <div class="priZrBt clear">
                        <span class="zjie">结算金额:</span>
                        <span class="jie">￥<i>{{number_format($count/100,2,".","")}}</i></span>
                    </div>
                    <p>可获得积分 : <span>{{floor($count/10000)}}</span></p>
                </div>
            </div>
        </div>
        <!--应付金额-->
        <div class="wei">
            <input type="button" class="tij" value="提交订单">
            <p class="tijj">应付金额 : <span>￥<em>{{number_format($count/100,2,".","")}}</em></span></p>
        </div>
    </div>
    <div class="quan">
        <div class="zhezhao">
            <form class="zheCon" id="addr">
                <p class="add">添加地址</p>
                <div class="sRen">
                    <label for="ren"><i>*</i>收货人 : </label>
                    <input id="ren" name="name" type="text" placeholder="请输入收货人姓名">
                </div>
                <div class="sRenn">
                    <label><i>*</i>收货地址 : </label>
                    <div data-toggle="distpicker" id="cacon" class="clear">
                        <div class="form-group">
                            <label class="sr-only" for="province2">Province</label>
                            <select name="province" class="form-control" id="province2"
                                    data-province="---- 选择省 ----"></select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="city2">City</label>
                            <select name="city" class="form-control" id="city2" data-city="---- 选择市 ----"></select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="district2">District</label>
                            <select class="form-control" name="town" id="district2"
                                    data-district="---- 选择区 ----"></select>
                        </div>
                    </div>
                </div>
                <input id="tail" name="ex" type="text" placeholder="请输入您的详细地址">
                <label for="danAddr"><i>*</i>单位名称 : </label>
                <input id="danAddr" name="company_name" type="text" placeholder="请输入您的单位名称">
                <br/>
                <label for="tel"><i>*</i>手机号码 : </label>
                <input onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="11"
                       onafterpaste="this.value=this.value.replace(/\D/g,'')" id="tel" name="tel_no" type="text"
                       placeholder="请输入您的电话号">
            </form>
            <a href="javascript:;" class="yq">确定</a>
            <a href="javascript:;" class="noadd">取消</a>
            <img src="{{asset('home/images/shopcart/guanbi.png')}}" alt="">
        </div>
    </div>
    <div class="del">
        <div class="zhaozhao">
            <p class="btiao">删除地址</p>
            <p class="gan">
                <img src="{{asset('home/images/shopcart/gantan.png')}}" alt="">
                <span>您确定要删除该地址吗？</span>
            </p>
            <a class="laL" href="javascript:;">确定</a>
            <a class="noDel" href="javascript:;">取消</a>
        </div>
    </div>
    {{--10/27修改地址弹框--}}
    <div class="alert_area">
        <div class="alert_area_up">
            <p>您在<span id="alert_begin">北京</span>选购的商品如配送至<span id="alert_end">上海</span>，商品可能发生变化</p>
            <i id="alert_i">不修改</i>
            <em id="alert_em">确定修改</em>
        </div>
    </div>
@endsection
@section("js")
    <script src="http://www.jq22.com/jquery/bootstrap-3.3.4.js"></script>
    <script type="text/javascript" src="{{asset('home/js/order/distpicker.data.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/order/distpicker.js')}}"></script>
    {{--<script type="text/javascript" src="{{asset('home/js/order/main.js')}}"></script>--}}
    <script type="text/javascript">
        $('#cacon').distpicker({
            autoSelect: false
        });
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || documnet.body.clientHeight;
        $('.quan,.del,.alert_area').css({'width': widthP, 'height': heightP});
        //收货地址的遮罩层消失或者弹出
        $('.xiu').click(function () {
            $('.add').text('修改地址');
            var dzhi = $(this).parent().parent().find('.det').attr('title').split(' '),
                nam = $(this).parent().parent().find('.shou>em').text(),
                tel = $(this).parent().parent().find('.telp').text();
            var par = $(this).parent().parent().attr('id');
            $('#ren').val(nam);
            $('#tel').val(tel);
            $('#danAddr').val($(this).attr('zds'));
            $("#province2").val(dzhi[0]);
            $("#province2").trigger("change");
            $("#city2").val(dzhi[1]);
            $("#city2").trigger("change");
            $("#district2").val(dzhi[2]);
            $('#tail').val(dzhi[3]);
            $('.yq').attr('myId', par);
            $('.quan').fadeIn(300);
        });
        $('#newA,.shiyong').click(function () {
            $('.add').text('添加地址');
            $('.quan').fadeIn(300);
        });
        $('.zhezhao .noadd,.zhezhao>img').click(function () {
            $('.yq').removeAttr('myId');
            $('.quan').fadeOut(300, function () {
                $('#ren').val('');
                $('#tel').val('');
                $('#danAddr').val('');
                $('#tail').val('');
                $("#province2").val('');
                $("#province2").trigger("change");
                $("#city2").val('');
                $("#city2").trigger("change");
                $("#district2").val('');
            });
        });
        //删除地址的遮罩层消失或者弹出
        /*$('.oldA .oldAR img').click(function () {
         $('.del').fadeIn(300);
         });*/
        $('.noDel').unbind('click').click(function () {
            $('.del').fadeOut(300);
        });
        //点击是否出现优惠卷
        $('#shiyong').click(function () {
            //切换是否使用优惠券
            if ($('.ccc').css('display') == 'inline-block') {
                $('.ccc').css('display', 'none');
                $('.red').css('display', 'inline-block');
                $('.juan').fadeIn(300);
                $('.nonn').fadeIn(300);
                $('.priZ .priZr').removeClass('hui').addClass('chang');
            } else {
                $('.ccc').css('display', 'inline-block');
                $('.red').css('display', 'none');
                $('.juan').fadeOut(300);
                $('.nonn').fadeOut(300);
                $('.priZ .priZr').removeClass('chang').addClass('hui');
            }
        });
        //显示更多的收货地址
        $('#dianwo').click(function () {
            $(this).children('img').toggleClass('huojian');
            $('#contentt').slideToggle();
            if ($(this).children('img').hasClass('huojian')) {
                $(this).children('span').text('收起收货地址');
            } else {
                $(this).children('span').text('显示更多收货地址');
            }
        });
        //添加备注
        $('.beizhu input').focus(function () {
            $(this).css('borderColor', '#b35174');
        });
        $('.beizhu input').blur(function () {
            $(this).css('borderColor', '#ccc');
        });
        //单个删除收货地址
        $('.oldAR>img').unbind('click').click(function () {
            $('.del').fadeIn(300);
            var oId = $(this).parent().parent().attr('id');
            $('.laL').unbind('click').click(function () {
                $('.del').fadeOut(300);
                $.ajax({
                    type: 'post',
                    url: '{{url("takeOver/delTakeOver")}}',
                    data: {id: oId},
                    success: function (res) {
                        if (res.err == 200) {
                            //_this.parent().parent().remove();
                            location.reload(true);
                        }
                    }
                })
            })
        });
        //添加收货地址和修改收货地址
        $(".yq").click(function () {
            var _that = $(this);
            var flag = true;
            var obj = {},
                a = $('#addr').serialize();
            var c = a.split('&');
            $(c).each(function (item, index) {
                var b = index.split('=');
                obj[b[0]] = b[1];
            });
            if (flag) {
                if (obj['name'] == '') {
                    layer.msg('请您填写收货人姓名');
                    flag = false;
                }
            }
            if (flag) {
                if (obj['name'] != '' && $('#ren').val().length > 25) {
                    layer.msg('收货人姓名不能大于25位');
                    flag = false;
                }
            }
            if (flag) {
                if (obj['province'] == '' || obj['city'] == '' || obj['town'] == '') {
                    layer.msg('请选择收货地址');
                    flag = false;
                }
            }
            if (flag) {
                if (obj['ex'] == '') {
                    layer.msg('您需要填写详细的收货地址，可在下方文本框内填写');
                    flag = false;
                }
            }
            if (flag) {
                if (obj['tel_no'] == '') {
                    layer.msg('请您填写收货人手机号码');
                    flag = false;
                }
            }
            if (flag) {
                if (obj['tel_no'] != '' && obj['tel_no'].length != 11) {
                    layer.msg('请您输入正确的手机号码');
                    flag = false;
                }
            }
            if (flag) {
                if (obj['company_name'] == '') {
                    layer.msg('请您输入单位名称');
                    flag = false;
                }
            }
            if (flag) {
                if (!/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17[0-9])|(18[0-9]))\d{8}$/.test(obj['tel_no'])) {
                    layer.msg('请您输入正确的手机号码');
                    flag = false;
                }
            }
            if (flag) {
                if (typeof (_that.attr('myId')) == 'string') {
                    $.ajax({
                        url: "{{url('takeOver/updateTakeOver')}}/" + _that.attr('myId'),
                        type: 'post',
                        data: a,
                        success: function (res) {
                            if (res.err = 200) {
                                layer.msg('修改地址成功');
                                location.reload(true);
                            } else {
                                layer.msg(res.msg);
                            }
                        },
                        error: function (res) {
                            console.log(res);
                        }
                    });
                } else if (typeof (_that.attr('myId')) == 'undefined') {
                    $.ajax({
                        url: "{{url('takeOver/addTakeOver')}}",
                        type: 'post',
                        data: a,
                        success: function (res) {
                            if (res.err == 200) {
                                //添加成功
                                layer.msg('添加地址成功');
                                location.reload(true);
                            } else {
                                layer.msg(res.msg);
                            }
                        },
                        error: function (res) {
                            console.log(res);
                        }
                    });
                }
            }
        });
        //选择优惠券
        $('.juan li').click(function () {
            $(this).toggleClass('sec').siblings('li').removeClass('sec');
            if ($(this).hasClass('sec')) {
                var zongP = parseFloat($('#zongJ').text()),
                    youP = parseFloat($(this).attr('price')).toFixed(2),
                    zuiP = (zongP - youP).toFixed(2);
                $('#youJ').text(youP);
                $('.jie i,.tijj em').text(zuiP);
            } else {
                $('#youJ').text((0.0).toFixed(2));
                $('.jie>i,.tijj em').text($('#zongJ').text())
            }
        });
        //提交订单
        $('.tij').click(function () {
            $(this).attr('disabled', true);
            var dId = null,
                str = '',
                beizhu = $('.beizhu>input').val(),
                youHui = null;
            $('input[name="dizhi"]').each(function (k, v) {
                if ($(v).prop('checked')) {
                    dId = $(v).parent().parent().attr('id');
                }
            });
            $('.zhi>dd').each(function (k, v) {
                str += $(v).attr('id') + ',';
            });
            $('.juan>li').each(function (m, n) {
                if ($(n).hasClass('sec')) {
                    youHui = $(n).attr('id');
                }
            });
            if (dId == null) {
                layer.msg('请选择收货地址');
                $(this).attr('disabled', false);
            } else {
                $.ajax({
                    type: 'post',
                    url: '{{url("order/add")}}',
                    data: {addrId: dId, cartId: str, explain: beizhu, couponId: youHui},
                    success: function (res) {
                        if (res.err == 200) {
                            location.href = "{{url('order/pay/')}}/" + res.no;
                        } else {
                            layer.msg(res.msg);
                        }
                    }
                })
            }
        })
        //选择收货地址，获取地区id和地址id，然后刷新页面
        $('input[name="dizhi"]').click(function () {
            var addressId = $(this).parent().parent().attr('id');
            var areaId = $(this).parent().parent().attr('f_area_id');
            $('#alert_begin').text($('#wspan').text());
            var alert_city = $(this).parent().children('span').attr('title').split(' ')[1];
            $('#alert_end').text(alert_city);
            if(areaId=="{{$areaID}}")
            {
                return;
            }
            $('.alert_area').fadeIn();
            $('#alert_i').unbind('click').click(function () {
                $('.alert_area').fadeOut();
            });
            $('#alert_em').unbind('click').click(function () {
                //console.log(areaId);
                location.href="{{url("order/create")}}/"+areaId+"/"+addressId+"/?id={{$id}}";
            })
        })
    </script>
@endsection