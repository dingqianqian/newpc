@extends("admin.layout.layout")
@section("title","优惠券列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/jquery.searchableSelect.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset('admin/css/ly_roleList.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/z_coupon.css')}}">

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
			<!--<a href="z_addshop.html" class="btn btn-default btn-xs"><i></i></a>-->
		</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
                <div class="panel panel-default" style="margin-bottom: 15px">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{route("coupon.list")}}" method="get" id="export">
                        <div class="form-group">
                            <select class="selectpicker" data-live-search="true" id="dl_Filter_two"
                                    name="f_area_id">
                                <option value="0" selected="">地区</option>
                                @foreach($areaInfo as $k=>$v)
                                    <option value="{{$v["id"]}}" @if($info["f_area_id"] == $v["id"]) selected @endif>{{$v["name"]}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select  name="status" style="height: 30px;line-height: 30px;padding: 0 4px;font-size: 12px;">
                                <option value="0">优惠券状态</option>
                                <option value="1" @if($info["status"] == 1) selected @endif>未使用</option>
                                <option value="2" @if($info["status"] == 2) selected @endif>已使用</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="signin_name" placeholder="手机号" value="{{$info["signin_name"]}}">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="exports()">导出</button>
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
                                    编号
                                </label>
                            </th>
                            <th>用户名</th>
                            <th>手机号</th>
                            <th>优惠券状态</th>
                            <th>领取时间</th>
                            <th>使用时间</th>
                            <th>使用类型</th>
                            <th>价值</th>
                            <th>地区</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($couponInfo["data"] as $k=>$v)
                        <tr>
                            <td>{{$v["id"]}}</td>
                            @if(!$v["user"]["username"])
                                <td>暂无</td>
                            @else
                            <td>{{$v["user"]["username"]}}</td>
                            @endif
                            @if(!$v["user"]["signin_name"])
                                <td>用户已删除</td>
                            @else
                            <td>{{$v["user"]["signin_name"]}}</td>
                            @endif
                            @if($v["use_time"] == 0)
                            <td>未使用</td>
                            @else
                                <td>已使用</td>
                            @endif
                            <td>{{date("Y-m-d",$v["create_time"])}}</td>
                            @if($v["use_time"] == 0)
                                <td>暂无</td>
                            @else
                            <td>{{date("Y-m-d",$v["use_time"])}}</td>
                            @endif
                            <td>{{$v["use_type"]}}</td>
                            <td>{{$v["use_value"]}}</td>
                            @if($v["f_area_id"] == 0)
                                <td>全国</td>
                            @endif
                            @foreach($areaInfo as $kk=>$vv)
                             @if($v["f_area_id"] == $vv["id"])
                                 <td>{{$vv["name"]}}</td>
                                @endif
                                @endforeach
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
                {{$couponInfos->appends(["f_area_id"=>$info["f_area_id"],"status"=>$info["status"],"signin_name"=>"{$info["signin_name"]}"])->links()}}
            </div>
        </section>

        <!-- Footer -->
       @component("admin.layout.footer")
           @endcomponent
    </div>
    <div class="control-sidebar-bg"></div>

@endsection
@section("js")
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
<script>
    //导出方法
    function exports()
    {
        var data = $("#export").serialize();
        location.href = "{{url("admin/coupon/export")}}?"+data;
    }
    // 下拉搜索
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
    // 下拉搜索
    $(function() {
        // 全选
        $('#checkAll').click(function() {
            // 保存当前状态
            var ischecked = $(this).prop('checked');
            // 遍历check
            $('tbody>tr>td>input').each(function(k, v) {
                $(v).prop('checked', ischecked);
            });
        });
        // 点击选择
        $('tbody>tr>td>input').unbind('click').click(function() {
            var flag = true;
            if($(this).prop('checked')) {
                $('tbody>tr>td>input').not('#checkAll').each(function(k, v) {
                    if($(v).prop('checked') == false) {
                        flag = false;
                        return false;
                    }
                });
            } else {
                flag = false;
            }
            if(flag) {
                $('#checkAll').prop('checked', 'checked');
            } else {
                $('#checkAll').prop('checked', false);
            }
        });
    })</script>
@endsection