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
<div class="container">
    <!--表头-->
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 text-center">
            <h4>宜优速商城（北京）线上销售单&nbsp;<button  class="btn btn-primary" onclick="funPrint(this)">打印订单</button></h4>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style="font-size: 12px;">
            <p>
                <span>单位名称: </span><strong>草园宾馆</strong>
                <br>
                收货人:贾经理				<br>
                收货地址:北京 东城区 北京市东城区东直门北小街南口草园胡同甲29号				<br>
                联系电话:13691158179			</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
            <h4>全国服务热线:400-068-7870</h4>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right" style="font-size: 12px;">
            <p>
                <br>
                订单号: 201708171108205250				<br>
                下单时间: 2017-08-17 11:08:20				<br>
                预计送达时间:2017-08-20~2017-08-22				<br>
                打印记录单号：2017080197			</p>
        </div>
    </div>

    <!--订单内容-->
    <div class="row">
        <div class="col-md-12">
            <table style="width: 100%;" border="1px dashed black;">
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
                <tr>
                    <td>10</td>
                    <td>北京草园宾馆定制专区</td>
                    <td>
                        组合套装,卡盒,1*600					</td>
                    <td></td>
                    <td>10</td>
                    <td>438.00</td>
                    <td>4,380.00</td>
                    <td></td>
                </tr>
                <tr>
                    <td>总价</td>
                    <td class="text-center" colspan="3">肆仟叁佰捌拾元</td>
                    <td>10</td>
                    <td></td>
                    <td>4,380.00</td>
                    <td>- (券)</td>
                </tr>
            </table>
        </div>
    </div>
    <!--页脚2-->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        北京宜优速电子商务科技有限责任公司
                        <br>
                        公司地址：北京市石景山区京原路19号院4号楼901
                        <br>
                        区域专员:
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-8">
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
</body>
</html>
<script>
    /**
     * 打印网页
     */
    funPrint = function (Obj) {
        $(Obj).hide();
        window.print();
    };
</script>