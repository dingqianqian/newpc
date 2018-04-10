@extends("home.layout.layout")
        @section("title","新闻列表")
        @section("css")
            <link rel="stylesheet" href="{{asset("home/css/new/newList.css")}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>新闻列表</span></p>
</div>
<div class="newB">
    <img src="{{asset("home/images/new/newList.png")}}" alt="">
</div>
<div class="newTit">
    <img src="{{asset("home/images/new/newTit.png")}}" alt="">
</div>
<ul class="newL">
    @foreach($newsInfo as $k=>$v)
        <li>
            <a href="{{$v['url']}}/{{$v['id']}}">
                <img src="{{asset("home/images/new/xiaoshou.png")}}" alt="">
                <span>{{$v['title']}}</span>
                <span>{{date("Y-m-d",$v['add_time'])}}</span>
            </a>
        </li>
    @endforeach
    <li>
        <a href="{{url('new/8')}}">
            <img src="{{asset("home/images/new/xiaoshou.png")}}" alt="">
            <span>关于近期送货时间波动的通知</span>
            <span>2017-08-30</span>
        </a>
    </li>
    <li>
        <a href="{{url('new/7')}}">
            <img src="{{asset("home/images/new/xiaoshou.png")}}" alt="">
            <span>宜优速加快全国市场布局 签约入驻常州创业产业基地</span>
            <span>2017-08-16</span>
        </a>
    </li>
    <li>
        <a href="{{url('new/6')}}">
            <img src="{{asset("home/images/new/xiaoshou.png")}}" alt="">
            <span>注重便捷化体验 宜优速全新采购平台上线</span>
            <span>2017-08-03</span>
        </a>
    </li>
    <li>
        <a href="{{url('new/4')}}">
            <img src="{{asset("home/images/new/xiaoshou.png")}}" alt="">
            <span>宜优速获华庄创投2000万天使轮融资</span>
            <span>2017-06-14</span>
        </a>
    </li>
    <li>
        <a href="{{url('new/2')}}">
            <img src="{{asset("home/images/new/xiaoshou.png")}}" alt="">
            <span>积分商城火热上线</span>
            <span>2017-02-27</span>
        </a>
    </li>
    <li>
        <a href="{{url('new/1')}}">
            <img src="{{asset("home/images/new/xiaoshou.png")}}" alt="">
            <span>宜优速成立河南分公司顺利开启“F2B”易耗品采购新模式</span>
            <span>2016-12-01</span>
        </a>
    </li>
    <li>
        <a href="{{url('new/3')}}">
            <img src="{{asset("home/images/new/xiaoshou.png")}}" alt="">
            <span>易耗狂购日活动</span>
            <span>2016-11-11</span>
        </a>
    </li>
</ul>
@endsection