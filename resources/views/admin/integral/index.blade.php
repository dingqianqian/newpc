@extends("admin.layout.layout")
@section("title","积分列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/ly_roleList.css")}}">
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
                    <b>-积分列表</b>
                    <span class="pull-right">

			{{--錯誤--}}
                        {{--<a href="{{route('order.search')}}" class="btn btn-default btn-xs"><i></i>订单查询</a>--}}
		</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default" style="margin-bottom: 15px">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{url('admin/integral/index')}}" method="get">
                        <div class="form-group">
                            <input type="text" name="id" value="{{$Info['id']}}" class="form-control input-sm" id="exampleInputName2" placeholder="ID">
                        </div>
                        <div class="form-group">
                            <input type="text" name="f_user_signin_name" value="{{$Info['f_user_signin_name']}}" class="form-control input-sm" id="exampleInputEmail2" placeholder="用户账号">
                        </div>
                        <div class="form-group">
                             处理状态 :
                            <select class="selectpicker" data-live-search="true" name="status">
                                <option value="0" @if($Info['status']==0) selected @endif>全部</option>
                                <option value="1" @if($Info['status']==1) selected @endif>已处理</option>
                                <option value="2" @if($Info['status']==2) selected @endif>未处理</option>
                            </select>
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
                            ID
                        </th>
                        <th>
                            <label class="checkbox inline">
                                {{--<input type="checkbox" id="checkAll" value="option1">--}}
                            </label> 用户账号
                        <th>积分</th>
                        <th>留言</th>
                        <th>充值手机号</th>
                        <th>积分兑换序号</th>
                        <th>是否已处理</th>
                        <th>积分商品编号</th>
                        <th>第三方快递单号</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($integralInfo['data'] as $k=>$v)
                        <tr>
                            <td>{{$v['id']}}</td>
                            <td>{{$v['f_user_signin_name']}}</td>
                            <td>{{$v['use_integral']}}</td>
                            <td>{{$v['commit']?$v['commit']:"暂无"}}</td>
                            <td>{{$v['recharge_tel']?$v['recharge_tel']:"暂无"}}</td>
                            <td>{{$v['no']}}</td>
                            @if($v['fixed_time']=="0")
                            <td>未处理</td>
                            @else
                                <td>已处理</td>
                            @endif
                            <td>{{$v['f_integral_goods_id']}}</td>
                            <td>{{$v['expressage']?$v['expressage']:"暂无"}}</td>
                            <td>
                                <a href="{{route('integral.info',['id'=>$v['id']])}}" class="edit" title="查看详情"><img src="{{asset("admin/img/details.png")}}" alt=""></a>
                            </td>
                        </tr>
                            @endforeach
                    </tbody>
                </table>
                {{$integralInfos->appends(["id"=>$Info['id'],"f_user_signin_name"=>"{$Info['f_user_signin_name']}","status"=>$Info['status']])->links()}}
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
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
    <script src="{{asset("admin/js/defaults-zh_CN.js")}}"></script>
    <script>
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
        $(function(){
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
            $('tbody>tr>td>label>input').unbind('click').click(function() {
                var flag = true;
                if($(this).prop('checked')) {
                    $('tbody>tr>td>label>input').not('#checkAll').each(function(k, v) {
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
    </script>
@endsection