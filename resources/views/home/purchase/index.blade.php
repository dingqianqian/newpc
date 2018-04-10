@extends("home.layout.layout")
        @section("title","企业采购")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/purchase/purchase.css')}}">
        @endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>企业采购</span></p>
</div>
<!--采购内容-->
<div class="caigouCon">
    <div class="clear">
        <div class="caigouL">
            <img src="{{asset('home/images/purchase/img1.jpg')}}" alt="">
        </div>
        <div class="caigouR">
            &nbsp;&nbsp;&nbsp;&nbsp;我们希望借力于互联网的透明，去解决社会和环境的基本问题。正如宜优速正在践行的使命：让采购更简单。宜优速将持续为企业提供高品质的一站式服务，与您共同打造信任采购生态。<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;宜优速集团采购是专为政企客户、集团客户提供采供综合解决方案和服务版块.提供易耗品采购,市场活动等定制化解决方案。<br/>

            服务热线：40018-11121<br/>
            服务时间：9:00-18:00<br/>
        </div>
        <div class="caigoul">
            宜优速定制化服务：<br/>
            1.	开店指导<br/>
            2.	店面设计<br/>
            3.	装饰装潢<br/>
            4.	活动策划<br/>
            5.	品牌定制<br/>
            6.	耗品定制<br/>
        </div>
        <div class="caigour">
            <img src="{{asset('home/images/purchase/img2.jpg')}}" alt="">
        </div>
    </div>
    <p>
        <img src="{{asset('home/images/purchase/caishang.png')}}" alt="">
    </p>
</div>
@endsection