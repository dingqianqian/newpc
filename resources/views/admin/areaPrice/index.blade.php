@extends('admin.layout.layout')
@section('title','折扣列表')
@section('css')
    <link rel="stylesheet" href="{{asset("admin/css/jquery.searchableSelect.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset('admin/css/ly_roleList.css')}}">

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
                    <b>-折扣列表</b>
                    <span class="pull-right">
<a href="{{route('areaPrice.create')}}" class="btn btn-default btn-xs"><i></i>添加折扣</a>
</span>
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">
            <div class="panel panel-default" style="margin-bottom: 15px">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{route('areaPrice.list')}}" method="get">
                        <!--下拉搜索-->
                        <div class="form-group">
                            <span class="">地区 :</span>
                            <select class="selectpicker" data-live-search="true" name="f_area_id">
                                <option value="">请选择</option>
                                @foreach($areaInfo as $k=>$v)
                                    <option value="{{$v["id"]}}" @if($info["f_area_id"] == $v["id"]) selected @endif>{{$v["name"]}}</option>
                                    @endforeach
                            </select>
                            {{--<span class="">折扣 :</span>--}}
                            {{--<select class="selectpicker" data-live-search="true" name="discount">--}}
                                {{--<option value="0">请选择</option>--}}
                                {{--<option value="1">0.1~0.5</option>--}}
                                {{--<option value="2">0.5~1.0</option>--}}
                            {{--</select>--}}
                        </div>
                        {{csrf_field()}}
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
                                    {{--<input type="checkbox" id="checkAll" value="option1">编号--}}编号
                                </label>
                            </th>
                            <th>地区</th>
                            <th>折扣</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($areaDiscountInfo["data"] as $k=>$v)
                       <tr>
                           <td>{{$v["id"]}}</td>
                           <td>{{$v['area']["name"]}}</td>
                           <td>{{$v["discount"]*10}}</td>
                       </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$areaDiscountInfos->links()}}
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
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
    <script>
        //	弹出框
        function dele(id) {
            layer.confirm("是否确定删除此分组？", {
                btn: ['确定', '取消'], //按钮，
                title: '删除规格分组',
            }, function() {
                $.ajax({
                    url: "" + id,
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
