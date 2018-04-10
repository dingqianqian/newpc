@extends("admin.layout.layout")
@section("title","广播列表")
@section("css")
    <link rel="stylesheet" type="text/css" href="{{asset("admin/css/z_special.css")}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset("admin/css/dl_css.css")}}"/>
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
                    <b>- 广播列表</b>
                    <span class="pull-right">
                        <a href="{{route("broadcastSystem.create")}}" class="btn btn-default btn-xs"><i></i>添加广播</a>
                    </span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel" style="font-weight: normal;font-size: 12px;">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{url("admin/broadcastSystem/index")}}" method="get" enctype="text/plain">
                        <!--日期1-->
                        <div class="form-group">
                            开始日期:
                            <input class="datainp form-control input-sm" name="begin_time" id="dateinfo"   value="{{$info['begin_time']}}"  type="text">
                        </div>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <!--日期2-->
                        <div class="form-group">
                            结束日期:
                            <input class="datainp form-control input-sm" name="end_time"   value="{{$info['end_time']}}"  id="datebut" type="text">
                        </div>
                        <div class="form-group">
                            <input class="form-control input-sm" type="text" value="{{$info['title']}}" name="title" placeholder="广播标题">
                        </div>
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <!--表格-->
            <div class="panel panel-default">
            <form class="form-inline table-responsive" >
                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr>
                        <th style="min-width: 45px;" >编号</th>
                        <th>标题</th>
                        <th>内容</th>
                        <th style="min-width: 65px;">图片</th>
                        <th style="min-width: 90px;">创建时间</th>
                        <th style="min-width: 52px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($broadcastSystemInfo["data"] as $k=>$v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td class="titleTd" style="max-width: 180px; overflow: hidden;white-space: nowrap;-ms-text-overflow: ellipsis;text-overflow: ellipsis;cursor: pointer;" title="{{$v['title']}}">{{$v['title']}}</td>
                        <td class="contentTd" style="max-width: 650px; overflow: hidden;white-space: nowrap;-ms-text-overflow: ellipsis;text-overflow: ellipsis;cursor: pointer;" title="{{$v['commit']}}">{{$v['commit']}}</td>
                        <td>
                            <div class="demo">
                                <a path="{{$v['img']}}" class="preview" href="javascript:;">
                                    悬浮查看
                                </a>
                            </div>
                        </td>
                        <td>{{date("Y-m-d",$v["create_time"])}}</td>
                        <td>
                            <a href="{{route("broadcastSystem.edit",["id"=>$v["id"]])}}" class="edit"><img src="{{asset("admin/img/edit.png")}}" alt="" title="编辑"></a>
                            <a href="javascript:;" class="delete" onclick="del({{$v['id']}})"><img src="{{asset("admin/img/delete.png")}}" alt="" title="删除"></a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
                <!--分页-->
                {{$broadcastSystemInfos->appends(["title"=>"{$info["title"]}","begin_time"=>"{$info['begin_time']}","end_time"=>"{$info["end_time"]}"])->links()}}
                <div></div>
            </form>
            </div>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
            @endcomponent
    </div>
@endsection

@section("js")
    <script src="{{asset("admin/js/jedate.min.js")}}"></script>
    <script src="{{asset("admin/js/previewshow.js")}}" type="text/javascript" charset="utf-8"></script>
<script>
    // 开始日期
    jeDate({
        dateCell:"#dateinfo",
        format:"YYYY年MM月DD日",
        isinitVal:true,
        isTime:true, //isClear:false,
        minDate:"1901-01-01"
    });
    // 结束日期
    jeDate({
        dateCell:"#datebut",
        format:"YYYY年MM月DD日",
        isinitVal:true,
        isTime:true, //isClear:false,
        minDate:"1901-01-01"
    });

    // 删除弹框
//    $('.delete').each(function(k,v){
//        $(v).click(function(){
//            layer.confirm('是否确定删除此条广播？', {
//                title:'删除广播信息',
//                btn: ['确定','取消'] //按钮
//            }, function(){
//                $.ajax({
//                 url:+id,
//                 type:"post",
//                 success:function (res) {
//                 layer.msg(res.msg);
//                 location.reload();
//                 },
//                 error:function (res) {
//                 layer.msg(res.responseText);
//                 }
//                 });
//            }, function(){
//                layer.msg("取消成功");
//            });
//        });
//    });

    function del(id) {
        layer.confirm("是否确定删除此条广播？", {
            btn: ['确定', '取消'], //按钮，
            title: '删除广播信息',
        }, function() {
            $.ajax({
                url:"{{url('admin/broadcastSystem/delete')}}/"+ id,
                type: "post",
                success: function(res) {
                    layer.msg(res.msg);
                    location.reload();   //刷新
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


    $(function () {
        if ($('a.preview').length) {
            var img = preloadIm();
            imagePreview(img);
        }
    });

</script>
@endsection