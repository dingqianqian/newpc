@extends("admin.layout.layout")
@section("title","添加新商品")
@section("css")
    <!--图片上传-->
    <link rel="stylesheet" href="{{asset("admin/css/style.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/ssi-uploader.css")}}"/>

    {{--<link rel="stylesheet" href="{{asset("admin/css/z_shoplist.css")}}">--}}
    <link rel="stylesheet" href="{{asset("admin/css/z_attr.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
@endsection
@section("content")


    <div class="content-wrapper">
        <!--header-->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-添加商品</b>
                    <span class="pull-right">
			<a href="{{route("goods.list")}}" class="btn btn-default btn-xs"><i></i>商品列表</a>
		</span>
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{--选项卡--}}
            <div class="tabs">
                <div class="lytabs text-center">
                    <a href="#cont" class="active">商品信息</a>
                    <a href="#album">商品图片</a>
                </div>
                <form class="form-horizontal" action="{{url("admin/goods/update")}}/{{$goodsInfo['id']}}" method="post"
                      enctype="multipart/form-data">
                    <div id="cont" class="active">
                        <!--商品名称-->
                        <div class="form-group">
                            <label for="username" class="control-label col-xs-4">商品名称</label>
                            <div class="col-xs-6 col-sm-4">
                                <input type="text" class="form-control" name="name" value="{{$goodsInfo['name']}}">
                            </div>
                        </div>
                        <!--打印送货单时显示的名字-->
                        <div class="form-group">
                            <label for="passward" class="control-label col-xs-4">打印送货单时显示的名字</label>
                            <div class="col-xs-6 col-sm-4">
                                <input type="text" class="form-control" name="open_id"
                                       value="{{$goodsInfo['open_id']}}">
                            </div>
                        </div>
                        <!--预计到达时间-->
                        <div class="form-group">
                            <label for="surepassward" class="control-label col-xs-4">预计到达时间</label>
                            <div class="col-xs-6 col-sm-4">
                                <input type="text" class="form-control" name="send_time"
                                       value="{{$goodsInfo['send_time']}}">
                            </div>
                        </div>
                        {{--商品单位--}}
                        <div class="form-group">
                            <label for="username" class="control-label col-xs-4">商品单位</label>
                            <div class="col-xs-6 col-sm-4">
                                <input type="text" class="form-control" name="unit" value="{{$goodsInfo['unit']}}">
                            </div>
                        </div>
                        <!--商品说明-->
                        <div class="form-group">
                            <label for="name" class="control-label col-xs-4">商品说明</label>
                            <div class="col-xs-6 col-sm-4">
                                <input type="text" class="form-control" id="name" name="explain"
                                       value="{{$goodsInfo['explain']}}">
                            </div>
                        </div>
                        <!--最小售卖单位-->
                        <div class="form-group">
                            <label for="phone" class="control-label col-xs-4">最小售卖单位</label>
                            <div class="col-xs-6 col-sm-4">
                                <input type="text" class="form-control" id="phone" name="min_sale"
                                       value="{{$goodsInfo['min_sale']}}">
                            </div>
                        </div>
                        <!--易购价-->
                        <div class="form-group">
                            <label for="email" class="control-label col-xs-4">易购价</label>
                            <div class="col-xs-6 col-sm-4">
                                <input type="text" class="form-control" name="show_price"
                                       value="{{$goodsInfo['show_price']}}">
                            </div>
                        </div>
                        <!--狂购价-->
                        <div class="form-group">
                            <label for="idcard" class="control-label col-xs-4">狂购价</label>
                            <div class="col-xs-6 col-sm-4">
                                <input type="text" class="form-control" name="show_sale_price"
                                       value="{{$goodsInfo['show_sale_price']}}">
                            </div>
                        </div>
                        <!--所属商铺-->
                        <div class="form-group">
                            <label for="wcart" class="control-label col-xs-4">商品状态</label>
                            <div class="col-xs-6">
                                <select class="selectpicker zf-select" data-live-search="true" name="f_goods_status_id">
                                    @foreach($goodsStatusInfo as $k=>$v)
                                        <option value="{{$v['id']}}"
                                                @if($v['id']==$goodsInfo['f_goods_status_id']) selected @endif>{{$v['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--商品分类-->
                        <div class="form-group">
                            <label class="control-label col-xs-4">所属分类:</label>
                            <div class="col-xs-6">
                                <select class="selectpicker z-select" data-live-search="true" id="d1">
                                    {{--<option value="-1">商品分类</option>--}}
                                    @foreach($goodsTypeInfo as $k=>$v)
                                        <option value="{{$loop->index}}"
                                                @if($v['id']==$goodsInfo ['goods_type']['parent_id']) selected @endif>{{$v['name']}}</option>
                                    @endforeach
                                </select>
                                <select class="selectpicker z-select" data-live-search="true" id="d2"
                                        name="f_goods_type_id">
                                </select>
                            </div>
                        </div>
                        <!--规格分组-->
                        <div class="form-group">
                            <label for="wcart" class="control-label col-xs-4">规格分组</label>
                            <div class="col-xs-6 col-sm-4" style="margin-top: 5px;">
                                @foreach($normsGroupInfo as $k=>$v)
                                    <p class="col-xs-4 z-p-ckeckbox"><input type="checkbox" name="norms_group[]"
                                                                            value="{{$v['id']}}"
                                                                            @if(in_array($v['id'],$goodsInfo['f_norms_group_id'])) checked @endif/>{{$v['name']}}
                                    </p>
                                @endforeach

                            </div>
                        </div>
                        <!--提交-->
                        {{csrf_field()}}
                        <div class="submitBtn text-center">
                            <button type="submit" class="btn btn-success">确定</button>
                            <button type="reset" class="btn btn-primary">重置</button>
                        </div>
                    </div>
                    <div id="album">
                        {{--编辑--}}
                        <div class="row">
                            <label class="control-label col-xs-4">商品图片编辑</label>
                            <div class="editalbem col-xs-4">
                                <div class="first">
                                    <div class="detailphoto">
                                        <h3>商品主图</h3>
                                        <div class="detailImg">
                                            <div class="img">
                                                @foreach($goodsInfo['goods_img'] as $k=>$v)
                                                    @if($v['is_lead']=="T")
                                                        <img src="{{$v['thumb_url']}}" alt="">


                                                        <a href="javascript:;"
                                                           onclick="delImg({{$v['id']}},this)">删除</a>
                                                        <button disabled>删除成功</button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mainphoto">
                                        <h3>商品详情图</h3>
                                        <div class="shagnpinDetail text-center">
                                            <div class="img">
                                                <img src="{{$goodsInfo['goods_details_img']['url']}}" alt="" class="">
                                            </div>
                                            <a href="javascript:;"
                                               onclick="delDetailsImg({{$goodsInfo['goods_details_img']['id']}},this)">删除</a>
                                            <button disabled>删除成功</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="guige">
                                    <h3>规格图片</h3>
                                    <ul class="detailImg">
                                        @foreach($goodsInfo['goods_img'] as $k=>$v)
                                            <li class="img">
                                                <img src="{{$v['thumb_url']}}" alt="">
                                                <a href="javascript:;" onclick="delImg({{$v['id']}},this)">删除</a>
                                                <button disabled>删除成功</button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <!--上传商品图片-->
                        <div class="form-group">
                            <label for="shang" class="control-label col-xs-4">上传商品主图</label>
                            <input type="file" class="col-xs-4" id="shang" name="masterImg">
                        </div>
                        <!--上传详情图-->
                        <div class="form-group">
                            <label for="shang" class="control-label col-xs-4">上传商品详情图</label>
                            <input type="file" class="col-xs-4" id="shang" name="detailsImg">
                        </div>
                        <!--多图片上传-->
                        <div class="form-group">
                            <label for="" class="control-label col-xs-4">商品规格图片</label>
                            <!--<div class="row">-->
                            <div class="col-md-4 col-sm-6">
                                <input data-validate="required:" type="file" name="goodsImg" multiple id="ssi-upload"/>
                            </div>
                            <!--</div>-->
                        </div>
                        {{--存放图片--}}
                        <div style="display: none;" id="goodsImg">
                        </div>
                        <!--提交-->
                        {{csrf_field()}}
                        <div class="submitBtn text-center">
                            <button type="submit" class="btn btn-success">确定</button>
                            <button type="reset" class="btn btn-primary">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent
    </div>
@endsection
@section("js")

    <script src="{{asset("admin/js/ssi-uploader.js")}}" charset="utf-8"></script>
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
    <script>
        $('#ssi-upload').ssi_uploader({
            url: '{{url("admin/goods/upload")}}',
            allowed: ['jpg', 'gif', 'txt', 'png', 'pdf'],
            locale: "zh_CN",
            onEachUpload: function (res, name) {
                $("#goodsImg").append('<input name="goodsImg[]" type="hidden" value="' + name + '">');
            }
        });
        $(function () {
            var erji = [
                    @foreach($goodsTypeInfo as $k=>$v)
                [
                        @foreach($v['child'] as $k1=>$v1)
                    [{{$v1['id']}}, '{{$v1['name']}}'],
                    @endforeach
                ],
                @endforeach
            ];
            $(function () {
                //console.log(erji);
                var value = $('#d1').val();
                var funIndex = erji[value];// 当前下标在二级对应内容
                var html = '';
                var erjiOption = '';
                for (var i = 0; i < funIndex.length; i++) {
                    html += '<li data-original-index=' + funIndex[i][0] + '>' +
                        '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                        '<span class="text">' + funIndex[i][1] + '</span>' +
                        '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                        '</a>' +
                        '</li>';
                    // 添加option
                    if (funIndex[i][0] == "{{$goodsInfo['goods_type']['id']}}") {
                        erjiOption += '<option value=' + funIndex[i][0] + ' selected >' + funIndex[i][1] + '</option>';
                    } else {
                        erjiOption += '<option value=' + funIndex[i][0] + '>' + funIndex[i][1] + '</option>';
                    }
                }
                $('#d2').prev('div.dropdown-menu').find('ul').html(html);
                $('#d2').html(erjiOption);
                $('.selectpicker').selectpicker('refresh');
                smallScreen();

            });

            $('#d1').change(function () {
                var cityIndex = erji[this.value];  // 当前下标在二级对应内容
                var html = '';
                var erjiOption = '';
                for (var i = 0; i < cityIndex.length; i++) {
                    html += '<li data-original-index=' + cityIndex[i][0] + '>' +
                        '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                        '<span class="text">' + cityIndex[i][1] + '</span>' +
                        '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                        '</a>' +
                        '</li>';
                    // 添加option
                    erjiOption += '<option value=' + cityIndex[i][0] + '>' + cityIndex[i][1] + '</option>';
                }
                $('#d2').prev('div.dropdown-menu').find('ul').html(html);
                $('#d2').html(erjiOption);
                $('.selectpicker').selectpicker('refresh');
                smallScreen();
            });
        });
        $(function () {
            if ($(window).width() < 768) {
                $('.haspadding .row>div').removeClass('text-right');
                $('.haspadding .form-control:not(select)').css({
                    'margin-top': '10px'
                });
                $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                    'width': '100%',
                    'margin-top': '10px'
                });
            }
        });
        function smallScreen() {
            if ($(window).width() < 768) {
                $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                    'width': '100%',
                    'margin-top': '10px'
                });
            }
        }
        // 选项卡
        $('.lytabs>a').click(function (e) {
            e.preventDefault();
            // id
            var id = $(this).attr('href');
            $(id).addClass('active').siblings('.active').removeClass('active');
            $(this).addClass('active').siblings('.active').removeClass('active');
        });
        //删除商品图片
        function delImg(id, _this) {
            var $this = $(_this);
            layer.confirm("确定要删除这个图片", function () {
                $.ajax(
                    {
                        url: "{{url('admin/goods/delImg')}}/" + id,
                        type: "post",
                        success: function (res) {
                            $this.parent().find('button').css('display', 'block');
                            layer.msg(res.msg);
                        }
                    });
            }, function () {
                layer.msg("取消成功");
            });
        }
        //删除商品详情图
        function delDetailsImg(id, _this) {
            var $this = $(_this);
            layer.confirm("确定要删除这个图片", function () {
                $.ajax(
                    {
                        url: "{{url('admin/goods/delDetailsImg')}}/" + id,
                        type: "post",
                        success: function (res) {
                            $this.parent().find('button').css('display', 'block');
                            layer.msg(res.msg);
                        }
                    });
            }, function () {
                layer.msg("取消成功");
            });
        }
    </script>
@endsection