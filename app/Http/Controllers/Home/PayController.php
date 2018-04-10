<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\SulifuRequest;
use App\Model\Goods;
use App\Model\GoodsSale;
use App\Model\Integral;
use App\Model\NormsCombo;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\PayErrorCount;
use App\Model\User;
use App\Http\Controllers\Controller;
use App\Model\Wallet;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Yunpian\Sdk\YunpianClient;

class PayController extends Controller
{
    //速立派支付
    public function sulifu(Order $order,Goods $goods,$no)
    {
        $orderInfo=$order::with("orderGoods")->where([["no","$no"],['f_user_id',session("userInfo")["id"]]])->first();
        //dd($orderInfo);
        if ($orderInfo->f_pay_type_id!=0||$orderInfo->f_order_form_status_id!=3)
        {
            return redirect("pay/success/".$orderInfo->no);
        }
        if ($orderInfo)
        {

            $orderInfo=$orderInfo->toArray();
            if ($orderInfo["create_time"]+3600*24<time())
            {
                abort(404);
            }
            //dd($orderInfo);
            $goodsId=[];
            foreach ($orderInfo["order_goods"] as $k=>$v)
            {
                $goodsId[]=$v['f_goods_id'];
            }
            $goodsInfo=$goods->whereIn('id',$goodsId)->get()->toArray();
            $time=date("Y/m/d H:i:s",$orderInfo["create_time"]+3600*24);
        }else
        {
            abort(404);
        }
        return view('home.pay.sulifu',compact('time','goodsInfo','orderInfo'));
    }
    //速立派钱包支付
    public function sulifuPay(Wallet $wallet,Integral $integral,Order $order,OrderGoods $orderGoods,NormsCombo $normsCombo,GoodsSale $goodsSale,SulifuRequest $request,User $user,PayErrorCount $payErrorCount)
    {
        //校验用户支付密码
        $pay_code=$request->input("pay_code");
        $no=$request->input("no");
        $orderInfo=$order->where([["f_user_id",session("userInfo")["id"]],["no",$no]])->first();
        if ($orderInfo->f_pay_type_id!=0||$orderInfo->f_order_form_status_id!=3)
        {
            return ["err"=>500,"msg"=>"该订单已经支付"];
        }
        //获取这个用户的所有信息
        $userInfo=$user::find(session("userInfo")["id"]);
        if ($userInfo->disable_time>time())
        {
            return ["err"=>403,"msg"=>"账户已经被冻结"];
        }
        if (!$userInfo)
        {
            return ["err"=>404,"msg"=>"用户不存在"];
        }
        if ($userInfo->pay_code==md5($pay_code))
        {
            //支付密码验证成功
            //减少钱包余额
            if (is_11121())
            {
                if ($userInfo->wallet<$orderInfo->price)
                {
                    return ["err"=>403,"msg"=>"钱包余额不足"];
                }
                $userInfo->wallet=$userInfo->wallet-$orderInfo->price;
                //修正成交价钱
                $orderGoodsInfo=$orderGoods->where("f_order_form_no",$orderInfo->no)->get();
                foreach ($orderGoodsInfo as $k=>$v)
                {
                    //查询11121价钱
                    $normsComboInfo=$normsCombo->where([["f_goods_id",$v['f_goods_id']],["f_norms_id","{$v['f_norms_id']}"]])->first();
                    $orderGoodsTemp=$orderGoods::find($v['id']);
                    $orderGoodsTemp->deal_min_price=$normsComboInfo->sale_single_price;
                    $orderGoodsTemp->save();
                }
            }else
                {
                    if ($userInfo->wallet<$orderInfo->price)
                    {
                        return ["err"=>403,"msg"=>"钱包余额不足"];
                    }
                    $userInfo->wallet=$userInfo->wallet-$orderInfo->price;
                }
            if ($userInfo->save())
            {
                if ($this->paySuccess($integral,$order,$orderGoods,$normsCombo,$goodsSale,$user,4,$orderInfo->no))
                {
                    $wallet->add($orderInfo->f_user_id,"-".$orderInfo->price,"订单支付",$orderInfo->no);
                    return ["err"=>200,"msg"=>"钱包扣除成功"];
                }else
                    {
                        return ["err"=>500,"msg"=>"钱包扣除失败"];
                    }
            }else
                {
                    return ["err"=>500,"msg"=>"钱包扣除失败"];
                }
        }else
            {
                $info=$payErrorCount->create(["f_user_id"=>session("userInfo")["id"],"create_time"=>time()]);
                if ($info)
                {
                        $count=$payErrorCount->where([["f_user_id",session("userInfo")["id"]],["create_time",">",time()-3600*5]])->count();
                        if ($count>=5)
                        {
                            $userInfo->disable_time=time()+3600*5;
                            if($userInfo->save())
                            {
                                if($payErrorCount->where("f_user_id",session("userInfo")["id"])->delete())
                                {
                                    return ["err"=>403,"msg"=>"账户已经被冻结"];
                                }
                            }else
                                {
                                    return ["err"=>500,"msg"=>"账户冻结失败"];
                                }
                        }else
                            {
                                return ["err"=>404,"msg"=>"密码错误"];
                            }
                }else
                    {
                        return ["err"=>500,"msg"=>"插入错误"];
                    }
            }
    }
    //支付成功后的回调
    public function paySuccess(Integral $integral,Order $order,OrderGoods $orderGoods,NormsCombo $normsCombo,GoodsSale $goodsSale,User $user,$f_pay_type_id,$no)
    {
        //修改订单状态
        $orderInfo=$order->where("no",$no)->first();
        if (!$orderInfo)
        {
            //订单未找到
            return false;
        }
        //修改支付渠道
        $orderInfo->f_pay_type_id=$f_pay_type_id;
        //修改订单状态为已支付
        $orderInfo->f_order_form_status_id=2;
        //修改支付时间
        $orderInfo->pay_time=time();
        if(!$orderInfo->save())
        {
            //订单状态更新失败
            return false;
        }
        //减少库存
        $goodsInfo=$orderGoods->where("f_order_form_no",$no)->get()->toArray();
        foreach ($goodsInfo as $k=>$v)
        {
            //减少库存
            $normsComboInfo=$normsCombo->where([["f_goods_id",$v['f_goods_id']],['f_norms_id',$v["f_norms_id"]]])->first();
            $normsComboInfo->stock=$normsComboInfo->stock-$v["number"];
            $normsComboInfo->save();
            //dd($info);
            //创建商品购买记录
            $data["f_goods_id"]=$v["f_goods_id"];
            $data["create_at"]=time();
            $data["f_user_id"]=$orderInfo->f_user_id;
            $data["number"]=$v["number"];
            $data["f_area_id"]=$orderInfo->f_area_id;
            $goodsSale->create($data);
        }

        //添加积分
        $userInfo=$user::find($orderInfo->f_user_id);
        if (in_array($f_pay_type_id,[14,15,16]))
        {
            $userInfo->integral=$userInfo->integral+floor($orderInfo->discount_price/100);
        }else
            {
                $userInfo->integral=$userInfo->integral+floor($orderInfo->price/100);
            }
        $userInfo->save();
        //dd($userInfo);
        //记录积分变化
        $integralInfo["f_user_id"]=$orderInfo->f_user_id;
        $integralInfo["no"]=$orderInfo->no;
        $integralInfo["number"]="+".floor($orderInfo->price/100);
        $integralInfo["create_time"]=time();
        $integralInfo["f_order_form_status_id"]=2;
        $integralInfo["explain"]="购买商品";
        $integralInfo["type"]=1;
        $integral->create($integralInfo);
        //发送短信通知管理员
        if (isEmployee($userInfo->signin_name))
        {
            $addr="（".explode(" ",$orderInfo['take_over_addr'])[0]."）";
            $clent=YunpianClient::create("2489d60e93f19eff2b41ee9a6da75c03");
            $param = [YunpianClient::MOBILE => "13811188441,18510780526,13671379821,13718187865,18518092630",YunpianClient::TPL_ID=>"1524584",YunpianClient::TPL_VALUE=>"#name#={$userInfo->username}{$addr}&#order_form_url#=http://www.yiyousu.cn/dash/SSC/OrderForm/show/{$no}"];
            $r=$clent->sms()->tpl_batch_send($param);
        }
        return true;
    }
    //支付成功后的页面
    public function success(Order $order,$no)
    {
        $orderInfo=$order->where("no",$no)->first();
        if (!$orderInfo)
        {
            abort(404);
        }
        //订单未支付成功
        if ($orderInfo->f_order_form_status_id!=2)
        {
            return redirect("order/pay/".$orderInfo->no);
        }
        $orderInfo=$orderInfo->toArray();
        return view("home.pay.success",compact('orderInfo'));
    }
    //支付宝跳转页面
    public function aliCreate(Order $order,$no)
    {
        //判断订单是否存在
        $orderInfo=$order->where([['no',$no],["f_user_id",session("userInfo")["id"]]])->first();
        if (!$orderInfo||is_11121())
        {
            abort(404);
        }
        //判断订单是否已经支付
        if ($orderInfo->f_pay_type_id!=0||$orderInfo->f_order_form_status_id!=3)
        {
            return redirect("pay/success/".$orderInfo->no);
        }
        //支付宝统一下单
        $aliPay=app("alipay.web");
        //设置支付成功跳转地址
        $aliPay->setReturnUrl(url("pay/ali/aliReturn"));
        //设置回调地址
        $aliPay->setNotifyUrl(url("pay/ali/success"));
        //设置订单号
        $aliPay->setOutTradeNo($orderInfo->no);
        //设置订单价格
        $aliPay->setTotalFee($orderInfo->price);
        //$aliPay->setTotalFee("0.01");
        //设置订单标题
        $aliPay->setSubject("宜优速订单:".$orderInfo->no);
        //设置订单描述
        $aliPay->setBody("宜优速电子商务有限公司PC端扫码支付");
        //设置支付类型
        //$aliPay->setQrPayMode("4");
        //dd($aliPay);
        return redirect()->to($aliPay->getPayLink());

    }
    //支付宝成功后的回调
    public function aliSuccess(Integral $integral,OrderGoods $orderGoods,NormsCombo $normsCombo,GoodsSale $goodsSale,User $user,Order $order)
    {
        //file_put_contents("./ali.txt",Input::get('out_trade_no'));
        // 验证请求。
        if (! app('alipay.web')->verify()) {
            return 'fail';
        }

        // 判断通知类型。
        switch (Input::get('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
            if ($this->paySuccess($integral,$order,$orderGoods,$normsCombo,$goodsSale,$user,1,Input::get('out_trade_no')))
            {
                return 'success';
            }
                break;
        }
    }
    //支付宝成功跳转页面
    public function aliReturn(Order $order)
    {
        // 验证请求。
        if (! app('alipay.web')->verify()) {
            return 'fail';
        }
        // 判断通知类型。
        $no=Input::get('out_trade_no');
        switch (Input::get('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                return redirect("pay/success/$no");
                break;
        }
        //return $this->success($order,Input::get('out_trade_no'));
    }
    //微信支付
    public function weixinPayCreate(Order $order,Goods $goods,Application $application,$no)
    {
        $orderInfo=$order::with("orderGoods")->where([["no","$no"],['f_user_id',session("userInfo")["id"]]])->first();
        if (is_11121())
        {
            abort(404);
        }
        //dd($orderInfo);
        if ($orderInfo->f_pay_type_id!=0||$orderInfo->f_order_form_status_id!=3)
        {
            return redirect("pay/success/".$orderInfo->no);
        }
        if ($orderInfo)
        {

            $orderInfo=$orderInfo->toArray();
            if ($orderInfo["create_time"]+3600*24<time())
            {
                abort(404);
            }
            //dd($orderInfo);
            $goodsId=[];
            foreach ($orderInfo["order_goods"] as $k=>$v)
            {
                $goodsId[]=$v['f_goods_id'];
            }
            $goodsInfo=$goods->whereIn('id',$goodsId)->get()->toArray();
            $time=date("Y/m/d H:i:s",$orderInfo["create_time"]+3600*24);
            //dd($time);
            //dd($goodsInfo);
        }else
        {
            abort(404);
        }
        //微信统一下单
        $payment=$application->payment;
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => '宜优速订单:'.$orderInfo['no'],
            'detail'           => '宜优速订单',
            'out_trade_no'     => $orderInfo['no'],
            'total_fee'        => intval($orderInfo["price"]*100), // 单位：分
            //'total_fee' =>1,
            ///支付结果通知网址，如果不设置则会使用配置里的默认地址
            'notify_url'       => url('pay/weixin/success')
        ];
        //dd($attributes);
        $order=new \EasyWeChat\Payment\Order($attributes);
        $result=$payment->prepare($order)->toArray();
        //dd($result);
        return view('home.pay.weixin',compact('time','goodsInfo','orderInfo','result'));
    }
    //微信支付成功的回调
    public function weixinPaySuccess(Application $application)
    {
        $response=$application->payment->handleNotify(function ($notify,$successful)
        {
            $order=new Order();
            $integral=new Integral();
            $orderGoods=new OrderGoods();
            $normsCombo=new NormsCombo();
            $goodsSale=new GoodsSale();
            $user=new User();
            $orderInfo=$order->where("no",$notify->out_trade_no)->first();
            if (!$orderInfo)
            {
                return 'Order not exist.';
            }
            if ($successful)
            {
                if ($this->paySuccess($integral,$order,$orderGoods,$normsCombo,$goodsSale,$user,2,$notify->out_trade_no))
                {
                    return true;
                }
            }else
                {
                    return true;
                }
        });
        return $response;
    }
}
