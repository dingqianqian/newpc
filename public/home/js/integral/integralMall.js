 // 积分选项卡
function tabs(){
	$('.oStepC>li').on('click','a',function(e){
		e.preventDefault();
		var $this = e.target;
		var href = $this.href;
		var starti = href.lastIndexOf("#");
		var div = href.slice(starti);
		console.log(div)
		// 根据id找到对应的div
		$(div).css('display','block').siblings().css('display','none');
		$($this).parent().addClass('active');
		$(this).parent().siblings('.active').removeClass('active')
	})
}
// 积分记录选项卡
function tab(){
	$('.mgI>p').on('click','a',function(e){
		e.preventDefault();
		var $this = e.target;
		var href = $this.href;
		var starti = href.lastIndexOf("#");
		var div = href.slice(starti);
		console.log(div)
		// 根据id找到对应的div
		$(div).css('display','block').siblings().css('display','none');
		$(this).addClass('active').siblings('.active').removeClass('active')
	})
}
tabs();
tab();

// 懒加载
function loadImg(curImg) {
	var tempImg = new Image;
	tempImg.src = curImg.getAttribute('data-trueImg');
	tempImg.onload = function () {
		curImg.src = this.src;
		$(curImg).fadeIn();
		tempImg = null;
	};
	curImg.isLoad = true;
}
function xun() {
	$('.tStepCont > li > a > div > img').each(function (k, v) {
		var bHeight = $(window).height() + $(window).scrollTop(),
			vHeight = $(v).parent().outerHeight() / 2 + $(v).parent().offset().top;
		if ($(v).attr('isLoad')) {
			return;
		}
		if (bHeight > vHeight) {
			loadImg($(v)[0]);
		}
	});
}
window.setTimeout(xun, 500);
window.onscroll = xun;

 // 地址
 $('#cacon').distpicker({
	 autoSelect: false
 });
 // 弹框
 var widthP = document.documentElement.clientWidth || document.body.clientWidth,
	 heightP = document.documentElement.clientHeight || document.body.clientHeight;
 $('.succHuan,.failHuan,.quan,.getAdress').css({'width': widthP, 'height': heightP});
	// 点击兑换
	$('.tStepCont > li > a > p').each(function(k,v){
		$(v).click(function(){
			//	 $('#suc').fadeIn(300);
			//$('.failHuan').fadeIn(300);
			//   $('.lianxi').fadeIn(300);
		});
	});

 //确定
 $('.laL').unbind('click').click(function () {

	 $('.succHuan').fadeOut(300);
	 $('.failHuan').fadeOut(300);
 });
 // 取消或者叉号
 $('.noDel,.zhaozhao>img').click(function(){
	 $('.succHuan').fadeOut(300);
	 $('.failHuan').fadeOut(300);
	 $('.getAdress').fadeOut(300);
	 $('.moreAdress').toggle()
 });
 // 添加地址取消
 $('.noadd, .zhezhao>img').click(function(){
	 $(this).parent().parent().css('display','none');
	 $('#sureding').css('display','block')
	 $('.moreAdress').css('display','none')
 });

 // 点击添加更多地址
$('.getAdress .addAdr>div,.getAdress .addAdr>b').click(function(){
 $('.moreAdress').toggle()
});
 // 点击地址切换默认
 /*var lis = $('#sureding .moreAdress>li:not(".newAdre")');
 for(var i=0;i<lis.length;i++){
	 $(lis[i]).click(function(){
	 	console.log($(this))
		 // 复制当前内容
		 var copy = $(this).children('div').html();
		 // 原div内容
		 var old = $('#sureding .addAdr>div').html();
		 console.log(copy);
		 // 追加到默认div
		 console.log()
		 $('#sureding .addAdr>div').html(copy);
		 // 当前内容为div内容
		 $(this).find('div').html(old);

	 })
 }*/
 $('.addTel .laL,.addTel .noDel').click(function(){
	 $('.quan').css('display','none');
	 $('#addtel').css('display','block');
 });
 // 点击添加新地址
 $('.moreAdress>li.newAdre').click(function(){
	 // 清空value
	 $('#ren').val('');
	 $('#tel').val('');

	$(this).parent().parent().parent().parent().parent().css('display','none');
	 $('.quan').css('display','block');
 });


