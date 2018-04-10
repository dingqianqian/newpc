/*  ++++++         LY    */
	// 固定宽度
	var h = 200;
	$('.leftCon>ul>li:first-child').each(function(k,v){
		$(v).click(function(){

			if($(this).siblings('li').css('display') == 'block'){
				$(this).siblings('li').css('display','none');
				$(this).find('i').css('background','url("img/plus.gif") no-repeat');
			}else{
				$(this).siblings('li').css('display','block');
				$(this).find('i').css('background','url("img/minus.gif") no-repeat');
			}
		})
	});

// 显示隐藏
$('.sectionLeft .collapse>img').click(function(){

	if($('.leftContent').css('display')  == 'block'){
		$('.leftContent').css('display','none');
		$('.sectionRight').css('margin-left','10px');
		$('.sectionLeft').css('width','10px');
		$(this).attr('src','img/right.gif');
	}else{
		$('.leftContent').css('display','block');
		$('.sectionRight').css('margin-left',h+'px');
		$('.sectionLeft').css('width',h+'px');
		$(this).attr('src','img/left.gif');
	}
});

	// 显示隐藏

var height = $(document).height()-77;
var conHeight = $('.sectionRight').height()+70;
/*console.log(height,conHeight)*/
if(height<conHeight){
	$('.collapse').css('height',conHeight);

}else{
	$('.collapse').css('height',height);

}/*
// 省级联动
$('#cacon').distpicker({
	autoSelect: false
});
// 下拉搜索
$(function(){
	$('#select').searchableSelect();
});*/

// section的高度
var height = $(document).height() - 77;
$('.section,.sectionRight').css('height', height);

//路径切换
$("ul li a").click(function() {
	if($(this).attr('myhref') !== 'undefined') {
		$('#pIframe').attr('src', $(this).attr('myhref'));
		sessionStorage.setItem("a",$("#pIframe").attr("src"));
	}
});
//刷新
$(".nav-sel .break").click(function() {
    window.location.reload();
});




// 图片点击切换
$('.yOn img').each(function(k,v){
	$(v).click(function(){
		if($(this).attr('src') == 'img/yes.gif'){
			$(this).attr('src','img/no.gif');
		}else{
			$(this).attr('src','img/yes.gif');
		}
	});
});

//点击输入等级
$('.need').each(function(k,v){
	$(v).click(function(){
		// 获取span内容
		var value = $(this).text();
		// 显示可输入框
		$(this).parent().children('.shuru').css('display','inline-block').focus();
		$(this).hide();
		// span内容切换到input
		$(this).next('input').val(value);
	});
});
$('.shuru').each(function(k,v){
	$(v).blur(function(){
		var textVal = $(this).val();
		$(this).css('display','none');
		// span内容显示
		$(this).parent().children('.need').css('display','inline-block').text(textVal);
	});
});
