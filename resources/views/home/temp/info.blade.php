@extends("home.layout.layout")
@section("title","信息资讯")
@section("css")
    <link rel="stylesheet" href="{{asset("home/css/temp/information.css")}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <!--标题-->
    <div class="er-title">
        <p><a href="">首页</a>/<span>信息咨询</span></p>
    </div>
    <!--内容-->
    <div class="coon">
        <h3>本网站资讯仅供网站会员浏览,会员服务费15元/月;普通用户浏览本公司资讯需逐条收取资讯浏览费,5元/条。</h3>
        <ul>
            <li>
                <a href="javascript:;">酒店用品采购节&第十五届广州国际酒店用品展览会</a>
            </li>
            <li>
                <a href="javascript:;">宜优速加快全国市场布局&nbsp;&nbsp;签约入驻常州创业产业基地</a>
            </li>
            <li>
                <a href="javascript:;">注重便捷化体验&nbsp;&nbsp;宜优速全新采购品台上线</a>
            </li>
            <li>
                <a href="javascript:;">宜优速打造易耗品狂购日&nbsp;&nbsp;加速推动线上采购常态化</a>
            </li>
            <li>
                <a href="javascript:;">宜优速获华庄创投2000万天使轮融资</a>
            </li>
            <li>
                <a href="javascript:;">宜优速完成2000万人人民币天使轮融资,投资方为华庄创投</a>
            </li>
            <li>
                <a href="javascript:;">快消品垂直电商平台"宜优速"完成2000万人民币天使轮融资,投资方为华庄创投</a>
            </li>
            <li>
                <a href="javascript:;">宜优速作为F2B业内风向标,将举办名为 “1.11.21易耗品狂购日”线上活动,意图发力易耗品采购电商化</a>
            </li>
        </ul>
    </div>
@endsection
@section("js")
    <script>
        $('.coon li').click(function () {
            layer.msg('只对VIP会员开放,请先注册VIP会员');
        })
    </script>
@endsection