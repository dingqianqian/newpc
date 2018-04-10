@extends("home.layout.layout")
		@section("title","加入我们")
		@section("css")
			<link rel="stylesheet" href="{{asset('home/css/joinus/jionUs.css')}}">
		@endsection
@section("content")
@component("home.layout.headTwo")
	@endcomponent
<div class="er-title">
	<p><a href="{{url('/')}}">首页</a>/<span>加入我们</span></p>
</div>
<div class="oStep clear">
	<!--左侧导航-->
	@component("home.layout.sidebar",["index"=>$index])
		@endcomponent
	<!--右侧内容-->
	<div class="tStepCont">
		<div class="joinImg">
			<img src="{{asset('home/images/joinus/joinD.jpg')}}" alt="">
		</div>
		<div class="welcome">
			<h2>
				<i><img src="{{asset('home/images/joinus/hi.png')}}" alt=""></i>
				欢迎来到我们的团队
			</h2>
			<p>做事认真 , 仔细 , 吃苦耐劳 , 责任心强 ; 有良好的团队精神及团队协作力 ; 有梦想 , 有抱负 , 希望通过公司平台得以发展 ; 能够为提升个人能力和退订企业发展付诸行动 ; 不一定要有学历 , 但一定要有学习力!</p>
		</div>
		<div class="jionUs">
			<p><img src="{{asset('home/images/joinus/jionUs.png')}}" ></p>
			<div class="jion_1">
				<h1>
					<i><img src="{{asset('home/images/joinus/circle.png')}}" alt=""></i>
					市场营销
				</h1>
				<div class="jion_1_p">
					<p>
						<b>岗位职责：</b>
						商业客户的开发、维护 ; 广告设计稿的审核和客户复核等一系列的工作任务。
					</p>
					<p>
						<b>要求：</b>
						大专以上学历 , 年龄22-26岁 , 男性 , 有较强的团队协作精神及创新能力 , 责任心强。
					</p>
				</div>
			</div>
			<div class="jion_2">
				<h1>
					<i><img src="{{asset('home/images/joinus/circle.png')}}" alt=""></i>
					平面设计
				</h1>
				<div class="jion_2_p">
					<p>
						<b>岗位职责：</b>
						设计公司广告业务广告 , 公司形象宣传广告 , 公司办公用品等。
					</p>
					<p>
						<b>要求：</b>
						大专以上学历 , 年龄22-26岁 熟练使用Photoshop、CoreIDRAW、等设计排版软件 , 做事仔细、认真、责任心强。
					</p>
				</div>
			</div>
			<div class="jion_3">
				<div class=                                                                           "jion_3-p">
					<p>
						<b>岗位职责：</b>
						设计公司广告业务广告 , 公司形象宣传广告 , 公司办公用品等。
					</p>
					<p>
						<b>要求：</b>
						大专以上学历 , 年龄22-26岁 熟练使用Photoshop、CoreIDRAW、等设计排版软件 , 做事仔细、认真、责任心强。
					</p>
				</div>
				<h1><img src="{{asset('home/images/joinus/circle.png')}}" alt="">销售客服</h1>
			</div>
			<div class="jion_4">
				<div class="jion_4-p">
					<p>
						<b>岗位职责：</b>
						对计算机软硬件及网络设备维护 , 保证公司日常信息系统的稳定性。对企业信息文化、 高效化提出合理建议并进行实施。
					</p>
					<p>
						<b>要求：</b>
						男 , 大专以上学历 , 年龄22-26岁 , 对网络维护有实践经验 , 具有良好的组织协调能力。
					</p>
				</div>
				<h1><img src="{{asset('home/images/joinus/circle.png')}}" alt="">销售客服</h1>
			</div>
			<div class="jion_5">
				<h1>
					<i><img src="{{asset('home/images/joinus/circle.png')}}" alt=""></i>
					发行人员
				</h1>
				<div class="jion_5_p">
					<p>
						<b>岗位职责：</b>
						对市场进行监督和调查 , 投放刊物。
					</p>
					<p>
						<b>要求：</b>
						18-26周岁 , 男 , 身体健康 , 能吃苦耐劳 , 有责任心 , 优秀者提供住宿。
					</p>
				</div>
			</div>
			<div class="jion_6">
				<img src="{{asset('home/images/joinus/jion.png')}}" alt="">
			</div>
		</div>
		<div class="jion-text">
			<div>
				<p>在这里 , 你将得到</p>
				<p>持续提升的环境和空间 ;</p>
				<p>
					持续提升的个人素质和技能 ;
				</p>
				<p>持续展现的自我价值和梦想！</p>
			</div>
			<div>
				<p>简历投稿邮箱 : </p>
				<p>yiyousu@126.com</p>
			</div>
		</div>
	</div>
</div>
@endsection