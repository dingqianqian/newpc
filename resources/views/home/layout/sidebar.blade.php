<div class="oStepC">
    <dl>
        <dt>
            <img src="{{asset('home/images/checkin/goche.png')}}" alt="">
            <span>购物中心</span>
        </dt>
        <dd>
            @if($index=='buylist')
                <a href="{{url('buyList/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">常购清单</span></a>
            @else
                <a href="{{url('buyList/index')}}">常购清单</a>
            @endif
            @if($index=='collect')
                <a href="{{url('collect/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">收藏</span></a>
                @else
                <a href="{{url('collect/index')}}">收藏</a>
                @endif
            @if($index=="browse")
                    <a href="{{url('browseHistory/index')}}"><span
                                style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">足迹</span></a>
                @else
                    <a href="{{url('browseHistory/index')}}">足迹</a>
                @endif
        </dd>
    </dl>
    <dl>
        <dt>
            <img src="{{asset('home/images/checkin/dingdan.png')}}" alt="">
            <span>订单中心</span>
        </dt>
        <dd>
            @if($index=="order")
                <a href="{{url('order/index/0')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">所有订单</span></a>
            @else
                <a href="{{url('order/index/0')}}">所有订单</a>
            @endif
                @if($index=="comment")
                    <a href="{{url('comment/index')}}"><span
                                style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">评价中心</span></a>
                @else
                    <a href="{{url('comment/index')}}">评价中心</a>
                @endif
        </dd>
    </dl>
    <dl>
        <dt>
            <img src="{{asset('home/images/checkin/shouhou.png')}}" alt="">
            <span>售后服务</span>
        </dt>
        <dd>
            @if($index=="refund")
                <a href="{{url('refund/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">退款</span></a>
            @else
                <a href="{{url('refund/index')}}">退款</a>
            @endif
                @if($index=="returnsale")
                    <a href="{{url('returnSale/index')}}"><span
                                style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">退货</span></a>
                @else
                    <a href="{{url('returnSale/index')}}">退货</a>
                @endif
        </dd>
    </dl>
    <dl>
        <dt>
            <img src="{{asset('home/images/checkin/zichan.png')}}" alt="">
            <span>资产中心</span>
        </dt>
        <dd>
            @if($index=="wallet")
                <a href="{{url('wallet/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">速立付</span></a>
            @else
                <a href="{{url('wallet/index')}}">速立付</a>
            @endif
                @if($index=="integral")
                    <a href="{{url('integral/person')}}"><span
                                style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">我的积分</span></a>
                @else
                    <a href="{{url('integral/person')}}">我的积分</a>
                @endif
            @if($index=="recharge")
                <a href="{{url('recharge/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">充值中心</span></a>
                @else
            <a href="{{url('recharge/index')}}">充值中心</a>
            @endif
                @if($index=="coupon")
                    <a href="{{url('coupon/index')}}"><span
                                style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">优惠券</span></a>
                @else
                    <a href="{{url('coupon/index')}}">优惠券</a>
                @endif
            @if($index=="invoice")
                <a href="{{url('invoice/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">发票管理</span></a>
            @else
                <a href="{{url('invoice/index')}}">发票管理</a>
            @endif
        </dd>
    </dl>
    <dl>
        <dt>
            <img src="{{asset('home/images/checkin/yonghu.png')}}" alt="">
            <span>用户中心</span>
        </dt>
        <dd>
            @if($index=="person")
                <a href="{{url('person/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">个人信息</span></a>
            @else
                <a href="{{url('person/index')}}">个人信息</a>
            @endif
            @if($index=="takeover")
                <a href="{{url('takeOver/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">收货地址</span></a>
             @else
                <a href="{{url('takeOver/index')}}">收货地址</a>
            @endif
            @if($index=="custom")
                <a href="{{url('custom/index')}}"><span
                                style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">定制信息</span></a>
            @else
                <a href="{{url('custom/index')}}">定制信息</a>
            @endif
            @if($index=="safe")
                <a href="{{url('safe/password/stepOne')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">安全设置</span></a>
                @else
            <a href="{{url('safe/password/stepOne')}}">安全设置</a>
            @endif
            @if($index=="checkin")
            <a href="{{url('checkIn/index')}}"><span
                       style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">签到</span></a>
            @else
                <a href="{{url('checkIn/index')}}">签到</a>
            @endif
        </dd>
    </dl>
    <dl>
        <dt>
            <img src="{{asset('home/images/checkin/kefu.png')}}" alt="">
            <span>服务中心</span>
        </dt>
        <dd>
            @if($index=="advise")
                <a href="{{url('advise/index')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">意见反馈</span></a>
            @else
                <a href="{{url('advise/index')}}">意见反馈</a>
            @endif
            @if($index=="contact")
                <a href="{{url('contact/person')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">联系我们</span></a>
                @else
            <a href="{{url('contact/person')}}">联系我们</a>
            @endif
            @if($index=="join")
                <a href="{{url('join')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">加盟合作</span></a>
            @else
                <a href="{{url('join')}}">加盟合作</a>
            @endif
                @if($index=="joinus")
                    <a href="{{url('joinUs')}}"><span
                                style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">加入我们</span></a>
                @else
                    <a href="{{url('joinUs')}}">加入我们</a>
                @endif
        </dd>
    </dl>
    <dl>
        <dt>
            <img src="{{asset('home/images/checkin/huiyuan.png')}}" alt="">
            <span>会员中心</span>
        </dt>
        <dd>
            @if($index=="vip")
                <a href="{{url('vip')}}"><span
                            style="text-decoration: none;color:#980c3f;padding-bottom: 4px;border-bottom: 2px solid #980c3f;">会员特权</span></a>
            @else
                <a href="{{url('vip')}}">会员特权</a>
            @endif
        </dd>
    </dl>
</div>