@extends('admin.layout.layout')
@section('title','优惠券列表')
@section("css")
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
                    <b>-优惠券列表</b>
                    <span class="pull-right">
			<a href="{{route('coupontype.create')}}" class="btn btn-default btn-xs"><i></i>添加新优惠券</a>
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
                                {{--<input type="checkbox" id="checkAll" value="option1">优惠券名称--}}优惠券名称
                            </label>
                        </th>
                        <th>有效期起点</th>
                        <th>有效期终点</th>
                        <th>使用类型</th>
                        <th>抵用金额(折扣)</th>
                        <th>派发总数</th>
                        <th>使用金额起点</th>
                        <th>是否全场通用</th>
                        <th>状态</th>
                        {{--<th>缩略图</th>--}}
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                   @foreach($couponTypeInfo as $k=>$v)
                    <tr>
                        <td>
                            {{--<input type="checkbox" />--}}{{$v['name']}}
                        </td>
                        <td>{{date('Ymd',$v['expire_time_start'])}}</td>
                        <td>{{date('Ymd',$v['expire_time_end'])}}</td>
                        <td>{{$v['use_type']}}</td>
                        <td>{{$v['use_value']}}</td>
                        <td>{{$v['distribute_count']}}</td>
                        <td>{{$v['start_price']}}</td>
                        @if($v['is_include_over']=="T")
                        <td>是</td>
                            @else
                            <td>否</td>
                        @endif
                        <td>{{$v['coupon_status']['name']}}</td>
                        {{--<td>--}}
                            {{--<div class="demo">--}}
                                {{--<a path="http://www.yiyousu.cn/dash/uploads/48fc349104ef6aecc66e1e6987e9bdb3.jpg" class="preview" href="javascript:;">--}}
                                    {{--件支持鼠标滑过、点击、自动切换、数据回调等功能</a>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        <td>
                            <a href="{{route('coupontype.edit',['id'=>$v['id']])}}" class="z_a_color"><img src="{{asset("admin/img/edit.png")}}" alt=""></a>
                            {{--<a href="javascript:;" onclick="del({{$v['id']}})"><span class="glyphicon glyphicon-trash dele" style="margin-left: 5px;" title="删除"></span></a>--}}
                            <a href="javascript:;" onclick="dele({{$v['id']}})" class="z_a_color"><img src="{{asset("admin/img/delete.png")}}" alt=""></a>
                        </td>
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
    <!-- /.content-wrapper -->

    <div class="control-sidebar-bg"></div>
</div>
    @endsection

<!-- jQuery 3 -->
@section('js')
<script>
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
    //	弹出框
    {{--$(".dele").each(function(k, v) {--}}

    {{--});--}}

    function dele(id) {
        layer.confirm("是否确定删除此优惠券？", {
            btn: ['确定', '取消'], //按钮，
            title: '删除优惠券',
        }, function() {
            $.ajax({
                url:"{{url('admin/coupontype/delete')}}/"+ id,
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


    //	展示图片
    $(function(){
        if($('a.preview').length){
            var img = preloadIm();
            imagePreview(img);
        }
    })

</script>
@endsection