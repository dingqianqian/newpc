@extends("home.layout.layout")
        @section("title","修改信息")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/person/jiben.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>个人信息</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <ul class="clear">
            <li class="sec">基本信息</li>
            {{--<li>头像照片</li>--}}
        </ul>
        <div class="conI">
            <div class="sec">
                <form class="basic" method="post" action="{{url("person/update")}}">
                    <div class="group1">
                        <span><i>*</i>用户名 : </span>
                        <input name="username" value="{{$userInfo['username']}}" type="text" placeholder="请输入用户名">
                        <p>
                            <i></i>
                            <span>请输入正确的用户名格式</span>
                        </p>
                    </div>
                    <div class="group2">
                        <span><i>*</i>性别 : </span>
                        <input type="radio" name="sex" @if($userInfo["sex"]==1) checked="true" @endif name="sex" value="1" checked>
                        <i>男</i>
                        <input type="radio" name="sex" @if($userInfo["sex"]==0) checked="true" @endif name="sex" value="0">
                        <i>女</i>
                    </div>
                    <div class="group3">
                        <span><i>*</i>生日 : </span>
                        <select id="select_year" name="year" rel="{{date("Y",$userInfo['birthday'])}}"></select>年
                        <select id="select_month" name="month" rel="{{date("m",$userInfo['birthday'])}}" style="margin-left:16px;"></select>月
                        <select id="select_day" name="day" rel="{{date("d",$userInfo['birthday'])}}" style="margin-left:16px;"></select>日
                    </div>
                    <p>请选择您感兴趣的分类，给您最精准的推荐</p>
                    <div class="group4">
                        <span>消费偏好 : </span>
                        <p>
                            @foreach($resarchInfo as $k=>$v)
                                @if($v['group']==1)
                            <label>
                                <input type="checkbox" name="likes[]" value="{{$v['id']}}">
                                <span>{{$v['name']}}</span>
                            </label>
                                @endif
                                @endforeach
                        </p>
                    </div>
                    <div class="group5">
                        <span>吸引您的消费方式 : </span>
                        <p>
                            @foreach($resarchInfo as $k=>$v)
                                @if($v['group']==2)
                                    <label>
                                        <input type="checkbox" name="likes[]" value="{{$v['id']}}">
                                        <span>{{$v['name']}}</span>
                                    </label>
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <div class="group6">
                        <span>影响您作出购买决策的因素 : </span>
                        <p>
                            @foreach($resarchInfo as $k=>$v)
                                @if($v['group']==3)
                                    <label>
                                        <input type="checkbox" name="likes[]" value="{{$v['id']}}">
                                        <span>{{$v['name']}}</span>
                                    </label>
                                @endif
                            @endforeach
                        </p>
                    </div>
                    {{csrf_field()}}
                    <input type="submit" class="保存信息">
                </form>
            </div>
            {{--<div>
                <form class="touF">
                    <p>
                        <b></b>
                        <span>选择您要上传的头像</span>
                        <input type="file" accept="image/jpeg" id="up">
                    </p>
                    <div class="outeF">
                        <p>
                            <b></b>
                            <span>无法上传，因为您的图片过大，请上传小于3M的图片</span>
                        </p>
                    </div>
                    <h4>仅支持JPG格式，文件小于3M</h4>
                    <img src="img/logo.png" alt="" id="ImgPr">
                    <h5>推荐头像</h5>
                    <ul class="clear">
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                        <li>
                            <img src="img/logo.png" alt="">
                        </li>
                    </ul>
                    <input type="submit" value="提交">
                </form>
            </div>--}}
        </div>
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript" src="{{asset('home/js/person/birthday.js')}}"></script>
    <script type="text/javascript" src="{{asset('home/js/person/uploadView.js')}}"></script>
    <script>
        //    上传头像
        $(function () {
            $("#up").uploadPreview({Img: "ImgPr", Width: 173, Height: 173});
        });
        //    生日选择
        $(function () {
            $.ms_DatePicker({
                YearSelector: "#select_year",
                MonthSelector: "#select_month",
                DaySelector: "#select_day"
            });
        });
        //选中北京颜色改变
        $('label>input').click(function () {
            $(this).parent().toggleClass('dian');
        });
        //    选项卡
        $('.tStepCont>ul>li').click(function () {
            $('.tStepCont>ul>li,.conI>div').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            $('.conI>div').eq($(this).prevAll().length).addClass('sec');
        })
    </script>
    @endsection