@extends('admin.layout.layout')
@section('title','编辑推送')
@section('css')
@endsection
@section('content')


    <!--内容-->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-编辑推送</b>
                    <span class="pull-right">
			<a href="{{route("push.list")}}" class="btn btn-default btn-xs"><i></i>推送列表</a>
		</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="section container-fluid">
            <form class="form-horizontal">
                <!--机型-->
                <div class="form-group">
                    <label for="show" class="control-label col-xs-5" style="transform: translate(0,40%);padding-top: 0;">机型 :</label>
                    <div class="col-xs-6 col-sm-4 radio" id="show">
                        <label>
                            <input name="li" type="radio" checked>IOS
                        </label>
                        <label>
                            <input  name="li" type="radio">Android
                        </label>
                    </div>
                </div>
                <!--推送分类-->
                <div class="form-group" id="limitsDengji">
                    <label for="" class="col-xs-5">推送分类 :</label>
                    <select class="col-xs-6 col-sm-4 from-control lyheight-control">
                        <option value="tabs1">新闻URL推送</option>
                        <option value="tabs2">APP页面推送</option>
                        <option value="tabs3">商品列表推送</option>
                    </select>
                </div>
                <!--新闻URL推送-->
                <div id="tabs1" class="tabactive">
                    <div class="form-group">
                        <label for="commname" class="control-label col-xs-5">通知栏提示文字 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" id="commname" placeholder="通知栏提示文字">
                        </div>
                    </div>
                    <!--新闻标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">新闻标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="新闻标题">
                        </div>
                    </div>
                    <!--副标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">副标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="副标题">
                        </div>
                    </div>
                    <!--跳转新闻链接-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">跳转新闻链接 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="跳转新闻链接地址">
                        </div>
                    </div>
                </div>
                <!--APP页面推送-->
                <div id="tabs2">
                    <!--通知栏-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">通知栏提示文字 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="通知栏提示文字">
                        </div>
                    </div>
                    <!--推送标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">推送标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="推送标题">
                        </div>
                    </div>
                    <!--副标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">副标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="副标题">
                        </div>
                    </div>
                    <!--跳转新闻链接-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">跳转商品ID :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="跳转商品ID">
                        </div>
                    </div>
                </div>
                <!--商品列表推送-->
                <div id="tabs3">
                    <!--通知栏-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">通知栏提示文字 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="通知栏提示文字">
                        </div>
                    </div>
                    <!--新闻标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">新闻标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="新闻标题">
                        </div>
                    </div>
                    <!--副标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">副标题 :</label>
                        <div class="col-xs-6 col-md-4">
                            <input type="text" class="form-control" placeholder="副标题">
                        </div>
                    </div>
                    <!--推送页面标题-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">推送页面标题 :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="推送页面标题">
                        </div>
                    </div>
                    <!--跳转商品ID-->
                    <div class="form-group">
                        <label class="control-label col-xs-5">跳转商品ID :</label>
                        <div class="col-xs-6 col-sm-4">
                            <input type="text" class="form-control" placeholder="跳转商品ID">
                        </div>
                    </div>
                </div>

                <!--提交-->
                <div class="submitBtn text-center">
                    <button type="submit" class="btn btn-success">编辑</button>
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
@section("js")
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

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
        $('#limitsDengji>select').change(function(){
            var id = '#'+$(this).val();
            $(id).addClass('tabactive').siblings('.tabactive').removeClass('tabactive');
        });

    </script>
@endsection