@extends('admin.layout.layout')
@section('title','折扣录入')
@section('css')
    <link rel="stylesheet" href="{{asset("admin/css/jquery.searchableSelect.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_areaprice.css")}}">
@endsection
@section('content')

    <div class="content-wrapper">
        <!--header-->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-折扣录入</b>
                    <span class="pull-right">
			<a href="{{route("areaPrice.list")}}"  class="btn btn-default btn-xs">折扣列表</a>
		</span>
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="form-horizontal" action="{{url("admin/areaPrice/add")}}" method="post" enctype="multipart/form-data">
                <!--地区-->
                <div class="form-group">
                    <label for="wcart" class="control-label col-xs-4">地区:</label>
                    <div class="col-xs-6">
                        <select name="area" class="selectpicker zf-select" data-live-search="true">
                            <option value="">请选择</option>
                            @foreach($areaInfo as $k=>$v)
                            <option value="{{$v["id"]}}">{{$v["name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{--折扣--}}
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">折扣:</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" name="discount">
                    </div>
                </div>
            {{csrf_field()}}
            <!--提交-->
                <div class="submitBtn text-center">
                    <button type="submit" class="btn btn-success">录入</button>
                    <button type="reset" class="btn btn-primary">重置</button>
                </div>
            </form>
        </section>
        <!-- Footer -->
        @component('admin.layout.footer')
        @endcomponent
    </div>
    <div class="control-sidebar-bg"></div>
@endsection
<!-- jQuery 3 -->
@section('js')
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
@endsection