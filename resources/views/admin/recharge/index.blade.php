@extends("admin.layout.layout")
		@section("title","充值列表")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/z_strand.css")}}">
			<link rel="stylesheet" href="{{asset('admin/css/z_memberList.css')}}">
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
						<b>-充值列表</b>
						<span class="pull-right">
		{{--<a href="#" class="btn btn-default btn-xs"><i></i>用户充值</a>--}}
	</span>
					</div>
				</div>
			</section>

			<!-- 内容 -->
			<section class="content container-fluid">
				{{--统计--}}
				<div class="panel panel-default dl_Commodity_panel" style="font-size: 12px;font-weight:normal">
					<div class="panel panel-body">
						<ul class="z-ul">
							<li>充值订单数: <span>{{$count['order']}}</span></li>
							<li>充值金额总计: <span>{{number_format($count['price'],2,".","")}}</span></li>
							<li>返现金额总计: <span>{{number_format($count['give'],2,".","")}}</span></li>
						</ul>
					</div>
				</div>
				<!--搜索-->
				<div class="panel panel-default dl_Commodity_panel" style="font-size: 12px;font-weight:normal">
					<div class="panel panel-body" id="xiugaiInput">
						<form class="form-inline" action="{{route('recharge.list')}}" method="get" id="export">
							<!--用户手机号-->
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="用户手机号" name="phone" value="{{$info['phone']}}">
							</div>
							<!--充值单号-->
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="exampleInputEmail2" placeholder="充值单号" name="no" value="{{$info['no']}}">
							</div>
							{{--<!--用户酒店-->
							<div class="form-group">
								<input type="text" class="form-control input-sm" id="exampleInputEmail2" placeholder="用户酒店">
							</div>--}}
							<!--支付时间-->
							<div class="form-group">
								<span for="">支付时间</span>
								<input type="text" class="form-control input-sm" id="dateinfo" name="min_time" value="{{$info['min_time']}}"> --
									<input type="text" class="form-control input-sm" value="{{$info['max_time']}}" id="datebut" name="max_time" onClick="jeDate({dateCell:'#datebut',isTime:true,format:'YYYY年MM月DD日'})">
							</div>
							<!--所有分类-->
							<div class="form-group">
								<select id="select" name="pay_type">
									<option value="0">所有分类</option>
									@foreach($payTypeInfo as $k=>$v)
									<option value="{{$v['id']}}" @if($v['id']==$info['pay_type']) selected @endif>{{$v['name']}}</option>
										@endforeach
								</select>
							</div>
							{{csrf_field()}}
							<button type="submit" class="btn btn-success btn-sm">搜索</button>
							<button type="button" class="btn btn-warning btn-sm" onclick="exports()">导出</button>
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
								<th><label for="">充值单号</label></th>
								<th><label for="">充值金额</label></th>
								<th><label for="">返现金额</label></th>
								<th><label for="">支付方式</label></th>
								<th><label for="">支付时间</label></th>
								<th><label for="">创建时间</label></th>
								<th><label for="">用户酒店</label></th>
								<th><label for="">操作</label></th>
							</tr>
						</thead>
						<tbody>
							@foreach($rechargeInfo['data'] as $k=>$v)
							<tr>
								<td>
									{{$v['id']}}
								</td>
								<td>{{$v['user']?$v['user']['signin_name']:"用户已被删除"}}</td>
								<td>{{$v['no']}}</td>
								<td>{{number_format($v['price'],2,".","")}}</td>
								<td>{{number_format($v['give_back'],2,".","")}}</td>
								<td>{{$v['pay_type']?$v['pay_type']['name']:"手动充值"}}</td>
								<td>{{date("Y-m-d H:i:s",$v['pay_time'])}}</td>
								<td>{{date("Y-m-d H:i:s",$v['create_time'])}}</td>
								<td>{{$v['user']?$v['user']['hotel_name']:"用户已被删除"}}</td>
								<td>
									<a href="{{route('recharge.info',['id'=>$v['id']])}}" class="z_a_color"><span class="glyphicon glyphicon-search" title="查看"></span></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{$rechargeInfos->appends(["pay_type"=>"{$info['pay_type']}","min_time"=>"{$info['min_time']}","max_time"=>"{$info['max_time']}","no"=>"{$info['no']}","phone"=>"{$info['phone']}"])->links()}}
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
	<script src="{{asset('admin/js/distpicker.data.js')}}"></script>
	<script src="{{asset('admin/js/distpicker.js')}}"></script>
	<script src="{{asset('admin/js/jedate.min.js')}}"></script>
	<script>
        function exports(){
            var data=$("#export").serialize();
            location.href="{{url("admin/recharge/export")}}?"+data;
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

	</script>
@endsection