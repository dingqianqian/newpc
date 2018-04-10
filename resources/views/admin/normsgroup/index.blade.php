@extends('admin.layout.layout')
@section('title','规格分组列表')
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
                    <b>-规格列表</b>
                    <span class="pull-right">
<a href="{{route('normsgroup.create')}}" class="btn btn-default btn-xs"><i></i>添加规格</a>
</span>
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">
            <!--表格-->
            <div class="panel panel-default">
            <form class="form-inline table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr>
                        <th>
                            <label class="checkbox inline">
                                {{--<input type="checkbox" id="checkAll" value="option1">编号--}}编号
                            </label>
                        </th>
                        <th>规格名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($normsGroupInfo['data'] as $K=>$v)
                    <tr>
                        <td>
                            {{--<input type="checkbox" />001--}}{{$v['id']}}
                        </td>
                        <td>{{$v['name']}}</td>
                        <td>
                            <a href="{{route('normsgroup.edit',['id'=>$v['id']])}}" class="z_a_color"><img src="{{asset("admin/img/edit.png")}}" alt=""></a>
                            {{--<a href="javascript:;" onclick="dele({{$v['id']}})"><span class="glyphicon glyphicon-trash dele" style="margin-left: 5px; cursor: pointer;" title="删除"></span></a>--}}
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$normsGroupInfos->links()}}
            </form>
            </div>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent
    </div>

@endsection
<!-- jQuery 3 -->
@section('js')
<script>
    //	弹出框
    function dele(id) {
        layer.confirm("是否确定删除此分组？", {
            btn: ['确定', '取消'], //按钮，
            title: '删除规格分组',
        }, function() {
            $.ajax({
                url: "{{url('admin/normsgroup/delete')}}/" + id,
                type: "post",
                success: function(res) {
                    layer.msg(res.msg);
                    location.reload();
                },
                error: function(res) {
                    layer.msg(res.responseText);
                }
            });
        }, function() {
            layer.msg('取消成功');
        });
        return false;
    }
    // 下拉搜索
//    $(function() {
//        // 日期
//        jeDate({
//            dateCell: "#dateinfo",
//            format: "YYYY-MM-DD",
//            isinitVal: true,
//            isTime: true, //isClear:false,
//            minDate: "1901-1-1",
//            okfun: function(val) {
//                alert(val)
//            }
//        })
//    });
//
//    $(function() {
//        // 全选
//        $('#checkAll').click(function() {
//            // 保存当前状态
//            var ischecked = $(this).prop('checked');
//            // 遍历check
//            $('tbody>tr>td>input').each(function(k, v) {
//                $(v).prop('checked', ischecked);
//            });
//        });
//        // 点击选择
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
