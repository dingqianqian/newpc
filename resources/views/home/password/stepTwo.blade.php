@extends("home.layout.layout")
        @section("title","设置支付密码")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/password/dengTwo.css')}}">
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
            <li><a class="sec" href="{{url('safe/password/stepOne')}}">修改登录密码</a></li>
            <li><a href="{{url('safe/paycode/checkInfo')}}">支付密码管理</a></li>
            <li><a href="{{url('safe/username/stepOne')}}"">修改验证手机</a></li>
        </ul>
        <div class="box">
            <img src="{{asset('home/images/safe/dengTwo.png')}}" alt="">
            <form action="{{url('safe/password/stepThr')}}" method="post">
                <label class="one">
                    <span>请输入新密码 : </span>
                    <input onkeyup="checkPwdStrong(this.value)" name="password" onfocus="this.type='password'" maxlength="16">
                    <div>
                        <p>密码长度为6-16个字符，请重新设置</p>
                        <ul>
                            <li>
                                <img src="{{asset('home/images/safe/ruo.png')}}" alt="">
                                <span>有被盗风险,建议使用字母、数字和符号两种及以上组合</span>
                            </li>
                            <li>
                                <img src="{{asset('home/images/safe/zhong.png')}}" alt="">
                                <span>安全强度适中,可以使用三种以上的组合来提高安全强度</span>
                            </li>
                            <li>
                                <img src="{{asset('home/images/safe/qiang.png')}}" alt="">
                                <span>你的密码很安全</span>
                            </li>
                        </ul>
                    </div>
                </label>
                <label class="two" style="padding-left:312px;">
                    <span>请确认密码 : </span>
                    <input onfocus="this.type='password'" name="password_confirmation" maxlength="16">
                    <div>
                        <p>两次输入的密码不一致，请重试</p>
                    </div>
                </label>
                {{csrf_field()}}
                <input value="提交" type="submit">
            </form>
        </div>
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        //点击input改变框的颜色
        $('label input').focus(function () {
            $(this).css('borderColor', '#d25174');
        });
        $('label input').blur(function () {
            $(this).css('borderColor', '#ccc');
        });
        //onkeyup
        function checkPwdStrong(pwd) {
            var element = $(".tStepCont .box form label div ul");
            var value = pwd;
            if (value.length >= 6) {
                element.show();
                $('.box form .one>div>p').hide();
                var level = pwdLevel(value);
                switch (level) {
                    case 1:
                        element.children('li').eq(0).show().siblings('li').hide();
                        break;
                    case 2:
                        element.children('li').eq(1).show().siblings('li').hide();
                        break;
                    case 3:
                        element.children('li').eq(2).show().siblings('li').hide();
                        break;
                    default:
                        break;
                }
            } else {
                element.hide();
            }
        }
        function pwdLevel(value) {
            var pattern_1 = /^.*([\W_])+.*$/i;
            var pattern_2 = /^.*([a-zA-Z])+.*$/i;
            var pattern_3 = /^.*([0-9])+.*$/i;
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
        //点击提交出现提示框
        $('.box form>input').click(function () {
            var a = $('.box form .one>input').val(),
                b = $('.box form .two>input').val()
            if (a.length < 6) {
                $('.box form .one>div>p').show();
                return false;
            } else if (a.length >= 6 && a != b) {
                $('.box form .one>div>p').hide();
                $('.box form .two>div>p').show();
                return false;
            } else if (a.length > 6 && a == b) {

            }
        })
    </script>
@endsection