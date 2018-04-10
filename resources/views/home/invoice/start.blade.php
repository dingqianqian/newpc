
{{--   通过验证   --}}
@if($addValueTaxInfo["status"]==2)
<div class="okVail">
	<div class="dXieS">
		<p>
			<span>发票类型 : <i></i>增值税发票</span>
		</p>
		<p>
			<span>发票内容 : <i></i>明细</span>
		</p>
	</div>
	<form action="">
		<div class="startTaitou">
			<p>
				<span>可用增值票信息：</span>
				<img src="{{asset('home/images/invoice/xiesi.png')}}" alt="">
				<span>{{$addValueTaxInfo['company_name']}}</span>
			</p>
			<!--选择收货地址-->
			<ul id="yiXiuGai">
				{{--<li>增票售票地址</li>--}}
				@foreach($takeOverInfo as $k=>$v)
					@if($loop->index==0)
				<li id="adreeDetail">
					<span>收货地址 : </span>
					<p>
						<i></i>
						<span>寄送至</span>
						<label>
							<input type="radio" name="adressOne">
							<span title="{{$v['province']}} {{$v['city']}} {{$v['town']}} {{$v['ex']}}">{{$v['province']}}{{$v['city']}}{{$v['town']}}{{$v['ex']}}</span>
						</label>
						<span class="lyRen">收货人 : <em>{{$v['name']}}</em></span>
						<span class="lyTel">电话 : <em>{{$v['tel_no']}}</em></span>
						<span class="lyxiugai" id="{{$v['id']}}" zds="{{$v['company_name']?$v['company_name']:""}}">修改</span>
						<em class="deleteAd" ids="{{$v['id']}}"></em>
					</p>
				</li>
					@endif
				@endforeach
				<!--显示新添加地址-->
				<div id="lyscoll" style="display: none;margin-top:10px;">
				@foreach($takeOverInfo as $k=>$v)
					@if($loop->index!=0)
							<li class="showAdress">
								<ul>
									<li>
										<p>
											<i></i>
											<span>寄送至</span>
											<label>
												<input type="radio" name="adressOne">
												<span title="{{$v['province']}} {{$v['city']}} {{$v['town']}} {{$v['ex']}}">{{$v['province']}}{{$v['city']}}{{$v['town']}}{{$v['ex']}}</span>
											</label>
											<span class="lyRen">收货人 : <em>{{$v['name']}}</em></span>
											<span class="lyTel">电话 : <em>{{$v['tel_no']}}</em></span>
											<span class="lyxiugai" id="{{$v['id']}}" zds="{{$v['company_name']?$v['company_name']:""}}">修改</span>
											<em class="deleteAd" ids="{{$v['id']}}"></em>
										</p>
									</li>
								</ul>
							</li>
					@endif
				@endforeach
				</div>
				@if(count($takeOverInfo)>1)
				<li id="showMoreAdr">
					<span>显示更多收货地址</span><img src="{{asset('home/images/invoice/down.png')}}" alt="">
				</li>
				@endif
				<li>
					收货人信息 <a href="javascript:;" id="useNewAd">【使用新地址】</a>
				</li>
			</ul>
		</div>
		<div class="startXinxi">
			<p class="fTime">
				<span>订单号/下单时间</span>
				<span>支付方式</span>
				<span class="lastM">可开发票金额</span>
			</p>
			@if($orderInfo)
			<ul class="detailX">
                @foreach($orderInfo as $k=>$v)
				<li ids="{{$v['id']}}">
						<span><input type="checkbox" @if(in_array($v['f_pay_type_id'],[4,9,10,14,15,16])) name="wallet" @endif></span>
						<div class="spanT">
							<p>{{$v['no']}}</p>
							<p>{{date("Y-m-d H:i:s",$v['create_time'])}}</p>
						</div>
					<p class="pLeft">{{$v['pay_type']['name']}}</p>
					@if(in_array($v['f_pay_type_id'],[14,15,16]))
					<p class="lyP"><span>{{number_format($v["discount_price"],2,".","")}}</span>(元)</p>
					@else
					<p class="lyP"><span>{{number_format($v["price"],2,".","")}}</span>(元)</p>
						@endif
				</li>
                    @endforeach
			</ul>
			@else
			<!--    如果没有    -->
			<p class="noneFa">暂无可开发票信息</p>
			@endif
			@if($orderInfo)
			<div class="clickGetF">
				{{--<input type="checkbox" id="checkAll">--}}
				{{--<span >全选</span>--}}
				<div class="notGt">钱包支付的订单可开发票金额不能大于 :
					<span kekai="{{number_format($price,2,".","")}}">{{number_format($price,2,".","")}}</span>元</div>
				<div class="clickGetFBtn">
					已选金额：<span>0</span>(元)
					<button type="button">索取发票</button>
				</div>
			</div>
			@endif
		</div>
	</form>
	<div class="suc1">
		<div class="sucN">
			<h2>发票索取成功</h2>
			<p>我们会在7-15个工作日内寄送到您填写的发票地址，注意查收</p >
			<span>确定</span>
		</div>
	</div>
	<!--删除收货地址遮罩层-->
	<div class="delHide_ly">
		<div class="zhaozhao">
			<p class="btiao">删除商品</p>
			<p class="gan">
				<img src="{{asset('home/images/invoice/gantanhao.png')}}" alt="">
				<span>您确定要删除该商品吗？</span>
			</p>
			<a class="laL" href="javascript:;">确定</a>
			<a class="noDel" href="javascript:;">取消</a>
		</div>
	</div>
</div>
{{--   审核中   --}}
@elseif($addValueTaxInfo["status"]==1)
<div class="vailing">
	<p>对不起 , 您的认证申请正在审核中 , 暂不能开取增值税发票。</p>
	<p>给您带来的不变 , 敬请谅解。</p>
</div>
@else
{{--已驳回--}}
<div class="noVail">
	<p>对不起 , 您的认证信息未通过 , 暂不能开取增值税发票 , 请前往增票资质信息修改您的认证信息。</p>
	<p>给您带来的不变 , 敬请谅解。</p>
</div>
	@endif