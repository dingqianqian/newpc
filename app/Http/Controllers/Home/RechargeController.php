<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\RechargeOrderRequest;
use App\Model\Recharge;
use App\Model\RechargeType;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class RechargeController extends Controller
{
    /*
     * 充值首页
     */
    public function index(RechargeType $rechargeType)
    {
        $rechargeTypeInfo=$rechargeType::where("is_show",0)->orderBy("sort")->get()->toArray();
        $index="recharge";
        return view('home.recharge.index',compact("index","rechargeTypeInfo"));
    }
    /*
     * 创建充值订单
     */
    public function createOrder(RechargeType $rechargeType,Application $application,RechargeOrderRequest $request,Recharge $recharge)
    {
        //$giveBack=["2000"=>30,"5000"=>100,"10000"=>300,"20000"=>1000,"50000"=>3000,"100000"=>7000];
        $data["price"]=$request->input("price");
        /*$rechargeTypeInfo=$rechargeType::where("money",$data['price'])->first();
        if (!$rechargeTypeInfo){
            return json(500,"不存在的充值金额");
        }*/
        $data["f_user_id"]=session("userInfo")["id"];
        $data["no"]=make_no();
        $data["create_time"]=time();
        //$data["give_back"]=$rechargeTypeInfo->give_back;
        $data["give_back"]=0;
        $data["f_order_form_status_id"]=3;
        $data["in_ex"]="充值";
        if($rechargeInfo=$recharge->create($data))
        {
            if ($request->input("type")==1)
            {
                //支付宝统一下单
                $aliPay=app("alipay.web");
                //设置支付成功跳转地址（钱包）
                $aliPay->setReturnUrl(url("wallet/index"));
                //设置回调地址
                $aliPay->setNotifyUrl(url("recharge/ali/success"));
                //设置订单号
                $aliPay->setOutTradeNo($rechargeInfo->no);
                //设置订单价格
                $aliPay->setTotalFee($rechargeInfo->price);
                //$aliPay->setTotalFee("0.01");
                //设置订单标题
                $aliPay->setSubject("宜优速充值订单:".$rechargeInfo->no);
                //设置订单描述
                $aliPay->setBody("宜优速电子商务有限公司PC端扫码支付");
                //设置支付类型
                //$aliPay->setQrPayMode("4");
                //dd($aliPay);
                return redirect()->to($aliPay->getPayLink());
            }
            if ($request->input("type")==2)
            {
                $payment=$application->payment;
                $attributes = [
                    'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
                    'body'             => '宜优速订单:'.$rechargeInfo->no,
                    'detail'           => '宜优速订单',
                    'out_trade_no'     => $rechargeInfo->no,
                    'total_fee'        => intval($rechargeInfo["price"]*100), // 单位：分
                    //'total_fee' =>1,
                    ///支付结果通知网址，如果不设置则会使用配置里的默认地址
                    'notify_url'       => url('recharge/weixin/success')
                ];
                //dd($attributes);
                //dd($attributes);
                $order=new \EasyWeChat\Payment\Order($attributes);
                $result=$payment->prepare($order)->toArray();
                $no=$rechargeInfo->no;
                return view("home.recharge.weixin",compact("result","no"));
            }
            return false;
        }else{
            return ["err"=>500,"msg"=>"创建充值订单失败"];
        }
    }
    /*
     * 查询订单信息
     */
    public function getOrderStatus(Request $request,Recharge $recharge)
    {
        $no=$request->input("no");
        $rechargeInfo=$recharge->where("no",$no)->first();
        if ($rechargeInfo->f_order_form_status_id==2)
        {
            return ["err"=>200,"msg"=>"支付成功"];
        }
    }
}
