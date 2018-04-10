@extends("home.layout.layout")
        @section("title","发票制度")
        @section("css")
            <link rel="stylesheet" href="{{asset("home/css/footer/fapiao.css")}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url("/")}}">首页</a>/<span>发票制度</span></p>
</div>
<!--发票制度内容-->
<div class="conta">
    <h3>发票制度</h3>
    <h4>一、可以开发票吗？</h4>
    <p>
        （宜优速网站所售商品都是正品，自营商品均开具正规发票，另有说明的除外。）<br>
        （1）<span>如何获得普通纸质发票：</span>下单后，前往“我的宜优速—资产中心—发票管理”中，选择“普通发票”自助开取，此发票可用作单位报销凭证，一个订单对应一张或多张发票，发票会随每次包裹一同发出。<br>
        （2）<span>如何获得增值税发票：</span>下单后，选择“增值税发票 ”自助开具。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.首次开具增值税专用发票的顾客，请填写开具增值税专用发票所需信息，具体操作路径：我的宜优速-资产中心-发票管理-增票资质信息。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.如需要修改、删除增票资质，直接在此页面修改、删除即可，无需上传资质证件。<br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：有效增值税开票资质仅为一个。
    </p>
    <h4>二、未收到发票</h4>
    <p>
        （1）若宜优速漏开发票，将以单独邮寄或同下一次交易后补开的方式邮寄给您，详情拨打宜优速客服热线40018-11121。<br>
        （2）若您忘记开取发票，前往“我的宜优速—资产中心—发票管理”中，选择“普通发票”或“增值税发票”自助开取，宜优速商品补开发票后会为您寄出，邮寄信息可联系宜优速客服为您查询。
    </p>
</div>
@endsection