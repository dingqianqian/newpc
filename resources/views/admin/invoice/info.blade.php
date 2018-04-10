@extends("admin.layout.layout")
@section("title","发票详情")
@section("content")

    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-发票信息管理</b>
                    <span class="pull-right">
	<a href="{{route('invoice.list')}}" class="btn btn-default btn-xs"><i></i>发票列表</a>
</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <!--表格-->
            <form class="form-inline table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr class="active">
                        <th colspan="4">开票明细</th>
                    </tr>
                    </thead>
                    <tbody class="z_aptitude">
                    <tr>
                        <th class="col-md-3">发票订单号:</th>
                        <td class="col-md-3">{{$invoiceOrderInfo['no']}}</td>
                        <th class="col-md-3">收货人姓名:</th>
                        <td class="col-md-3">{{$invoiceOrderInfo['f_user_username']}}</td>
                    </tr>
                    <tr>
                        <th class="col-md-3">收货人电话:</th>
                        <td class="col-md-3">{{$invoiceOrderInfo['receive_tel']}}</td>
                        <th class="col-md-3">收货人地址:</th>
                        <td class="col-md-3">{{$invoiceOrderInfo['receive_addr']}}</td>
                    </tr>
                    <tr>
                        <th class="col-md-3">所开发票金额:</th>
                        <td class="col-md-3">{{number_format($invoiceOrderInfo['price'],2,".","")}}</td>
                        <th class="col-md-3">所开发票金额(钱包支付):</th>
                        <td class="col-md-3">{{number_format($invoiceOrderInfo['wallet_price'],2,".","")}}</td>
                    </tr>
                    <tr>
                        <th class="col-md-3">申请开发票的订单号:</th>
                        <td class="col-md-3">@foreach($invoiceOrderInfo['order_no'] as $k=>$v) @if($loop->last) {{$v}}  @else {{$v}}
                            | @endif @endforeach</td>
                        <th class="col-md-3">用户当前剩余可开发票金额(钱包支付):</th>
                        <td class="col-md-3">{{number_format($invoiceOrderInfo['allow_price'],2,".","")}}</td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr class="active">
                        <th colspan="4">发票信息</th>
                    </tr>
                    </thead>
                    <tbody class="z_aptitude">
                    @if($invoiceOrderInfo['invoice_type']=="专票")
                        @if($invoiceOrderInfo['add_value_tax'])
                            <tr>
                                <th class="col-md-3">发票类型:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['invoice_type']}}</td>
                                <th class="col-md-3">单位名称:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['add_value_tax']['company_name']}}</td>
                            </tr>
                            <tr>
                                <th class="col-md-3">纳税人识别号:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['add_value_tax']['tax_no']}}</td>
                                <th class="col-md-3">注册地址:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['add_value_tax']['addr']}}</td>
                            </tr>
                            <tr>
                                <th class="col-md-3">注册电话:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['add_value_tax']['tel_no']}}</td>
                                <th class="col-md-3">银行账号:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['add_value_tax']['bank_name']}}</td>
                            </tr>
                            <tr>
                                <th class="col-md-3">银行地址:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['add_value_tax']['bank_account']}}</td>
                            </tr>
                        @else
                            <tr>
                                {{--<th class="col-md-3">发票类型:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['invoice_type']}}</td>
                                <th class="col-md-3">单位名称:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['invoice_name']}}</td>--}}
                                <th style="text-align: center;">用户更改过增值税发票信息,需要重新认证！</th>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <th class="col-md-3">发票类型:</th>
                            <td class="col-md-3">{{$invoiceOrderInfo['invoice_type']}}</td>
                            <th class="col-md-3">单位名称:</th>
                            <td class="col-md-3">{{$invoiceOrderInfo['invoice_name']}}</td>
                        </tr>
                        @if($invoiceOrderInfo['tax_no'])
                            <tr>
                                <th class="col-md-3">纳税人识别号:</th>
                                <td class="col-md-3">{{$invoiceOrderInfo['tax_no']}}</td>
                            </tr>
                        @endif
                    @endif
                    </tbody>
                </table>
                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr class="active">
                        <th colspan="7" style="text-align: left;">订单明细</th>
                    </tr>
                    <tr>
                        <th>商品编号</th>
                        <th>商品名称</th>
                        <th>所属订单号</th>
                        <th>规格</th>
                        <th>数量</th>
                        <th>单价</th>
                        <th>金额</th>
                    </tr>
                    </thead>
                    <tbody id="z-tbody">
                    @foreach($invoiceOrderInfo['goods'] as $k=>$v)
                        <tr>
                            <td>{{$v['goods']['id']}}</td>
                            <td>{{$v['goods']['open_id']}}</td>
                            <td>{{$v['f_order_form_no']}}</td>
                            <td>@foreach($v['norm'] as $k1=>$v1) @if($loop->last){{$v1['name']}}@else {{$v1['name']}}
                                &nbsp;&nbsp; @endif @endforeach</td>
                            <td class="z-num">{{$v['number']}}</td>
                            <td class="z-price">{{number_format($v['deal_min_price'],2,".","")}}</td>
                            <td class="z-subtotal"></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: 600;">优惠券抵扣</td>
                        <td id="dl_zhekou" style="font-weight: 600;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: 600;">总金额</td>
                        <td id="dl_zong"
                            style="font-weight: 600;">{{number_format($invoiceOrderInfo['price'],2,".","")}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            @if(!$invoiceOrderInfo['is_fixed'])
                <!--提交-->
                    <div class="submitBtn text-center" id="mange">
                        <button type="button" class="btn btn-success">标记为已处理</button>
                    </div>
                @endif
            </form>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent

    </div>

@endsection
@section("js")
    <script type="text/javascript">
        $(document).ready(function () {
            var zNum;
            var zPrice;
            var zSubtotal;
            var zTotal = 0;
            $('#z-tbody').find('tr').each(function () {
                zNum = $(this).find('.z-num').text();
                zPrice = $(this).find('.z-price').text();
                zSubtotal = parseFloat(zNum * zPrice).toFixed(2);
                $(this).find(".z-subtotal").text(zSubtotal);
                $(this).find('.z-subtotal').each(function () {
                    zTotal += parseFloat($(this).text());
                });
                $("#z-total").text(zTotal.toFixed(2));
            });
            $('#dl_zhekou').text((zTotal - parseFloat($('#dl_zong').text())).toFixed(2));
        });
        $("#mange").children().click(
            function () {
                var name = $(this).text();
                layer.confirm('确定要' + name + "吗？", {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    $.ajax({
                        url: "{{url('admin/invoice/status')}}/{{$invoiceOrderInfo['id']}}",
                        type: "post",
                        success: function (res) {
                            layer.msg(res.msg);
                            location.reload();
                        }
                    });
                }, function () {

                });
                return false;
            }
        );
    </script>
@endsection