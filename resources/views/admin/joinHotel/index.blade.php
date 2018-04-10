@extends("admin.layout.layout")
@section("title","酒店加盟列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/z_rceived.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_special.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/dl_css.css")}}">
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
                    <b>-酒店加盟列表</b>
                    <span class="pull-right">
			<a href="{{route("joinHotel.create")}}" class="btn btn-default btn-xs"><i></i>添加加盟酒店</a>
		</span>
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="" method="get" id="export">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="酒店名称" name="name" value="{{$info["name"]}}">
                        </div>
                        <div class="form-group">
                            <select id="select" name="type">
                                <option value="2" @if($info["type"]==2) selected @endif>全部状态</option>
                                <option value="0" @if($info["type"]==0) selected @endif>自营</option>
                                <option value="1" @if($info["type"]==1) selected @endif>连锁</option>
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
                                <label class="checkbox inline">
                                    ID
                                </label>
                            </th>
                            <th>酒店名称</th>
                            <th>logo</th>
                            <th>酒店类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($joinHotelInfo["data"] as $k=>$v)
                            <tr>
                            <td>{{$v["id"]}}</td>
                            <td>{{$v["name"]}}</td>
                            <td>
                                <div class="demo">
                                    <a path="{{$v["logo_url"]}}" class="preview" href="javascript:;">
                                        悬浮查看 </a>
                                </div>
                            </td>
                                @if($v["type"] == 0)
                            <td>自营</td>
                                @else
                                    <td>连锁</td>
                                @endif
                                <td>
                                    <a href="{{route("joinHotel.edit",["id"=>$v["id"]])}}" class="z_a_color">
                                        <img src="{{asset("admin/img/edit.png")}}"  title="编辑" alt="">
                                    </a>
                                    <a href="javascript:;" onclick="del({{$v["id"]}})">
                                        <img src="{{asset("admin/img/delete.png")}}"  title="删除" alt="">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                {{$joinHotelInfos->appends([["name"=>"{$info["name"]}"],["type"=>$info["type"]]])->links()}}
            </div>
        </section>

        @component("admin.layout.footer")
        @endcomponent
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("js")
    <script src="{{asset("admin/js/previewshow.js")}}"></script>

    <script>
        // 下拉搜索
        $(function(){
            $('#select').searchableSelect();
        });
        $(window).resize(function(){
            if($(window).width()<768){
                $('div.searchable-select').css('min-width','100%');
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%')
            }else{
                $('div.searchable-select').css('width','160px');
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto')
            }
        });
        $(function(){
            if($(window).width()<768){
                $('div.searchable-select').css('min-width','100%')
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%')
            }else{
                $('div.searchable-select').css('width','160px');
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto')
            }
        })
        function del(id) {
            layer.confirm("是否确定删除此加盟酒店？", {
                btn: ['确定', '取消'], //按钮，
                title: '删除加盟酒店',
            }, function() {
                $.ajax({
                    url:"{{url('admin/joinHotel/delete')}}/"+ id,
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
        //	展示图片
        $(function(){
            if($('a.preview').length){
                var img = preloadIm();
                imagePreview(img);
            }
        })
    </script>
@endsection