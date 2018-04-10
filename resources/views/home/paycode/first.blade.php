@extends("home.layout.layout")
        @section("title","验证身份")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/paycode/oneSteps.css')}}">
        @endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>安全设置</span></p>
</div>
<div class="oStep clear">
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <div class="oStepCon">
        <div class="zhaoJin">
            <img src="{{asset('home/images/paycode/zhaoOne.png')}}" alt="">
        </div>
        <form class="low" action="" method="post" autocomplete="off">
            <div class="zGroup" style="margin-bottom: 24px;">
                <label for="xuan">请选择验证身份方式 : </label>
                <select name="type" id="xuan">
                    <option value="0">使用(尾号<span>{{substr(session("userInfo")['signin_name'],7,4)}}</span>)的手机验证</option>
                    <option value="1">验证身份信息</option>
                </select>
            </div>
            <div class="contax">
                <div class="zGroup" style="margin-bottom: 24px;">
                    <label for="hao">已验证手机 : </label>
                    <p id="hao"><i>{{substr_replace(session("userInfo")['signin_name'],"****",3,4)}}</i></p>
                </div>
                <div class="zGroup" style="margin-bottom: 36px;">
                    <label for="yuZ" style="vertical-align: middle;">请填写手机校检码 : </label>
                    <input id="yuZ"  name="code" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" type="text" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                    <input id="huoquMes" type="button" value="获取短信效验码" onclick="settime(this)">
                </div>
                <p class="zhu">
                    <span>效验码已发出,请注意查收短信,如果还没有收到,你可以在<i>118</i>秒后要求重新发送</span>
                </p>
                <p class="zhuu">
                    <img src="{{asset('home/images/paycode/heng.png')}}" alt="">
                    <span>效验码已发出,请注意查收短信,如果还没有收到,你可以在秒后要求重新发送</span>
                </p>
                <div class="zGroup" style="margin-bottom: 108px;">
                    <label for="yaZ">请输入验证码 : </label>
                    <input id="yaZ" name="captcha" type="text" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                    <div class="you">
                        <img id="code" src="{{captcha_src()}}" alt="" onclick="fun1()">
                        <p>看不清？<span onclick="fun1()">换一张</span></p>
                    </div>
                </div>
                <input id="zhaoTij" type="submit" value="提交">
            </div>
            <div class="hideCon">
                <div class="zGroup" style="position: relative;">
                    <label for="mid">请输入您手机号码的中间4位 : </label>
                    <input id="mid" name="phone" onclick="this.type='password'" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')"
                           onafterpaste="this.value=this.value.replace(/\D/g,'')">
                    <p>
                        <img src="{{asset('home/images/paycode/heng.png')}}" alt="">
                        <span>您输入的手机号码有误，确认后重新输入</span>
                    </p>
                </div>
                <input id="hideTij" type="submit" value="提交">
            </div>
            {{csrf_field()}}
        </form>
        <div id="dibu">
            <h5>为什么要进行身份验证？</h5>
            <p>为保障您的账户信息安全，在变更账户中的重要信息时需要进行身份验证，感谢您的理解和支持</p>
        </div>
    </div>
</div>
    @endsection
@section("js")
<script type="text/javascript">
    $('#yuZ,#yaZ,#mid').focus(function () {
        $(this).css('borderColor', '#b25174');
    });
    $('#yuZ,#yaZ,#mid').blur(function () {
        $(this).css('borderColor', '#ccc');
    });
    //点击获取验证码
    var countdown = 120,flag=true;
    function settime(obj) {
        if (obj.getAttribute('disabled') == null) {
                $.ajax({
                    url:"{{url('paycode/sendMessage')}}",
                    type:'post',
                    async:false,
                    success:function (res) {
                        if(res.err==200)
                        {
                            layer.msg("发送短信验证码成功,请注意查收");
                            flag=true;
                        }else
                            {
                                layer.msg(res.msg);
                                obj.style.backgroundColor = '#fff';
                                obj.removeAttribute("disabled");
                                $('.zhu').css('display', 'none');
                                countdown = 120;
                                flag = false;
                            }
                    }
                });
        }
        if(flag){
            if (countdown == 0) {
                obj.style.backgroundColor = '#fff';
                obj.removeAttribute("disabled");
                $('.zhu').css('display', 'none');
                countdown = 120;
                return;
            } else {
                obj.style.backgroundColor = '#ccc';
                obj.setAttribute("disabled", true);
                $('.zhu').css('display', 'block').find('i').text(countdown);
                countdown--;
            }
            setTimeout(function () {
                settime(obj)
            }, 1000)
        }
    }
    //监听select值改变
    $('#xuan').change(function () {
        if ($('#xuan').val() == 1) {
            $('.contax').css('display', 'none');
            $('.hideCon').css('display', 'block');
        } else {
            $('.contax').css('display', 'block');
            $('.hideCon').css('display', 'none');
        }
    });
    function fun1() {
        var src=$("#code").attr("src","{{captcha_src()}}");
    }
    @if(session("msg"))
        layer.msg('{{session("msg")}}');
        @endif
</script>
@endsection