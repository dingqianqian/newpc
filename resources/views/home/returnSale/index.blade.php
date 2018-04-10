@extends("home.layout.layout")
        @section("title","退货列表")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/returnsale/tuihuo.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>退货</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <h3>退货记录</h3>
        @if(!$orderInfo['data'])
        {{--暂无优惠券--}}
        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
            <img src="{{asset('home/images/comment/zzwu.png')}}" style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无退货信息~</span>
        </p>
        <!--有商品时-->
        @else
        <p class="lieB">
            <span>商品详情</span>
            <span>数量</span>
            <span>订单编号</span>
            <span>申请时间</span>
            <span>操作</span>
        </p>
        <ul class="clear">
            <!--查看进度-->
            @foreach($orderInfo['data'] as $k=>$v)
            <li class="clear">
                <ul class="inCon">
                    @foreach($v['order_goods'] as $k1=>$v1)
                    <li>
                        <div class="lef">
                            <img src="{{$v1['img_url']}}" alt="">
                            <p class="ming">{{$v1['name']}}</p>
                        </div>
                        <p class="shuL">{{$v1['number']}}</p>
                    </li>
                        @endforeach
                </ul>
                <div class="inR">
                    <div class="bianhao"><span>{{$v['no']}}</span></div>
                    <div class="shijian"><span>{{date("Y-m-d H:i:s",$v['return_goods_time'])}}</span></div>
                    <div class="chaKan">
                        @if($v['f_order_form_status_id']==10)
                        <a href="{{url("returnSale/info")}}/{{$v['no']}}">查看进度</a>
                        @else
                        <a href="{{url("returnSale/info")}}/{{$v['no']}}" class="suc">退货完成</a>
                        <img class="deleteAd" ids="{{$v['id']}}" src="{{asset('home/images/returnsale/lajitong.png')}}" alt="">
                            @endif
                    </div>
                </div>
            </li>
            @endforeach
            <!--退货完成-->
            {{--<li class="clear">
                <ul class="inCon">
                    <li>
                        <div class="lef">
                            <img src="img/logo.png" alt="">
                            <p class="ming">伦敦警方了解对方拉就事论事加夫列拉健身房了解水力发电极乐世界分</p>
                        </div>
                        <p class="shuL">999</p>
                    </li>
                    <li>
                        <div class="lef">
                            <img src="img/logo.png" alt="">
                            <p class="ming">伦敦警方了解对方拉就事论事加夫列拉健身房了解水力发电极乐世界分</p>
                        </div>
                        <p class="shuL">999</p>
                    </li>
                    <li>
                        <div class="lef">
                            <img src="img/logo.png" alt="">
                            <p class="ming">伦敦警方了解对方拉就事论事加夫列拉健身房了解水力发电极乐世界分</p>
                        </div>
                        <p class="shuL">999</p>
                    </li>
                </ul>
                <div class="inR">
                    <div class="bianhao"><span>3333333999888899988</span></div>
                    <div class="shijian"><span>2017-06-14 16:13:17</span></div>
                    <div class="chaKan">
                        <a href="javascript:;" class="suc">退货完成</a>
                        <img class="deleteAd" src="{{asset('home/images/returnsale/lajitong.png')}}" alt="">
                    </div>
                </div>
            </li>--}}
        </ul>
        <!--分页-->
        <div class="fenY">
            {{$orderInfos->links()}}
        </div>
            @endif
    </div>
</div>
<!--点击确定删除-->
<div class="delHide">
    <div class="zhaozhao">
        <p class="btiao">删除订单</p>
        <p class="gan">
            <img src="{{asset('home/images/returnsale/gantanhao.png')}}" alt="">
            <span>您确定要删除该订单吗？</span>
        </p>
        <a class="laL" href="javascript:;">确定</a>
        <a class="noDel" href="javascript:;">取消</a>
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        var widthP = document.documentElement.clientWidth || document.body.clientWidth,
            heightP = document.documentElement.clientHeight || document.body.clientHeight;
        $('.delHide').css({'width': widthP, 'height': heightP});
        $('.deleteAd').click(function () {
            var id=$(this).attr("ids");
            $('.delHide').fadeIn(300);
            $('.laL').unbind('click').click(function () {   // 确定
                $.ajax({
                    url:"{{url('order/ajaxDel')}}/"+id,
                    type:"post",
                    success:function (res) {
                        if(res.err==200){
                            location.reload();
                        }else{
                            layer.msg("删除失败,稍后重试");
                        }
                    }
                });
                $('.delHide').fadeOut(300);
            });
            $('.noDel').click(function () {  // 取消
                $('.delHide').fadeOut(300);
            });
        });
    </script>
@endsection