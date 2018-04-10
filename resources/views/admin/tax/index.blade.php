@extends("admin.layout.layout")
		@section("title","认证列表")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/jedate.css")}}">
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
						<b>-资质信息</b>
						<!--<span class="pull-right"><a href="#" class="btn btn-default btn-xs"><i></i>用户充值</a></span>-->
					</div>
				</div>
			</section>

			<!-- 内容 -->
			<section class="content container-fluid">
				<!--搜索-->
				<div class="panel panel-default dl_Commodity_panel" style="font-weight: normal">
					<div class="panel panel-body" id="xiugaiInput">
						<form class="form-inline" action="{{route("tax.list")}}" method="get" id="export">
							<!--根据用户联系电话-->
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="根据用户联系电话" name="phone" value="{{$info['phone']}}">
							</div>
							<!--时间-->
							<div class="form-group ">
							{{--<label for="" style="margin-top: 4px;">开始时间:</label>--}}
								<span>开始时间：</span>
							<input type="text" class="form-control input-sm" id="dateinfo" name="min_time" value="{{$info['min_time']}}"> -- <input type="text" class="form-control input-sm" placeholder="结束时间"  id="datebut" onClick="jeDate({dateCell:'#datebut',isTime:true,format:'YYYY年MM月DD日'})" name="max_time" value="{{$info['max_time']}}">
							</div>
							<!--订单状态-->
							<div class="form-group">
							{{--<label for="" class="control-label">订单状态</label>--}}
							<select id="select" class="form-control" name="status">
								<option value="0" @if($info['status']==0) selected @endif>所有状态</option>
								<option value="1" @if($info['status']==1) selected @endif>待审核</option>
								<option value="2" @if($info['status']==2) selected @endif>已通过</option>
								<option value="3" @if($info['status']==3) selected @endif>已驳回</option>
							</select>
							</div>
							{{csrf_field()}}
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
				{{--<input type="checkbox" id="checkAll">--}}用户ID
						</label>
								</th>
								<th><label for="">联系电话</label></th>
								<th><label for="">提交申请时间</label></th>
								<th><label for="">审核状态</label></th>
								<th><label for="">公司名称</label></th>
								<th><label for="">操作</label></th>
							</tr>
						</thead>
						<tbody>
						@foreach($addValueTaxInfo['data'] as $k=>$v)
							<tr>
								<td>
									{{--<input type="checkbox" />--}}{{$v['user']['id']}}
								</td>
								<td>{{$v['user']['signin_name']}}</td>
								<td>{{date("Y-m-d H:i:s",$v['create_time'])}}</td>
								@if($v['status']==1)
								<td>待审核</td>
								@elseif($v['status']==2)
									<td>已通过</td>
								@else
									<td>已驳回</td>
								@endif
								<td>{{$v['company_name']}}</td>
								<td>
									<a href="{{route('tax.info',['id'=>$v['id']])}}" class="z_a_color" title="查看"><img src="{{asset("admin/img/details.png")}}" alt="查看"/></a>
									<!--<a href="z_rechargequery.html" class="z_a_color"><span class="glyphicon glyphicon-eye-open" title="删除"></span></a>-->
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					{{$addValueTaxInfos->appends(["min_time"=>"{$info['min_time']}","max_time"=>"{$info['max_time']}","status"=>"{$info['status']}","phone"=>"{$info['phone']}"])->links()}}
				</form>
				</div>
			</section>

			@component("admin.layout.footer")
				@endcomponent

		</div>
@endsection

@section("js")
	<script src="{{asset("admin/js/distpicker.data.js")}}"></script>
	<script src="{{asset("admin/js/distpicker.js")}}"></script>
	<script src="{{asset("admin/js/jedate.min.js")}}"></script>
	<script>
		//审核列表方法
		function exports()
		{
		    var data = $("#export").serialize();
		    location.href="{{url("admin/tax/export")}}?"+data;
		}
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
	</script>
@endsection