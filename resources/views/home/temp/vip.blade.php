@extends("home.layout.layout")
@section("title","会员充值")
@section("css")
    <link rel="stylesheet" href="{{asset("home/css/temp/memberRecharge.css")}}">

@endsection

@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="">首页</a>/<span>会员充值</span></p>
    </div>
    <!--内容-->
    <div class="coon">
        <h3>支持储蓄卡和信用卡，需要开通网银</h3>
        <ul class="clear">
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-nongye.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-zhaoshang.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-pufa.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-zhongxin.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-gongshang.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-jianshe.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-youzheng.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-minsheng.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-xingye.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-zhongguo.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-jiaotong.png')}}" alt="">
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="bank">
                    <img src="{{asset('home/images/temp/P-guangfa.png')}}" alt="">
                </label>
            </li>
        </ul>
        <form>
            <label for="hao">银行卡号 : </label>
            <input type="text" id="hao" placeholder="请输入卡号">
        </form>
        <p>下一步</p>
    </div>
@endsection
@section("js")
    <script>
        $('.coon>p').click(function () {
            layer.msg('充值系统维护中,给您带来的不变,敬请谅解～');
        })
    </script>
@endsection
