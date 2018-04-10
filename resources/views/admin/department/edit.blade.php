@extends("admin.layout.layout")
@section("title","编辑部门")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_department.css")}}">
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
                    <b>-编辑员工部门</b>
                    <span class="pull-right">
			<a href="{{route("department.list")}}" class="btn btn-default btn-xs"><i></i>员工部门列表</a>
		</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section class="content container-fluid">
            <form class="form-horizontal" action="{{url("admin/department/update")}}/{{$departmentInfo['id']}}" method="post" enctype="multipart/form-data">
                <!--部门名称-->
                <div class="form-group">
                    <label for="" class="control-label col-xs-4" >员工部门名称:</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" name="name" value="{{$departmentInfo['name']}}">
                    </div>
                </div>
                <!--地区-->
                <div class="form-group">
                    <label class="control-label col-xs-4">地区</label>
                    <select id="goodsNames" name="f_area_id" class="selectpicker z-select" data-live-search="true">
                        @foreach($areaInfo as $k=>$v)
                            <option value="{{$v['id']}}" @if($departmentInfo['f_area_id']==$v['id']) selected @endif>{{$v['name']}}</option>
                        @endforeach
                    </select>
                </div>
            {{csrf_field()}}
            <!--提交-->
                <div class="submitBtn text-center">
                    <button type="submit" class="btn btn-success btn-sm">编辑</button>
                    <button type="reset" class="btn btn-primary btn-sm">重置</button>
                </div>
            </form>
        </section>

        @component("admin.layout.footer")
        @endcomponent

    </div>

@endsection
@section("js")
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
@endsection
