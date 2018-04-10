@extends("home.layout.layout")
@section("title","登录")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/login/login.css')}}">
    {{--<script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 1339 * 100 + 'px';
    </script>--}}
@endsection
@section("content")
    <div class="logLine"></div>
    <div class="title">
        <a href="{{url('/')}}">
            <img src="{{asset('home/images/login/logo.png')}}" alt="">
        </a>
        <span>欢迎登录</span>
    </div>
    <div class="work">
        <img src="{{asset('home/images/login/logBack.jpg')}}" alt="">
        <form action="{{url('check')}}" method="post">
            @if(session("msg"))
                <p class="tit">账户登录</p>
                <p id="tishi" style="display: block;">
                    <img src="{{asset('home/images/login/heng.png')}}" alt="">
                    <span>{{session("msg")}}</span>
                </p>
            @else
                <p class="tit">账户登录</p>
                <p id="tishi">
                    <img src="{{asset('home/images/login/heng.png')}}" alt="">
                    <span>1</span>
                </p>
            @endif
            <label for="tel">
                <input id="tel" type="text" name="username" placeholder="请输入手机号" maxlength="11"
                       onkeyup="this.value=this.value.replace(/\D/g,'')"
                       onafterpaste="this.value=this.value.replace(/\D/g,'')">
                <span>
                <img src="{{asset('home/images/login/zhanghu.png')}}" alt="">
            </span>
                <i></i>
            </label>
            <label for="mima">
                <input id="mima" onfocus="this.type='password'" name="password" placeholder="请输入6-16位密码">
                <span>
                <img src="{{asset('home/images/login/mima.png')}}" alt="">
            </span>
            </label>
            <a style="float:left;margin-left: 20px;" href="{{url('register')}}">
                <img style="width: .1rem;height: .1rem;" src="{{asset('home/images/login/zhuce.png')}}" alt="">
                <span>免费注册</span>
            </a>
            <a href="{{url('forgetPasssowrd/index')}}">忘记密码?</a>
            <input class="clear deng" type="submit" onclick="return fun1();" value="登录">
            <div class="weixin">
                {{--<a href="javascript:;">
                    <img src="{{asset('home/images/login/weixin.png')}}" alt="">
                    <span>微信</span>
                </a>--}}
                {{--<a href="{{url('register')}}">
                    <img style="width: .1rem;height: .1rem;" src="{{asset('home/images/login/zhuce.png')}}" alt="">
                    <span>免费注册</span>
                </a>--}}
            </div>
            {{csrf_field()}}
        </form>
    </div>
@endsection
@section("js")
    <script>
        $('#blur').focus(function () {
            $(this).css('borderColor', '#b25174');
        });
        $('label>input').blur(function () {
            $(this).css('borderColor', '#ccc');
        });
        $('#tel').focus(function () {
            $(this).css('borderColor', '#b25174');
            if ($(this).val().length != 0) {
                $('.work form label > i').css('display', 'block').click(function () {
                    $(this).parent().find('#tel').val('');
                });
            } else {
                $('.work form label > i').css('display', 'none');
            }
        });
        $('#tel').keyup(function () {
            if ($(this).val().length != 0) {
                $('.work form label > i').css('display', 'block').click(function () {
                    $(this).parent().find('#tel').val('');
                });
            } else {
                $('.work form label > i').css('display', 'none');
            }
        });
        /*$('#tel,#mima').blur(function () {
         $('#tishi').css('display', 'none').children('span').text('');
         });*/
        //点击登录出现提示语
        /* $('.deng').click(function () {
         var te = $('#tel').val().length,
         mi = $('#mima').val().length;
         if (te == 0 && mi == 0) {
         $('#tishi').css('display', 'block').children('span').text('请输入用户名和密码!');
         } else if (te == 0 && mi != 0) {
         $('#tishi').css('display', 'block').children('span').text('请输入用户名!');
         } else if (te != 0 && mi == 0) {
         $('#tishi').css('display', 'block').children('span').text('请输入密码!');
         } else if (te != 11 && mi != 0) {
         $('#tishi').css('display', 'block').children('span').text('用户名不存在，请重新输入!');
         } else {
         //            用户名与密码不匹配，请重新输入!
         }
         });*/
        function fun1() {
            var te = $('#tel').val().length,
                mi = $('#mima').val().length;
            if (te == 0 && mi == 0) {
                $('#tishi').css('display', 'block').children('span').text('请输入用户名和密码!');
                return false;
            } else if (te == 0 && mi != 0) {
                $('#tishi').css('display', 'block').children('span').text('请输入用户名!');
                return false;
            } else if (te != 0 && mi == 0) {
                $('#tishi').css('display', 'block').children('span').text('请输入密码!');
                return false;
            } else if (te != 11 && mi != 0) {
                $('#tishi').css('display', 'block').children('span').text('用户名不存在，请重新输入!');
                return false;
            } else if (!/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17[0-9])|(18[0-9]))\d{8}$/.test($('#tel').val())) {
                $('#tishi').css('display', 'block').children('span').text('用户名不存在，请重新输入!');
                return false;
            } else {
                //            用户名与密码不匹配，请重新输入!
                return true;
            }
        }
    </script>
@endsection