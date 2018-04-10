@extends("admin.layout.layout")
@section("title","添加新闻")
@section("css")
    <link rel="stylesheet" href="{{asset("admin/css/bootstrap-select.css")}}">
    <link rel="stylesheet" href="{{asset("admin/css/z_news.css")}}">
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
                    <b>-添加新闻</b>
                    <span class="pull-right">
			<a href="{{route("news.list")}}" class="btn btn-default btn-xs"><i></i>新闻列表</a>
		</span>
                </div>
            </div>
        </section>
        <!-- 内容 -->
        <section class="content container-fluid">
            <form class="form-horizontal" action="{{url("admin/news/add")}}" method="post"
                  enctype="multipart/form-data">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            <!--新闻分类-->
                <div class="form-group">
                    <label class="control-label col-xs-3 col-md-1">新闻分类</label>
                    <select id="goodsNames" class="selectpicker z-select" data-live-search="true" name="type">
                        <option value="2">新闻|公告</option>
                        <option mustard value="0">新闻</option>
                        <option value="1">公告</option>
                    </select>
                </div>
                <!--新闻标题-->
                <div class="form-group">
                    <label for="" class="control-label col-xs-3 col-md-1">新闻标题</label>
                    <div class="col-xs-8 col-md-9">
                        <input type="text" class="form-control" placeholder="新闻标题" name="title">
                    </div>
                </div>
                <!--新闻作者-->
                <div class="form-group">
                    <label for="" class="control-label col-xs-3 col-md-1">新闻作者</label>
                    <div class="col-xs-8 col-md-9">
                        <input type="text" class="form-control" id="dateinfo" placeholder="新闻作者" name="authour">
                    </div>
                </div>
                <!--新闻描述-->
                <div class="form-group">
                    <label for="" class="control-label col-xs-3 col-md-1">新闻描述</label>
                    <div class="col-xs-8 col-md-9">
                        <textarea name="description" rows="5" cols="56" class="z-textarea"
                                  placeholder="新闻描述"></textarea>
                    </div>
                </div>
                <!--图片-->
                <div class="form-group">
                    <label for="" class="control-label col-xs-3 col-md-1">PC大图</label>
                    <div class="col-xs-8 col-md-9">
                        <input type="file" class="z-file" name="image_url">
                    </div>
                </div>
                <!--图片-->
                <div class="form-group">
                    <label for="" class="control-label col-xs-3 col-md-1">手机图片</label>
                    <div class="col-xs-8 col-md-9">
                        <input type="file" class="z-file" name="small_image_url">
                    </div>
                </div>
                <!--百度编辑器-->
                <div class="form-group">
                    <label for="" class="control-label col-xs-3 col-md-1">新闻内容</label>
                    <div class="col-xs-8 col-md-9">
                        <textarea id="editor" name='content' type="text/plain"
                                  style="width:100%;height:500px;"></textarea>
                    </div>
                </div>
            {{csrf_field()}}
            <!--提交-->
                <div class="submitBtn text-center">
                    <button type="submit" class="btn btn-success">提交</button>
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
    <script src="{{asset("admin/js/bootstrap-select.js")}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset("admin/js/defaults-zh_CN.js")}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset("admin/ueditor/utf8-php/ueditor.config.js")}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset("admin/ueditor/utf8-php/ueditor.all.min.js")}}" type="text/javascript"
            charset="utf-8"></script>
    <script src="{{asset("admin/ueditor/utf8-php/lang/zh-cn/zh-cn.js")}}" type="text/javascript"
            charset="utf-8"></script>

    <script>
        $(window).resize(function () {
            var ue;
            if ($(window).width() < 768) {
                var ue = UE.getEditor('editor', {
                    //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
                    toolbars: [
                        ['link', //超链接
                            'unlink', //取消链接
                            '|',
                            'forecolor', //字体颜色
                            'backcolor', //背景色
                            'fontfamily', //字体
                            'fontsize', //字号
                            '|',
                            'bold', //加粗
                            'italic', //斜体
                            'underline', //下划线
                            'strikethrough', //删除线
                            '|',
                            'formatmatch', //格式刷
                            'removeformat', //清除格式
                            '|',
                            'insertorderedlist', //有序列表
                            'insertunorderedlist', //无序列表
                            '|',
                            'inserttable', //插入表格
                            'paragraph', //段落格式
                            'simpleupload', //单图上传
                            'imagecenter', //居中
                            'attachment', //附件

                            '|',
                            'justifyleft', //居左对齐
                            'justifycenter', //居中对齐
                            'horizontal', //分隔线
                            '|',
                            'blockquote', //引用
                            'insertcode', //代码语言

                            '|',
                            'source', //源代码
                            'preview', //预览
                            'fullscreen', //全屏
                        ]
                    ],
                });

            } else {
                ue = UE.getEditor('editor')
            }
        });
        $(function () {
            var ue;
            if ($(window).width() < 768) {
                ue = UE.getEditor('editor', {
                    //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
                    toolbars: [
                        ['link', //超链接
                            'unlink', //取消链接
                            '|',
                            'forecolor', //字体颜色
                            'backcolor', //背景色
                            'fontfamily', //字体
                            'fontsize', //字号
                            '|',
                            'bold', //加粗
                            'italic', //斜体
                            'underline', //下划线
                            'strikethrough', //删除线
                            '|',
                            'formatmatch', //格式刷
                            'removeformat', //清除格式
                            '|',
                            'insertorderedlist', //有序列表
                            'insertunorderedlist', //无序列表
                            '|',
                            'inserttable', //插入表格
                            'paragraph', //段落格式
                            'simpleupload', //单图上传
                            'imagecenter', //居中
                            'attachment', //附件

                            '|',
                            'justifyleft', //居左对齐
                            'justifycenter', //居中对齐
                            'horizontal', //分隔线
                            '|',
                            'blockquote', //引用
                            'insertcode', //代码语言

                            '|',
                            'source', //源代码
                            'preview', //预览
                            'fullscreen', //全屏
                        ]
                    ],
                });


            } else {
                ue = UE.getEditor('editor');
            }
        })
    </script>
@endsection