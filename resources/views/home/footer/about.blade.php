@extends("home.layout.layout")
        @section("title","关于我们")
        @section("css")
            <link rel="stylesheet" href="{{asset("home/css/footer/guanyuus.css")}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url("/")}}">首页</a>/<span>关于我们</span></p>
</div>
<!--关于我们内容-->
<div class="contt">
    <img src="{{asset("home/images/footer/titimg.png")}}" alt="">
    <h4>关于我们</h4>
    <p>江苏宜优速电子商务有限公司是一家集研发、生产、销售、配送为一体的创新型企业，注册资金5000万，目前全国5家省级子公司分布华北、华南、华中、华东地区。业务覆盖酒店、餐饮行业，为企业提供一站式快速易耗品采购解决方案。宜优速始终以来秉承“宜购价、优品质、速立派”的经营理念，以合理的市场价格、优良的产品质量、自营物流配送体系、全天候配送与规范化的高效运营。</p>
    <p>独特的商业模式及爆炸式的增长，预计未来三年内有望由目前的数千万级销售额突破至百亿元，并能随着产业链的扩展和大数据的挖掘，宜优速的业务及营收在未来将持续保持稳定的高增长态势。
    </p>
    <img src="{{asset("home/images/footer/ignore.png")}}" alt="" class="lastimg">
</div>
@endsection