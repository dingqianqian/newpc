@extends("admin.layout.layout")
@section("title","订单详情")
@section("css")
	<link rel="stylesheet" href="{{asset("admin/css/z_roleList.css")}}">
@endsection

@section("content")

			<section class="content-wrapper">
				<!-- Content Header -->
				<section class="content-header">
					<div class="panel panel-default">
						<div class="panel-body">
							<b>
						<a href="javascript:;">宜优速 管理中心</a>
					</b>
							<b>-订单信息</b>
							<span class="pull-right">
			<a href="{{route('order.list')}}" class="btn btn-sm btn-default"><i></i>订单列表</a>


		</span>
						</div>
					</div>
				</section>

				<!-- 内容 -->
				<section class="content container-fluid">
					<div class="panel panel-default">
						<div class="panel-body text-center">
							@if(session("employeeInfo")['f_area_id']==1)
							<a href="{{route("order.info",['id'=>$id,"status"=>"2"])}}" class="btn btn-bitbucket btn-sm">前一个订单</a>
							<a href="{{route("order.info",['id'=>$id,"status"=>"1"])}}" class="btn btn-bitbucket btn-sm">后一个订单</a>
							@endif
							<a target="_blank" href="{{route("order.print",['no'=>$orderInfo['no']])}}" class="btn btn-danger btn-sm">打印订单</a>
							<a href="javascript:;" class="btn btn-sm btn-warning" onclick="addRemark()">添加备注</a>
						</div>
					</div>
					<!--基本信息-->
					<div class="z-order">
						<form class="form-inline table-responsive">
							<table class="table table-bordered table-striped dataTable">
								<thead>
									<tr>
										<th colspan="4" style="font-size: 14px;"  class="text-center">基本信息</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="col-md-3">订单号:</th>
										<td class="col-md-3">{{$orderInfo['no']}}</td>
										<th class="col-md-3">订单状态:</th>
										<td class="col-md-3">{{$orderInfo['order_form_status']['name']}}</td>
									</tr>
									<tr>
										<th class="col-md-3">购货人账号:</th>
										<td class="col-md-3">{{$orderInfo['user']['signin_name']}}</td>
										<th class="col-md-3">下单时间:</th>
										<td class="col-md-3">{{date("Y-m-d H:i:s",$orderInfo['create_time'])}}</td>
									</tr>
									<tr>
										<th class="col-md-3">支付方式:</th>
										<td class="col-md-3">
											{{$orderInfo['pay_type']['name']?$orderInfo['pay_type']['name']:"未支付"}}
											{{--<a href="#" class="btn btn-dropbox zf-check">编辑</a>--}}
										</td>
										<th class="col-md-3">付款时间:</th>
										<td class="col-md-3">{{$orderInfo['pay_time']?date("Y-m-d H:i:s",$orderInfo['pay_time']):"暂无信息"}}</td>
									</tr>
									<tr>
										<th class="col-md-3">配送方式:</th>
										<td class="col-md-3">速立派
											{{--<a href="#" class="btn btn-dropbox zf-check">编辑</a>--}}
										</td>
										<th class="col-md-3">打印时间:</th>
										<td class="col-md-3">{{$orderInfo['print_out_time']?date("Y-m-d H:i:s",$orderInfo['print_out_time']):"未打印"}}</td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
					<!--收货人信息-->
					<div class="z-order">
						<form class="form-inline table-responsive">
							<table class="table table-bordered table-striped dataTable">
								<thead>
									<tr>
										<th colspan="4" style="font-size: 14px;" class="text-center">收货人信息
											{{--<a href="#" class="btn btn-dropbox zf-check">编辑</a>--}}
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="col-md-3">收货人:</th>
										<td class="col-md-3">{{$orderInfo['take_over_name']}}</td>
										<th class="col-md-3">地址:</th>
										<td class="col-md-3">{{$orderInfo['take_over_addr']}}</td>
									</tr>
									<tr>
										<th class="col-md-3">公司:</th>
										<td class="col-md-3">{{$orderInfo['take_over_company']}}</td>
										<th class="col-md-3">手机:</th>
										<td class="col-md-3">{{$orderInfo['take_over_tel_no']}}</td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
					@if(in_array($orderInfo['f_order_form_status_id'],[6,7,10,11]))
					{{--退款退货原因--}}
					<div class="z-order">
						<form class="form-inline table-responsive">
							<table class="table table-bordered table-striped dataTable">
								<thead>
								<tr>
									<th colspan="4" style="font-size: 14px;" class="text-center">退款/退货原因
										{{--<a href="#" class="btn btn-dropbox zf-check">编辑</a>--}}
									</th>
								</tr>
								</thead>
								<tbody>
								@if(in_array($orderInfo['f_order_form_status_id'],[6,7]))
								<tr>
									<th class="col-md-3">原因:</th>
									<td class="col-md-3">{{$orderInfo['refund_reason']}}</td>
									<th class="col-md-3">说明:</th>
									<td class="col-md-3">{{$orderInfo['refund_explain']}}</td>
								</tr>
								@endif
								@if(in_array($orderInfo['f_order_form_status_id'],[10,11]))
								<tr>
									<th class="col-md-3">原因:</th>
									<td class="col-md-3">{{$orderInfo['return_goods_reason']}}</td>
									<th class="col-md-3">说明:</th>
									<td class="col-md-3">{{$orderInfo['return_goods_explain']}}</td>
								</tr>
									@endif
								</tbody>
							</table>
						</form>
					</div>
					@endif
					<!--商品信息-->
					<div>
						<form class="form-inline table-responsive">
							<table class="table table-bordered table-striped dataTable text-center">
								<thead>
									<tr>
										<th colspan="5" style="font-size: 14px;">商品信息
											{{--<a href="#" class="btn btn-dropbox zf-check">编辑</a>--}}
										</th>
									</tr>
									<tr>
										<th>商品名称</th>
										<th>规格</th>
										<th>数量</th>
										<th>价格</th>
										<th>小计</th>
									</tr>
								</thead>
								<tbody id="z-tbody">
								@foreach($goodsInfo as $k=>$v)
									@if($v["order"]["f_custom_id"] == 0)
										<tr>
											<td class="col-md-6 " style="cursor: pointer;"  data-target="#myModal">{{$v['goods']['name']}}</td>
											<td class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											</td>
											<td>@foreach($v['norms_name'] as $k1=>$v1) {{$v1['name']}}&nbsp;&nbsp; @endforeach</td>
											<td class="z-num">{{$v['order']['number']}}</td>
											<td class="z-price">{{number_format($v['order']['deal_min_price'],2,".","")}}</td>
											<th class="z-subtotal"></th>
										</tr>
									@else
									<tr>
										<td class="col-md-6 " style="cursor: pointer;" data-toggle="modal" data-target="#myModal">{{$v['goods']['name']}}</td>
										<td class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
															&times;
														</button>
														<h4 class="modal-title" id="myModalLabel">
															酒店定制信息
														</h4>
													</div>
													<div class="modal-body">
														<div class="form-group z-form-group">
															<div for="username" class="zcontrol-label">酒店名称:</div>
															<div class="z-group">
																{{$v["order"]["custom"]["hotel_name"]}}
															</div>
														</div>
														<div class="form-group z-form-group">
															<div for="username" class="zcontrol-label">酒店地址:</div>
															<div class="z-group">
																{{$v["order"]["custom"]["hotel_address"]}}
															</div>
														</div>
														<div class="form-group z-form-group">
															<div for="username" class="zcontrol-label">酒店电话:</div>
															<div class="z-group">
																{{$v["order"]["custom"]["hotel_phone"]}}
															</div>
														</div>
														<div class="form-group z-img">
															<div for="username" class="zcontrol-label">酒店logo:</div>
															<div class="z-group">
																<p><img src="{{$v['order']["logo"]}}" alt=""></p>
															</div>
														</div>
													</div>
												</div><!-- /.modal -->
											</div>
										</td>
										<td>@foreach($v['norms_name'] as $k1=>$v1) {{$v1['name']}}&nbsp;&nbsp; @endforeach</td>
										<td class="z-num">{{$v['order']['number']}}</td>
										<td class="z-price">{{number_format($v['order']['deal_min_price'],2,".","")}}</td>
										<th class="z-subtotal"></th>
									</tr>
									@endif
								@endforeach
								<tr>
									<td colspan="4" style="text-align: right;">合计</td>
									<td id="z-total"></td>
								</tr>
								</tbody>
							</table>
						</form>
					</div>
					{{--备注--}}
					<div>
						<form class="form-inline table-responsive">
							<table class="table table-bordered table-striped dataTable text-center">
								<thead>
								<tr>
									<th colspan="5" style="font-size: 14px;">员工备注信息
										{{--<a href="#" class="btn btn-dropbox zf-check">编辑</a>--}}
									</th>
								</tr>
								</thead>
								<tbody id="z-tbody">
									<tr>
										<td>{{$orderInfo['employee_remark']?$orderInfo['employee_remark']:"暂无信息"}}</td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
					<!--操作信息-->
					<div class="z-order">
						<form class="form-inline table-responsive">
							<table class="table table-bordered table-striped dataTable">
								<thead>
									<tr>
										<th colspan="4" class="text-center" style="font-size: 14px;">操作信息</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th colspan="1" class="col-md-4 text-right" >当前可执行操作:</th>
										<td colspan="3"class="col-md-8" id="mange">
											@if(in_array($orderInfo['f_order_form_status_id'],[4]))
											<a href="javascript:;" class="btn btn-success btn-sm" ids="1">标记为已送达</a>
											@endif
												@if(in_array($orderInfo['f_order_form_status_id'],[2]))
											<a href="javascript:;" class="btn btn-warning btn-sm" ids="2">标记为已出库</a>
												@if($orderInfo['print_out_time']==0&&$orderInfo['print_out_id']==0)
													<a href="javascript:;" class="btn btn-danger btn-sm" ids="7">标记为已打印</a>
													@endif
												@endif
												@if(in_array($orderInfo['f_order_form_status_id'],[10]))
											<a href="javascript:;" class="btn btn-danger btn-sm" ids="3">标记退货完成</a>
												@endif
												@if(in_array($orderInfo['f_order_form_status_id'],[6]))
											<a href="javascript:;" class="btn btn-danger btn-sm" ids="4">标记退款完成</a>
													<a href="javascript:;" class="btn btn-danger btn-sm" ids="8">退款驳回</a>
												@endif
												@if(in_array($orderInfo['f_order_form_status_id'],[5]))
											<a href="javascript:;" class="btn btn-warning btn-sm" ids="5">标记为已签收</a>
											<a href="javascript:;" class="btn btn-primary btn-sm" ids="6">提醒用户签收</a>
													@endif
										</td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>
				</section>
				<!-- /.content-wrapper -->
				<!-- Footer -->
				@component("admin.layout.footer")
					@endcomponent
				<div class="control-sidebar-bg"></div>
			</section>
	@endsection
@section("js")
<script type="text/javascript">
        function addRemark() {
            var data = " <div class='form-group d-div'>" +
                "<div>" +
                "<textarea class='form-control d_val' rows='3' id='remark'></textarea>" +
                "</div> </div>";
            layer.confirm("添加备注", {
                type:1,
                btn: ['保存', '取消'], //按钮，
                title: "<span style='font-weight: 900'>添加备注</span>",
                content: data,
                area: ['320px', '190px']
            }, function () {
                var val=$('#remark').val();
                $.ajax({
					type:"post",
					url:"{{url("admin/order/remark")}}/{{$orderInfo['id']}}",
					data:{name:val},
					success:function (res) {
					    layer.msg(res.msg);
					    location.reload();
                    }
				});
            }, function () {
                layer.msg('取消成功');
            });
            return false;
        };
    $(document).ready(function() {
        var zNum;
        var zPrice;
        var zSubtotal ;
        var zTotal=0;
        $('#z-tbody').find('tr').each(function() {
            zNum = $(this).find('.z-num').text();
            zPrice = $(this).find('.z-price').text();
            zSubtotal = parseFloat(zNum * zPrice).toFixed(2);
            $(this).find(".z-subtotal").text(zSubtotal);
            $(this).find('.z-subtotal').each(function() {
                zTotal += parseFloat($(this).text());
            });
            $("#z-total").text(zTotal.toFixed(2));
        })
    });
	$("#mange").children().click(
	    function () {
	        var name=$(this).text();
	        var href=$(this).attr("href");
	        var id=$(this).attr("ids");
            layer.confirm('确定要'+name+"吗？", {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
					url:"{{url('admin/order/status')}}/{{$orderInfo['no']}}/"+id,
					type:"post",
					success:function (res) {
						layer.msg(res.msg);
                        location.reload();
                    },
					error:function (res) {
                        layer.msg(res.responseText);
                    }
				});
            }, function(){
						layer.msg("取消成功");
            });
            return false;
        }
	);
</script>
@endsection