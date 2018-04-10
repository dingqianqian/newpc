@extends('admin.layout.layout')
@section('title','添加规格分组')
@section('css')
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
                    <b>-添加规格</b>
                    <span class="pull-right">
			<a href="{{route('normsgroup.list')}}"  class="btn btn-default btn-xs"><i></i>规格列表</a>
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
            <form class="form-horizontal" action="{{url("admin/normsgroup/add")}}" method="post" enctype="multipart/form-data">
                <!--属性名称-->
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">规格名称:</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
                {{csrf_field()}}
                <!--提交-->
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
    <div class="control-sidebar-bg"></div>
@endsection
<!-- jQuery 3 -->
@section('js')
    @endsection