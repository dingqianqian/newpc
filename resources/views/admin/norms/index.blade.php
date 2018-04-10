@extends("admin.layout.layout")
@section("title","规格属性列表")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/jquery.searchableSelect.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset('admin/css/ly_roleList.css')}}">
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
                    <b>-属性列表</b>
                    <span class="pull-right">
			<a href="{{route("norms.create")}}" class="btn btn-default btn-xs"><i></i>添加规格属性</a>
		</span>
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">
            <!--搜索-->
            <div class="panel panel-default" style="margin-bottom: 15px">
                <div class="panel panel-body" id="xiugaiInput">
                    <form class="form-inline" action="{{route('norms.list')}}" method="get">
                        <!--下拉搜索-->
                        <div class="form-group">
                            <span class="">规格名称 :</span>
                            <select class="selectpicker" data-live-search="true" name="f_norms_group_id">
                                <option value="0">请选择</option>
                                @foreach($normsGroupInfo as $k=>$v)
                                <option value="{{$v['id']}}" @if($info['f_norms_group_id']==$v['id']) selected @endif>{{$v['name']}}</option>
                                @endforeach
                            </select>
                            &nbsp; &nbsp;
                           所属商品分类 :
                            <select class="selectpicker" data-live-search="true" name="f_goods_type_id">
                                <option value="0">请选择</option>
                                @foreach($goodsTypeInfo as $k=>$v)
                                    @if(isset($v['child']))
                                        @foreach ($v['child'] as $kk=>$vv)
                                    <option value="{{$vv['id']}}" @if($info['f_goods_type_id']==$vv['id']) selected @endif>{{$vv['name']}}</option>
                                            @endforeach
                                    @endif
                                @endforeach
                            </select>
                            <span>属性 :</span>
                            <input type="text" name="name" value="{{$info['name']}}" class="form-control input-sm" placeholder="输入属性">
                        </div>
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-success btn-sm">搜索</button>
                    </form>
                </div>
            </div>
            <!--表格-->
            <div class="panel panel-default">
            <form class="form-inline table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr>
                        <th class="col-md-2">编号</th>
                        <th class="col-md-2">规格名称</th>
                        <th class="col-md-2">规格属性</th>
                        <th class="col-md-3">所属商品分类</th>
                        <th class="col-md-3">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($normsInfo['data'] as $k=>$v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['norms_group']['name']}}</td>
                        <td>{{$v['name']}}</td>
                        <td>{{$v['goods_type']['name']}}</td>
                        <td>
                            <a href="{{route('norms.edit',['id'=>$v['id']])}}" class="edit"><img src="{{asset("admin/img/edit.png")}}" title="修改" alt=""></a>
                            <a href="javascript:;" class="delect" onclick="dele({{$v['id']}})"><img src="{{asset("admin/img/delete.png")}}" title="删除" alt=""></a>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- 分页 -->
                {{$normsInfos->appends(["name"=>"{$info['name']}","f_norms_group_id"=>$info['f_norms_group_id'],"f_goods_type_id"=>$info['f_goods_type_id']])->links()}}
            </form>
            </div>
        </section>

        <!-- Footer -->
        @component('admin.layout.footer')
        @endcomponent
    </div>
@endsection
@section("js")
    <script src="{{asset("admin/js/bootstrap-select.js")}}"></script>
    <script src="{{asset("admin/js/defaults-zh_CN.js")}}"></script>
    <script>
        // 弹框
//        $('.delect').each(function(k,v){
//            $(v).click(function(){
//                layer.confirm('确定要删除商品'+'吗？', {
//                    btn: ['确定','取消'] //按钮
//                }, function(){
//                    /* $.ajax({
//                     url:""d,
//                     type:"post",
//                     success:function (res) {
//                     layer.msg(res.msg);
//                     location.reload();
//                     },
//                     error:function (res) {
//                     layer.msg(res.responseText);
//                     }
//                     });*/
//                }, function(){
//                });
//            });
//        });
        //	弹出框
        function dele(id) {
            layer.confirm("是否确定删除此属性？", {
                btn: ['确定', '取消'], //按钮，
                title: '删除规格属性',
            }, function() {
                $.ajax({
                    url: "{{url('admin/norms/delete')}}/" + id,
                    type: "post",
                    success: function(res) {
                        layer.msg(res.msg);
                        location.reload();
                    },
                    error: function(res) {
                        layer.msg(res.responseText);
                    }
                });
            }, function() {
                layer.msg('取消成功');
            });
            return false;
        }
        $(function(){
            /*var erji=[
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
            });*/

            if($(window).width()<768){
                $('.haspadding .row>div').removeClass('text-right');
                $('.haspadding .form-control:not(select)').css({
                    'margin-top':'10px'
                });
                $('.form-group>.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)').css({
                    'margin-top':'10px'
                });
                $('.table-responsive').css({
                    'overflow-y':'auto'
                });
            }
        });
    </script>
@endsection