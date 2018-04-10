@extends("admin.layout.layout")
@section("title","修改加盟酒店")
@section("css")
    <!--图片上传-->
    <link rel="stylesheet" href="{{asset("admin/css/style.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/ssi-uploader.css")}}" />

    {{--<link rel="stylesheet" href="{{asset("admin/css/z_shoplist.css")}}">--}}
    <link rel="stylesheet" href="{{asset("admin/css/z_attr.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
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
                    <b>-酒店加盟</b>
                    <span class="pull-right">
			<a href="{{route("joinHotel.list")}}" class="btn btn-default btn-xs"><i></i>酒店加盟列表</a>
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
            <form class="form-horizontal" action="{{url("admin/joinHotel/update")}}/{{$joinHotelInfo["id"]}}" method="post" enctype="multipart/form-data">
                <!--酒店名称-->
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">酒店名称</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" name="name" value="{{$joinHotelInfo["name"]}}">
                    </div>
                </div>

                <!--酒店首字母大写-->
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">酒店首字母大写</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" name="index" value="{{$joinHotelInfo["index"]}}">
                    </div>
                </div>
                <!--酒店排序-->
                <div class="form-group">
                    <label for="username" class="control-label col-xs-4">酒店排序</label>
                    <div class="col-xs-6 col-sm-4">
                        <input type="text" class="form-control" name="sort" value="{{$joinHotelInfo["sort"]}}">
                    </div>
                </div>
                <!--酒店类型-->
                <div class="form-group">
                    <label for="wcart" class="control-label col-xs-4">酒店类型</label>
                    <div class="col-xs-6">
                        <select class="selectpicker zf-select" data-live-search="true" name="type">
                            <option value="0" @if($joinHotelInfo["type"]==0) selected @endif>自营</option>
                            <option value="1" @if($joinHotelInfo["type"]==1) selected @endif>连锁</option>
                        </select>
                    </div>
                </div>
                <!--上传酒店logo-->
                <div class="form-group">
                    <label for="shang" class="control-label col-xs-4">上传酒店logo</label>
                    <input type="file" class="col-xs-4" id="shang" name="image_url" value="">
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

    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
    <script>
        $(function(){
            if($(window).width()<768){
                $('.haspadding .row>div').removeClass('text-right');
                $('.haspadding .form-control:not(select)').css({
                    'margin-top':'10px'
                });
                $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                    'width':'100%',
                    'margin-top':'10px'
                });
            }
        });
        function smallScreen(){
            if($(window).width()<768){
                $('.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                    'width':'100%',
                    'margin-top':'10px'
                });
            }
        }
    </script>
@endsection