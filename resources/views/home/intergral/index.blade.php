@extends("home.layout.layout")
		@section("title","积分商城")
		@section("css")
			<link href="http://www.jq22.com/jquery/bootstrap-3.3.4.css" rel="stylesheet">
			<script src="http://libs.baidu.com/html5shiv/3.7/html5shiv.min.js"></script>
			<link rel="stylesheet" href="{{asset('home/css/integral/integralMall.css')}}">
		@endsection
@section("content")
@component("home.layout.headTwo")
	@endcomponent
<div class="er-title">
	<p><a href="{{url('/')}}">首页</a>/<span>积分商城</span></p>
</div>
<div class="oStep clear">
	<div id="integralMall" style="margin: 24px auto 710px;width: 1152px;height: 361px;">
		<img src="{{asset('home/images/integral/jifenNone.jpg')}}" alt="">
	</div>
	{{--<!--左侧导航-->
	<div class="leftMyInte">
		<div class="myInte">
			<img src="{{asset('home/images/integral/integral.png')}}" alt="">
			<span>我的积分：</span>
			<span> 225</span>
		</div>
		<ul class="oStepC">
			<li class="active">
				<a href="#integralMall">积分商城</a>
			</li>
			<li>
				<a href="#myIntegral">我的积分</a>
			</li>
			<li>
				<a href="#integralRule">积分规则</a>
			</li>
		</ul>
	</div>
	<!--右侧内容-->
	<div class="tRight">
		<ul id="integralMall" class="tStepCont" style="display: block;">
			@foreach($integralShopInfo as $k=>$v)
			<li ids="{{$v['id']}}" type="{{$v['type']}}">
				<a href="javascript:;">
					<div>
						<img src="" data-trueImg="{{asset('home/images/integral_goods')}}/{{$v['id']}}.png" alt="">
					</div>
					<p class="getIntegral">消耗{{$v['integral']}}积分兑换</p>
				</a>
			</li>
			@endforeach
		</ul>
		<div id="myIntegral">
			<div class="mgI">
				<span>收支记录</span>
				<p>
					<a href="#getRecord" class="active">获取记录</a>
					<a href="#exchangeRecord">兑换记录</a>
				</p>
			</div>
			<div class="recordTop">
				<span>日期</span>
				<span>来源/用途</span>
				<span>积分变化</span>
			</div>
			<div class="mainInte">
				<!--获取记录-->
				<div id="getRecord" style="display: block;">
					<div class="myIDetail">
						<ul>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-21</span>
								<p>桌面端签到</p>
								<span>+7</span>
							</li>
						</ul>
						<div class="integralPage">
							<button>上一页</button>
							<a href="javascript:;" class="active">1</a>
							<a href="javascript:;">2</a>
							<a href="javascript:;">3</a>
							<span>...</span>
							<button>下一页</button>
						</div>
					</div>
				</div>
				<!--暂无获取记录-->
				<!--<div class="noRecord" style="display: block;">
					<img src="{{asset('home/images/integral/canyin.png')}}" alt="">
					<p>暂无获取记录</p>
				</div>-->
				<!--兑换记录-->
				<div id="exchangeRecord">
					<div class="myIDetail">
						<ul>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票兑换香港双人游机票兑换香港双人游机票兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
							<li>
								<span class="integralTime">2016-06-1</span>
								<p>兑换香港双人游机票</p>
								<span>+7</span>
							</li>
						</ul>
						<div class="integralPage">
							<button>上一页</button>
							<a href="javascript:;" class="active">1</a>
							<a href="javascript:;">2</a>
							<a href="javascript:;">3</a>
							<span>...</span>
							<button>下一页</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="integralRule">
			<div class="ly_1">
				<div class="integralTitle">1.积分的获得方式</div>
				<div class="ly_1_content">
					<p>1.已有素的每一位会员在本城消费可累计积分 , 100元置换1分 , 积分累计无上限 ; 消费完成后即自动激活成为可用积分 ; 积分的数值精确到个位(小数点后全部舍弃 , 不进行四舍五入)例如购买商品实际支付总价为999元 , 积分累计9分 ;</p>
					<p>2.完善用户资料 , 所有选项均添写保存成功后可获得10积分 ; </p>
					<p>3.用户在译宜优速商城完成订单交易并将货品签收之日后的一个月内 , 成功提交评价可获得2分 ;</p>
					<p>4.凡在已宜优速商城注册成功的用户均可获得5分 ;</p>
					<p>5.您登陆宜优速商城后 , 在 "我的" - "速立付" 中查看当前积分及积分历史记录。</p>
				</div>
			</div>
			<div class="ly_2">
				<div class="integralTitle">2.积分的用途</div>
				<div class="ly_2_content">
					<p>1.积分换礼 : 您可登录宜优速官网的积分商城挑选礼物 , 自行兑礼。(或致电客服热线 : 400-068-7870)</p>
					<p>2.登录宜优速官网积分商城 , 可参与积分抽奖活动 , 获取奖品。</p>
					<p>3.宜优速官网将不定期举办积分换购活动 , 登录宜优速官网积分商城 , 参与积分换购活动。</p>
				</div>
			</div>
			<div class="ly_3">
				<div class="integralTitle">3.积分换礼的领取</div>
				<div class="ly_3_content">
					<p>1.积分换礼后 , 您可以在宜优速账户的积分兑换记录中查询您所兑换的礼品 ;</p>
					<p>2.兑换成功后 , 宜优速客服会在您兑换48小时内跟您取得联系 , 确定发放时间 , 为您发放。您也可以拨打400-068-7870客服热线查询。</p>
					<p>3.参加宜优速各种活动的礼品和奖品领取方式以活动说明为准。</p>
				</div>
			</div>
			<div class="ly_4">
				<div class="integralTitle">3.积分的扣除方式</div>
				<div class="ly_4_content">
					<p>购买后如遇会员退货情况 , 该笔消费产生的积分将相应扣除。</p>
				</div>
			</div>
			<div class="zhu">
				<p>注 : </p>
				<p>以上所有产品折扣及售后服务仅限为本公司出售的产品 , 本手册在不损害会员既有利益的条件下由北京宜优速电子商务科技有限责任公司享有最终解释权 ,</p>
				<p>并可能在法律允许的范围内对会员活动细则进行调整。 修改后的内容将在宜优速网站及移动端App这种公布 , 无需另行通知。</p>
			</div>
		</div>
	</div>--}}
</div>
<!--积分兑换弹框-->
<div class="succHuan" id="suc">
	<div class="zhaozhao">
		<img src="{{asset('home/images/integral/guanbi.png')}}" alt="">
		<p class="btiao">确认订单</p>
		<div class="gan">
			<p>您已成功兑换
				<i>"50元手机卡充值卡"</i></p>
			<p>本次兑换扣除<i>70</i>积分</p>
		</div>
		<div class="sucClose">
			<a class="laL" href="javascript:;">返到积分商城</a>
			<a class="noDel" href="javascript:;">返回到首页</a>
		</div>
	</div>
</div>
<!--积分不足弹框-->
<div class="failHuan">
	<div class="zhaozhao">
		<img src="{{asset('home/images/integral/guanbi.png')}}" alt="">
		<p class="btiao">确认订单</p>
		<div class="gan">
			<p>您的积分不足 , 暂时不能兑换</p>
		</div>
		<div class="sucClose">
			<a class="laL" href="javascript:;">去购物获积分</a>
			<a class="noDel" href="javascript:;">取消</a>
		</div>
	</div>
</div>
<!--48联系弹框-->
<div class="lianxi succHuan">
	<div class="zhaozhao lianxiZ">
		<img src="{{asset('home/images/integral/guanbi.png')}}" alt="">
		<p class="btiao">确认订单</p>
		<div class="gan lianxigan">
			<p>您已成功兑换
				<i>"50元手机卡充值卡"</i></p>
			<p>本次兑换扣除<i>70</i>积分</p>
			<p>工作人员将在48小时内与您联系</p>
		</div>
		<div class="sucClose">
			<a class="laL" href="javascript:;">返到积分商城</a>
			<a class="noDel" href="javascript:;">返回到首页</a>
		</div>
	</div>
</div>
<!--确认订单弹框-->
<div class="getAdress sureDing" id="sureding">
	<div class="zhaozhao">
		<img src="{{asset('home/images/integral/guanbi.png')}}" alt="">
		<p class="btiao">确认订单</p>
		<div class="gan">
			<div class="addAdr">
				<div>
					<i><img src="{{asset('home/images/integral/pos.png')}}" alt=""></i>
					<span class="name">李影</span>
					<span class="tel">1232323456</span>
					<span class="adress"></span>
				</div>
				<b><img src="{{asset('home/images/integral/down.png')}}" alt=""></b>
				<a href="javascript:;" class="adit">编辑</a>
				<a href="javascript:;" class="del">删除</a>
				<ul class="moreAdress" style="display: none;">
					<li class="newAdre">
						<img src="{{asset('home/images/integral/add.png')}}" alt="">
						<span>添加新地址</span>
					</li>
				</ul>
			</div>
			<!--商品-->
			<div class="pStore">
				<span><img src="{{asset('home/images/integral/1.jpg')}}" alt=""></span>
				<p class="storeDetail">
					大家平222
				</p>
				<span><i class="pay">124.8</i></span>
			</div>
			<p class="needPay">需支付 : <span>00000</span></p>
		</div>
		<div class="sucClose">
			<a class="laL" href="javascript:;">返到积分商城</a>
			<a class="noDel" href="javascript:;">返回到首页</a>
		</div>
	</div>
</div>
<!--确认订单 填写手机号 弹框-->
<div class="addTel getAdress" id="addtel">
	<div class="zhaozhao">
		<img src="{{asset('home/images/integral/guanbi.png')}}" alt="">
		<p class="btiao">确认订单</p>
		<div class="gan">
			<!--商品-->
			<div class="pStore">
				<div class="addP">
					<span><img src="{{asset('home/images/integral/1.jpg')}}" alt=""></span>
					<p class="storeDetail">
						大家好我是赵子平222我今年22岁大家好我是赵子平222我今年22岁大家好我是赵子平222我今年22岁
					</p>
					<span class="pay"><i>124.8</i></span>
				</div>
				<div class="pStoreTel">
					<label for="aTel" id="tell" name="tel_no" type="text">请输入手机号码： </label>
					<input type="text"  id="aTel" onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="11"
					       onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="请在此输入您要充值的手机号">
				</div>

			</div>
			<p class="needPay">需支付 : <span>00000</span></p>
		</div>
		<div class="sucClose">
			<a class="laL" href="javascript:;">返到积分商城</a>
			<a class="noDel" href="javascript:;">返回到首页</a>
		</div>
	</div>
</div>
<!--填写地址弹框-->
<div class="quan">
	<div class="zhezhao">
		<form class="zheCon" id="addr">
			<p class="add">填写收货地址</p>
			<div class="sRen">
				<label for="ren"><i>*</i>收货人 : </label>
				<input id="ren" name="name" type="text" placeholder="请输入收货人姓名">
			</div>
			<div class="sRenn">
				<label><i>*</i>收货地址 : </label>
				<div data-toggle="distpicker" id="cacon" class="clear">
					<div class="form-group">
						<label class="sr-only" for="province2">Province</label>
						<select name="province" class="form-control" id="province2"
						        data-province="---- 选择省 ----"></select>
					</div>
					<div class="form-group">
						<label class="sr-only" for="city2">City</label>
						<select name="city" class="form-control" id="city2" data-city="---- 选择市 ----"></select>
					</div>
					<div class="form-group">
						<label class="sr-only" for="district2">District</label>
						<select class="form-control" name="town" id="district2"
						        data-district="---- 选择区 ----"></select>
					</div>
				</div>
			</div>
			<input id="tail" name="ex" type="text" placeholder="如选择不到您的地区 , 请在此处详细描述">
			<label for="tel"><i>*</i>手机号码 : </label>
			<input onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="11"
			       onafterpaste="this.value=this.value.replace(/\D/g,'')" id="tel" name="tel_no" type="text"
			       placeholder="请输入您的电话号">
		</form>
		<a href="javascript:;" class="yq">确定</a>
		<a href="javascript:;" class="noadd">取消</a>
		<img src="{{asset('home/images/integral/guanbi.png')}}" alt="">
	</div>
</div>
@endsection
@section("js")
	<script src="http://libs.baidu.com/html5shiv/3.7/html5shiv.min.js"></script>
	<script src="{{asset('home/js/integral/distpicker.data.js')}}"></script>
	<script src="{{asset('home/js/integral/distpicker.js')}}"></script>
	<script src="{{asset('home/js/integral/integralMall.js')}}"></script>
	<script type="text/javascript">
		var lis = $('.tStepCont > li > a > p');
		for(var i=0,len=lis.length;i<len;i++){
			$(lis[i]).click(function(){
			    @if(!session("userInfo"))
					location.href="{{url('login')}}";
					return false;
				@endif
					var ids = $(this).parent().parent().attr('ids');
					var type = $(this).parent().parent().attr('type');
				if(type == '1'){
				    $.ajax({
						url:'{{url('integral/shop/getInfo')}}/'+ids,
						type:'get',
						success:function(res){
						    var adress = res.data.integralShopInfo;
						    $(adress).each(function(k,v){
								$('#addtel .pStore img').attr('src',v.img_url);
								$('#addtel .pStore .storeDetail').text(v.name);
								$('#addtel .pStore i').text(v.integral);
								$('#addtel .gan .needPay>span').text(v.integral)
							});
						}
					});
                    $('#addtel').fadeIn(300);
				}
				else if(type == '2'){
				}
				else{
				    $.ajax({
						url:'{{url('integral/shop/getInfo')}}/'+ids,
						type:'get',
						success:function(res){
						    var first = res.data.default,
								others = res.data.takeOverInfo,
								info = res.data.integralShopInfo;
								$('#sureding .zhaozhao .addAdr>div .name').text(first.name)
                            $('#sureding .zhaozhao .addAdr>div').attr('ids',first.id);
							$('#sureding .zhaozhao .addAdr>div .tel').text(first.tel_no);
                            $('#sureding .zhaozhao .addAdr>div .adress').text(first.addr)
                            $('#sureding .zhaozhao .addAdr>div .adress').attr('title',first.addr);
                            $('#sureding .pStore img').attr('src',info.img_url);
                            $('#sureding .pStore .storeDetail').text(info.name);
                            $('#sureding .pStore i.pay').text(info.integral);
                            $('#sureding .gan .needPay>span').text(info.integral);


							var li = $('#sureding .moreAdress>li');
                            if(others == ''){
                                return false;
							}else{
                                var html = '';
                                for(var k in others){
                                    var data = others[k];
									html+=`
										<li>
						<div ids='${data.id}'>
							<i><img src="{{asset('home/images/integral/pos.png')}}" alt=""></i>
							<span class="name">${data.name}</span>
							<span class="tel">${data.tel_no}</span>
							<span class="adress" title='${data.province} ${data.city} ${data.town} ${data.ex}'>${data.addr}</span>
						</div>
						<a href="javascript:;" class="adit">编辑</a>
						<a href="javascript:;" class="del">删除</a>
					</li>
									`;
								}
							}
						$('#sureding .moreAdress').append(html);
                            var lis = $('#sureding .moreAdress>li:not(".newAdre")>div');
                            for(var i=0;i<lis.length;i++) {
                                $(lis[i]).click(function () {
                                    // 复制当前内容
                                    var copy = $(this).html();
                                    // 原div内容
                                    var old = $('#sureding .addAdr>div').html();
                                    // 追加到默认div
                                    $('#sureding .addAdr>div').html(copy);
                                    // 当前内容为div内容
                                    $(this).html(old);
                                })
                            }
                            // 点击删除地址
                            $('.addAdr a.del').click(function(){
                                $(this).parent().attr('ids',' $(this).attr("id")');
                            });
                            // 点击编辑地址
                            $('.addAdr>a.adit').click(function(){
                                $('#sureding,#addtel').css('display','none');
                                $('.quan').css('display','block');
                                // 将地址显示在页面上
                                var name = $(this).parent().children('div').children('.name').html();
                                var tel = $(this).parent().children('div').children('.tel').text();
                                $('.quan #ren').val(name);
                                $('.quan #tel').val(tel);
                                $('.quan #province2').val(first.province);
                                $("#province2").trigger("change");
                                $('.quan #city2').val(first.city);
                                $("#city2").trigger("change");
                                $('.quan  #district2').val(first.town);
                                $('.quan  #tail').val(first.ex);
                                $('.yq').attr('id', $(this).parent().children('div').attr('ids'));
                            });
                            // 点击编辑 ul
                            $('.moreAdress>li>.adit').click(function(){
                                $('.yq').attr('id', $(this).parent().children('div').attr('ids'));
                                var name = $(this).parent().children('div').children('.name').text();
                                var tel = $(this).parent().children('div').children('.tel').text();
                                var ly_Adre = $(this).parent().children('div').children('.adress').attr('title').split(' ');
                                $('#ren').val(name);  // 收货人
                                $('#tel').val(tel); // 电话
                                $("#province2").val(ly_Adre[0]);
                                $("#province2").trigger("change");
                                $("#city2").val(ly_Adre[1]);
                                $("#city2").trigger("change");
                                $("#district2").val(ly_Adre[2]);
                                $('#tail').val(ly_Adre[3]);
                                $('.yq').attr('id', $(this).parent().children('div').attr('ids'));
                                $('.quan').css('display','block')
                            });
                            // 点击确定
                            $('.yq').unbind('click').click(function () {
                                var flag = true;
                                if (flag) {
                                    $('.quan .zhezhao #cacon .form-group .form-control').each(function (m, n) {
                                        if ($(n).val() == '') {
                                            layer.msg('请选择收货地址');
                                            flag = false;
                                            return false;
                                        }
                                    });
                                }
                                if (flag) {
                                    if ($('#tail').val() == '') {
                                        layer.msg('您需要填写详细的收货地址，可在下方文本框内填写');
                                        flag = false;
                                    }
                                }
                                if (flag) {
                                    if ($('#tel').val() == '') {
                                        layer.msg('请您填写收货人手机号码');
                                        flag = false;
                                    }
                                }
                                if (flag) {
                                    if ($('#tel').val().length !== 11) {
                                        layer.msg('请您输入正确的电话号');
                                        flag = false;
                                    }
                                }
                                if (flag) {
                                    var ly_people = $(this).parent().find('#ren').val() ; // 收货人
                                    var ly_tel = $(this).parent().find('#tel').val(),  // 电话
                                        ly_prev = $(this).parent().find('#province2').val(),
                                        ly_city = $(this).parent().find('#city2').val(),
                                        ly_town = $(this).parent().find('#district2').val(),
                                        ly_xiang = $(this).parent().find('#tail').val();

                                    if($(this).attr('id') !=undefined){
                                        var lyId = $(this).attr('id');
                                        // 修改
                                        $.ajax({
                                            url:"{{url('/takeOver/updateTakeOver')}}/"+lyId,
                                            type:'post',
                                            data:{name:ly_people,province:ly_prev,city:ly_city,tel_no:ly_tel,town:ly_town,ex:ly_xiang},
                                            success:function(res){
                                                if(res.err == 200){
													var data = res.data;
                                                    console.log(data);
													var id  = data.id;
													// 循环
                                                    $('.addAdr  div').each(function(k,v){
                                                        if($(v).attr('ids') == id){
                                                            $(v).children('.name').text(data.name);
                                                            $(v).children('.tel').text(data.tel_no);
                                                            // 获取省市县
                                                            var sheng = data.province,
                                                                shi = data.city,
                                                                xian = data.town,
                                                                di = data.ex;

                                                            $(v).children('.adress').text(''+sheng+shi+xian+di);
														}
													});
                                                }
                                            }
                                        });
                                    }else{
                                        // 新增
                                        $.ajax({
                                            url:"{{url('takeOver/addTakeOver')}}",
                                            type:'post',
                                            data:{name:ly_people,province:ly_prev,city:ly_city,tel_no:ly_tel,town:ly_town,ex:ly_xiang},
                                            success:function(res){
                                                return false;
                                                if(res.err ==200 ){
                                                    location.reload(true)
                                                }
                                            }
                                        })
                                    }
                                    $(this).removeAttr('id');
                                    $('.quan').css('display','none');
									$('#sureding').css('display','block')
                                }
                            });
						}
					});
                    $('#sureding').fadeIn(300);
				}
			})
		}
	</script>
	@endsection