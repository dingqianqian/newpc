@extends("admin.layout.layout")
@section("title","订制列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/custom.css")}}">
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
                    <b>-订制列表</b>
                    {{--<span class="pull-right">--}}
{{--<a href="{{route("news.create")}}" class="btn btn-default btn-xs"><i></i>添加新闻</a>--}}
{{--</span>--}}
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel" style="font-weight: normal;font-size:12px;">
                <div class="panel panel-body">
                    <form class="form-inline" id="xiugaiInput" action="{{route("custom.list")}}" method="get">
                        <!--关键字-->
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="酒店名称" name="hotel_name" value="{{$info["hotel_name"]}}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="用户手机号" name="signin_name" value="{{$info["signin_name"]}}">
                        </div>
                        <div class="form-group">
                            <select id="select" name="is_delete">
                                <option value="2" @if($info["is_delete"]==2) selected @endif>全部状态</option>
                                <option value="1" @if($info["is_delete"]==1) selected @endif>已删除</option>
                                <option value="0" @if($info["is_delete"]==0) selected @endif>未删除</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <!--表格-->
            <div class="panel panel-default">
                <form class="form-inline table-responsive">
                    <table class="table table-bordered table-hover text-center zf_table">
                        <thead>
                        <tr>
                            <th>
                                <label class=" z_first text-center">
                                    {{--<input type="checkbox" id="checkAll" value="option1">--}}编号
                                </label>
                            </th>
                            <th><label for="">酒店名称</label></th>
                            <th><label for="">酒店地址</label></th>
                            <th><label for="">酒店电话</label></th>
                            <th><label for="">酒店logo</label></th>
                            <th><label for="">状态</label></th>
                            <th><label for="">用户手机号</label></th>
                            <th><label for="">创建时间</label></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customInfo["data"] as $k=>$v)
                            <tr>
                                <td>{{$v["id"]}}</td>
                                <td>{{$v["hotel_name"]}}</td>
                                <td>{{$v["hotel_address"]}}</td>
                                <td>{{$v["hotel_phone"]}}</td><td>
                                    <div class="demo z_div">
                                        <a path="{{$v["logo_url"]}}" class="preview" href="javascript:;">
                                        悬浮查看</a>
                                    </div>
                                </td>
                                @if($v["is_delete"] == 0)
                                <td>未删除</td>
                                @elseif($v["is_delete"] == 1)
                                    <td>已删除</td>
                                @endif
                                <td>{{$v["user"]["signin_name"]}}</td>
                                <td>{{date("Y-m-d H:i:s",$v["create_time"])}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                {{$customInfos->appends([["hotel_name"=>"{$info["hotel_name"]}"],["signin_name"=>"{$info["signin_name"]}"],["is_delete"=>$info["is_delete"]]])->links()}}
            </div>
        </section>

        @component("admin.layout.footer")
        @endcomponent

    </div>
@endsection
@section("js")
    <script src="{{asset("admin/js/jedate.min.js")}}"></script>
    <script src="{{asset("admin/js/previewshow.js")}}"></script>
    <script>

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
        })
        //	展示图片
        $(function(){
            if($('a.preview').length){
                var img = preloadIm();
                imagePreview(img);
            }
        })

        // 下拉搜索
        $(function(){
            $('#select').searchableSelect();
            $('#ly_select').searchableSelect();
        });
        $(window).resize(function() {
            if($(window).width() < 768) {
                $('div.searchable-select').css('width', '100%');
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%');

            }else {
                $('div.searchable-select').css('width', '140px');
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto');
            }
        });
        $(function() {
            if($(window).width() < 768) {
                $('div.searchable-select').css('width', '100%')
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%');
            }else {
                $('div.searchable-select').css('width', '160px');
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto');
            }
        })
    </script>

@endsection