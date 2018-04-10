@component("home.layout.tpl")
    @endcomponent
<div class="openTwo">
    <!--步骤-->
    <div class="kBuzou">
        <p>1.开票方式</p>
        <span></span>
        <p>2.填写或核对公司信息</p>
    </div>
    <form name="fForm" action="{{url('invoice/create')}}" method="post">
        <ul class="openTXinxi" id="uld1" ng-click="click()">
            <li>
                <label>单位名称 :</label>
                <input type="text" name="company_name" ng-model="gsDetail.gsName">
                <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>单位名称不能为空</span>
            </li>
            <li id="ly_people">
                <label>纳税人识别码 :</label>
                <input type="text" name="tax_no" id="cIdCode" ng-model="gsDetail.gsIdCode">
                <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>纳税人识别码15或18位</span>
            </li>
            <li>
                <label>注册地址 :</label>
                <input type="text" name="addr" ng-model="gsDetail.gsAdre">
                <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>注册地址不能为空</span>
            </li>
            <li>
                <label>注册电话 :</label>
                <input type="text" name="tel_no" onkeyup="this.value=this.value.replace(/\D/g,'')"
                       onaftepaste="this.value=this.value.replace(/\D/g,'')" ng-model="gsDetail.gsPhone">
                <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>注册电话不能为空</span>
            </li>
            <li>
                <label>开户银行 :</label>
                <input type="text" name="bank_name" ng-model="gsDetail.gsBank">
                <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>开户银行不能为空</span>
            </li>
            <li>
                <label>银行账户 :</label>
                <input type="text" name="bank_account" ng-model="gsDetail.gsCount">
                <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>银行账户不能为空</span>
            </li>
            <li class="readAgree">
                <label for="agree">
                    <input type="checkbox" id="agree">我已阅读并同意
                    <a href="#/zizhi">《增票资质确认书》</a>
                </label>
            </li>
            {{csrf_field()}}
            <li class="open1Btn">
                <button type="submit" class="twoJump">确认提交</button>
                <a href="javascript:;">取消</a>
            </li>
        </ul>
    </form>
</div>