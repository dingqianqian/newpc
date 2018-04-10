@extends("home.layout.layout")
@section("title","收货地址")
@section("css")
    <link href="http://www.jq22.com/jquery/bootstrap-3.3.4.css" rel="stylesheet">
    <!--[if IE]>
    <script src="http://libs.baidu.com/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('home/css/takeover/addresss.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>收货地址</span></p>
    </div>
    <div class="oStep clear">
        <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <!--右侧内容-->
        <div class="tStepCont">
            <div class="xinJian">
                <span>新增收货地址</span>
                <p>您已创建<i>{{count($takeOverInfo)}}</i>个收货地址，最多可以创建<em>20</em>个</p>
            </div>
            @if(!$takeOverInfo)
                {{--暂无优惠券--}}
                <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
                    <img src="{{asset('home/images/comment/zzwu.png')}}"
                         style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
                    <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无收货地址~</span>
                </p>
            @else
                <ul class="xinOut">
                    @foreach($takeOverInfo as $k=>$v)
                        <li id="{{$v["id"]}}">
                            <ul class="xinIn">
                                <li class="clear">
                                    <p>收货地址<i>{{$loop->iteration}}</i></p>
                                    @if($v["is_default"]==1)
                                        <div class="sec"></div>
                                    @endif
                                    <img src="{{asset('home/images/takeover/xinDel.png')}}" alt="">
                                </li>
                                <li>
                                    <span>收货人 : </span>
                                    <em class="ming">{{$v['name']}}</em>
                                </li>
                                <li>
                                    <span>手机 : </span>
                                    <em class="pho">{{$v['tel_no']}}</em>
                                </li>
                                <li>
                                    <span>所在地区 : </span>
                                    <em class="sheng"
                                        title="{{$v['province'].' '.$v['city'].' '.$v['town'].' '.$v['ex']}}">{{city_province($v['province'],$v['city']).$v['town'].$v['ex']}}</em>
                                    {{--<em class="shi">{{$v['city']}}</em>
                                    <em class="qu">{{$v['town']}}</em>--}}
                                </li>
                                <li>
                                    <span>地址 : </span>
                                    <em class="xiang">{{$v['ex']}}</em>
                                </li>
                                <li class="clear">
                                    <span class="bian" zds="{{$v['company_name']?$v['company_name']:""}}">编辑</span>
                                    @if($v["is_default"]==0)
                                        <span class="mo">设为默认</span>
                                    @endif
                                </li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
            @endif
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
            <img src="{{asset('home/images/takeover/guanbi.png')}}" alt="">
        </div>
    </div>
    <!--删除收货地址遮罩层-->
    <div class="delHide">
        <div class="zhaozhao">
            <p class="btiao">删除地址</p>
            <p class="gan">
                <img src="{{asset('home/images/takeover/gantanhao.png')}}" alt="">
                <span>您确定要删除该地址吗？</span>
            </p>
            <a class="laL" href="javascript:;">确定</a>
            <a class="noDel" href="javascript:;">取消</a>
        </div>
    </div>
@endsection
@section("js")
    <script src="http://www.jq22.com/jquery/bootstrap-3.3.4.js"></script>
    <script type="text/javascript" src="{{asset('home/js/takeover/distpicker.data.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/takeover/distpicker.js')}}"></script>
    <script type="text/javascript">
        $('#cacon').distpicker({
            autoSelect: false
        });
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || document.body.clientHeight;
        $('.quan,.delHide').css({'width': widthP, 'height': heightP});
        //删除收货地址
        $('.xinIn>li>img').unbind('click').click(function () {
            var id = $(this).parent().parent().parent().attr('id');
            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {
                $('.delHide').fadeOut(300);
                $.ajax({
                    url: "{{url("takeOver/delTakeOver")}}",
                    type: 'post',
                    data: {id: id},
                    success: function (res) {
                        if (res.err == 200) {
                            location.reload();
                        }
                    }
                })
            });
        });
        $('.noDel').unbind('click').click(function () {
            $('.delHide').fadeOut(300);
        });
        //收货地址的遮罩层消失或者弹出
        $('.xinJian>span').click(function () {
            $('.add').text('添加地址');
            $('.quan').fadeIn(300);
        });
        //点击编辑
        $('.bian').click(function () {
            $('.add').text('修改地址');
            var adressArry = $(this).parent().parent().find('.sheng').attr('title').split(' ');
            var sheng = adressArry[0], shi = adressArry[1], qu = adressArry[2], ex = adressArry[3];
            $('.yq').attr('myId', $(this).parent().parent().parent().attr('id'));
            $('#ren').val($(this).parent().parent().find('.ming').text());
            $('#tel').val($(this).parent().parent().find('.pho').text());
            $('#danAddr').val($(this).attr('zds'));
            $("#province2").val(sheng);
            $("#province2").trigger("change");
            $("#city2").val(shi);
            $("#city2").trigger("change");
            $("#district2").val(qu);
            $('#tail').val(ex);
            $('.quan').fadeIn(300);
        });
        //点击确定
        $('.yq').unbind('click').click(function () {
            var flag = true, _this = $(this);
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
                if ($('#danAddr').val() == '') {
                    layer.msg('请您输入单位名称');
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
                if (!/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17[0-9])|(18[0-9]))\d{8}$/.test($('#tel').val())) {
                    layer.msg('请您输入正确的手机号码');
                    flag = false;
                }
            }
            if (flag) {
                var name = $('#ren').val(),
                    province = $('#province2').val(),
                    city = $('#city2').val(),
                    town = $('#district2').val(),
                    ex = $('#tail').val(),
                    tel_no = $('#tel').val(),
                    danName = $(this).parent().find('#danAddr').val();
                var id = $(this).attr('myId');
                if ($('.add').text() == '添加地址') {
                    $.ajax({
                        url: "{{url("takeOver/addTakeOver")}}",
                        type: 'post',
                        data: {
                            name: name,
                            province: province,
                            city: city,
                            town: town,
                            ex: ex,
                            tel_no: tel_no,
                            company_name: danName
                        },
                        success: function (res) {
                            if (res.err == 200) {
                                _this.removeAttr('myId');
                                location.reload();
                            }
                        }
                    })
                } else {
                    $.ajax({
                        url: "{{url("takeOver/updateTakeOver")}}/" + id,
                        type: 'post',
                        data: {
                            name: name,
                            province: province,
                            city: city,
                            town: town,
                            ex: ex,
                            tel_no: tel_no,
                            company_name: danName
                        },
                        success: function (res) {
                            if (res.err == 200) {
                                _this.removeAttr('myId');
                                location.reload();
                            }
                        }
                    })
                }
            }
        });
        //点击取消或者叉号
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
        //设置为默认地址
        $('.mo').unbind('click').click(function () {
            var id = $(this).parent().parent().parent().attr('id');
            $.ajax({
                url: "{{url("takeOver/defaultTakeOver")}}",
                type: 'post',
                data: {id: id},
                success: function (res) {
                    console.log(res);
                    if (res.err == 200) {
                        layer.msg('修改默认地址成功');
                        location.reload();
                    }
                }
            })
        })
    </script>
@endsection