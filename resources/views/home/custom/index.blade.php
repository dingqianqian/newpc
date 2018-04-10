@extends("home.layout.layout")
@section("title","定制信息")
@section("css")
    <link rel="stylesheet" href="{{asset('home/css/custom/curInfomation.css')}}">
@endsection
@section("content")
    @component("home.layout.headTwo")
    @endcomponent
    <div class="er-title">
        <p><a href="{{url('/')}}">首页</a>/<span>定制信息</span></p>
    </div>
<div class="oStep clear">
    @component("home.layout.sidebar",["index"=>$index])
    @endcomponent
    <!--左侧导航-->
    <!--右侧内容-->
    <div class="tStepCont">
        <p>添加定制信息</p>
        @if(!$customInfo)
            <div style="margin-top:264px;text-align: center">
                <img style="vertical-align: middle" src="{{asset('home/images/comment/zzwu.png')}}" alt="">
                <span style="display:inline-block;vertical-align:middle;font-size: 20px;color:#666;">您暂无定制信息~</span>
            </div>
        @else
        <ul >
            @foreach($customInfo as $k=>$v)
            <li val="{{$v["id"]}}" >
                <h3>定制信息{{$loop->iteration}}</h3>
                <p>名称：<span class="name">{{$v['hotel_name']}}</span></p>
                <p>地址：<span class="addr">{{$v['hotel_address']}}</span></p>
                <p>联系热线：<span class="tel">{{$v['hotel_phone']}}</span></p>
                @if($v['img_info'])
                <p>logo：<span style="vertical-align: middle"><img src="{{$v["img_info"]}}" alt="" class="pic" val="{{$v["logo"]}}"></span></p>
                @endif
                <i class="del_d">
                <img src="{{asset("home/images/custom/xinDel.png")}}" alt="" >
                </i>
                <em id="d_edit">
                    编辑
                </em>
                <!--<div id="xuan_diy">设为默认</div>-->
            </li>
            @endforeach
        </ul>
          @endif
    </div>
</div>
<!--定制信息遮罩层-->
<div class="popup-detail">
    <div class="popup-detail-inner">
        <form id="c_modify" action="{{url('custom/addCustom')}}" method="post"  enctype="multipart/form-data">
            <p class="form_p">添加定制信息</p>
            <label>
                <span><i>*</i>名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称:</span>
                <input class="one" type="text" name="hotel_name" placeholder="请输入酒店或饭店名称">
            </label>
            <label>
                <span class="twoSapn"><i>*</i>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址:</span>
                <textarea class="two" name="hotel_address" id="" cols="30" rows="10" placeholder="请输入您的地址" style="resize:none"></textarea>
            </label>
            <label>
                <span><i>*</i>联系热线:</span>
                <input type="text" name="area_name" class="thr" placeholder="区号" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                <b>-</b>
                <input type="text" name="phone_name" class="thrr" placeholder="固话" maxlength="8" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
            </label>
            <label>
                <span><i style="opacity:0">*</i>上传logo:</span>
                <input class="four" readonly="readonly" type="text" placeholder="未选择任何文件">
                <span class="onSpan">浏览...
                    <input type="file" id="up" name="logo">
                </span>
            </label>
            <div class="oDiv">
                <img id="ImgPr" src="" alt="">
            </div>
            {{csrf_field()}}
            <div class="btn">
                <button type="submit">确定</button>
                <em>取消</em>
            </div>
        </form>
        <img src="{{asset("home/images/custom/guanbi.png")}}" alt="">
    </div>
</div>
<!--删除收货地址遮罩层-->
<div class="delHide">
    <div class="zhaozhao">
        <p class="btiao">删除定制信息</p>
        <p class="gan">
            <img src="{{asset("home/images/custom/gantanhao.png")}}" alt="">
            <span>您确定要删除该定制信息吗？</span>
        </p>
        <a class="laL" href="javascript:;">确定</a>
        <a class="noDel" href="javascript:;">取消</a>
    </div>
</div>
@endsection
@section("js")
<script type="text/javascript" src="{{asset("home/js/custom/uploadView.js")}}"></script>
<script type="text/javascript">
    $(function () {
        $("#up").uploadPreview({Img: "ImgPr", Width: 90, Height: 90});
    });
    //定制信息弹出层出现
    $('.tStepCont>p,.tStepCont ul li em').off('click').on('click', function () {
        var that = $(this)
        if ($(this)[0].nodeName.toUpperCase() == 'P') {
            if($('.tStepCont li').length>20){
                layer.msg('定制信息最多20条!')
                return
            }
            $('.form_p').text('添加定制信息')
            $('#c_modify').attr('action','{{url('custom/addCustom')}}')
            $('.popup-detail').fadeIn()
        } else {
            var id = that.parent().attr('val')
            $('.form_p').text('编辑定制信息')
            $('#c_modify').attr('action','{{url('custom/updCustom')}}?id=' +id)
            $('.one').val($(this).parent('li').find('.name').text())
            $('.two').val($(this).parent('li').find('.addr').text())
            $('.thr').val($(this).parent('li').find('.tel').text().split('-')[0])
            $('.thrr').val($(this).parent('li').find('.tel').text().split('-')[1])
            $('.four').val($(this).parent('li').find('.pic').attr('val'))
            $('#ImgPr').attr('src', $(this).parent('li').find('.pic').attr('src'))
            $('.popup-detail').fadeIn().attr('fg',$(this).parent().attr('val'))
        }
    })
    //点击确定修改/添加定制消息
    $('.btn>button').off('click').on('click',function () {
        var flag = true
        if($('.one').val()==='') {
            flag = false
            layer.msg('请填写酒店或饭店名称')
            return false
        }
        if($('.two').val()===''){
            flag = false
            layer.msg('请输入您的地址')
            return false
        }
        if(($('.thr').val()+$('.thrr').val()).length !== 11){
            flag = false
            layer.msg('请输入正确的联系热线')
            return false
        }
        if(flag){
            return true
        }
    })
    //关闭定制信息遮罩层
    $('.popup-detail-inner>img,.btn em').off('click').on('click', function () {
        $('.popup-detail').fadeOut('normal',function(){
            $('.one').val('')
            $('.two').val('')
            $('.thr').val('')
            $('.four').val('')
            $('#ImgPr').attr('src','')
        }).removeAttr('fg')
    })
    //删除该条定制信息
    $('.del_d').off('click').on('click',function () {
        var id = $(this).parent().attr('val');
        $('.delHide').fadeIn()
        $('.laL').off('click').on('click',function(){
            $.ajax({
                url:"{{url('custom/delCustom')}}",
                type:'post',
                data:{id:id},
                success:function(res){
                    if (res.err == 200) {
                        location.reload();
                    }
                }
            })
        })
    })
    //取消删除
    $('.noDel').on('click',function () {
        $('.delHide').fadeOut()
    })
    //设为默认定制信息
    {{--$('#xuan_diy').on('click',function(){--}}
        {{--var that = $(this)--}}
        {{--var id = $(this).parent().attr("val")--}}
        {{--$.ajax({--}}
            {{--url:"{{url("custom/chooseCustom")}}",--}}
            {{--type:'post',--}}
            {{--data:{id:id},--}}
            {{--success:function(res){--}}
                {{--if(res.err  == 200){--}}
                    {{--location.href = "{{url('goods/index')}}";--}}
                    {{--that.addClass('sec').siblings('li').removeClass('sec');--}}
                {{--}--}}
            {{--}--}}
        {{--})--}}
    {{--})--}}
</script>
@endsection