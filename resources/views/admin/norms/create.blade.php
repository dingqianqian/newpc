@extends('admin.layout.layout')
@section('title','添加规格属性')
@section('css')
    <link rel="stylesheet" href="{{asset("admin/css/ly_addGroup.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
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
                    <b>-添加属性</b>
                   <span class="pull-right">
                <a href="{{route("norms.list")}}" class="btn btn-default btn-sm">规格属性列表</a>
                    </span>
                </div>
            </div>
        </section>

        <!-- 内容 -->

            <form class="form haspadding" action="{{url('admin/norms/add')}}" method="post">
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
                <!--内容-->
                <div class="row">
                    <div class="col-md-3 text-right">所属规格分组 :</div>
                    <div class="col-md-5">
                        <select class="selectpicker" data-live-search="true" name="f_norms_group_id">
                            <option value="0">请选择规格</option>
                            @foreach($normsgroupInfo as $k=>$v)
                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 text-right">规格属性名称 :</div>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" placeholder="请输入属性名称">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 text-right">所属商品分类 :</div>
                    <div class="col-md-9">
                        <select class="selectpicker" data-live-search="true" id="d1">
                            @foreach($goodsTypeInfo as $k=>$v)
                                <option value="{{$loop->index}}">{{$v['name']}}</option>
                                @endforeach
                        </select>
                        <select class="selectpicker" data-live-search="true" id="d2" name="f_goods_type_id">
                            <option value="-1">暂无</option>
                        </select>
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


    <!-- /.control-sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
@endsection
@section('js')
<script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
<script src="{{asset("admin/js/defaults-zh_CN.js")}}"></script>

<script>
$(function(){
    var erji=[
            @foreach($goodsTypeInfo as $k=>$v)
        [
            @if(isset($v['child']))
                @foreach($v['child'] as $k1=>$v1)
            [{{$v1['id']}},'{{$v1['name']}}'],
                @endforeach
            @else
                [0,"暂无"],
            @endif

        ],
        @endforeach
    ];
    $(function(){
        //console.log(erji);
        var value = $('#d1').val();
        var funIndex = erji[ value ];// 当前下标在二级对应内容
        var html = '';
        var erjiOption = '';
        for(var i=0;i<funIndex.length;i++){
            html += '<li data-original-index='+funIndex[i][0]+'>' +
                '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                '<span class="text">'+funIndex[i][1]+'</span>' +
                '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                '</a>' +
                '</li>';
            // 添加option
            erjiOption +='<option value='+funIndex[i][0]+'>'+funIndex[i][1]+'</option>';
        }
        $('#d2').prev('div.dropdown-menu').find('ul').html(html);
        $('#d2').html(erjiOption);
        $('.selectpicker').selectpicker('refresh');
        smallScreen();

    });

    $('#d1').change(function(){
        var cityIndex = erji[ this.value ];  // 当前下标在二级对应内容
        var html = '';
        var erjiOption = '';
        for(var i = 0;i<cityIndex.length;i++){
            html += '<li data-original-index='+cityIndex[i][0]+'>' +
                '<a tabindex="0" data-tokens="null" role="option" aria-disabled="false" aria-selected="false">' +
                '<span class="text">'+cityIndex[i][1]+'</span>' +
                '<span class="glyphicon glyphicon-ok check-mark"></span>' +
                '</a>' +
                '</li>';
            // 添加option
            erjiOption += '<option value='+cityIndex[i][0]+'>'+cityIndex[i][1]+'</option>';
        }
        $('#d2').prev('div.dropdown-menu').find('ul').html(html);
        $('#d2').html(erjiOption);
        $('.selectpicker').selectpicker('refresh');
        smallScreen();
    });
});
</script>

@endsection