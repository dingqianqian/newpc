@extends("admin.layout.layout")
		@section("title","订单列表")
		@section("css")
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
					<b>-订单列表</b>
		<span class="pull-right">

			{{--錯誤--}}
			<a href="{{route('order.search')}}" class="btn btn-default btn-xs"><i></i>订单查询</a>
			<a href="{{route('order.export')}}" class="btn btn-default btn-xs"><i></i>订单导出</a>
		</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			{{--统计--}}
			<div class="panel panel-default dl_Commodity_panel">
				<div class="panel panel-body">
					<ul class="z-ul">
						<li>金额总计: <span>{{number_format($count['total_price'],2,".","")}}</span></li>
						<li>订单数量: <span>{{$count['count']}}</span></li>
						{{--<li>普通会员数: <span>3</span></li>--}}
					</ul>
				</div>
			</div>
			<!--搜索-->
			<div class="panel panel-default dl_Commodity_panel" style="font-weight: normal">
				<div class="panel panel-body" id="xiugaiInput">
					<form class="form-inline" action="{{route('order.list')}}" method="get">
						<div class="form-group">
							<input type="text" name="no" value="{{$info['no']}}" class="form-control input-sm" id="exampleInputName2" placeholder="订单号">
						</div>
						<div class="form-group">
							<input type="text" name="phone" value="{{$info['phone']}}" class="form-control input-sm" id="exampleInputEmail2" placeholder="下单人手机">
						</div>
						<div class="form-group">
							<select id="select" name="status[]">
								<option value="0">订单状态</option>
								@foreach($orderFormStatusInfo as $k=>$v)
									<option value="{{$v['id']}}" @if(in_array($v['id'],$info['status'])&&count($info['status'])==1) selected @endif>{{$v['name']}}</option>
									@endforeach
							</select>
						</div>
						{{--打印状态--}}
						<div class="form-group">
							{{--<label class="control-label ">是否打印</label>--}}
							<select id="z-select"  name="print">
								<option value="0">是否打印</option>
								<option value="1" @if($info['print']==1) selected @endif>已打印</option>
								<option value="2" @if($info['print']==2) selected @endif>未打印</option>
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
							</label> 订单编号
						<th>订单状态</th>
						<th>打印时间</th>
						<th>收货人姓名</th>
						<th>下单人电话</th>
						<th>下单时间</th>
						<th>订单金额</th>
						<th>使用优惠金额</th>
						<th>地区</th>
						<th>支付方式</th>
						<th>操作</th>
					</tr>
					</thead>
					<tbody>
					@foreach($orderInfo['data'] as $k=>$v)
						<tr>
							<td>{{$v['id']}}</td>
						<td>
  					{{--<input type="checkbox" value="option1">--}}
							{{$v['no']}}</td>
							<td>{{$v['order_form_status']['name']}}</td>
							<td>{{$v['print_out_time']?date("Y-m-d H:i:s",$v['print_out_time']):"未打印"}}</td>
						<td>{{$v['take_over_name']}}</td>
						<td>{{$v['take_over_tel_no']}}</td>
						<td>{{date("Y-m-d H:i:s",$v['create_time'])}}</td>
							@if(in_array($v['f_pay_type_id'],[14,15,16]))
							<td>{{number_format($v['discount_price'],2,".","")}}</td>
							@else
									<td>{{number_format($v['price'],2,".","")}}</td>
							@endif
						<td>{{$v['coupon']?number_format($v["coupon"]['use_value'],2,".",""):"未使用优惠券"}}</td>
						<td>{{$v['area']['name']}}</td>
						<td>{{$v['pay_type']['name']}}</td>
						<td>
							<a href="{{route('order.info',['id'=>$v['id']])}}" class="z_a_color"><span class="glyphicon glyphicon-search" title="查看"></span></a>
							{{--<span class="glyphicon glyphicon-trash" title="删除" style="margin-left: 5px;"></span>--}}
						</td>
					</tr>
					@endforeach
					</tbody>
				</table>
				{{$orderInfos->appends(["phone"=>"{$info['phone']}","no"=>"{$info['no']}","status"=>"{$info['page_status']}","print"=>"{$info['print']}","min_time"=>"{$info['min_time']}","max_time"=>"{$info['max_time']}","min_price"=>"{$info['min_price']}","max_price"=>"{$info['max_price']}","pay_type"=>"{$info['pay_type']}","area"=>$info['area']])->links()}}
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
<script>// 下拉搜索
$(function() {
	$('#select').searchableSelect();
    $('#z-select').searchableSelect();
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
});
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