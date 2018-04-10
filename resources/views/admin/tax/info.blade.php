@extends("admin.layout.layout")
		@section("title","增值票资质信息")
@section("content")

	<div class="content-wrapper">
		<!-- Content Header -->
		<section class="content-header">
			<div class="panel panel-default">
				<div class="panel-body">
					<b>
				<a href="javascript:;">宜优速 管理中心</a>
			</b>
					<b>-增值票资质信息</b>
					<span class="pull-right">
	<a href="{{route("tax.list")}}" class="btn btn-default btn-xs"><i></i>审核列表</a>
</span>
				</div>
			</div>
		</section>

		<!-- 内容 -->
		<section class="content container-fluid">
			<!--表格-->
			<form class="form-inline table-responsive">
				<table class="table table-bordered table-hover text-center">
					<tbody class="z_aptitude">
						<tr>
							<th class="col-md-3">单位名称:</th>
							<td class="col-md-3">{{$addValueTaxInfo['company_name']}}</td>
							<th class="col-md-3">纳税人识别号:</th>
							<td class="col-md-3">{{$addValueTaxInfo['tax_no']}}</td>
						</tr>
						<tr>
							<th class="col-md-3">注册地址:</th>
							<td class="col-md-3">{{$addValueTaxInfo['addr']}}</td>
							<th class="col-md-3">注册电话:</th>
							<td class="col-md-3">{{$addValueTaxInfo['tel_no']}}</td>
						</tr>
						<tr>
							<th class="col-md-3">开户银行:</th>
							<td class="col-md-3">{{$addValueTaxInfo['bank_name']}}</td>
							<th class="col-md-3">对公账户:</th>
							<td class="col-md-3">{{$addValueTaxInfo['bank_account']}}</td>
						</tr>
					</tbody>
				</table>
				<!--提交-->
						<div class="submitBtn text-center">
							@if($addValueTaxInfo['status']==1)
							<button type="button" class="btn btn-success" ids="1">审核通过</button>
							<button type="button" class="btn btn-primary" ids="2">审核驳回</button>
								@endif
						</div>
			</form>
		</section>

		@component("admin.layout.footer")
			@endcomponent

	</div>
	<!-- /.content-wrapper -->

@endsection
@section("js")
	<script type="text/javascript">
		$("button").click(function () {
		    var  name=$(this).text();
		    var  type=$(this).attr("ids");
            layer.confirm('确定要'+name+"吗？", {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    url:"{{url("admin/tax/status")}}/{{$addValueTaxInfo['id']}}/"+type,
                    type:"post",
                    success:function (res) {
                        layer.msg(res.msg);
                        location.reload();
                    }
                });
            }, function(){

            });
            return false;
        });
	</script>
	@endsection