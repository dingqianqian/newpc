@extends("home.layout.layout")
@section("title","加盟合作")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/join/joinIn.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>加盟合作</span></p>
    </div>
    <div class="oStep clear">
        <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <!--右侧内容-->
        <div class="tStepCont">
            <img src="{{asset('home/images/join/backJoin.jpg')}}" alt="">
            <div class="box">
                <div class="list">
                    <ul>
                        {{--<li class="p7"><a href="#"><img src="{{asset('home/images/join/1.jpg')}}" alt=""/></a></li>--}}
                        <li class="p6"><a href="javascript:;"><img src="{{asset('home/images/join/3.jpg')}}"
                                                                   alt=""/></a></li>
                        <li class="p5"><a href="javascript:;"><img src="{{asset('home/images/join/2.jpg')}}"
                                                                   alt=""/></a></li>
                        <li class="p4"><a href="javascript:;"><img src="{{asset('home/images/join/1.jpg')}}"
                                                                   alt=""/></a></li>
                        <li class="p3"><a href="javascript:;"><img src="{{asset('home/images/join/3.jpg')}}"
                                                                   alt=""/></a></li>
                        <li class="p2"><a href="javascript:;"><img src="{{asset('home/images/join/2.jpg')}}"
                                                                   alt=""/></a></li>
                        <li class="p1"><a href="javascript:;"><img src="{{asset('home/images/join/1.jpg')}}"
                                                                   alt=""/></a></li>
                    </ul>
                </div>
                <a href="javascript:;" class="prev btn">
                    <img src="{{asset('home/images/join/zuo.png')}}" alt="">
                </a>
                <a href="javascript:;" class="next btn">
                    <img src="{{asset('home/images/join/you.png')}}" alt="">
                </a>
            </div>
            <p class="jieshao">
                <img src="{{asset('home/images/join/diqiu.png')}}" alt="">
                <span>公司的既定战略是--公司的既定战略是——以阿拉丁资本为息壤，在未来3~5年衍生出集电商、物流快递、纸业、布草、制浆、生物医药、有机农业、无人机、家用/商用工业机器人、文化传媒、投资等产业为一体的大型企业集团，形成一个拥有主体公司和8~10个全资子公司、参股公司，实现成为跨地区、跨行业的、基本符合现代企业制度要求的大型企业集团。</span>
            </p>
            <p class="telJ">
                <img src="{{asset('home/images/join/joinTel.png')}}" alt="">
                <span>联系电话 : 40018-11121</span>
            </p>
        </div>
    </div>
@endsection
@section("js")
    <script type="text/javascript">
        var cArr = ["p6", "p5", "p4", "p3", "p2", "p1"];
        var index = 0;
        $(".next").click(
            function () {
                nextimg();
            }
        );
        $(".prev").click(
            function () {
                previmg();
            }
        );
        //上一张
        function previmg() {
            cArr.unshift(cArr[5]);
            cArr.pop();
            $(".list li").each(function (i, e) {
                $(e).removeClass().addClass(cArr[i]);
            });
            index--;
            if (index < 0) {
                index = 5;
            }
        }

        //下一张
        function nextimg() {
            cArr.push(cArr[0]);
            cArr.shift();
            $(".list li").each(function (i, e) {
                $(e).removeClass().addClass(cArr[i]);
            });
            index++;
            if (index > 5) {
                index = 0;
            }
        }
        //点击class为p2的元素触发上一张照片的函数
        $(document).on("click", ".p2", function () {
            previmg();
            return false;//返回一个false值，让a标签不跳转
        });

        //点击class为p4的元素触发下一张照片的函数
        $(document).on("click", ".p4", function () {
            nextimg();
            return false;
        });

        //			鼠标移入box时清除定时器
        $(".box").mouseover(function () {
            clearInterval(timer);
        });

        //			鼠标移出box时开始定时器
        $(".box").mouseleave(function () {
            timer = setInterval(nextimg, 4000);
        });

        //			进入页面自动开始定时器
        timer = setInterval(nextimg, 4000);
    </script>
@endsection