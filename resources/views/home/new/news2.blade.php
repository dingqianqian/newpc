@extends("home.layout.layout")
@section("title","积分商城火热上线")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/new/newOne.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="heng">
    <img src="{{asset('home/images/new/jf.jpg')}}" alt="">
</div>
<div class="coon">
    <h3>积分商城火热上线</h3>
    <p>【积分商城】功能上线试运营,让你的积分帮你来购物！通过当前所获取的积分来兑换心仪的礼品，积分越多，兑换的礼物档次越高！礼品有限，速来抢购吧！</p>
    <img src="{{asset('home/images/new/notifyBoard3.png')}}" alt="">
    <div>
        <p>宜优速电子商务企划部</p>
        <p>2017-02-27</p>
    </div>
</div>
@endsection