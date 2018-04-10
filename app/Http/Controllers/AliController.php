<?php

namespace App\Http\Controllers;

use App\Model\Area;
use Illuminate\Http\Request;
use Latrell\Alipay\Facades\AlipayWeb;
use Latrell\Alipay\Web\SdkPayment;

class AliController extends Controller
{
    //
    public function create()
    {
        $alipay=app("alipay.web");
        $alipay->setOutTradeNo("201608201445375911");
        $alipay->setTotalFee("500");
        $alipay->setSubject("测试订单1");
        $alipay->setBody("测试数据");
        return redirect()->to($alipay->getPayLink());
    }
    public function  back(Area $area)
    {
        dd(mb_substr("北京市",0,2));
        $area->where("name","like","郑州")->first()->toArray();
        echo 123;
    }
}
