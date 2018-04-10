@extends("home.layout.layout")
@section("title","注册")
@section("css")
    <link href="http://www.jq22.com/jquery/bootstrap-3.3.4.css" rel="stylesheet">
    <!--[if IE]>
    <script src="http://libs.baidu.com/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('home/css/register/register.css')}}">
@endsection
@section("content")
    <div class="line" style="width: 100%;border-top:1px solid #ccc;"></div>
    <div class="sYe">
        <a href="{{url('/')}}">
            <img src="{{asset('home/images/logo2.png')}}" alt="">
        </a>
        <span>欢迎注册</span>
    </div>
    <div class="regCon">
        <form id="regist" method="post" action="{{url('user/create')}}">
            @if (count($errors) > 0)
                <p id="reTi" style="display: block;">
                    <img src="{{asset('home/images/login/heng.png')}}" alt="">
                    <span>
                    @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
            </span>
                </p>
            @else
                <p id="reTi">
                    <img src="{{asset('home/images/login/heng.png')}}" alt="">
                    <span></span>
                </p>
            @endif
            <div class="group">
                <label for="yi">用户名 : </label>
                <input id="yi" value="{{session('info')['username']}}" name="username" type="text"
                       placeholder="您的用户名">
            </div>
            <p>
                <img src="{{asset('home/images/login/huiti.png')}}" alt="">
                <span>可包含英文字母、数字、"-"、"_",4-30个字符(不填写默认为宜优速用户)</span>
            </p>
            <div class="group">
                <label for="er">手机号码 : </label>
                <input id="er" value="{{session('info')['signin_name']}}" type="text" name="signin_name" maxlength="11"
                       placeholder="建议使用常用手机"
                       onkeyup="this.value=this.value.replace(/\D/g,'')"
                       onafterpaste="this.value=this.value.replace(/\D/g,'')">
            </div>
            <p>
                <img src="{{asset('home/images/login/huiti.png')}}" alt="">
                <span>完成验证后，您可以用该手机接收确认订单信息，找回密码等服务</span>
            </p>
            <div class="group">
                <label for="san">用户密码 : </label>
                <input id="san" value="{{session('info')['pwd']}}" name="pwd" onfocus="this.type='password'"
                       maxlength="16"
                       placeholder="建议至少使用两种字符组合"
                       onkeyup="checkPwdStrong(this)">
            </div>
            <p style="margin-bottom: 6px">
                <img src="{{asset('home/images/login/huiti.png')}}" alt="">
                <span>建议使用字母数字和符号两种及以上的组合，6-16个字符</span>
            </p>
            <ul class="for-hd">
                <li>
                    <img src="{{asset('home/images/login/ruo.png')}}" alt="">
                    <span>有被盗风险，建议使用字母、数字和符号两种及以上组合</span>
                </li>
                <li>
                    <img src="{{asset('home/images/login/zhong.png')}}" alt="">
                    <span>安全强度适中，可以使用三种以上的组合来提高安全强度</span>
                </li>
                <li>
                    <img src="{{asset('home/images/login/qiang.png')}}" alt="">
                    <span>你的密码很安全</span>
                </li>
            </ul>
            <div class="group">
                <label for="si">确认密码 : </label>
                <input id="si" value="{{session('info')['pwd_confirmation']}}" name="pwd_confirmation"
                       onfocus="this.type='password'"
                       maxlength="16" placeholder="再次输入密码">
            </div>
            <div class="group">
                <label for="wu">验证码 : </label>
                <input id="wu" value="{{session('info')['code']}}" type="text" name="code" placeholder="请输入验证码"
                       maxlength="4"
                       onkeyup="this.value=this.value.replace(/\D/g,'')"
                       onafterpaste="this.value=this.value.replace(/\D/g,'')">
                <input class="for-huo" type="button" value="获取验证码" onclick="settime(this)">
            </div>
            <div class="group" style="margin-bottom: 24px;">
                <label for="hang">所属行业 : </label>
                <select name="trade_type" id="hang">
                    <option value="">--请选择--</option>
                    <option value="0">酒店</option>
                    <option value="1">饭店</option>
                </select>
            </div>

            <div class="group" style="margin-bottom: 15px;">
                <label for="lei">企业类型 : </label>
                <select name="company_type" id="lei">
                    <option value="">--请选择--</option>
                    <option value="0">自营</option>
                    <option value="1">连锁</option>
                </select>
            </div>

            <div class="group" style="margin-bottom: 15px;">
                <label for="qiye">企业名称 : </label>
                <input id="qiye" value="{{session('info')['username']}}" name="hotel_name" type="text"
                       placeholder="请输入您的企业名称">
            </div>

            <div class="group" style="margin-bottom: 10px;">
                <label for="zhi">企业地址 : </label>
                <div data-toggle="distpicker" id="cacon" class="clear">
                    <div class="form-group">
                        <label class="sr-only" for="province2">Province</label>
                        <select name="take_over_province" class="form-control" id="province2"
                                data-province="-- 选择省 --"></select>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="city2">City</label>
                        <select name="take_over_city" class="form-control" id="city2" data-city="-- 选择市 --"></select>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="district2">District</label>
                        <select class="form-control" name="take_over_town" id="district2"
                                data-district="-- 选择区 --"></select>
                    </div>
                </div>
            </div>
            <input id="tail" name="take_over_ex" type="text" placeholder="请输入您的详细地址">

            <div class="group">
                <label for="liu">员工编号 : </label>
                <input id="liu" value="{{session('info')['f_employee_id']}}" type="text" name="f_employee_id"
                       placeholder="请填写销售人员编号(选填)" maxlength="5"
                       onkeyup="this.value=this.value.replace(/\D/g,'')"
                       onafterpaste="this.value=this.value.replace(/\D/g,'')">
            </div>
            {{--<div class="mo" style="margin-bottom:0;">
                <input type="checkbox" name="agree" value="1">
                <p>
                    <span style="margin-bottom: 9px;">付费会员注册15元/月<a href="{{url("temp/vip")}}"
                                                                    target="_blank">充值会员</a></span>
                </p>
            </div>--}}
            <div class="mo">
                <input type="checkbox" name="agree" value="1">
                <p>
                    <span style="margin-bottom: 9px;">我已同意并阅读<a href="{{url('clause')}}"
                                                                target="_blank">《宜优速服务条款》</a></span>
                    <span>已有账号,<a href="{{asset('login')}}">请登录</a></span>
                </p>
            </div>
            <input id="regiZhu" type="submit" value="立即注册">
            <img id="regTu" src="{{asset('home/images/login/ren.png')}}" alt="">
            {{csrf_field()}}
        </form>
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
        $('.group input').focus(function () {
            $(this).css('borderColor', '#b25174');
        });
        $('.group input').blur(function () {
            $(this).css('borderColor', '#ccc');
        });
        //点击判断密码强度
        function checkPwdStrong(pwd) {
            var element = $(".for-hd");
            var value = pwd.value;
            if (value.length >= 6) {
                element.show();
                $(pwd).parent().children('i').css('display', 'block');
                var level = pwdLevel(value);
                switch (level) {
                    case 1:
                        element.children('li').css('display', 'none').eq(0).css('display', 'block');
                        break;
                    case 2:
                        element.children('li').css('display', 'none').eq(1).css('display', 'block');
                        break;
                    case 3:
                        element.children('li').css('display', 'none').eq(2).css('display', 'block');
                        break;
                    default:
                        break;
                }
            } else {
                element.hide();
                $(pwd).parent().children('i').css('display', 'none');
            }
        }
        function pwdLevel(value) {
            var pattern_1 = /^.*([\W_])+.*$/i; //匹配任何非单词字符。等价于 '[^A-Za-z0-9_]'并且支持下划线_。
            var pattern_2 = /^.*([a-zA-Z])+.*$/i;//英文字母
            var pattern_3 = /^.*([0-9])+.*$/i;//数字
            var level = 0;
            if (value.length > 10) {
                level++;
            }
            if (pattern_1.test(value)) {
                level++;
            }
            if (pattern_2.test(value)) {
                level++;
            }
            if (pattern_3.test(value)) {
                level++;
            }
            if (level > 3) {
                level = 3;
            }
            return level;
        }
        //点击获取验证码
        var countdown = 120, flag = true;
        function settime(obj) {
            if ($('#er').val().length == 0) {
                $('#reTi').css('opacity', '1').children('span').text('请输入注册手机!');
            } else if ($('#er').val().length != 0 && $('#er').val().length != 11) {
                $('#reTi').css('opacity', '1').children('span').text('格式不正确，请您输入正确的手机号码!');
            } else if (($('#er').val().length == 11) && (!/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17[0-9])|(18[0-9]))\d{8}$/.test($('#er').val()))) {
                $('#reTi').css('opacity', '1').children('span').text('格式不正确，请您输入正确的手机号码!');
            } else if ($('#er').val().length == 11) {
                if ($('.for-huo').attr('disabled') == null) {
                    var phone = $('#er').val();
                    $.ajax({
                        url: "{{url('register/code')}}",
                        data: {"phone": phone},
                        async: false,
                        type: "post",
                        success: function (res) {
                            if (res.err != 200) {
                                layer.msg(res.msg);
                                $('.for-huo')[0].style.backgroundColor = '#980c3f';
                                $('.for-huo')[0].removeAttribute("disabled");
                                $('.for-huo')[0].value = "获取验证码";
                                countdown = 120;
                                flag = false;
                            } else {
                                layer.msg('验证码发送成功,请注意查收!');
                                flag = true;
                            }
                        }
                    });
                }
                if (flag) {
                    if (countdown == 0) {
                        obj.style.backgroundColor = '#980c3f';
                        obj.removeAttribute("disabled");
                        obj.value = "获取验证码";
                        countdown = 120;
                        return;
                    } else {
                        obj.setAttribute("disabled", true);
                        obj.style.backgroundColor = '#ccc';
                        obj.value = "重新发送(" + countdown + ")";
                        countdown--;
                    }
                    setTimeout(function () {
                        settime(obj)
                    }, 1000)
                }
            }
        }
        //点击出现错误提示
        $('#regiZhu').click(function () {
            var yi = $('#yi').val(),
                er = $('#er').val(),
                san = $('#san').val(),
                si = $('#si').val(),
                wu = $('#wu').val(),
                liu = $('#liu').val(),
                reg = /[^\w\u4E00-\u9FA5-]/;
            var boo = $('input[type="checkbox"]').prop('checked');
            var flag = true;
            if (flag) {
                if (reg.test(yi)) {
                    $('#reTi').css('opacity', '1').children('span').text('可包含英文字母、数字、"-"、"_",4-30个字符');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if ((!reg.test(yi)) && (yi.length != 0)) {
                    var a = /[\u4e00-\u9fa5]+/g.exec(yi),
                        b = /[\w-]+/g.exec(yi);
                    if (a != null) {
                        a = parseFloat(/[\u4e00-\u9fa5]+/g.exec(yi)[0].length) * 2;
                    }
                    if (b != null) {
                        b = parseFloat(/[\w-]+/g.exec(yi)[0].length);
                    }
                    var c = a + b;
                    if (c < 4 || c > 30) {
                        $('#reTi').css('opacity', '1').children('span').text('长度只能在4-30个字符之间');
                        flag = false;
                        return false;
                    }
                }
            }
            if (flag) {
                if (er.length == 0) {
                    $('#reTi').css('opacity', '1').children('span').text('请输入注册手机');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if (er.length != 0 && er.length != 11) {
                    $('#reTi').css('opacity', '1').children('span').text('格式不正确，请您输入正确的手机号码');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if ((er.length == 11) && (!/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17[0-9])|(18[0-9]))\d{8}$/.test(er))) {
                    $('#reTi').css('opacity', '1').children('span').text('格式不正确，请您输入正确的手机号码');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if (er.length == 11 && san.length == 0 && si.length == 0) {
                    $('#reTi').css('opacity', '1').children('span').text('请输入密码');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if (er.length == 11 && (san == si) && (si.length < 6 || si.length > 16)) {
                    $('#reTi').css('opacity', '1').children('span').text('请您输入6-16位的登录密码');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if (er.length == 11 && (san != si)) {
                    $('#reTi').css('opacity', '1').children('span').text('两次密码输入不一致');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if ((er.length == 11) && (san == si) && (san.length > 5) && (san.length < 17) && (wu.length == 0)) {
                    $('#reTi').css('opacity', '1').children('span').text('请输入验证码');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if ((er.length == 11) && (san == si) && (san.length > 5) && (san.length < 17) && (wu.length != 0 && wu.length != 4)) {
                    $('#reTi').css('opacity', '1').children('span').text('请输入4位数字验证码');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if ($('#hang').val() == '') {
                    $('#reTi').css('opacity', '1').children('span').text('请选择所属行业');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if ($('#lei').val() == '') {
                    $('#reTi').css('opacity', '1').children('span').text('请选择企业类型');
                    flag = false;
                    return false;
                }
            }

            if (flag) {
                if ($('#qiye').val() == '') {
                    $('#reTi').css('opacity', '1').children('span').text('请输入您的企业名称');
                    flag = false;
                    return false;
                }
            }

            if (flag) {
                if ($('#province2').val() == '') {
                    $('#reTi').css('opacity', '1').children('span').text('请选择省');
                    flag = false;
                    return false;
                } else if ($('#city2').val() == '') {
                    $('#reTi').css('opacity', '1').children('span').text('请选择市');
                    flag = false;
                    return false;
                } else if ($('#district2').val() == '') {
                    $('#reTi').css('opacity', '1').children('span').text('请选择区');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if ($('#tail').val() == '') {
                    $('#reTi').css('opacity', '1').children('span').text('请输入您的详细地址');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                if (er.length == 11 && san == si && san.length > 5 && san.length < 17 && wu.length == 4 && boo == false) {
                    $('#reTi').css('opacity', '1').children('span').text('请阅读并同意《宜优速服务条款》');
                    flag = false;
                    return false;
                }
            }
            if (flag) {
                return true;
            }
        });
        $('.group input').blur(function () {
            $('#reTi').css('opacity', '0').children('span').text('');
        });
        @if(session("msg"))
            layer.msg('{{session("msg")}}');
        @endif
    </script>
@endsection