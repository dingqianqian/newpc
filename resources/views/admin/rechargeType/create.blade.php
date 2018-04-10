@extends("admin.layout.layout")
        @section("title","充值添加")
        @section("css")
            <link rel="stylesheet" href="{{asset("admin/css/ly_addguangbo.css")}}">
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
                    <b>-添加充值</b>
                    <span class="pull-right">
                <a href="{{route("rechargeType.list")}}" class="btn btn-default btn-sm">充值返现列表</a>
                    </span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <form class="form addchognzhi" method="post" action="{{url("admin/rechargeType/add")}}" enctype="multipart/form-data">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!--内容-->
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>充值金额 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <input type="text" class="form-control" placeholder="填写充值金额" name="money">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>返现金额 :</b></div>
                    <div class="col-md-5  col-xs-9">
                        <input type="text" class="form-control" placeholder="填写返现金额" name="give_back">
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-3 text-right"><b>排序 :</b></div>
                        <div class="col-md-5  col-xs-9">
                            <input type="text" class="form-control" placeholder="充值排序" name="sort">
                        </div>
                    </div>
                {{--<div class="row">
                    <div class="col-md-4 col-xs-3 text-right"><b>充值描述 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <input type="text" class="form-control" placeholder="填写充值描述" name="description"/>
                    </div>
                </div>--}}
                <div class="row file">
                    <div class="col-md-4 col-xs-3 text-right"><b>图片 :</b></div>
                    <div class="col-md-5 col-xs-9">
                        <!--图片上传-->
                        <input type="file" name="image"/>
                    </div>
                </div>
                {{csrf_field()}}
                <div class="submitBtn text-center">
                    <button type="reset" class="btn btn-success">重置</button>
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>
            </form>
        </section>

       @component("admin.layout.footer")
           @endcomponent

    </div>
@endsection