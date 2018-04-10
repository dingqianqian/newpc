@extends('admin.layout.layout')
@section('title','推送列表')
@section('css')
    @endsection
@section('content')

    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-推送列表</b>
                    <span class="pull-right">
			<a href="{{route("push.create")}}" class="btn btn-default btn-xs"><i></i>添加推送</a>
		</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <div class="panel panel-default">
            <!--表格-->
            <form class="form-inline table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>通知栏提示文字</th>
                        <th>标题</th>
                        <th>描述</th>
                        {{--<th>跳转新闻位置</th>--}}
                        <th>推送类型</th>
                        <th>推送时间</th>
                        {{--<th>操作</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pushInfo as $k=>$v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['message']}}</td>
                        <td>{{$v['title']}}</td>
                        <td>{{$v['description']}}</td>
                        {{--<td>跳转url</td>--}}
                        <td>
                            @if($v['type']==0)
                                新闻链接
                                @elseif($v['type']==1)
                                单件商品---ID:{{$v['custom_id']}}
                                @else
                                商品分类---ID:{{$v['custom_id']}}
                                @endif
                        </td>
                        <td>{{date("Y-m-d",$v['create_time'])}}</td>
                        {{--<td>
                            <a href="{{route("push.edit")}}" class="edit"><img src="{{asset("/admin/img/edit.png")}}" title="编辑" alt=""></a>
                            <a href="javascript:;" class="delect"><img src="{{asset("/admin/img/delete.png")}}" title="删除" alt=""></a>
                        </td>--}}
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            </div>
        </section>

        <!-- Footer -->
       @component('admin.layout.footer')
        @endcomponent

    </div>
@endsection

@section('js')
<script>
    // 弹框
    $('.delect').each(function(k,v){
        $(v).click(function(){
            layer.confirm('确定要删除推送'+"吗？", {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                 url:"{{url('admin/push/delete')}}/"+id,
                 type:"post",
                 success:function (res) {
                 layer.msg(res.msg);
                 location.reload();
                 },
                 error:function (res) {
                 layer.msg(res.responseText);
                 }
                 });
            }, function(){
                layer.msg("取消成功");
            });

        });
    });
</script>
@endsection