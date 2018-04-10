@extends("admin.layout.layout")
@section("title","套餐详情")
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
                    <b>-套餐详情</b>
                    <span class="pull-right">
			<a href="{{route('order.list')}}" class="btn btn-sm btn-default"><i></i>套餐列表</a>


		</span>
                </div>
            </div>
        </section>


            <!--基本信息-->
            <div class="z-order">
                <form class="form-inline table-responsive">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th colspan="4" style="font-size: 14px;"  class="text-center">套餐信息</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th class="col-md-3">套餐ID:</th>
                            <td class="col-md-3">{{$goodsPackageInfo["id"]}}</td>
                            <th class="col-md-3">套餐名称:</th>
                            <td class="col-md-3">{{$goodsPackageInfo["name"]}}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">价格:</th>
                            <td class="col-md-3">{{$goodsPackageInfo["show_price"]}}</td>
                            <th class="col-md-3">11121(价格):</th>
                            <td class="col-md-3">{{$goodsPackageInfo["show_sale_price"]}}</td>
                        </tr>
                        <tr>
                            <th class="col-md-3">商品状态:</th>
                            <td class="col-md-3"></td>
                            <th class="col-md-3">创建时间:</th>
                            <td class="col-md-3"></td>
                        </tr>
                        <tr>
                            <th class="col-md-3">更新时间:</th>
                            <td class="col-md-3"></td>
                            <th class="col-md-3">套餐所属类型:</th>
                            <td class="col-md-3"></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        <!--商品信息-->
            <div>
                <form class="form-inline table-responsive">
                    <table class="table table-bordered table-striped dataTable text-center">
                        <thead>
                        <tr>
                            <th colspan="5" style="font-size: 14px;">绑定商品信息
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

                            <tr>
                                <td class="col-md-6"></td>
                                <td>&nbsp;&nbsp; </td>
                                <td class="z-num"></td>
                                <td class="z-price"></td>
                                <th class="z-subtotal"></th>
                            </tr>

                        <tr>
                            <td colspan="4" style="text-align: right;">合计</td>
                            <td id="z-total"></td>
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

@endsection