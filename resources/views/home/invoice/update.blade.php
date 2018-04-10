<div class="openTwo xiugaiInfo">
    <div>
        <p>填写增票资质信息 <span>( 所有信息均为必填 )</span></p>
        <form name="fForm" method="post" action="{{url('invoice/update')}}">
            <ul class="openTXinxi" id="uld1" ng-click="click()">
                <li>
                    <label>单位名称 :</label>
                    <input type="text" name="company_name" ng-model="info.company_name">
                    <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>单位名称不能为空</span>
                </li>
                <li id="ly_people">
                    <label>纳税人识别码 :</label>
                    <input type="text" name="tax_no"   id="cIdCode" ng-model="info.tax_no">
                    <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>纳税人识别码15或18位</span>
                </li>
                <li>
                    <label>注册地址 :</label>
                    <input type="text" name="addr"  ng-model="info.addr">
                    <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>注册地址不能为空</span>
                </li>
                <li>
                    <label>银行账户 :</label>
                    <input type="text" name="tel_no"  ng-model="info.bank_name">
                    <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>银行账户不能为空</span>
                </li>
                <li>
                    <label>注册电话 :</label>
                    <input type="text" name="bank_name" ng-model="info.tel_no">
                    <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>注册电话不能为空</span>
                </li>
                <li>
                    <label>银行账户 :</label>
                    <input type="text" name="bank_account" ng-model="info.bank_account">
                    <span><i><img src="{{asset('home/images/invoice/alert.png')}}" alt=""></i>银行账户不能为空</span>
                </li>
                <li class="readAgree">
                    <label for="agree">
                        <input type="checkbox" id="agree">我已阅读并同意
                        <a href="#/zizhi">《增票资质确认书》</a>
                    </label>
                </li>
                {{csrf_field()}}
                <li class="open1Btn" id="open1Btn">
                    <button class="twoJump" type="submit">确定并重新上传</button>
                    <a href="#/detailMessage">取消</a>
                </li>
            </ul>
        </form>
    </div>
    <!--增票地址-->
    <!--<ul id="weiXiuGai">-->
        <!--<li>增票售票地址</li>-->
        <!--<li class="settingAdress">-->
            <!--您还没有收货地址，马上去-->
            <!--<a href="javascript:;" class="nowSetAdress">添加</a>-->
            <!--吧!-->
        <!--</li>-->
    <!--</ul>-->
</div>
