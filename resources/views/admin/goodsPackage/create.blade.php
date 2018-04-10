@extends("admin.layout.layout")
@section("title","添加订制套餐")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_attr.css")}}">
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
                    <b>-添加订制套餐</b>
                    <span class="pull-right">
		<a href="{{route("goodsPackage.list")}}" class="btn btn-default btn-xs"><i></i>套餐列表</a>
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
            <form class="form-horizontal" action="{{route("goodsPackage.add")}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="{{$info["type"]}}">
                <!--套餐名称-->
                <div class="form-group">
                    <label for="name" class="control-label col-xs-4">套餐名称</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                </div>
                <!--易购价-->
                <div class="form-group">
                    <label for="phone" class="control-label col-xs-4">易购价</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" id="phone" name="show_price">
                    </div>
                </div>
                <!--狂购价-->
                <div class="form-group">
                    <label for="email" class="control-label col-xs-4">狂购价</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" name="show_sale_price">
                    </div>
                </div>
                <!--商品状态-->
                <div class="form-group">
                    <label for="wcart" class="control-label col-xs-4">商品状态</label>
                    <div class="col-xs-6">
                        <select class="selectpicker zf-select" data-live-search="true" name="status">
                            <option value="0">上架</option>
                            <option value="1">下架</option>
                        </select>
                    </div>
                </div>
                <!--所属商铺-->
                <div class="form-group">
                    <label for="wcart" class="control-label col-xs-4">商品</label>
                    <div class="col-xs-6">
                        <select id="id_select" class="selectpicker bla bla bli zf-select" multiple data-live-search="true" name="f_goods_norms_id[]">
                            {{--<optgroup>--}}
                            @foreach($normsComboInfo as $k=>$v)
                                <option value="{{$v['id']}}" >{{$v['goods']['open_id']}}({{$v['norms']}})</option>
                            </optgroup>
                                @endforeach
                        </select>
                    </div>
                </div>
                <!--上传商品图片-->
                <div class="form-group">
                    <label for="shang" class="control-label col-xs-4">上传商品主图</label>
                    <input type="file" class="col-xs-4" id="shang" name="masterImg">
                </div>
                <!--上传商品详情图片-->
                <div class="form-group">
                    <label for="shang" class="control-label col-xs-4">上传商品详情图片</label>
                    <input type="file" class="col-xs-4" id="shang" name="detailsImg">
                </div>
                <!--提交-->
                {{csrf_field()}}
                <div class="submitBtn text-center">
                    <button type="submit" class="btn btn-success">确定</button>
                    <button type="reset" class="btn btn-primary">重置</button>
                </div>
            </form>
        </section>
        <!-- Footer -->
        <!-- Footer -->
        @component("admin.layout.footer")
            @endcomponent
    </div>
</div>
{{--<form class="row" role="form"  method="get" action="http://newpc.yiyousu.cn/admin/normsCombo/create">--}}
    {{--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
        {{--<div class="modal-dialog" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span--}}
                                {{--aria-hidden="true">&times;</span></button>--}}
                    {{--<h4 class="modal-title" id="myModalLabel">请选择要添加的商品名称</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<select class="col-md-12 selectpicker" data-live-search="true" name="goods_id">--}}
                        {{--<option value="561">饭店套餐</option>--}}
                        {{--<option value="563">酒店套餐</option>--}}

                    {{--</select>--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>--}}
                    {{--<button type="submit" class="btn btn-primary">确定</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</form>--}}
    @endsection
@section("js")
<script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
<script src="{{asset("admin/js/defaults-zh_CN.js")}}"></script>
<script>
    $(function() {
        if($(window).width() < 768) {
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
        if($(window).width() < 768) {
            $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                'width': '100%',
                'margin-top': '10px'
            });
        }
    }
    //		$(function(){
    //			 $('.selectpicker').selectpicker({
    //              'selectedText': 'cat'
    //         });
    //     });
</script>
@endsection