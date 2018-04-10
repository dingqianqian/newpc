@extends("admin.layout.layout")
@section("title","入驻列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/z_strand.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_special.css")}}">
    <link rel="stylesheet" href="{{asset('admin/css/dl_css.css')}}">
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
                    <b>-入驻列表</b>
                    <span class="pull-right">
		{{--<a href="#" class="btn btn-default btn-xs"><i></i>用户充值</a>--}}
	</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel" style="font-size: 12px;font-weight:normal">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="" method="get">
                        <!--用户手机号-->
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="用户手机号" name="phone" value="{{$info["phone"]}}">
                        </div>
                        <!--所有分类-->
                        <div class="form-group">
                            <select id="select" name="status">
                                <option value="4" @if($info["status"]==4) selected @endif>全部状态</option>
                                <option value="0" @if($info["status"]==0) selected @endif>审核中</option>
                                <option value="1" @if($info["status"]==1) selected @endif>审核通过</option>
                                <option value="2" @if($info["status"]==2) selected @endif>驳回</option>
                            </select>
                        </div>
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
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
                                <th><label for="">用户手机号</label></th>
                                <th><label for="">名称</label></th>
                                <th><label for="">地址</label></th>
                                <th><label for="">电话</label></th>
                                <th><label for="">审核状态</label></th>
                                <th><label for="">logo</label></th>
                                <th><label for="">创建时间</label></th>
                                <th><label for="">操作</label></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($enterInfo["data"] as $k=>$v)
                            <tr>
                                <td>
                                    {{$v["id"]}}
                                </td>
                                <td>{{$v["user"]["signin_name"]}}</td>
                                <td>{{$v["name"]}}</td>
                                <td>{{$v["address"]}}</td>
                                <td>{{$v["phone"]}}</td>
                                @if($v["status"] == 0)
                                <td>正在审核</td>
                                @elseif($v["status"] == 1)
                                    <td>审核通过</td>
                                @else
                                    <td>驳回</td>
                                @endif
                                <td>
                                    <div class="demo">
                                        <a path="{{$v["logo_url"]}}" class="preview" href="javascript:;">
                                           悬浮查看 </a>
                                    </div>
                                </td>
                                <td>{{date("Y-m-d H:i:s",$v["create_time"])}}</td>
                                <td>
                                    <a href="{{route("enter.info",["id"=>$v["id"]])}}" class="z_a_color"><span class="glyphicon glyphicon-search" title="查看详情"></span></a>
                                </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                    {{$enterInfos->appends([["phone"=>"{$info["phone"]}"],["status"=>$info["status"]]])->links()}}
                </div>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent
    </div>
    <!-- /.content-wrapper -->
@endsection
@section("js")
    <script src="{{asset("admin/js/previewshow.js")}}"></script>
    <script>
        // 下拉搜索
        $(function() {
            $('#select').searchableSelect();
            // 日期
            jeDate({
                dateCell: "#dateinfo",
                format: "YYYY年MM月DD日",
                isinitVal: true,
                isTime: true, //isClear:false,
                minDate: "1901-1-1",
                okfun: function(val) {
                    alert(val)
                }
            })
        });
        // 屏幕变化，用于测试
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
        // 下拉搜索
        $(function() {
            // 全选
            $('#checkAll').click(function() {
                // 保存当前状态
                var ischecked = $(this).prop('checked');
                // 遍历check
                $('tbody>tr>td>label>input').each(function(k, v) {
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
        });
        //	展示图片
        $(function(){
            if($('a.preview').length){
                var img = preloadIm();
                imagePreview(img);
            }
        })
    </script>
@endsection