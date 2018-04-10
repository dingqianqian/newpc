@extends("home.layout.layout")
@section("title","易耗狂购日活动内容")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/new/newOne.css')}}">
    <style>
        .coon p{
            padding-left: 370px;
            line-height: 40px;
        }
    </style>
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
<div class="heng">
    <img src="{{asset('home/images/new/notifyBoard2.jpg')}}" alt="">
</div>
<div class="coon">
    <h3>易耗狂购日活动内容</h3>
    <p>1.活动时间：每月1日、11日、21日0：00~24：00；</p>
    <p>2.活动期间，全场随机商品享低价优惠；</p>
    <p>3.活动期间，商品随机价格仅限活动当天有效；</p>
    <p>4.活动期间，无法使用优惠卷；</p>
    <p>5.活动期间，全场无门槛包邮（新疆、西藏、港澳台除外）；</p>
    <p>6.活动期间可能会出现爆仓现象，导致部分订单配送延缓，敬请谅解；</p>
    <p>7.本活动降价商品不享有“退补差价”；</p>
    <p>8.本活动最终解释权归宜优速电子商务有限责任公司所有。</p>
    <div>
        <p>宜优速电子商务市场部</p>
        <p>2016-12-05</p>
    </div>
</div>
@endsection