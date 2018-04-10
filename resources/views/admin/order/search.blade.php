@extends("admin.layout.layout")
		@section("title","订单查询")
		@section("css")
			<link rel="stylesheet" href="{{asset("admin/css/z_addshop.css")}}">
		@endsection
@section("content")
	<div class="content-wrapper">
		<!--header-->
		<section class="content-header">
			<div class="panel panel-default">
				<div class="panel-body">
					<b>
						<a href="javascript:;">宜优速 管理中心</a>
					</b>
					<b>-订单查询</b>
					<span class="pull-right">
			<a href="{{route('order.list')}}" class="btn btn-default btn-xs"><i></i>订单列表</a>
		</span>
				</div>
			</div>
		</section>
		<!-- 内容 -->
		<section class="content container-fluid">
			<form class="form-horizontal" action="{{route('order.list')}}" method="post">
				<!--订单号-->
				<div class="form-group">
					<label for="username" class="control-label col-xs-4">订单号:</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" name="no">
					</div>
				</div>
				<!--用户手机号-->
				<div class="form-group">
					<label for="passward" class="control-label col-xs-4">下单人手机号</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" name="phone">
					</div>
				</div>
				<!--下单时间-->
				<div class="form-group">
					<label for="text" class="control-label col-xs-4" style="margin-top: 4px;">下单时间</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control input-sm z_input" id="dateinfo" name="min_time" value="2015年01月01日">
						<input type="text" class="form-control input-sm z_input" id="datebut" name="max_time" onClick="jeDate({dateCell:'#datebut',isTime:true,format:'YYYY年MM月DD日'})" value="{{date("Y年m月d日",time())}}">
					</div>
				</div>
				<!--金额-->
				<div class="form-group">
					<label for="text" class="control-label col-xs-4" style="margin-top: 4px;">金额</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control input-sm z_input" name="min_price">
						<input type="text" class="form-control input-sm z_input" name="max_price">
					</div>
				</div>
				<!--订单状态-->
				<div class="form-group" >
					<label for="wcart" class="control-label col-xs-4">订单状态</label>
					<div class="col-xs-8 col-sm-4" style="margin-top: 5px;">
						@foreach($orderFormStatusInfo as $k=>$v)
						<p class="col-xs-4 z-p-ckeckbox"><input type="checkbox"  value="{{$v['id']}}" name="status[]"/>{{$v['name']}}</p>
							@endforeach
					</div>
				</div>
				<!--订单支付方式-->
				<div class="form-group">
					<label for="status" class="control-label col-xs-4">订单支付方式</label>
					<select class="col-xs-4 form-control z-select-img" name="pay_type">
						<option value="">全部</option>
						@foreach($payTypeInfo as $k=>$v)
						<option value="{{$v['id']}}">{{$v['name']}}</option>
							@endforeach
					</select>
				</div>
                <div class="form-group">
                    <label class="control-label col-xs-4">是否打印</label>
                    <select  class="col-xs-4 form-control z-select-img" name="print">
                        <option value="0">全部</option>
                        <option value="1">已打印</option>
                        <option value="2">未打印</option>
                    </select>
                </div>
				<!--地区-->
				<div class="form-group">
					<label class="control-label col-xs-4">地区</label>
					<select id="select" class="zf_select" name="area">
						<option value="0">地区</option>
						@foreach($areaInfo as $k=>$v)
						<option value="{{$v['id']}}">{{$v['name']}}</option>
						@endforeach
					</select>
				</div>
                {{csrf_field()}}
				<!--提交-->
				<div class="submitBtn text-center">
					<button type="submit" class="btn btn-success">确定</button>
					<button type="reset" class="btn btn-primary">重置</button>
				</div>
			</form>
		</section>
		<!-- Footer -->
		@component("admin.layout.footer")
			@endcomponent
	</div>
	@endsection

@section("js")
		<script src="{{asset('admin/js/distpicker.data.js')}}"></script>
		<script src="{{asset('admin/js/distpicker.js')}}"></script>
		<script src="{{asset('admin/js/jedate.min.js')}}"></script>>
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
            $(window).resize(function(){
                if($(window).width()<768){
                    $('div.searchable-select').css('width','45.88%');
                    $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%');

                }else{
                    $('div.searchable-select').css('width','160px');
                    $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto');

                }
            });
            $(function(){
                if($(window).width()<768){
                    $('div.searchable-select').css('width','45.88%');
                    $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%');

                }else{
                    $('div.searchable-select').css('width','160px');
                    $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto');
                }
            })
		</script>
@endsection