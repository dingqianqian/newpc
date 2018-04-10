@component("home.layout.tpl")
	@endcomponent
<div class="open1">
	<div class="openOne">
		<!--步骤-->
		<div class="kBuzou">
			<p>1.开票方式</p>
			<span></span>
			<p>2.填写或核对公司信息</p>
		</div>
		<div class="openOneKText">
			<p>发票类型 :
				<input type="radio" checked>增值税发票(纸质)
			</p>
			<p>发票内容 :
				<input type="radio" checked>明细
			</p>
		</div>
		<p>发票将在订单完成之后7-15个工作日寄出</p>
	</div>
	<div class="open1Btn">
		<a href="#/openTwo">下一步</a>
		<a href="javascript:;">取消</a>
	</div>
</div>
