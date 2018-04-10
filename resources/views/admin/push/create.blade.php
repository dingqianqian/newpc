@extends('admin.layout.layout')
@section('title','添加推送')
    @section("css")
        <link rel="stylesheet" href="{{asset("admin/css/ly_addCommClass.css")}}">
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
                    <b>-添加推送</b>
                    <span class="pull-right">
			<a href="{{route("push.list")}}" class="btn btn-default btn-xs"><i></i>推送列表</a>
		</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <form class="form-horizontal" action="{{url("admin/push/add")}}" method="post">
                <div class="alert alert-danger" id="ly_red">
                    <ul></ul>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!--推送分类-->
                <div class="form-group" id="limitsDengji">
                    <label for="" class="control-label col-xs-4">推送分类 :</label>
                    <div class="col-xs-6 col-sm-4">
                        <select class="form-control col-xs-6 col-sm-4" name="type">
                            <option value="0">新闻URL推送</option>
                            <option value="1">APP页面推送</option>
                            <option value="2">商品列表推送</option>
                        </select>
                    </div>
                </div>
                <!--新闻URL推送-->
                <div id="tabs0" class="tabactive">
                    <div class="form-group">
                        <label for="commname" class="control-label col-xs-4">通知栏提示文字 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" id="commname" placeholder="通知栏提示文字" name="message1">
                        </div>
                    </div>
                    <!--新闻标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="标题" name="title1">
                        </div>
                    </div>
                    <!--副标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">描述 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="副标题" name="description1">
                        </div>
                    </div>
                    <!--跳转新闻链接-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">跳转新闻链接 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="跳转新闻链接地址" name="news_url">
                        </div>
                    </div>
                </div>
                <!--APP页面推送-->
                <div id="tabs1">
                    <!--通知栏-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">通知栏提示文字 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="通知栏提示文字" name="message2">
                        </div>
                    </div>
                    <!--推送标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="推送标题" name="title2">
                        </div>
                    </div>
                    <!--副标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">描述 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="副标题" name="description2">
                        </div>
                    </div>
                    <!--跳转新闻链接-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">跳转商品ID :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="跳转商品ID" name="custom_id2">
                        </div>
                    </div>
                </div>
                <!--商品列表推送-->
                <div id="tabs2">
                    <!--通知栏-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">通知栏提示文字 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="通知栏提示文字" name="message3">
                        </div>
                    </div>
                    <!--新闻标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="新闻标题" name="title3">
                        </div>
                    </div>
                    <!--副标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">描述 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="副标题" name="description3">
                        </div>
                    </div>
                    <!--推送页面标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">推送页面标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="推送页面标题" name="category_title3">
                        </div>
                    </div>
                    <!--跳转商品ID-->
                    <div class="form-group">
                        <label class="control-label col-xs-4">商品分类ID :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="商品分类ID" name="custom_id3">
                        </div>
                    </div>
                </div>
                {{csrf_field()}}
                <!--提交-->
                <div class="submitBtn text-center">
                    <button type="reset" class="btn btn-primary">重置</button>
                    <button type="submit" class="btn btn-success">推送</button>
                </div>
            </form>
        </section>

        <!-- Footer -->
        @component('admin.layout.footer')
        @endcomponent

    </div>
 @endsection

@section("js")
<script>
    $(window).resize(function(){
        if($(window).width()<768){
            $('div.searchable-select').css('width','45.88%');
            $('#xiugaiInput  .btn-sm').addClass('btn-block').css('width','99%')
        }else{
            $('div.searchable-select').css('width','160px');
            $('#xiugaiInput  .btn-sm').removeClass('btn-block').css('width','auto')
        }
    });

    // select 选择显示
    $('#limitsDengji select').change(function(){
        $('#ly_red').removeClass('ly_red_show');
        var id = '#tabs'+$(this).val();
        $(id).addClass('tabactive').siblings('.tabactive').removeClass('tabactive');
    });

    // 点击推送
    $('button[type="submit"]').click(function(){
        var falg = null;
        var html = "";
        $('.tabactive>.form-group input[type="text"]').each(function(k,v){
            if($(v).val() === ""){
                    var text = $(v).parent().prev('label').text().split(':')[0].trim();
                    html += "<li>"+text+"不能为空"+"<li>";
                $('#ly_red>ul').html(html);
                $('#ly_red').addClass('ly_red_show');
                falg = false;
                }else{
                falg = true;
            }
        });
        return falg;
    });

</script>
@endsection