@extends("admin.layout.layout")
		@section("title","添加SKU")
		@section("css")
			<link rel="stylesheet" type="text/css" href="{{asset("admin/css/bootstrap-select.css")}}"/>
			<link rel="stylesheet" type="text/css" href="{{asset("admin/css/z_grouping.css")}}"/>
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
					<b>-添加SKU</b>
					<span class="pull-right">
	<a href="{{route("normsCombo.list")}}" class="btn btn-default btn-xs"><i></i>SKU列表</a>
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
			{{--TAB选项卡--}}
			<div class="tabs">
				<div class="z_tabs text-center">
					<a href="#cont" class="active">商品信息</a>
					<a href="#album">商品图片</a>
				</div>
			<form class="form-horizontal" method="post" action="{{url("admin/normsCombo/update")}}/{{$normsComboInfo['id']}}">
				<div id="cont" class="active">
				<!--商品名称-->
				<div class="form-group">
					<label for="" class="control-label col-xs-4">商品名称:</label>
					<div class="col-xs-6 col-sm-4">
						<span class="z-span">{{$goodsInfo['name']}}</span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">地区</label>
					<select id="goodsNames" class="selectpicker z-select" data-live-search="true" name="f_area_id">
						@foreach($areaInfo as $k=>$v)
							<option value="{{$v['id']}}" @if($v['id']==$normsComboInfo['f_area_id']) selected @endif>{{$v['name']}}</option>
							@endforeach
					</select>
				</div>
				<!--库存数量-->
				<div class="form-group">
					<label for="" class="control-label col-xs-4">库存数量:</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" placeholder="请填写库存数量" name="stock" value="{{$normsComboInfo['stock']}}">
					</div>
				</div>
				<!--销售库存-->
				<div class="form-group">
					<label for="" class="control-label col-xs-4">促销库存:</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" placeholder="请填写促销库存数量" name="sale_stock" value="{{$normsComboInfo['sale_stock']}}">
					</div>
				</div>
				<!--商品单价-->
				<div class="form-group">
					<label for="" class="control-label col-xs-4">商品单价:</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" placeholder="请填写商品单价" name="piece_price" value="{{$normsComboInfo['piece_price']}}">
					</div>
				</div>
					<!--商品单价-->
					<div class="form-group">
						<label for="" class="control-label col-xs-4">商品单价(11121):</label>
						<div class="col-xs-6 col-sm-4">
							<input type="text" class="form-control" placeholder="请填写商品单价" name="small_piece_price" value="{{$normsComboInfo['small_piece_price']}}">
						</div>
					</div>
				<!--易购价-->
				<div class="form-group">
					<label for="" class="control-label col-xs-4">宜购价:</label>
					<div class="col-xs-6 col-sm-4">
						<input type="text" class="form-control" placeholder="请填写商品易购价" name="single_price" value="{{$normsComboInfo['single_price']}}">
					</div>
				</div>
					<!--冰点价-->
					<div class="form-group">
						<label for="" class="control-label col-xs-4">冰点价:</label>
						<div class="col-xs-6 col-sm-4">
							<input type="text" class="form-control" placeholder="请填写商品冰点价格" name="sale_single_price" value="{{$normsComboInfo['sale_single_price']}}">
						</div>
					</div>
				@foreach($normsGroupInfo as $k=>$v)
				<div class="form-group">
					<label class="control-label col-xs-4">{{$v['name']}}</label>
					<select id="goodsNames" class="selectpicker z-select" data-live-search="true" name="norms[{{$v['id']}}]">
						@foreach($v['norms'] as $k1=>$v1)
						<option value="{{$v1['id']}}" @if(in_array($v1['id'],$normsComboInfo["f_norms_id"])) selected @endif>{{$v1['name']}}</option>
							@endforeach
					</select>
				</div>
				@endforeach
					{{csrf_field()}}
					<input type="hidden" name="f_goods_id" value="{{$goodsInfo['id']}}">
					{{--提交--}}
				<div class="submitBtn text-center">
					<button type="submit" class="btn btn-success">确定</button>
					<button type="reset" class="btn btn-primary">重置</button>
				</div>
				</div>
				<div id="album">
				<div class="form-group">
					<label for="" class="control-label col-xs-4">详情图:</label>
					<div class="col-xs-6 col-sm-4"  style="margin-top: 5px;">
						@foreach($goodsDetailsImgInfo as $k=>$v)
						<div class="col-xs-4 z-diva">
							<input type="radio" name="f_goods_details_img_id" class="a" value="{{$v['id']}}" @if($normsComboInfo['f_goods_details_img_id']==$v['id']) checked @endif/>
							<p class="z-img">
								<img src="{{$v['url']}}"/>
							</p>
							<div class="z-show"><img src="{{$v['url']}}" alt=""></div>
						</div>
						@endforeach
					</div>
				</div>
				<!--规格图片-->
				<div class="form-group">
					<label for="" class="control-label col-xs-4">规格主图:</label>
					<div class="col-xs-6 col-sm-4"  style="margin-top: 5px;">
						@foreach($goodsImgInfo as $k=>$v)
						<div class="col-xs-4 z-div">
							<input type="radio" name="f_goods_img_id" id="" value="{{$v['id']}}" @if($normsComboInfo['f_goods_img_id']==$v['id']) checked @endif/>
							<p path="{{$v['url']}}" class="zf-img dome">
								<a path="{{$v['url']}}" class="preview" href="javascript:;">
									<img src="{{$v['url']}}"/>
								</a>
							</p>
						</div>
							@endforeach
					</div>
				</div>
					{{--多选--}}
					<div class="form-group">
						<label for="" class="control-label col-xs-4">规格图片:</label>
						<div class="col-xs-6 col-sm-4"  style="margin-top: 5px;">
							@foreach($goodsImgInfo as $k=>$v)
								<div class="col-xs-4 z-div z_checkbox">
									<input type="checkbox" name="f_norms_image[]" @if(in_array($v['id'],$relationNormsComboGoodsImgInfos)) checked @endif value="{{$v['id']}}"/>
									<p path="{{$v['url']}}" class="zfa-img dome ">
										<a path="{{$v['url']}}" class="preview" href="javascript:;">
											<img src="{{$v['url']}}"/>
										</a>
									</p>
								</div>
							@endforeach
						</div>
					</div>
					<!--提交-->
					<div class="submitBtn text-center">
						<button type="submit" class="btn btn-success">添加</button>
						<button type="reset" class="btn btn-primary">重置</button>
					</div>
				</div>
			</form>
			</div>
		</section>

		@component("admin.layout.footer")
			@endcomponent

	</div>
	@endsection
@section("js")
<script src="{{asset("admin/js/bootstrap-select.js")}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset("admin/js/defaults-zh_CN.js")}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset("admin/js/previewshow.js")}}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	$(function () {
		let height = $(window).height()/1.4;
		$(".z-show").css("height",height);
		$('.z-diva').mouseenter(function(){
            $(this).children('div').addClass('show');
            if($(this).siblings('div').children('div').hasClass('show')){
                $(this).siblings('div').children('div').removeClass('show')
            }
		}).mouseleave(function(){
            $(this).children('div').removeClass('show');
		})
        $("body").on('click',function(e){
            if(e.target.nodeName!=='IMG'){
            $(".show").removeClass('show')
			}
		})
    });
    $(".z_checkbox .zfa-img").each(function (index,val) {
        $(val).click(function(){
            if($(this).parent().children('input').prop("checked")){
                $(this).parent().children('input').prop('checked',false);
            }
            else {
                $(this).parent().children('input').prop('checked',true)
            }
        })
    });
// ly
	$(function(){
	    $('.z-img,.zf-img').each(function(index,value){
	        $(value).click(function(){
				$(this).parent().children('input').prop('checked',true)
			})
		});
	});
	
	//	展示图片
$(function(){
	if($('a.preview').length){
		var img = preloadIm();
		imagePreview(img);
	}
});
// 选项卡
$('.z_tabs>a').click(function (e) {
	e.preventDefault();
	// id
	var id = $(this).attr('href');
	$(id).addClass('active').siblings('.active').removeClass('active');
	$(this).addClass('active').siblings('.active').removeClass('active');
});
</script>
@endsection
