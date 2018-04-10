@extends("home.layout.layout")
@section("title","找回密码")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/password/forgot.css')}}">
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
                <img src="{{asset('home/images/login/youjian.pn')}}g" alt="">
            </a>
        </div>
    </div>
    <p class="dange">
        <img src="{{asset('home/images/login/tanhao.png')}}" alt="">
        <span>请输入您注册时预留的手机号</span>
    </p>
    <p class="forgot-Jin">
        <img src="{{asset('home/images/login/forgot-One.png')}}" alt="">
    </p>
    <form class="for-f" method="post" action="{{url('forgetPasssowrd/setPwd')}}">
        <label>
            <input id="for-tel" type="text" value="{{session('info')['username']}}" name="username" placeholder="请输入手机号"
                   maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'')"
                   onafterpaste="this.value=this.value.replace(/\D/g,'')">
            <span>
            <img src="{{asset('home/images/login/zhanghu.png')}}" alt="">
        </span>
        </label>
        @if(session("userNameError"))
            <p class="for-td" style="display: block">
                <img src="{{asset('home/images/login/huiti.png')}}" alt="">
                <span>{{session("userNameError")}}</span>
            </p>
        @else
            <p class="for-td">
                <img src="{{asset('home/images/login/huiti.png')}}" alt="">
                <span></span>
            </p>
        @endif
        <label>
            <input id="for-yan" type="text" value="{{session('info')['code']}}" name="code" placeholder="请输入验证码"
                   onkeyup="this.value=this.value.replace(/\D/g,'')"
                   onafterpaste="this.value=this.value.replace(/\D/g,'')">
            <span>
            <img src="{{asset('home/images/login/dian.png')}}" alt="">
        </span>
            <input class="for-huo" type="button" value="获取验证码" onclick="settime(this)">
        </label>
        @if(session("codeInfo"))
            <p class="for-yt" style="display: block">
                <img src="{{asset('home/images/login/huiti.png')}}" alt="">
                <span>{{session("codeInfo")}}</span>
            </p>
        @else
            <p class="for-yt">
                <img src="{{asset('home/images/login/huiti.png')}}" alt="">
                <span></span>
            </p>
        @endif
        <input type="submit" value="提交">
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
        $('.for-f>input').click(function () {
            var fTel = $('#for-tel').val().length,
                fYan = $('#for-yan').val().length;
            if (fTel == 0) {
                $('.for-td').css('display', 'block').children('span').text('请输入手机号!');
                return false;
            } else if (fTel != 11) {
                $('.for-td').css('display', 'block').children('span').text('请输入正确的手机号!');
                return false;
            } else if (fTel == 11 && fYan == 0) {
                $('.for-yt').css('display', 'block').children('span').text('请输入短信验证码!');
                return false;
            } else if (fTel == 11 && fYan != 4) {
                $('.for-yt').css('display', 'block').children('span').text('请输入正确的短信验证码!');
                return false;
            } else {
//            请输入正确的短信验证码！
                $('.for-td,.for-yt').css('display', 'none');
                return true;
            }
        });
        //获取验证码倒计时
        var countdown = 120,flag = true;
        function settime(obj) {
            if ($('#for-tel').val().length == 11) {
                $('.for-td').css('display', 'none').children('span').text('');
                if (obj.getAttribute('disabled') == null) {
                    var phone = $('#for-tel').val();
                    $.ajax({
                        url: "{{url('forgetPasssowrd/sendMessage')}}",
                        type: "post",
                        async: false,
                        data: {"phone": phone},
                        success: function (res) {
                            if (res.err != 200) {
                                layer.msg(res.msg);
                                obj.style.backgroundColor = '#980c3f';
                                obj.removeAttribute("disabled");
                                obj.value = "获取验证码";
                                countdown = 120;
                                flag = false;
                                console.log(res)
                            } else {
                                layer.msg(res.msg);
                                flag = true;
                            }
                        }
                    });
                }
                if(flag){
                    if (countdown == 0) {
                        obj.style.backgroundColor = '#980c3f';
                        obj.removeAttribute("disabled");
                        obj.value = "获取验证码";
                        countdown = 120;
                        return;
                    } else {
                        obj.style.backgroundColor = '#ccc';
                        obj.setAttribute("disabled", true);
                        obj.value = "重新发送(" + countdown + ")";
                        countdown--;
                    }
                    console.log(2)
                    setTimeout(function () {
                        settime(obj)
                    }, 1000)
                }
            } else if ($('#for-tel').val().length == 0) {
                $('.for-td').css('display', 'block').children('span').text('请输入手机号!');
                return false;
            } else {
                $('.for-td').css('display', 'block').children('span').text('格式不正确，请您输入正确的手机号码!');
                return false;
            }
        }
    </script>
@endsection