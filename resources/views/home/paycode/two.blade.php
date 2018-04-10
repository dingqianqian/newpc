@extends("home.layout.layout")
        @section("title","设置支付密码")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/paycode/zhaoer.css')}}">
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
    <div class="tStepCon">
        <div class="zhaoJin">
            <img src="{{asset('home/images/paycode/zhaoTwo.png')}}" alt="">
        </div>
        <form class="erFor" action="{{url('paycode/success')}}" method="post">
            <div class="erGroup">
                <label for="eTop">请输入新密码 : </label>
                <input onclick="this.type='password'" name="paycode" id="eTop" maxlength="6" minlength="6" onkeyup="this.value=this.value.replace(/\D/g,'')"
                       onafterpaste="this.value=this.value.replace(/\D/g,'')">
            </div>
            <p class="erP">
                <img src="{{asset('home/images/paycode/huiti.png')}}" alt="">
                <span>请输入6位完整的支付密码</span>
            </p>
            <div class="erGroup">
                <label for="eBot">请确认密码 : </label>
                <input onclick="this.type='password'" name="paycode_confirmation " id="eBot" maxlength="6" minlength="6" onkeyup="this.value=this.value.replace(/\D/g,'')"
                       onafterpaste="this.value=this.value.replace(/\D/g,'')">
            </div>
            <p class="erB">
                <img src="{{asset('home/images/paycode/huiti.png')}}" alt="">
                <span>请再次输入密码</span>
            </p>
            {{csrf_field()}}
            <input type="submit" value="确认提交">
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
        $('#eTop,#eBot').focus(function () {
            $(this).css('borderColor', '#b25174');
        });
        $('#eTop,#eBot').blur(function () {
            $(this).css('borderColor', '#ccc');
        });
        $('#eTop').focus(function () {
            $('.erP img').attr('src', "{{asset('home/images/paycode/huiti.png')}}");
            $('.erP span').text('请输入6位完整的支付密码').css('color', '#999');
            $('.erP').css('display', 'block');
        });
        $('#eTop').blur(function () {
            $('.erP').css('display', 'none');
        });
        $('#eBot').focus(function () {
            $('.erB img').attr('src', "{{asset('home/images/paycode/huiti.png')}}");
            $('.erB span').text('请再次输入密码').css('color', '#999');
            $('.erB').css('display', 'block');
        });
        $('#eBot').blur(function () {
            $('.erB').css('display', 'none');
        });
        $('.erFor>input').click(function () {
            var eTo = $('#eTop').val(),
                eBo = $('#eBot').val();
            if (eTo.length != 6) {
                $('.erP img').attr('src', "{{asset('home/images/paycode/heng.png')}}");
                $('.erP span').text('密码长度不正确，请重新设置').css('color', '#eb0303');
                $('.erP').css('display', 'block');
                return false;
            } else if (eTo.length == 6 && eBo.length != 6) {
                $('.erB img').attr('src', "{{asset('home/images/paycode/heng.png')}}");
                $('.erB span').text('两次输入的密码不一致，请重新输入').css('color', '#eb0303');
                $('.erB').css('display', 'block');
                return false;
            } else {
                return true;
            }

        })
        @if(session("msg"))
         layer.msg("{{session('msg')}}");
        @endif
    </script>
    @endsection