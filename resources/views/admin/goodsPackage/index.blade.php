@extends("admin.layout.layout")
@section("title","订制套餐列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/ly_roleList.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_special.css")}}">
@endsection
    @section("content")
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-套餐列表</b>
                    <span class="pull-right">
<a href="javascript:;" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal"><i></i>添加套餐</a>
		</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default" style="margin-bottom: 15px">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{route("goodsPackage.list")}}" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="名称" name="name" value="{{$info["name"]}}">
                        </div>
                        <div class="form-group">
                            {{--状态 :--}}
                            <select class="selectpicker" data-live-search="true" name="status">
                                <option value="3" @if($info["status"] == 3) selected @endif>全部状态</option>
                                <option value="0" @if($info["status"] == 0) selected @endif>上架</option>
                                <option value="1" @if($info["status"] == 1) selected @endif>下架</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <!--表格-->
            <div class="panel panel-default">
                <form class="form-inline table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th>
                                编号
                            </th>
                            <th>
                                <label class="checkbox inline">

                                </label> 名称
                            <th>价格</th>
                            <th>11121(价格)</th>
                            <th>主图</th>
                            {{--<th>详情图</th>--}}
                            <th>状态</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($goodsPackageInfo["data"] as $k=>$v)
                        <tr>
                            <td>{{$v["id"]}}</td>
                            <td>{{$v["name"]}}</td>
                            <td>{{$v["show_price"]}}</td>
                            <td>{{$v["show_sale_price"]}}</td>
                            <td>
                                <div class="demo" >
                                    <a path="{{$v['thumb_url']}}" class="preview" href="javascript:;">
                                        悬浮查看</a>
                                </div>
                            </td>
                            {{--<td>{{$v["f_goods_details_img"]}}</td>--}}
                            @if($v["status"] == 0)
                                <td>
                                    <a href="javascript:;" style="color: red" onclick="status({{$v["id"]}})">上架</a>
                                </td>
                            @else
                                <td>
                                    <a href="javascript:;" style="color: #0CA6FC" onclick="status({{$v["id"]}})">下架</a>
                                </td>
                            @endif
                            @if($v["create_time"] == 0)
                                <td>暂无</td>
                            @else
                            <td>{{date("Y-m-d",$v["create_time"])}}</td>
                            @endif
                            @if($v["update_time"] == 0)
                                <td>暂无</td>
                            @else
                                <td>{{date("Y-m-d",$v["update_time"])}}</td>
                            @endif
                            <td>
                                <a href="{{route("goodsPackage.edit",["id"=>$v["id"]])}}" class="z_a_color"><img src="{{asset("admin/img/edit.png")}}" alt="" title="编辑"></a>
                                <a href="javascript:;" onclick="del({{$v['id']}})">
                                    <img src="{{asset("admin/img/delete.png")}}" alt="" title="删除">
                                </a>
                                <a href="{{route("goodsPackage.info",["id"=>$v["id"]])}}" class="edit" title="查看详情"><img src="{{asset("admin/img/details.png")}}" alt="">
                                </a>
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                {{$goodsPackageInfos->appends(["name"=>"{$info["name"]}","status"=>$info["status"]])->links()}}
            </div>
        </section>

        <!-- Footer -->
        <!-- Footer -->
       @component("admin.layout.footer")
           @endcomponent
    </div>
        <form class="row" role="form"  method="get" action="{{route("goodsPackage.create")}}">
            <div class="modal fade" id="myModal"  role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">请选择要添加的商品名称</h4>
                        </div>
                        <div class="modal-body">
                            <select class="col-md-12 selectpicker" data-live-search="true" name="type">
                                <option value="0">酒店用品专区</option>
                                <option value="1">饭店用品专区</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            {{csrf_field()}}
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
<script src="{{asset("admin/js/previewshow.js")}}"></script>
<script>
    //上下架状态
    function status(id)
    {
        $.ajax(
            {
                url: "{{url("admin/goodsPackage/status")}}/"+id,
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
    //删除方法
    function del(id) {
        layer.confirm("是否确定删除此套餐？", {
            btn: ['确定', '取消'], //按钮，
            title: '删除套餐',
        }, function() {
            $.ajax({
                url:"{{url('admin/goodsPackage/delete')}}/"+ id,
                type: "post",
                success: function(res) {
                    layer.msg(res.msg);
                    location.reload();   //强制刷新
                },
                error: function(res) {
                    layer.msg(res.responseText);   //403错误
                }
            });
        }, function() {
            layer.msg("取消成功");       //弹出取消成功
        });
        return false;    //阻止表单提交
    }
    $(window).resize(function() {
        if($(window).width() < 768) {
            $('div.searchable-select').css('min-width', '100%');
            $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%')
        } else {
            $('div.searchable-select').css('width', '160px');
            $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto')
        }
    });
    $(function() {
        if($(window).width() < 768) {
            $('div.searchable-select').css('min-width', '100%')
            $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%')
        } else {
            $('div.searchable-select').css('width', '160px');
            $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto')
        }
    })
    //	展示图片
    $(function(){
        if($('a.preview').length){
            var img = preloadIm();
            imagePreview(img);
        }
    })
</script>
@endsection