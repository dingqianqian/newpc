<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->

    <!--引入jquery-->
    <script src="{{asset("admin/js/jquery-1.11.3.min.js")}}"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset("admin/css/print.css")}}">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <title>订单细节 - 进销存 - 宜优速</title>
</head>
<body>
<!--startprint-->
<div class="container">
    <!--表头-->
    <div class="row">
        {{--<div class="col-md-4"></div>--}}
        <div class="col-md-12 text-center">
            <h4>宜优速商城（北京）线上销售单&nbsp;<button  class="btn btn-primary" onclick="funPrint(this)">打印订单</button></h4>
        </div>
        {{--<div class="col-md-4"></div>--}}
    </div>
    <div class="row z-head">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <p>
                <span>单位名称: </span>{{$orderInfo['take_over_company']}}
                <br>
                收货人:{{$orderInfo['take_over_name']}}				<br>
                收货地址:{{$orderInfo['take_over_addr']}}				<br>
                联系电话:{{$orderInfo['take_over_tel_no']}}		</p>
        </div>
        <div  class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center style="margin: 0;padding: 0;">
            <h3>全国服务热线:40018-11121</h3>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <p>
                <br>
                订单号: {{$orderInfo['no']}}				<br>
                下单时间: {{date("Y-m-d H:i:s",$orderInfo['create_time'])}}			<br>
                预计送达时间:{{date("Y-m-d",$orderInfo['pay_time']+3600*24*3)}}	~	{{date("Y-m-d",$orderInfo['pay_time']+3600*24*5)}}		<br>
                打印记录单号：{{$orderInfo['print_out_id']}}			</p>
        </div>
    </div>

    <!--订单内容-->
    <div class="row">
        <div class="col-md-12">
            <table class="text-center" style="width: 100%;" border="1px dashed black;">
                <tr>
                    <td>序号</td>
                    <td>商品名称</td>
                    <td>规格</td>
                    <td>单位</td>
                    <td>件数</td>
                    <td>单价</td>
                    <td>小计</td>
                    <td>备注</td>
                </tr>
                @foreach($goodsInfo as $k=>$v)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$v['goods']['open_id']}}</td>
                    <td>
                        @foreach($v['norms_name'] as $k1=>$v1)
                            @if($loop->last)
                                {{$v1['name']}}
                                @else
                                {{$v1['name']}},
                                @endif
                            @endforeach
                    </td>
                    <td>{{$v['goods']['unit']}}</td>
                    <td>{{$v['order']['number']}}</td>
                    <td>{{number_format($v['order']['deal_min_price'],2,".","")}}</td>
                    <td>{{number_format($v['order']['number']*$v['order']['deal_min_price'],2,".","")}}</td>
                    @if($loop->index==0)
                    <td rowspan="{{count($goodsInfo)}}" title="{{$orderInfo['remark']}}">{{mb_substr($orderInfo['remark'],0,20)}}……</td>
                        @endif
                </tr>
                @endforeach
                <tr>
                    <td>总价</td>
                    <td class="text-center" colspan="3">{{$price}}</td>
                    <td>{{$number}}</td>
                    <td></td>
                    @if(in_array($orderInfo['f_pay_type_id'],[14,15,16]))
                    <td>{{number_format($orderInfo['discount_price'],2)}}</td>
                    @else
                        <td>{{number_format($orderInfo['price'],2)}}</td>
                    @endif
                    <td>—{{$orderInfo['coupon']?number_format($orderInfo['coupon']['use_value'],2,".",""):number_format(0,2)}}(券)&nbsp;&nbsp;折扣:{{number_format($orderInfo['virtual_discount'],2,".","")}}</td>
                </tr>
            </table>
        </div>
    </div>
    <!--页脚2-->
    <div class="row z-footer" style="margin-top: 10px; margin-left: 2px;">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="row">
                    <p style="margin: 0">
                        北京宜优速电子商务科技有限责任公司
                        <br>
                        公司地址：北京市石景山区京原路19号院4号楼901
                        <br>
                        区域专员:
                    </p>
            </div>
            <div class="row">
                    质量监督:18510780526
                    <br>
                    领单司机:
                    <select name="" style="border: none;">
                        <option value="17">刘瑶&nbsp;(13671379821)</option>
                        <option value="36">代冉&nbsp;(13671028464)</option>
                        <option value="42">刘福胜&nbsp;(13223207896)</option>
                        <option value="60">李雨嬛&nbsp;(13810938168)</option>
                        <option value="75" selected="selected">徐伟&nbsp;(15978408857)</option>
                        <option value="76">殷宁超&nbsp;(13718187865)</option>
                    </select>
                    <br>
                    出库专员:
                    <select name="" style="border: none;">
                        <option value="17">刘瑶&nbsp;(13671379821)</option>
                        <option value="36">代冉&nbsp;(13671028464)</option>
                        <option value="42">刘福胜&nbsp;(13223207896)</option>
                        <option value="60">李雨嬛&nbsp;(13810938168)</option>
                        <option value="75">徐伟&nbsp;(15978408857)</option>
                        <option value="76" selected="selected">殷宁超&nbsp;(13718187865)</option>
                    </select>
                    <br>
                    收货人签字:
                    <!--<img src="/Public/Company/yiyousu_logo2.png" alt="" style="width: 260px;">-->
                </div>
                <!--<div class="col-md-4 col-sm-4 col-xs-4">-->
                <!--<img src="/Public/Company/public_qr.jpg" alt="" style="width: 130px;">-->
                <!--</div>-->
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <p>
                <img src="{{asset("admin/img/public_qr_printOut.jpg")}}" alt="" class="col-lg-4 col-md-4 col-md-4 col-xs-4">
                <img src="{{asset("admin/img/ios_app_download.jpg")}}" alt="" class="col-lg-4 col-md-4 col-md-4 col-xs-4">
                <img src="{{asset("admin/img/android_app_download.jpg")}}" alt="" class="col-lg-4 col-md-4 col-md-4 col-xs-4">
            </p>
            <p>备注:&nbsp;白色:留存&nbsp;&nbsp;粉色:司机&nbsp;&nbsp;蓝色:客户&nbsp;&nbsp;黄色:财务</p>
        </div>
    </div>
</div>
<!--endprint-->
</body>
</html>
<script>
    /**
     * 打印网页
     */
    funPrint = function (Obj) {
        $(Obj).hide();
        bdhtml=window.document.body.innerHTML;
        sprnstr="<!--startprint-->";
        eprnstr="<!--endprint-->";
        prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+17);
        prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));
        window.document.body.innerHTML=prnhtml;
        window.print();
    };
</script>