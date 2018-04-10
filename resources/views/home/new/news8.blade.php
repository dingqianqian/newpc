@extends("home.layout.layout")
@section("title","关于近期送货时间波动的通知")
@section("css")
    <link rel="stylesheet" href="{{asset("home/css/new/newOne.css")}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="coon"
         style="height:600px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
        <h3>关于近期送货时间波动的通知</h3>
        <p style="text-indent: 0;">
            尊敬的宜优速用户：<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;近期因为环保相关不可抗拒的原因，宜优速商城旗下商品配送可能会有相应的延迟，通货类商品最晚7-10天送达，品牌定制类商品最晚20-30天送达，请大家提前查看库房，充足备货，给您带来的不便敬请谅解！
        </p>
        <div>
            <p>宜优速电子商务营销部</p>
            <p>2017-08-30</p>
        </div>
    </div>
@endsection