@extends("home.layout.layout")
        @section("title","联系我们")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/contact/lianxiwomen.css')}}">
            <script type="text/javascript"
                    src="http://api.map.baidu.com/api?v=2.0&ak=GyvtaKUvhb1nMN27FVAU12Xzupk8QTYK"></script>
        @endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>联系我们</span></p>
</div>
<div class="lianxiD">
    <img class="lianTop" src="{{asset('home/images/contact/lianD.jpg')}}" alt="">
    <p>
        <img src="{{asset('home/images/contact/lianTd.png')}}" alt="">
        <span>联系电话 : 40018-11121</span>
    </p>
    <p>
        <img src="{{asset('home/images/contact/lianYou.png')}}" alt="">
        <span>yiyousu@126.com</span>
    </p>
    <p>
        <img src="{{asset('home/images/contact/lianDi.png')}}" alt="">
        <span>北京市石景山区京原路19号院4号楼901</span>
    </p>
    <p style="padding-left:90px;font-size: 16px;color:#666;margin-top:6px;">(地铁1号线八角游乐园站下车，乘坐327路 385路 965路
        专91路到衙门口桥北下车)</p>
    <div id="lianBot"></div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        var map = new BMap.Map("lianBot", {minZoom: 16, maxZoom: 19});          // 创建地图实例
        var point = new BMap.Point(116.215229, 39.90118);  // 创建点坐标
        map.centerAndZoom(point, 17);               // 设置中心点坐标和地图级别
        map.setCurrentCity("北京");
        // 缩放控件
        var opts = {type: BMAP_NAVIGATION_CONTROL_SMALL};
        map.addControl(new BMap.NavigationControl(opts));
        /*map.disableDragging();     //禁止拖拽*/
        map.enableScrollWheelZoom();
        var marker = new BMap.Marker(point); // 坐标位置点
        map.addOverlay(marker);
        // 动画
        marker.setAnimation(BMAP_ANIMATION_BOUNCE);
    </script>
@endsection

