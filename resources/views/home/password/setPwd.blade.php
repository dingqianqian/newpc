@extends("home.layout.layout")
        @section("title","设置新密码")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/password/forgotTwo.css')}}">
        @endsection
@section("content")
<div class="goB">
    <div class="find-con">
        <a class="shou" href="{{url('/')}}">
            <img src="{{asset('home/images/login/logo.png')}}" alt="">
        </a>
        <span>找回密码</span>
        <a class="goS" href="{{url('/')}}">
            <span>返回首页</span>
            <img src="{{asset('home/images/login/youjian.png')}}" alt="">
        </a>
    </div>
</div>
<p class="dange">
    <img src="{{asset('home/images/login/tanhao.png')}}" alt="">
    <span>请您输入6-16位的登录密码</span>
</p>
<p class="forgot-Jin">
    <img src="{{asset('home/images/login/forgotTwo.png')}}" alt="">
</p>
<div class="for-shi">
    <img src="{{asset('home/images/login/heng.png')}}" alt="">
    <span></span>
</div>
<form class="for-f" method="post" action="{{url('forgetPasssowrd/success')}}">
    <label>
        <input id="for-tel" maxlength="16" name="password" type="password" placeholder="请输入新密码" onkeyup="checkPwdStrong(this)">
        <span>
            <img src="{{asset('home/images/login/mimi.png')}}" alt="">
        </span>
        <i>
            <img src="{{asset('home/images/login/duihao.png')}}" alt="">
        </i>
    </label>
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
    <label>
        <input id="for-yan" maxlength="16" type="password" name="password_confirmation" placeholder="再次输入密码" onkeyup="againCheck(this)">
        <span>
            <img src="{{asset('home/images/login/mimi.png')}}" alt="">
        </span>
        <i>
            <img src="{{asset('home/images/login/duihao.png')}}" alt="">
        </i>
    </label>
    <input type="submit" value="提交" id="two-Ti">
    {{csrf_field()}}
</form>
@endsection
@section("js")
    <script type="text/javascript">
        $('#for-tel,#for-yan').focus(function () {
            $(this).css('borderColor', '#b25174');
        });
        $('#for-tel,#for-yan').blur(function () {
            $(this).css('borderColor', '#ccc');
        });
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
        //再次输入密码
        function againCheck(_this) {
            var value = _this.value;
            if (value.length >= 6) {
                $(_this).parent().children('i').css('display', 'block');
            } else {
                $(_this).parent().children('i').css('display', 'none');
            }
        }
        $('input[type="password"]').blur(function () {
            $('.for-shi').css('opacity', '0').children('span').text('');
        });
        $('#two-Ti').click(function () {
            var toM = $('#for-tel').val(),
                boM = $('#for-yan').val();
            if (toM.length == 0 && boM.length == 0) {
                $('.for-shi').css('opacity', '1').children('span').text('请输入密码');
                return false;
            } else if ((toM == boM) && (boM.length < 6 || boM.length > 16)) {
                $('.for-shi').css('opacity', '1').children('span').text('请您输入6-16位的登录密码');
                return false;
            } else if ((toM != boM)) {
                $('.for-shi').css('opacity', '1').children('span').text('两次密码输入不一致');
                return false;
            } else {
                return true;
            }
        });

    </script>
    @endsection