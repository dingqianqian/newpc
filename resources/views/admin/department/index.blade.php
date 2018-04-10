@extends("admin.layout.layout")
        @section("title","部门列表")
@section("content")
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-部门列表</b>
                    <span class="pull-right">
			<a href="{{route("department.create")}}" class="btn btn-default btn-xs"><i></i>添加新部门</a>
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
                        <th>
                            <label class="checkbox inline">
                                {{--<input type="checkbox" id="" value="option1">编号--}}编号
                            </label>
                        </th>
                        <th>部门名称</th>
                        <th>地区</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departmentInfo['data'] as $k=>$v)
                    <tr>
                        <td>
                            {{--<input type="checkbox" />12--}}{{$v['id']}}
                        </td>
                        <td>{{$v['name']}}</td>
                        @foreach($areaInfo as $kk=>$vv)
                            @if($vv['id'] == $v['f_area_id'])
                        <td>{{$vv['name']}}</td>
                            @endif
                        @endforeach
                        <td>
                            <a href="{{route("department.edit",['id'=>$v['id']])}}" class="z_a_color"><img src="{{asset("admin/img/edit.png")}}" alt=""></a>
                            <a href="javascript:;" onclick="dele({{$v['id']}})" class="z_a_color"><img src="{{asset("admin/img/delete.png")}}" alt=""></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$departmentInfos->links()}}
            </form>
            </div>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent

    </div>
    <!-- /.content-wrapper -->
@endsection

@section("js")
<script>
    //弹出框
    function dele(id) {
        layer.confirm("是否确定删除此部门？", {
            btn: ['确定', '取消'], //按钮，
            title: '删除此部门',
        }, function() {
            $.ajax({
                url:"{{url('admin/department/delete')}}/"+ id,
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


//    $(function(){
//        // 全选
//        $('#checkAll').click(function() {
//            // 保存当前状态
//            var ischecked = $(this).prop('checked');
//            // 遍历check
//            $('tbody>tr>td>input').each(function(k, v) {
//                $(v).prop('checked', ischecked);
//            });
//        });
//// 点击选择
//        $('tbody>tr>td>input').unbind('click').click(function() {
//            var flag = true;
//            if($(this).prop('checked')) {
//                $('tbody>tr>td>input').not('#checkAll').each(function(k, v) {
//                    if($(v).prop('checked') == false) {
//                        flag = false;
//                        return false;
//                    }
//                });
//            } else {
//                flag = false;
//            }
//            if(flag) {
//                $('#checkAll').prop('checked', 'checked');
//            } else {
//                $('#checkAll').prop('checked', false);
//            }
//        });
//    })
</script>
@endsection