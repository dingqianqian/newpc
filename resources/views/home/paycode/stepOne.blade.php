@extends("home.layout.layout")
        @section("title","支付密码管理")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/paycode/zhifuOne.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>安全设置</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <ul>
            <li><a href="{{url('safe/password/stepOne')}}">修改登录密码</a></li>
            <li><a href="{{url('safe/paycode/checkInfo')}}" class="sec">支付密码管理</a></li>
            <li><a href="{{url('safe/username/stepOne')}}">修改验证手机</a></li>
        </ul>
        <div class="box">
            <img src="{{asset('home/images/safe/zhongOne.png')}}" alt="">
            <form method="post" action="{{url('safe/paycode/checkInfo')}}">
                <label style="margin-bottom: 24px;padding-left: 159px;">
                    <span>请选择验证身份方式 : </span>
                    <select name="type">
                        <option value="0">使用(尾号<span>{{mb_substr(session("userInfo")['signin_name'],7,4)}}</span>)的手机验证</option>
                        <option value="1">验证身份信息</option>
                    </select>
                </label>
                <label class="shoujiH">
                    <span>请填写手机效验码 : </span>
                    <input type="text" maxlength="4" name="code" onkeyup="this.value=this.value.replace(/\D/g,'')"
                           onafterpaste="this.value=this.value.replace(/\D/g,'')">
                    <button type="button">获取短信效验码</button>
                    <div>
                        <p class="zheng">效验码已发出,请注意查收短信,如果没有收到,你可以在<span>120</span>秒后要求重新发送</p>
                        <p class="cuo">请输入正确验证码格式</p>
                    </div>
                </label>
                <label class="zhongjian" style="padding-left:94px;">
                    <span>请输入您手机号码的中间4位 : </span>
                    <input onclick="this.type='password'" maxlength="4" name="phone" onkeyup="this.value=this.value.replace(/\D/g,'')"
                           onafterpaste="this.value=this.value.replace(/\D/g,'')">
                    <div>
                        <p>请输入正确手机号码</p>
                    </div>
                </label>
                {{csrf_field()}}
                <input type="submit" value="提交">
            </form>
        </div>
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        $('.box select').change(function () {
            if ($(this).val() == 0) {
                $('.shoujiH').css('display', 'block');
                $('.zhongjian').css('display', 'none').find('p').css('display', 'none');
                clearInterval(timer);
                count = 120;
                $('.shoujiH button').removeAttr('disabled').text('获取短信效验码').css('backgroundColor', '#fff');
                $('.zheng').css('display', 'none');
                $('.cuo').css('display', 'none');
            } else {
                $('.shoujiH').css('display', 'none');
                $('.zhongjian').css('display', 'block');
            }
        });
        var count = 120, timer = null;
        $('.shoujiH button').click(function () {
            $.ajax({
                url:"{{url('safe/sendMessage')}}",
                type:"post",
                success:function (res) {
                    if (res.err!=200)
                    {
                        layer.msg(res.msg);
                    }
                }
            });
            var _this = $(this);
            _this.attr('disabled', 'disabled').text('重新发送(' + count + ')').css('backgroundColor', '#ccc');
            $('.zheng').css('display', 'block');
            $('.cuo').css('display', 'none');
            timer = setInterval(function countDown() {
                count--;
                if (count == 0) {
                    clearInterval(-timer);
                    count = 120;
                    _this.removeAttr('disabled').text('获取短信效验码').css('backgroundColor', '#fff');
                    $('.zheng').css('display', 'none');
                    $('.cuo').css('display', 'none');
                } else {
                    _this.text('重新发送(' + count + ')');
                }
                $('.zheng').children('span').text(count);
            }, 1000);
        });
        //input获取焦点框变颜色
        $('.shoujiH input,.zhongjian input').focus(function () {
            $(this).css('borderColor', '#d25174');
        });
        $('.shoujiH input,.zhongjian input').blur(function () {
            $(this).css('borderColor', '#ccc');
        });
        //点击提交按钮
        $('.box form>input').click(function () {
            if ($('.shoujiH').css('display') == 'block') {
                if ($('.shoujiH>input').val().length != 4) {
                    $('.zheng').css('display', 'none');
                    $('.cuo').css('display', 'block');
                    return false;
                } else {

                }
            } else {
                if ($('.zhongjian>input').val().length != 4) {
                    $('.zhongjian p').css('display', 'block');
                    return false;
                } else {

                }
            }
        })
        @if(session("msg"))
            layer.msg("{{session("msg")}}");
            @endif
    </script>
    @endsection