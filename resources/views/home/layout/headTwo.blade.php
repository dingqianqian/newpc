<div class="steps">
    <div class="steCon">
        <a href="{{url('/')}}">
            <img src="{{asset("home/images/logo2.png")}}" alt="">
        </a>
        <ul>
            <li class="ulLiOne">
                <a href="javascript:;">全部商品分类</a>
                <ol class="hideOl" style="height:120px;">
                    <li>
                        <a href="{{url('category/hotel/5')}}">
                            <img src="{{asset('home/images/category/jiudian.png')}}" alt="">
                            <span>酒店用品</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('category/house/11')}}">
                            <img src="{{asset('home/images/category/canyin.png')}}" alt="">
                            <span>饭店用品</span>
                        </a>
                    </li>
                    {{--<li>
                        <a href="{{url('category/home/53')}}">
                            <img src="{{asset('home/images/category/jujia.png')}}" alt="">
                            <span>居家用品</span>
                        </a>
                    </li>--}}
                </ol>
            </li>
            {{--<li><a href="{{url('integral/shop/index')}}">积分商城</a></li>--}}
            {{--<li><a href="{{url("temp/vip")}}">会员充值</a></li>--}}
            <li><a href="{{url('checkIn/index')}}">签到</a></li>
            <li><a href="{{url('purchase')}}">企业采购</a></li>
            <li><a href="{{url('brand')}}">连锁品牌</a></li>
            <li><a href="{{url('recharge/index')}}">立即充值</a></li>
            <li><a href="{{url("news/list")}}">新闻中心</a></li>
            <li><a href="{{url('contact')}}">联系我们</a></li>
        </ul>
        <form method="get" action="{{url('goods/search')}}">
            <input type="text" name="name" placeholder="酒店用品/饭店用品/居家用品">
            <input type="submit" value="">
        </form>
        <!--<div class="goCur">
            <img src="img/goCur.png" alt="">
            <span>购物车</span>
        </div>-->
    </div>
</div>