@extends('admin.layout.layout')
@section('title','添加优惠券')
@section('css')
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    {{--<link rel="stylesheet" href="{{asset("admin/css/z_news.css")}}">--}}
    <link rel="stylesheet" href="{{asset("admin/css/z_special.css")}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-添加优惠券</b>
                    <span class="pull-right">
<a  href="{{route('coupontype.list')}}" class="btn btn-default btn-xs"><i></i>优惠券列表</a>
</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <form class="form-horizontal" action="{{url('admin/coupontype/add')}}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!--属性名-->
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">优惠券名称:</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" id="" name="name" placeholder="请输入名称">
                    </div>
                </div>
                <!--派发时间-->
                <div class="form-group">
                    <label for="text" class="control-label col-xs-4" style="margin-top: 4px;">有效期:</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control input-sm z_input" name="expire_time_start" id="dateinfo">
                        <input type="text" class="form-control input-sm z_input" name="expire_time_end" id="datebut" onClick="jeDate({dateCell:'#datebut',isTime:true,format:'YYYY-MM-DD hh:mm:ss'})">
                    </div>
                </div>
                <!--使用类型-->
                <div class="form-group">
                    <label class="control-label col-xs-4">使用类型</label>
                    <select id="goodsNames" class="selectpicker z-select" data-live-search="true" name="use_type">
                        <option value="PRICE">金额</option>
                        <option value="DISCOUNT">折扣</option>
                    </select>
                </div>
                <!--状态-->
                <div class="form-group">
                    <label class="control-label col-xs-4">状态</label>
                    <select id="goodsNames" class="selectpicker z-select" data-live-search="true" name="f_coupon_type_status_id">
                        @foreach($couponStatusInfo as $k=>$v)
                        <option value="{{$v['id']}}">{{$v['name']}}</option>
                       @endforeach
                    </select>
                </div>
                <!--是否全场通用-->
                <div class="form-group">
                    <label class="control-label col-xs-4">是否全场通用</label>
                    <select id="goodsNames" class="selectpicker z-select" data-live-search="true" name="is_include_over">
                        <option value="T">是</option>
                        <option value="F">否</option>
                    </select>
                </div>
                <!--抵用金额-->
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">抵用金额(折扣):</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" id="" name="use_value" placeholder="抵用金额">
                    </div>
                </div>
                <!--派发总数-->
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">派发总数:</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" id="" name="distribute_count" placeholder="派发总数">
                    </div>
                </div>
                <!--使用条件金额-->
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">使用金额起点:</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" id="" name="start_price" placeholder="使用金额起点">
                    </div>
                </div>
                <!--图片-->
                {{--<div class="form-group">
                    <label for="username" class="control-label col-xs-4">图片:</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="file" name="" id="" name="" value="" />
                    </div>
                </div>--}}
                <!--提交-->
                {{csrf_field()}}
                <div class="submitBtn text-center">
                    <button type="submit" class="btn btn-success">添加</button>
                    <button type="reset" class="btn btn-primary">重置</button>
                </div>
            </form>
        </section>
        <!-- Footer -->
        @component('admin.layout.footer')
        @endcomponent
    </div>

    @endsection

<!-- jQuery 3 -->
@section('js')
    <script src="{{asset("admin/js/jedate.min.js")}}"></script>
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
<script>
    $(function() {
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
</script>
    @endsection

