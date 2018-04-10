@extends("home.layout.layout")
@section("title","发票管理")
@section("css")
    <link href="http://www.jq22.com/jquery/bootstrap-3.3.4.css" rel="stylesheet">
    <!--[if IE]>
    <script src="http://libs.baidu.com/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('home/css/invoice/puFaOne.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>发票管理</span></p>
    </div>
    <div class="oStep clear">
        <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <!--右侧内容-->
        <div class="tStepCont" ng-controller="parentJump">
            <ul>
                <li onclick="location.href='{{url('invoice/index')}}'"><a href="javascript:;">普通发票</a></li>
                <li><a href="javascript:;">增值税发票</a></li>
                <li><a href="javascript:;">增票资质信息</a></li>
            </ul>
            <div class="faCont">
                <div>
                    <div class="dXieS">
                        <p>
                            <span>发票类型 : <i></i>普通发票</span>
                        </p>
                        <p>
                            <span>发票内容 : <i></i>明细</span>
                        </p>
                    </div>
                    <div class="taiT">
                        <div class="taiTtop clear">
                            <p class="tl">发票抬头 : </p>
                            <p class="tr scl">个人</p>
                            <form>
                                <ul class="clear">
                                    @foreach($invoiceTitleInfo as $k=>$v)
                                        <li id="{{$v['id']}}">
                                            <span>{{$v['name']}}</span>
                                            <input type="text" placeholder="请填写发票抬头">
                                            <em>删除</em>
                                            <i>编辑</i>
                                        </li>
                                    @endforeach
                                </ul>
                            </form>
                            <div class="zeng">新增单位抬头</div>
                            <div class="shibiehao">
                                <span>纳税人识别号 : </span>
                                <input type="text">
                            </div>
                        </div>
                    @if($takeOverInfo)
                        <!--有收货地址-->
                            <div class="taiTbot" style="height: auto;line-height: normal;">
                                <p>收货地址 : </p>
                                <div class="adrList">
                                    @foreach($takeOverInfo as $k=>$v)
                                        @if($loop->index==0)
                                            <p ids="{{$v['id']}}">
                                                <i></i>
                                                <span>寄送至</span>
                                                <label>
                                                    <input type="radio" name="dlzhi">
                                                    <span tit="{{$v['province']}} {{$v['city']}} {{$v['town']}} {{$v['ex']}}">{{$v['province']}}{{$v['city']}}{{$v['town']}}{{$v['ex']}}</span>
                                                </label>
                                                <span class="dshouhuo">收货人 : <em>{{$v['name']}}</em></span>
                                                <span class="dTho">电话 : <em>{{$v['tel_no']}}</em></span>
                                                <a href="javascript:;" id="{{$v['id']}}"
                                                   zds="{{$v['company_name']?$v['company_name']:""}}">修改</a>
                                                <em></em>
                                            </p>
                                        @endif
                                    @endforeach
                                    <ul>
                                        @foreach($takeOverInfo as $k=>$v)
                                            @if($loop->index!=0)
                                                <li ids="{{$v['id']}}">
                                                    <i></i>
                                                    <span>寄送至</span>
                                                    <label>
                                                        <input type="radio" name="dlzhi">
                                                        <span tit="{{$v['province']}} {{$v['city']}} {{$v['town']}} {{$v['ex']}}">{{$v['province']}}{{$v['city']}}{{$v['town']}}{{$v['ex']}}</span>
                                                    </label>
                                                    <span class="dshouhuo">收货人 : <em>{{$v['name']}}</em></span>
                                                    <span class="dTho">电话 : <em>{{$v['tel_no']}}</em></span>
                                                    <a href="javascript:;" id="{{$v['id']}}"
                                                       zds="{{$v['company_name']?$v['company_name']:""}}">修改</a>
                                                    <em></em>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @if(count($takeOverInfo)>1)
                                        <div class="dGduo">
                                            <span>显示更多收货地址</span>
                                            <img src="{{asset('home/images/invoice/dG.png')}}" alt="">
                                        </div>
                                    @endif
                                    <div class="newAdr">收货人信息<span>【使用新地址】</span></div>
                                </div>
                            </div>
                    @else
                        <!--没有收货地址-->
                            <div class="taiTbot">
                                <p>收货地址 : </p>
                                <span class="xiu">您还没有收货地址，马上去<i>添加</i>吧</span>
                            </div>
                        @endif
                    </div>
                    <div class="orList">
                        <div class="listT">
                            <p>订单号/下单时间</p>
                            <p style="margin-left:320px;">支付方式</p>
                            <span>可开发票金额</span>
                        </div>
                        <!--有发票显示-->
                        @if($orderInfo)
                            <ul>
                                @foreach($orderInfo as $k=>$v)
                                    <li ids="{{$v['id']}}">
                                        <input type="checkbox"
                                               @if(in_array($v['f_pay_type_id'],[4,9,10,14,15,16])) name="wallet" @endif>
                                        <div class="listM">
                                            <p>{{$v['no']}}</p>
                                            <p>{{date("Y-m-d H:i:s",$v['create_time'])}}</p>
                                        </div>
                                        <p style="padding:0;">{{$v['pay_type']['name']}}</p>
                                        @if(in_array($v['f_pay_type_id'],[14,15,16]))
                                            <span><i>{{number_format($v["discount_price"],2,".","")}}</i>(元)</span>
                                        @else
                                            <span><i>{{number_format($v["price"],2,".","")}}</i>(元)</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <div class="listS">
                                {{--<div class="sLeft">
                                    <input type="checkbox">
                                    <span>全选</span>
                                </div>--}}
                                {{--<div class="sLeft" style="margin-left:100px;">钱包支付的订单可开发票金额不能大于 : <span--}}
                                <div class="sLeft" style="margin-left:11px;">钱包支付的订单可开发票金额不能大于 : <span
                                            style="color:#980c3f;" kekai="{{number_format($price,2,".","")}}"
                                            id="ke">{{number_format($price,2,".","")}}</span>(元)
                                </div>
                                <div class="sRight">
                                    <span>已选金额 : <i>0</i>(元)</span>
                                    <button>索取发票</button>
                                </div>
                            </div>
                            <!--没有发票显示-->
                        @else
                            <p>暂无可开发票信息</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="zengzhi" ng-view ng-app="myApp"></div>
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
            <img src="{{asset('home/images/invoice/guanbi.png')}}" alt="">
        </div>
    </div>
    <div class="suc">
        <div class="sucN">
            <h2>发票索取成功</h2>
            <p>我们会在7-15个工作日内寄送到您填写的发票地址，注意查收</p>
            <span>确定</span>
        </div>
    </div>
    <!--删除收货地址遮罩层-->
    <div class="delHide">
        <div class="zhaozhao">
            <p class="btiao">删除地址</p>
            <p class="gan">
                <img src="{{asset('home/images/invoice/gantanhao.png')}}" alt="">
                <span>您确定要删除该地址吗？</span>
            </p>
            <a class="laL" href="javascript:;">确定</a>
            <a class="noDel" href="javascript:;">取消</a>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript" src="{{asset('home/js/invoice/angular.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/invoice/angular-route.min.js')}}"></script>
    <script src="http://www.jq22.com/jquery/bootstrap-3.3.4.js"></script>
    <script type="text/javascript" src="{{asset('home/js/invoice/distpicker.data.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/invoice/distpicker.js')}}"></script>

    <script type="text/javascript">
        $('#cacon').distpicker({
            autoSelect: false
        });
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || documnet.body.clientHeight;
        $('.quan,.suc,.delHide').css({'width': widthP, 'height': heightP});
        //点击切换选项卡
        $('.tStepCont > ul > li').click(function () {
            $('.tStepCont>ul>li').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            var len = $(this).prevAll().length;
            if (len != 0) {
                if (len == 1) {
                    window.location.href = "#/start";
                } else {
                    window.location.href = '#/detailMessage';
                }
                $('.faCont > div').eq(1).removeClass('sec');
                $('.faCont > div').eq(0).addClass('sec');
            } else {
                $('.faCont > div').eq(0).removeClass('sec');
                $('.faCont > div').eq(1).addClass('sec');
            }
        });
        //点击显示更多收货地址
        $('.dGduo').click(function () {
            $('.faCont .taiT .taiTbot .adrList > ul').slideToggle();
            $(this).children('img').toggleClass('huojian');
            if ($(this).children('img').hasClass('huojian')) {
                $(this).children('span').text('收起收货地址');
            } else {
                $(this).children('span').text('显示收货地址');
            }
        });
        //收货地址的遮罩层消失或者弹出
        $('.xiu>i,.newAdr').click(function () {
            $('.add').text('添加地址');
            $('.quan').fadeIn(300);
        });
        //点击修改收货地址
        $('.adrList>p>a,.adrList>ul>li>a').click(function () {
            $('.add').text('修改地址');
            $('.yq').attr('id', $(this).attr('id'));
            var nam = $(this).parent().find('.dshouhuo').children('em').text(),
                tel = $(this).parent().find('.dTho').children('em').text();
            var dAry = $(this).parent().find('label').children('span').attr('tit').split(' ');
            $('#ren').val(nam);
            $('#tel').val(tel);
            $('#danAddr').val($(this).attr('zds'));
            $("#province2").val(dAry[0]);
            $("#province2").trigger("change");
            $("#city2").val(dAry[1]);
            $("#city2").trigger("change");
            $("#district2").val(dAry[2]);
            $('#tail').val(dAry[3]);
            $('.quan').fadeIn(300);
        });
        //点击确定
        $('.yq').unbind('click').click(function () {
            var flag = true;
            if (flag) {
                if ($('#ren').val() == '') {
                    layer.msg('请您填写收货人姓名');
                    flag = false;
                }
            }
            if (flag) {
                if ($('#ren').val() !== '' && $('#ren').val().length > 25) {
                    layer.msg('收货人姓名不能大于25位');
                    flag = false;
                }
            }
            if (flag) {
                $('.zhezhao #cacon .form-group .form-control').each(function (m, n) {
                    if ($(n).val() == '') {
                        layer.msg('请选择收货地址');
                        flag = false;
                        return false;
                    }
                });
            }
            if (flag) {
                if ($('#tail').val() == '') {
                    layer.msg('您需要填写详细的收货地址，可在下方文本框内填写');
                    flag = false;
                }
            }
            if (flag) {
                if ($('#tel').val() == '') {
                    layer.msg('请您填写收货人手机号码');
                    flag = false;
                }
            }
            if (flag) {
                if ($('#danAddr').val() == '') {
                    layer.msg('请您输入单位名称');
                    flag = false;
                }
            }
            if (flag) {
                if (!/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17[0-9])|(18[0-9]))\d{8}$/.test($('#tel').val())) {
                    layer.msg('请您输入正确的电话号');
                    flag = false;
                }
            }
            if (flag) {
                var name = $(this).parent().find('#ren').val(),
                    tel = $(this).parent().find('#tel').val(),
                    prpvin = $(this).parent().find('#province2').val(),
                    city = $(this).parent().find('#city2').val(),
                    town = $(this).parent().find('#district2').val(),
                    xiang = $(this).parent().find('#tail').val(),
                    danName = $(this).parent().find('#danAddr').val();
                if ($(this).attr('id') != undefined) {
                    var myId = $(this).attr('id');
                    //修改收货地址
                    $.ajax({
                        url: "{{url('takeOver/updateTakeOver')}}/" + myId,
                        type: 'post',
                        data: {
                            name: name,
                            province: prpvin,
                            city: city,
                            tel_no: tel,
                            town: town,
                            ex: xiang,
                            company_name: danName
                        },
                        success: function (res) {
                            if (res.err == 200) {
                                location.reload(true);
                            }
                        }
                    });
                } else {
                    //新增收货地址
                    $.ajax({
                        url: "{{url('takeOver/addTakeOver')}}",
                        type: 'post',
                        data: {
                            name: name,
                            province: prpvin,
                            city: city,
                            tel_no: tel,
                            town: town,
                            ex: xiang,
                            company_name: danName
                        },
                        success: function (res) {
                            if (res.err == 200) {
                                location.reload(true);
                            }
                        }
                    });
                }
                $(this).removeAttr('id');
                $('.quan').fadeOut(300);
            }
        });
        //点击取消或者叉号
        $('.zhezhao .noadd,.zhezhao>img').click(function () {
            $('.yq').removeAttr('id');
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
        //删除收货地址
        $('.adrList>p>em,.adrList>ul>li>em,.faCont .taiT .taiTtop ul li em').unbind('click').click(function () {
            if ($(this).text() == '删除') {
                $('.delHide').attr('id', $(this).parent().attr('id'));
                $('.btiao').text('删除发票抬头');
                $('.gan>span').text('您确定要删除该发票抬头吗？');
            } else if ($(this).text() == '') {
                $('.delHide').attr('dlId', $(this).parent().children('a').attr('id'));
                $('.btiao').text('删除地址');
                $('.gan>span').text('您确定要删除该地址吗？');
            }
            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {
                var id = $(this).parent().parent().attr('id'),
                    dlId = $(this).parent().parent().attr('dlId');
                if (id != undefined) {
                    //删除发票抬头
                    $.ajax({
                        url: "{{url('invoiceTitle/del')}}",
                        type: 'post',
                        data: {id: id},
                        success: function (res) {
                            if (res.err == 200) {
                                location.reload(true);
                            }
                        }
                    });
                    $('.delHide').fadeOut(300).removeAttr('id');
                } else if (dlId != undefined) {
                    //删除收货地址
                    $.ajax({
                        url: "{{url('takeOver/delTakeOver')}}",
                        type: 'post',
                        data: {id: dlId},
                        success: function (res) {
                            if (res.err == 200) {
                                location.reload(true);
                            }
                        }
                    });
                    $('.delHide').fadeOut(300).removeAttr('dlId');
                }
            });
        });
        $('.noDel').unbind('click').click(function () {
            if ($(this).parent().parent().attr('id') == undefined) {
                $('.delHide').removeAttr('dlId');
            } else {
                $('.delHide').removeAttr('id');
            }
            $('.delHide').fadeOut(300);
        });
        //失去焦点时的状态
        $('.faCont .taiT .taiTtop ul li input').blur(function () {
            $(this).parent().children('i').text('编辑');
            $(this).css({'display': 'none', 'borderColor': '#ccc'});
            $(this).parent().children('span').css('display', 'block').text($(this).parent().children('input').val());
        });
        //点击发票抬头编辑
        $('.faCont .taiT .taiTtop ul li i').click(function () {
            var _this = $(this);
            if ($(this).text() == '编辑') {
                $(this).text('保存');
                $(this).parent().children('span').css('display', 'none');
                $(this).parent().children('input').css({
                    'display': 'block',
                    'borderColor': '#3BBD77'
                }).val($(this).parent().children('span').text()).focus();
            } else {
                $(this).text('编辑');
                $(this).parent().children('input').css({'display': 'none', 'borderColor': '#ccc'});
                $(this).parent().children('span').css('display', 'block').text($(this).parent().children('input').val());
                var val = $(this).parent().children('input').val(),
                    id = $(this).parent().attr('id');
                $.ajax({
                    url: "{{url('invoiceTitle/update')}}",
                    type: 'post',
                    data: {name: val, id: id},
                    success: function (res) {
                        if (res.err == 200) {
                            /*console.log(res);*/
                            location.reload(true);
                        }
                    }
                })
            }
        });
        //点击LI框变成#d25174;个人发票框消失
        $('.faCont .taiT .taiTtop ul li').click(function () {
            $('.shibiehao').css('display', 'block');
            $(this).addClass('scl').siblings('li').removeClass('scl');
            $('.faCont .taiT .taiTtop .tr').removeClass('scl');
            $(this).siblings('li').each(function (k, v) {
                if ($(v).attr('id') == undefined) {
                    $(v).remove();
                } else {
                    $(v).children('i').text('编辑');
                    $(v).children('input').css({'display': 'none', 'borderColor': '#ccc'});
                    var val = $(v).children('input').val();
                    if (val == '') {
                        var vall = $(v).children('span').text();
                        if (vall == '') {
                            $(v).remove();
                            return true;
                        } else {
                            val = vall;
                        }
                    }
                    $(v).children('span').css({'display': 'block'}).text(val);
                }
            })
        });
        //点击选择个人发票
        $('.faCont .taiT .taiTtop .tr').click(function () {
            $('.shibiehao').css('display', 'none');
            $(this).addClass('scl');
            $('.faCont .taiT .taiTtop ul li').each(function (k, v) {
                if ($(v).attr('id') == undefined) {
                    $(v).remove();
                } else {
                    $(v).removeClass('scl');
                    $(v).children('em').css('display', 'block');
                    $(v).children('i').text('编辑');
                    $(v).children('input').css({'display': 'none', 'borderColor': '#ccc'});
                    var val = $(v).children('input').val();
                    if (val == '') {
                        var vall = $(v).children('span').text();
                        if (vall == '') {
                            $(v).remove();
                            return true;
                        } else {
                            val = vall;
                        }
                    }
                    $(v).children('span').css({'display': 'block'}).text(val);
                }
            })
        });
        //新增单位抬头
        $('.zeng').click(function () {
            if ($('.faCont .taiT .taiTtop ul li').length == 10) {
                layer.msg('抱歉，发票抬头最多可添加10条');
            } else {
                $('.faCont .taiT .taiTtop ul').append(
                    '<li>' +
                    '<span></span>' +
                    '<input type="text" placeholder="请填写发票抬头">' +
                    '<em style="display: none;">删除</em>' +
                    '<i>编辑</i>' +
                    '</li>'
                ).children('li').click(function () {
                    $('.shibiehao').css('display', 'block');
                    $('.faCont .taiT .taiTtop .tr').removeClass('scl');
//                    $(this).css('borderColor', '#d25174').siblings('li').css('borderColor', '#ccc');
                    $(this).addClass('scl').siblings('li').removeClass('scl');
                    $(this).siblings('li').each(function (k, v) {
                        $(v).children('i').text('编辑');
                        $(v).children('input').css({'display': 'none', 'borderColor': 'red'});
                        var val = $(v).children('input').val();
                        if (val == '') {
                            var vall = $(v).children('span').text();
                            if (vall == '') {
                                $(v).remove();
                                return true;
                            } else {
                                val = vall;
                            }
                        }
                        $(v).children('span').css({'display': 'block'}).text(val);
                    })
                }).last().children('i').click(function () {
                    if ($(this).text() == '编辑') {
                        $(this).text('保存');
                        $(this).parent().children('span').css('display', 'none');
                        $(this).parent().children('input').css({
                            'display': 'block',
                            'borderColor': '#3BBD77'
                        }).val($(this).parent().children('span').text()).focus();
                    } else {
                        if ($(this).parent().children('input').val() == '') {
                            layer.msg('输入不能为空');
                        } else {
                            $(this).text('编辑');
                            $(this).parent().children('input').css({'display': 'none', 'borderColor': '#ccc'});
                            $(this).parent().children('span').css('display', 'block').text($(this).parent().children('input').val());
                            var val = $(this).parent().children('input').val();
                            $.ajax({
                                url: "{{url('invoiceTitle/add')}}",
                                type: 'post',
                                data: {name: val},
                                success: function (res) {
                                    if (res.err == 200) {
                                        location.reload(true);
                                    }
                                }
                            })
                        }
                    }
                });
                $('.faCont .taiT .taiTtop ul').children('li:last-child').children('i').trigger('click');
            }
        });
        //全选
        /*$('.sLeft>input').click(function () {
         if ($(this).prop('checked')) {
         $('.orList>ul>li>input').each(function (k, v) {
         $(v).prop('checked', 'checked');
         });
         var zJia = 0;
         $('.orList>ul>li>span>i').each(function (m, n) {
         zJia += parseFloat($(n).text());
         });
         $('.sRight>span>i').text(zJia.toFixed(2));
         } else {
         $('.orList>ul>li>input').each(function (k, v) {
         $(v).removeProp('checked');
         });
         $('.sRight>span>i').text(0);
         }
         });*/
        //单选
        $('.orList>ul>li>input').click(function () {
            if ($(this).prop('name') == 'wallet') {
                var ke = parseFloat($('#ke').text()).toFixed(2),
                    keTwo = parseFloat(parseFloat($(this).parent().children('span').children('i').text()).toFixed(2)),
                    kekai = parseFloat(parseFloat($('.sLeft').children('span').attr('kekai')).toFixed(2));
                var keZong;
                if ($(this).prop('checked')) {
                    if (parseFloat(ke) - parseFloat(keTwo) < 0) {
                        layer.msg('由于您申请的钱包支付的订单金额已经大于您实际充值的金额数，返现金额不给于开发票，所以您申请发票会按照实际充值金额开取。', {time: 5000});
                    }
                    if (parseFloat(ke) - parseFloat(keTwo) <= 0) {
                        keZong = 0.00;
                        $('.orList>ul>li>input[name="wallet"]').each(function (k, v) {
                            if (!$(v).prop('checked')) {
                                $(v).attr('disabled', true);
                            }
                        });
                    } else {
                        keZong = ke - keTwo;
                        $('.orList>ul>li>input[name="wallet"]').each(function (k, v) {
                            if (!$(v).prop('checked')) {
                                $(v).attr('disabled', false);
                            }
                        });
                    }
                } else {
                    var suan = 0;
                    keZong = parseFloat(ke) + parseFloat(keTwo);
                    $('.orList>ul>li>input[name="wallet"]').each(function (k, v) {
                        if ($(v).prop('checked')) {
                            suan = parseFloat(suan) + parseFloat(parseFloat($(v).parent().children('span').children('i').text()).toFixed(2));
                        }
                    });
                    if (parseFloat(kekai) > parseFloat(suan)) {
                        keZong = parseFloat(kekai) - parseFloat(suan);
                        $('.orList>ul>li>input[name="wallet"]').each(function (k, v) {
                            if (!$(v).prop('checked')) {
                                $(v).attr('disabled', false);
                            }
                        });
                    } else {
                        keZong = 0.00;
                        $('.orList>ul>li>input[name="wallet"]').each(function (k, v) {
                            if (!$(v).prop('checked')) {
                                $(v).attr('disabled', true);
                            }
                        });
                    }
                }
                $('#ke').text(keZong.toFixed(2));
            }
            var zJia = 0;
            $('.orList>ul>li>input').each(function (m, n) {
                if ($(n).prop('checked')) {
                    zJia += parseFloat($(n).parent().children('span').children('i').text());
                }
            });
            $('.sRight>span>i').text(zJia.toFixed(2));
        });
        //弹框显示
        $('.sRight>button').click(function () {
            var flag = true;
            if (flag) {
                if ($('.shibiehao').css('display') == 'block') {
                    var len = $('.shibiehao input').val().length;
                    if (len != 15 && len != 18) {
                        layer.msg('请填写15位或18位的纳税人识别号');
                        flag = false;
                    }
                }
            }
            if (flag) {
                if ($('.xiu').css('display') == 'inline-block') {
                    layer.msg('请填写您要寄送发票的地址');
                    flag = false;
                }
            }
            if (flag) {
                var nu = 0;
                $('.adrList').find('input[name="dlzhi"]').each(function (k, v) {
                    if ($(v).prop('checked') == true) {
                        nu++;
                    }
                });
                if (nu == 0) {
                    layer.msg('请选择您要寄送发票的地址');
                    flag = false;
                }
            }
            if (flag) {
                var num = 0;
                $('.faCont .orList ul li input').each(function (k, v) {
                    if ($(v).prop('checked') == false) {
                        num++;
                    }
                });
                if (num == $('.orList ul li').length) {
                    layer.msg('请勾选你要索取的订单');
                    flag = false;
                }
            }
            /*if (flag) {
             var ke = 0;
             $('.faCont .orList ul li input[name="wallet"]').each(function (k, v) {
             if ($(v).prop('checked') == true) {
             ke += parseFloat($(v).parent().children('span').children('i').text()).toFixed(2);
             }
             });
             var yin = parseFloat($('#ke').text());
             if (ke > yin) {
             layer.msg('钱包支付的订单可开发票金额不能大于 :' + yin);
             flag = false;
             }
             }*/
            if (flag) {
                //索取发票发送ajax
                var geren = $('.taiTtop').find('.scl')[0].nodeName.toLocaleLowerCase(),
                    taiTou = null,
                    shibie = '',
                    dzhiId = null,
                    cuan = '';
                if (geren == 'p') {
                    taiTou = 0;
                } else if (geren == 'li') {
                    taiTou = $('.taiTtop').find('.scl').attr('id');
                    shibie = $('.shibiehao input').val();
                }
                $('.adrList input[name="dlzhi"]').each(function (m, n) {
                    if ($(n).prop('checked') == true) {
                        dzhiId = $(n).parent().parent().attr('ids');
                        return false;
                    }
                });
                $('.faCont .orList ul li input').each(function (j, k) {
                    if ($(k).prop('checked') == true) {
                        cuan += $(k).parent().attr('ids') + ',';
                    }
                });
                $.ajax({
                    url: "{{url('invoice/getInvoiveNorm')}}",
                    type: 'post',
                    data: {addId: dzhiId, invoice: taiTou, f_order_form_id: cuan, tax_no: shibie},
                    success: function (res) {
                        if (res.err == 200) {
                            $('.suc').fadeIn();
                        } else {
                        }
                    }
                })
            }
        });
        //弹框隐藏
        $('.suc .sucN span').click(function () {
            $(this).parent().parent().fadeOut();
            location.reload(true);
        });

        $(document).ready(function () {
            $('.tStepCont > ul > li:first-child').addClass('sec');
            $('.faCont').css('display', 'block')
        });
        // 页面刷新
        window.onload = function () {
            if (window.location.hash == '#/start' || window.location.hash == '#/openTwo') {
                $('.tStepCont > ul > li:nth-child(2)').addClass('sec').siblings('.sec').removeClass('sec');
                $('.faCont').css('display', 'none');
            } else if (window.location.hash == '#/detailMessage' || window.location.hash == '#/xiugai' || window.location.hash == '#/zizhi') {
                $('.tStepCont > ul > li:last-child').addClass('sec').siblings('.sec').removeClass('sec');
                $('.faCont').css('display', 'none');
            } else {
                $('.tStepCont > ul > li:first-child').addClass('sec').siblings('.sec').removeClass('sec');
                $('.faCont').css('display', 'block');
            }
            if ($('#ke').text() == '0.00') {
                $('.orList>ul>li>input[name="wallet"]').each(function (k, v) {
                    if (!$(v).prop('checked')) {
                        $(v).attr('disabled', true);
                    }
                });
            } else {
                $('.orList>ul>li>input[name="wallet"]').each(function (k, v) {
                    if (!$(v).prop('checked')) {
                        $(v).attr('disabled', false);
                    }
                });
            }
        };
        var url = "{{url('/')}}";
    </script>
    <script type="text/javascript" src="{{asset('home/js/invoice/fapiaoNg.js')}}"></script>
@endsection