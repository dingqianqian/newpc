@extends("admin.layout.layout")
@section("title","添加属性")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("admin/css/z_special.css")}}"/>
    <link rel="stylesheet" href="{{asset("admin/css/ly_addGroup.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/dl_css.css")}}">
@endsection
@section("content")

    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 商城管理中心</a>
                    </b>
                    <b>-SKU管理</b>
                    <span class="pull-right">
                        <a id="dl_Add_goods" href="###" class="btn btn-default btn-sm" data-toggle="modal"
                           data-target="#myModal">添加SKU</a>
                    </span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--商品数量-->
            <div class="panel panel-default dl_Commodity_panel">
                <div class="panel-body">
                    <label for="" style="margin-bottom: 0;font-size: 14px">SKU商品数：</label><span
                            style="font-weight: normal">{{$count}}</span>
                </div>
            </div>
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline haspadding" action="{{route("normsCombo.list")}}" method="get" id="export">
                        <div class="form-group">
                            <label for="" class="control-label" style="font-weight: normal">商品名称:&nbsp;&nbsp;</label>
                            <input type="text" id="" class="form-control input-sm" placeholder="输入商品名称" name="name"
                                   style="font-weight: normal;" value="{{$info['name']}}">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="selectpicker" data-live-search="true" id="dl_Filter_one" name="type">
                                        <option value="0" ips="0">请选择</option>
                                        @foreach($goodsTypeInfo as $k=>$v)
                                            <option value="{{$v['id']}}" ips="{{$loop->iteration}}"
                                                    @if($info['type']==$v['id']) selected @endif>{{$v['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="selectpicker" data-live-search="true" id="dl_Filter_two"
                                            name="category">
                                        <option value="0" ips="0">请选择</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="selectpicker" data-live-search="true" id="dl_Filter_two"
                                            name="f_area_id">
                                        @foreach($areaInfo as $k=>$v)
                                            <option value="{{$v['id']}}"
                                                    @if($info['f_area_id']==$v['id'])  selected @endif>{{$v['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{csrf_field()}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-sm">搜索</button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="exports()">导出</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--表格-->
            <div class="panel panel-default">
                <form class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>商品名称</th>
                            <th>所属类型</th>
                            <th>商品品类</th>
                            <th>商品规格</th>
                            <th>状态</th>
                            <th>折扣</th>
                            <th>库存数量</th>
                            {{--<th>单价</th>
                            <th>单价(11121)</th>--}}
                            <th>售价</th>
                            <th>售价(11121)</th>
                            <th>图片</th>
                            <th>地区</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($normsComboInfo['data'] as $k=>$v)
                            <tr>
                                <td>{{$v['id']}}</td>
                                <td title="{{$v['goods']['name']}}">{{mb_substr($v['goods']['name'],0,30)}}</td>
                                <td>{{$v['type']}}</td>
                                <td>{{$v['category']}}</td>
                                <td>
                                    @foreach($v['norms'] as $k1=>$v1)
                                        @if($loop->last)
                                            {{$v1['name']}}
                                        @else
                                            {{$v1['name']}},
                                        @endif
                                    @endforeach
                                </td>
                                @if($v["f_goods_status_id"] ==1)
                                <td>
                                    <a href="javascript:;" style="color:red;" onclick="goodStatus({{$v["id"]}})">上架</a>
                                </td>
                                @elseif($v["f_goods_status_id"] == 0)
                                    <td>
                                        <a href="javascript:;" style="color:deepskyblue" onclick="goodStatus({{$v["id"]}})">下架</a>
                                    </td>
                                @endif
                                <td class="tabInput" ids="{{$v['id']}}">
                                    <span class="need" style="display: inline-block;" >{{$v['discount']*10}}</span>
                                    <input type="text" class="outlet" style="display: none;">
                                </td>
                                <td>{{$v['stock']}}</td>
                                {{--<td>{{$v['piece_price']}}</td>
                                <td>{{$v['small_piece_price']}}</td>--}}
                                <td>{{number_format($v['single_price'],2,".","")}}</td>
                                <td>{{number_format($v['sale_single_price'],2,".","")}}</td>
                                <td>
                                    <div class="demo">
                                        <a path="{{$v['thumb_url']}}" class="preview" href="javascript:;">
                                            悬浮查看
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    {{$v['area']['name']}}
                                </td>
                                <td>
                                    <a href="{{route('normsCombo.edit',["id"=>$v['id']])}}">
                                        <img src="{{asset("admin/img/edit.png")}}" alt="修改">
                                    </a>
                                    <a href="javascript:;" onclick="del({{$v['id']}})">
                                        <img src="{{asset("admin/img/delete.png")}}" alt="删除">
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            {{$normsComboInfos->appends(["name"=>"{$info['name']}","type"=>$info['type'],"category"=>$info['category'],"f_area_id"=>$info['f_area_id']])->links()}}
        </section>

        @component("admin.layout.footer")
        @endcomponent

    </div>
    <!-- /.content-wrapper -->
    <form class="row" role="form" {{--style="margin : 10px 10%;"--}} method="get" action="{{route("normsCombo.create")}}">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">请选择要添加的商品名称</h4>
                    </div>
                    <div class="modal-body">
                        <select class="col-md-12 selectpicker" data-live-search="true" name="goods_id">
                            @foreach($goodsInfo as $k=>$v)
                                <option value="{{$v['id']}}">{{$v['open_id']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">确定</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


@section("js")
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
    <script src="{{asset("admin/js/defaults-zh_CN.js")}}"></script>
    <script src="{{asset("admin/js/previewshow.js")}}" type="text/javascript" charset="utf-8"></script>
    <script>
        // 点击输入内容
        $('.tabInput>.need').each(function(k,v){
            $(v).click(function(){
                // 获取内容
                var text = $(this).text();
                // 隐藏当前
                $(this).css('display','none');
                // 显示input 与内容
                $(this).parent().children('.outlet').css('display','inline-block').val(text).focus();
            })
        });

        // 输入框 ajax提交
        $('.tabInput>.outlet').blur(function() {
            // 保存值
            $(this).css('display', 'none').parent().children('.need').css('display', 'inline-block').text($(this).val());
            var text = $(this).val();
            var id = $(this).parent().attr('ids');
            $.ajax({
                url: "{{url('admin/normsCombo/status')}}/" + id,
                type: "post",
                data: {discount:text},
                success: function (res) {
                    layer.msg(res.msg);
                    location.reload();   //强制刷新
                },
                error: function (res) {
                    layer.msg(res.responseText);   //403错误
                }
            });
            return false;  //阻止表单提交
        });

        //导出方法
        function exports()
        {
            var data = $("#export").serialize();
//            console.log(data);
            location.href="{{url("admin/normsCombo/export")}}?"+data;
        }

        //  请选择商品
        function smallScreen() {
            if ($(window).width() < 768) {
                $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                    'width': '100%'
                });
            }
        }
        //    模拟数据
        $(function () {
            $("#dl_Filter_two").selectpicker({});  //初始化
            var erji = [
                    @foreach($goodsTypeInfo as $k=>$v)
                    @if(isset($v['child']))
                [

                        @foreach($v['child'] as $k1=>$v1)
                    [{{$v1['id']}}, '{{$v1['name']}}'],
                    @endforeach

                ],
                    @else
                [],
                @endif
                @endforeach
            ];
            var yuan = '<li data-original-index="0" class>' +
                '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                '<span class="text">请选择</span>' +
                '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                '</a>' +
                '</li>';
            if ($('#dl_Filter_one').parent().find('li.selected').attr('data-original-index') !== 0) {
                var zhi = parseFloat($('#dl_Filter_one').parent().find('li.selected').attr('data-original-index')) - 1;
                var cityIndex = erji[zhi];  // 当前下标在二级对应内容
                var html = '',
                    erjiOption = '';
                if (cityIndex !== undefined) {
                    var html = '<li data-original-index="0" class>' +
                        '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                        '<span class="text">请选择</span>' +
                        '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                        '</a>' +
                        '</li>';
                    var erjiOption = '<option value="0" ips="0">请选择</option>';
                    for (var i = 0; i < cityIndex.length; i++) {
                        html += '<li data-original-index=' + cityIndex[i][0] + '>' +
                            '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                            '<span class="text">' + cityIndex[i][1] + '</span>' +
                            '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                            '</a>' +
                            '</li>';
                        // 添加option
                        if (cityIndex[i][0] =={{$info['category']}}) {
                            erjiOption += '<option value=' + cityIndex[i][0] + ' selected ips=' + cityIndex[i][0] + '>' + cityIndex[i][1] + '</option>';
                        } else {
                            erjiOption += '<option value=' + cityIndex[i][0] + ' ips=' + cityIndex[i][0] + '>' + cityIndex[i][1] + '</option>';
                        }

                    }
                } else {
                    var html = '<li data-original-index="0" class>' +
                        '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                        '<span class="text">暂无</span>' +
                        '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                        '</a>' +
                        '</li>';
                    var erjiOption = '<option value="0" ips="0">暂无</option>';
                }
                $('#dl_Filter_two').prev('div.dropdown-menu').find('ul').html(html);
                $('#dl_Filter_two').html(erjiOption);
                $('.selectpicker').selectpicker('refresh');
            }

            $('#dl_Filter_one').change(function () {
                if ($(this).parent().find('li.selected').attr('data-original-index') === '0') {
                    $('#dl_Filter_two').prev('div.dropdown-menu').find('ul').html(yuan);
                    $('#dl_Filter_two').html('<option value="0" ips="0">请选择</option>');
                    $('.selectpicker').selectpicker('refresh');
                    smallScreen();
                    return;
                }
                var zhi = parseFloat($(this).parent().find('li.selected').attr('data-original-index')) - 1;
                var cityIndex = erji[zhi];  // 当前下标在二级对应内容
                var html = '',
                    erjiOption = '';
                if (cityIndex !== undefined) {
                    var html = '<li data-original-index="0" class>' +
                        '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                        '<span class="text">请选择</span>' +
                        '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                        '</a>' +
                        '</li>';
                    var erjiOption = '<option value="0" ips="0">请选择</option>';
                    for (var i = 0; i < cityIndex.length; i++) {
                        html += '<li data-original-index=' + cityIndex[i][0] + '>' +
                            '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                            '<span class="text">' + cityIndex[i][1] + '</span>' +
                            '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                            '</a>' +
                            '</li>';
                        // 添加option
                        erjiOption += '<option value=' + cityIndex[i][0] + ' ips=' + cityIndex[i][0] + '>' + cityIndex[i][1] + '</option>';
                    }
                } else {
                    var html = '<li data-original-index="0" class>' +
                        '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                        '<span class="text">暂无</span>' +
                        '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                        '</a>' +
                        '</li>';
                    var erjiOption = '<option value="0" ips="0">暂无</option>';
                }
                $('#dl_Filter_two').prev('div.dropdown-menu').find('ul').html(html);
                $('#dl_Filter_two').html(erjiOption);
                $('.selectpicker').selectpicker('refresh');
                smallScreen();
            });
        });
        $('#dl_Filter_two').change(function () {
            //console.log($(this).val());
        });
        $(function () {
            if ($(window).width() < 768) {
                $('.haspadding .row>div').removeClass('text-right');
                $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                    'width': '100%'
                });
            }
            $(window).resize(function () {
                if ($(window).width() < 768) {
                    $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn),.btn-group.bootstrap-select.col-md-12').css({
                        'width': '100%'
                    });
                } else {
                    $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                        'width': '153px'
                    });
                }
            });
        });
        //图片跟随
        $(function () {
            if ($('a.preview').length) {
                var img = preloadIm();
                imagePreview(img);
            }
        });
        //删除sku
        function del(id) {
            layer.confirm("是否确定删除此商品规格？", {
                btn: ['确定', '取消'], //按钮，
                title: '删除规格属性',
            }, function () {
                $.ajax({
                    type: "get",
                    url: "{{url("admin/normsCombo/delete")}}/" + id,
                    success: function (res) {
                        layer.msg(res.msg);
                        location.reload();
                    }
                });
            }, function () {
                layer.msg("取消成功");
            });
        }
        $(window).resize(function () {
            if ($(window).width() < 768) {
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '100%')
            } else {
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto')
            }
        });
        $(function () {
            if ($(window).width() < 768) {
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%')
            } else {
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto')
            }
        })

        //上下架状态
        function goodStatus(id)
        {
            $.ajax(
                {
                    url: "{{url("admin/normsCombo/goodStatus")}}/"+id,
                    type: "post",
                    success: function (res) {
                        layer.msg(res.msg);
                        location.reload();
                    },
                    error: function (res) {
                        layer.msg(res.responseText);
                    }
                });
        }
    </script>
@endsection