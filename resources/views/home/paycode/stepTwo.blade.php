@extends("home.layout.layout")
        @section("title","支付密码管理")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/paycode/zhifuTwo.css')}}">
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
            <img src="{{asset('home/images/safe/zhongTwo.png')}}" alt="">
            <form method="post" action="{{url('safe/paycode/success')}}">
                <label class="one">
                    <span>设置6位数字密码 : </span>
                    <input maxlength="6" name="paycode" onkeyup="this.value=this.value.replace(/\D/g,'')"
                           onafterpaste="this.value=this.value.replace(/\D/g,'')" onfocus="this.type='password'">
                    <div>
                        <p>支付密码格式不正确，请重新设置</p>
                    </div>
                </label>
                <label class="two">
                    <span>确认6位数字密码 : </span>
                    <input maxlength="6" name="paycode_confirmation" onkeyup="this.value=this.value.replace(/\D/g,'')"
                           onafterpaste="this.value=this.value.replace(/\D/g,'')" onclick="this.type='password'">
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
        $('.box form>input').click(function () {
            var a = $('.box .one input').val(),
                b = $('.box .two input').val();
            if (a.length != 6) {
                $('.box .one p').css('display', 'block');
                $('.box .two p').css('display', 'none');
                return false;
            } else if (a.length == 6 && a != b) {
                $('.box .one p').css('display', 'none');
                $('.box .two p').css('display', 'block');
                return false;
            } else if (a.length == 6 && a == b) {

            }
        });
        //点击input改变框的颜色
        $('label input').focus(function () {
            $(this).css('borderColor', '#d25174');
        });
        $('label input').blur(function () {
            $(this).css('borderColor', '#ccc');
        })
    </script>
    @endsection
