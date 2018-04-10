@extends("home.layout.layout")
@section("title","修改验证手机第二步")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/password/xiuThr.css')}}">
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
                <li><a href="{{url('safe/paycode/checkInfo')}}">支付密码管理</a></li>
                <li><a href="{{url('safe/username/stepOne')}}" class="sec">修改验证手机</a></li>
            </ul>
            <div class="box">
                <img src="{{asset('home/images/safe/xiuTwo.png')}}" alt="">
                <form action="{{url('safe/username/stepThr')}}" method="post">
                    <label class="zhongjian" style="padding-left:230px;">
                        <span>我的手机号 : </span>
                        <input style="letter-spacing: normal;" type="text" id="phone" name="phone" maxlength="11"
                               onkeyup="this.value=this.value.replace(/\D/g,'')"
                               onafterpaste="this.value=this.value.replace(/\D/g,'')">
                        <div>
                            <p>请输入正确手机号码格式</p>
                        </div>
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
                    {{csrf_field()}}
                    <input type="submit" value="提交">
                </form>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript">
        var count = 120, timer = null;
        $('.shoujiH button').click(function () {
            var a = $("#phone").val();
            var _this = $(this);
            if (!/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17[0-9])|(18[0-9]))\d{8}$/.test(a)) {
                $('.zhongjian>div>p').css('display', 'block');
            } else {
                $('.zhongjian>div>p').css('display', 'none');
                var flag = true;
                $.ajax({
                    url: "{{url('safe/username/code')}}",
                    type: "post",
                    async: false,
                    data: {phone: a},
                    success: function (res) {
                        if (res.err != 200) {
                            layer.msg(res.msg);
                            flag = false;
                            return false;
                        }
                    }
                });
                if(flag){
                    _this.attr('disabled', 'disabled').text('重新发送(' + count + ')').css('backgroundColor', '#ccc');
                    $('.zheng').css('display', 'block');
                    $('.cuo').css('display', 'none');
                    timer = setInterval(function countDown() {
                        count--;
                        if (count == 0) {
                            clearInterval(timer);
                            count = 120;
                            _this.removeAttr('disabled').text('获取短信效验码').css('backgroundColor', '#fff');
                            $('.zheng').css('display', 'none');
                            $('.cuo').css('display', 'none');
                        } else {
                            _this.text('重新发送(' + count + ')');
                        }
                        $('.zheng').children('span').text(count);
                    }, 1000);
                }
            }
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
            var a = $('.box form .zhongjian>input').val(),
                b = $('.box form .shoujiH>input').val();
            if(!/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(17[0-9])|(18[0-9]))\d{8}$/.test(a)){
                $('.zhongjian>div>p').css('display', 'block');
                return false;
            } else if (b.length != 4) {
                $('.zheng').css('display', 'none');
                $('.cuo').css('display', 'block');
                return false;
            } else {

            }
        });
        @if(session("msg"))
            layer.msg("{{session("msg")}}");
        @endif
    </script>
@endsection