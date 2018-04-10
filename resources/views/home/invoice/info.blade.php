<div class="detailMess">
	<ul>
		<li>
			<p>我们会在一个工作日内完成审核工作</p>
			<p>1)注意有效增值税发票开票资质仅为一个</p>
			<p>2)发票常见问题查看增票资质帮助</p>
			<p>3)本页面信息仅供增值税准用发票-资质审核使用，切勿进行支付相关业务，谨防上当受骗。</p>
		</li>
		@if($addValueTaxInfo)
		<li class="detailRevise">
			<div>
				您的增票资质 :
			@if($addValueTaxInfo['status']==1)
				<span>已提交,等待审核</span>
				@elseif($addValueTaxInfo['status']==2)
				<span>审核已经通过 , 您可以正常开取增值税发票</span>
				@else
				<span>已驳回 , 对不起 , 您未通过申请 , 请重新认证</span>
				@endif
			</div>
			@if($addValueTaxInfo['status']!=1)
			<div class="detailReviseBtn">
				<a href="#/xiugai">修改</a>
				{{--<a href="javascript:;" ids="{{$addValueTaxInfo['id']}}">删除</a>--}}
			</div>
				@endif
		</li>
			@endif
	</ul>
	<!--增票资质信息-->
	@if($addValueTaxInfo)
	<ul class="messZengP">
		<li>增票资质信息</li>
		<li>
			<span>单位名称 : </span>
			<span>{{$addValueTaxInfo["company_name"]}}</span>
		</li>
		<li>
			<span>纳税人识别码 : </span>
			<span>{{$addValueTaxInfo['tax_no']}}</span>
		</li>
		<li>
			<span>注册地址 : </span>
			<span>{{$addValueTaxInfo['addr']}}</span>
		</li>
		<li>
			<span>注册电话 : </span>
			<span>{{$addValueTaxInfo['tel_no']}}</span>
		</li>
		<li>
			<span>开户银行 : </span>
			<span>{{$addValueTaxInfo['bank_name']}}</span>
		</li>
		<li>
			<span>银行账户 : </span>
			<span>{{$addValueTaxInfo['bank_account']}}</span>
		</li>
	</ul>
		@endif
</div>