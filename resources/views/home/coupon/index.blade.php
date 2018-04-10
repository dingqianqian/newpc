@extends("home.layout.layout")
@section("title","我的优惠券")
        @section("css")
            <link rel="stylesheet" href="{{asset('home/css/coupon/youhuijuan.css')}}">
        @endsection
@section("content")
@component("home.layout.headTwo")
    @endcomponent
<div class="er-title">
    <p><a href="{{url('/')}}">首页</a>/<span>优惠卷</span></p>
</div>
<div class="oStep clear">
    <!--左侧导航-->
    @component("home.layout.sidebar",["index"=>$index])
        @endcomponent
    <!--右侧内容-->
    <div class="tStepCont">
        <p class="tit">我的优惠卷</p>
        <p class="wen">温馨提示 : </p>
        <p class="gui"><span>1.一次仅限使用一张优惠卷</span><span style="margin: 0 38px;">2.活动期间不可使用优惠卷</span><span>3.点击右上角×删除不可使用优惠卷</span>
        </p>
        <ul class="clear">
            <li><a href="javascript:;" class="sec">全部优惠卷</a></li>
            <li>
                <i style="left:0;"></i>
                <a href="javascript:;">可用优惠卷</a>
                <i style="right:0;"></i>
            </li>
            <li><a href="javascript:;">不可用优惠卷</a></li>
        </ul>
        @if(!$couponInfo)
        {{--暂无优惠券--}}
        <p style="width: 100%;text-align: center;margin: 264px 0 0 0;">
            <img src="{{asset('home/images/comment/zzwu.png')}}" style="vertical-align: middle;width:46px;height:40px;margin-right:10px;" alt="">
            <span style="display: inline-block;vertical-align: middle;font-size: 20px;color:#666;">您暂无优惠券信息~</span>
        </p>
        @else
        <div class="con">
            <ul class="sec clear">
                @foreach($couponInfo as $k=>$v)
                @if($v['f_coupon_status_id']==1)
                <li ids="{{$v['id']}}">
                    <p>
                        <img src="{{asset("home/images/coupon/{$v['coupon_type']['id']}.png")}}" class="you" alt="">
                    </p>
                    <span><i>{{date("Y/m/d",$v['expire_time_end'])}}</i>前可用</span>
                    <span class="only_city">({{$v['f_area_id']?"仅限".$v['area']['name']:"全国通用"}})</span>
                </li>
                    @elseif($v['f_coupon_status_id']==3)
                <li ids="{{$v['id']}}">
                    <p>
                        <img src="{{asset("home/images/coupon/{$v['coupon_type']['id']}-no.png")}}" class="you" alt="">
                        <img src="{{asset('home/images/coupon/yiGuo.png')}}" class="yiG" alt="">
                        <img src="{{asset('home/images/coupon/delY.png')}}" class="shChu" alt="">
                    </p>
                    <span><i>{{date("Y/m/d",$v['expire_time_end'])}}</i>前可用</span>
                    <span class="only_city">({{$v['f_area_id']?"仅限".$v['area']['name']:"全国通用"}})</span>
                </li>
                    @elseif($v['f_coupon_status_id']==4)
                <li ids="{{$v['id']}}">
                    <p>
                        <img src="{{asset("home/images/coupon/{$v['coupon_type']['id']}-no.png")}}" class="you" alt="">
                        <img src="{{asset('home/images/coupon/yShi.png')}}" class="yShi" alt="">
                        <img src="{{asset('home/images/coupon/delY.png')}}" class="shChu" alt="">
                    </p>
                    <span><i>{{date("Y/m/d",$v['expire_time_end'])}}</i>前可用</span>
                    <span class="only_city">({{$v['f_area_id']?"仅限".$v['area']['name']:"全国通用"}})</span>
                </li>
                    @else
                    @endif
                @endforeach
            </ul>
            <ul class="clear">
                @foreach($couponInfo as $k=>$v)
                    @if($v['f_coupon_status_id']==1)
                <li ids="{{$v['id']}}">
                    <p>
                        <img src="{{asset("home/images/coupon/{$v['coupon_type']['id']}.png")}}" class="you" alt="">
                    </p>
                    <span><i>{{date("Y/m/d",$v['expire_time_end'])}}</i>前可用</span>
                    <span class="only_city">({{$v['f_area_id']?"仅限".$v['area']['name']:"全国通用"}})</span>
                </li>
                    @endif
                    @endforeach
            </ul>
            <ul class="clear">
                @foreach($couponInfo as $k=>$v)
                    @if($v['f_coupon_status_id']==3)
                <li ids="{{$v['id']}}">
                    <p>
                        <img src="{{asset("home/images/coupon/{$v['coupon_type']['id']}-no.png")}}" class="you" alt="">
                        <img src="{{asset('home/images/coupon/yiGuo.png')}}" class="yiG" alt="">
                        <img src="{{asset('home/images/coupon/delY.png')}}" class="shChu" alt="">
                    </p>
                    <span><i>2017/05/09</i>前可用</span>
                    <span class="only_city">({{$v['f_area_id']?"仅限".$v['area']['name']:"全国通用"}})</span>
                </li>
                    @elseif($v['f_coupon_status_id']==4)
                <li ids="{{$v['id']}}">
                    <p>
                        <img src="{{asset("home/images/coupon/{$v['coupon_type']['id']}-no.png")}}" class="you" alt="">
                        <img src="{{asset('home/images/coupon/yShi.png')}}" class="yShi" alt="">
                        <img src="{{asset('home/images/coupon/delY.png')}}" class="shChu" alt="">
                    </p>
                    <span><i>2017/05/09</i>前可用</span>
                    <span class="only_city">({{$v['f_area_id']?"仅限".$v['area']['name']:"全国通用"}})</span>
                </li>
                        @else
                    @endif
                @endforeach
            </ul>
        </div>
            @endif
    </div>
</div>
@endsection
@section("js")
    <script type="text/javascript">
        $('.tStepCont>ul>li>a').click(function () {
            $('.tStepCont>ul>li>a,.tStepCont .con>ul').each(function (k, v) {
                $(v).removeClass('sec');
            });
            $(this).addClass('sec');
            $('.tStepCont .con>ul').eq($(this).parent().prevAll('li').length).addClass('sec');
        });
        //删除优惠卷
        $('.shChu').click(function () {
            var ids = $(this).parent().parent().attr('ids');
            $.ajax({
                url:"{{url('coupon/del')}}/"+ids,
                type:'post',
                success:function (res) {
                    if(res.err==200){
                        location.reload(true);
                    }
                }
            })
        })
    </script>
    @endsection