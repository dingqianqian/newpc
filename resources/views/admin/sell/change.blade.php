@extends("admin.layout.layout")
@section("title","用户改绑")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_rceived.css")}}">
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
                    <b>-销售明细</b>
                    <!--<span class="pull-right">
    <a href="#" class="btn btn-default btn-xs"><i></i>用户充值</a>
</span>-->
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--统计-->
            <div class="panel panel-default dl_Commodity_panel">
                <div class="panel panel-body">
                    <ul class="z-ul">
                        <li>注册用户总量: <span>{{$count}}</span></li>
                    </ul>
                </div>
            </div>
            <!--搜索-->
            <div class="panel panel-default dl_Commodity_panel" style="font-weight: normal">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{route('change.list')}}" method="get" id="export">
                        <!--日期-->
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" id="dateinfo" name="start_time"
                                   placeholder="开始时间" value="{{$info['start_time']}}"> --
                            <input type="text" class="form-control input-sm" placeholder="结束时间" id="datebut"
                                   onClick="jeDate({dateCell:'#datebut',isTime:true,format:'YYYY年MM月DD日'})"
                                   name="end_time" value="{{$info['end_time']}}">
                        </div>
                        <!--所有分类-->
                        <div class="form-group">
                            <select id="select" name="area">
                                <option value="0">所有地区</option>
                                @foreach($areaInfo as $k=>$v)
                                    <option value="{{$v['id']}}"
                                            @if($info['area']==$v['id']) selected @endif>{{$v['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--所有分类-->
                        <div class="form-group">
                            <select id="selecta" name="employee">
                                <option value="0">所有员工</option>
                                @foreach($employeeInfo as $k=>$v)
                                    <option value="{{$v['id']}}"
                                            @if($info['employee']==$v['id']) selected @endif>{{$v['username']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="signin_name" class="form-control input-sm" value="{{$info['signin_name']}}" placeholder="账户或手机号">
                        </div>

                        {{csrf_field()}}
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="exports()">导出</button>
                    </form>
                </div>
            </div>
            <!--表格-->
            <div class="panel panel-default">
            <form class="form-inline table-responsive" id="lyF">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr>
                        <th>
                            <label class="checkbox inline">
                                {{--<input type="checkbox" id="checkAll" value="option1">--}}编号
                            </label>
                        </th>
                        <th><label for="">账户</label></th>
                        <th><label for="">用户名</label></th>
                        <th><label for="">酒店名称</label></th>
                        <th><label for="">所在地区</label></th>
                        <th><label for="">注册时间</label></th>
                        <th><label for="">绑定时间</label></th>
                        <th><label for="">绑定时所属员工</label></th>
                        <th><label for="">改绑</label></th>
                        <!--<th>操作</th>-->
                    </tr>
                    </thead>
                    <tbody class="z-rec-select">
                    @foreach($userInfo['data'] as $k=>$v)
                        <tr>
                            <td>
                                {{--<input type="checkbox" />--}}{{$v['id']}}
                            </td>
                            <td>{{$v['signin_name']}}</td>
                            <td>{{$v['username']?$v['username']:"未填写"}}</td>
                            <td>{{$v['hotel_name']?$v['hotel_name']:"未填写"}}</td>
                            <td>@if($v['employee']['f_area_id']==0)
                                    未绑定
                                @else
                                    @foreach($areaInfo as $k1=>$v1)
                                        @if($v['employee']['f_area_id']==$v1['id'])
                                            {{$v1['name']}}
                                        @endif
                                    @endforeach
                                @endif</td>
                            <td>{{date("Y-m-d H:i:s",$v['create_time'])}}</td>
                            <td>{{$v['bind_employee_time']?date("Y-m-d H:i:s",$v['bind_employee_time']):"未绑定"}}</td>
                            <td>{{$v['employee']?$v['employee']['username']:"未绑定"}}</td>
                            <td ids="{{$v['id']}}" idz="{{$v['employee']['id']}}">
                                <button id="ly_gaibang" type="button" class="ly_gaibang btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">改绑</button>
                                {{--<select id="goodsNames" class="selectpicker" data-live-search="true">
                                        <option value="0">未绑定</option>
                                        @foreach($employeeInfo as $k1=>$v1)
                                            <option value="{{$v1['id']}}"
                                                    @if($v['f_employee_id']==$v1['id']) selected @endif>{{$v1['username']}}</option>
                                        @endforeach
                                </select>--}}
                            </td>
                            <!--<td>
                                <a href="z_rechargequery.html" class="z_a_color"><span class="glyphicon glyphicon-eye-open" title="查看"></span></a>
                            </td>-->
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
            </div>
            {{$userInfos->appends(["start_time"=>"{$info['start_time']}","end_time"=>"{$info['end_time']}","area"=>$info['area'],"employee"=>$info['employee'],"signin_name"=>"{$info["signin_name"]}"])->links()}}
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent
        <form class="row" role="form" method="get">
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">请选择要改绑的员工</h4>
                        </div>
                        <div class="modal-body">
                            <select id="goodsNames" class="selectpicker" data-live-search="true">
                                <option value="0">未绑定</option>
                                @foreach($employeeInfo as $k1=>$v1)
                                    <option value="{{$v1['id']}}">{{$v1['username']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" id="lyslSure">确定</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.content-wrapper -->

@endsection

@section("js")
    <script src="{{asset("admin/js/distpicker.data.js")}}"></script>
    <script src="{{asset("admin/js/distpicker.js")}}"></script>
    <script src="{{asset("admin/js/jedate.min.js")}}"></script>
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
    <script src="{{asset("admin/js/defaults-zh_CN.js")}}"></script>
    <script src="{{asset("admin/js/jquery.searchableSelect.js")}}"></script>
    <script>
        //用户改绑方法
        function exports()
        {
            var data = $("#export").serialize();
            location.href = "{{url("admin/sell/changeExport")}}?"+data;
        }
        // 下拉搜索
        $(function () {
            $('#select').searchableSelect();
            $('#selecta').searchableSelect();
            // 日期
            jeDate({
                dateCell: "#dateinfo",
                format: "YYYY年MM月DD日",
                isinitVal: true,
                isTime: true, //isClear:false,
                minDate: "1901-1-1",
                okfun: function (val) {
                    alert(val)
                }
            })
        });
        $(function () {
            if ($(window).width() < 768) {
                $('div.searchable-select').css('width', '100%')
                $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width', '99%');
            } else {
                $('div.searchable-select').css('width', '160px');
                $('.z-rec-select tr td div.searchable-select').css('width', '80px');
                $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width', 'auto');
            }
        });
        // 下拉搜索
        $(function () {
            // 全选
            $('#checkAll').click(function () {
                // 保存当前状态
                var ischecked = $(this).prop('checked');
                // 遍历check
                $('tbody>tr>td>label>input').each(function (k, v) {
                    $(v).prop('checked', ischecked);
                });
            });
            // 点击选择
            $('tbody>tr>td>input').unbind('click').click(function () {
                var flag = true;
                if ($(this).prop('checked')) {
                    $('tbody>tr>td>input').not('#checkAll').each(function (k, v) {
                        if ($(v).prop('checked') == false) {
                            flag = false;
                            return false;
                        }
                    });
                } else {
                    flag = false;
                }
                if (flag) {
                    $('#checkAll').prop('checked', 'checked');
                } else {
                    $('#checkAll').prop('checked', false);
                }
            });
        });
        var ids;
        $('.ly_gaibang').each(function(k,v){
            $(v).click(function(){
                $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css('width','100%');
                // 默认选中id
                ids = $(this).parent('td').attr('ids');
                var morenId = $(this).parent('td').attr('idz');
                var selected;
                var slText;
                var slId = $('#goodsNames>option');
                for(var i=0;i<slId.length;i++){
                    if($(slId[i]).val() === morenId){
                        selected = slId[i];
                        $(selected).attr('selected',true);
                        slText = $(selected).text();
                        $('#myModal .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) .filter-option').text(slText);
                        $(selected).siblings(':selected').removeAttr('selected')
                    }
                }
                $('#myModal .bootstrap-select.btn-group .dropdown-menu.inner a span:first-child').each(function(k,v){
                    if($(v).text() === slText){
                        $(v).parent().parent().addClass('selected').siblings('.selected').removeClass('selected');
                    }
                })
            })
        })
        var employeeId;
        $('.selectpicker').change(function (){
            employeeId=$(this).val();
            $(this).addClass('selected').siblings('.selected').removeClass('selected');
        })
        $('#lyslSure').click(function() {
            var id = ids;
            $.ajax({
                url:"{{url("admin/sell/changeEmployee")}}/"+id,
                type:"post",
                data:{employee:employeeId},
                success:function (res) {
                    layer.msg(res.msg);
                    location.reload();
                },
                error:function (res) {
                    layer.msg(res.responseText);
                }
            });
        });
        /*$('.selectpicker').change(function () {
            var employeeId=$(this).val();
//            var id=$(this).attr("ids");
            var id = ids;
            layer.confirm("确定改绑该用户吗？", {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    {{--url:"{{url("admin/sell/changeEmployee")}}/"+id,--}}
                    type:"post",
                    data:{employee:employeeId},
                    success:function (res) {
                        layer.msg(res.msg);
                        location.reload();
                    },
                    error:function (res) {
                        layer.msg(res.responseText);
                    }
                });
            }, function(){

            });
        });*/

    </script>
@endsection