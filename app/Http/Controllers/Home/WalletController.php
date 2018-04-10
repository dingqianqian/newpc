<?php

namespace App\Http\Controllers\Home;

use App\Model\Recharge;
use App\Model\User;
use App\Model\Wallet;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class WalletController extends Controller
{
    //钱包首页
    public function index(User $user,Recharge $recharge)
    {
        //获取钱余额
        $wallet=$user::find(session("userInfo")["id"])->wallet;
        //获取充值记录
        $rechargeInfo=$recharge::with("payType")->where([["f_order_form_status_id",2],["f_user_id",session("userInfo")['id']]])->orderBy("id","desc")->get()->toArray();
        $index="wallet";
        return view("home.wallet.index",compact("index","wallet","rechargeInfo"));
    }
    //支付宝成功后修改钱包金额
    public function payAli(User $user,Recharge $recharge)
    {
        if (! app('alipay.web')->verify()) {
            return 'fail';
        }

        // 判断通知类型。
        switch (Input::get('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                if ($this->success($user,$recharge,Input::get('out_trade_no'),1))
                {
                    return 'success';
                }
                break;
        }
    }
    //成功执行的回调
    public function success($user,$recharge,$no,$payType)
    {
        //更新支付订单的状态
        $rechargeInfo=$recharge->where("no",$no)->first();
        if (!$rechargeInfo)
        {
            return false;
        }
        $userInfo=$user->where("id",$rechargeInfo->f_user_id)->first();
        if (!$userInfo)
        {
            return false;
        }
        //更新会员等级和钱包
        $userInfo->wallet=$userInfo->wallet+$rechargeInfo->price+$rechargeInfo->give_back;
        $userInfo->f_vip_level_id=2;
        if ($userInfo->save())
        {
            //更新支付订单信息
            $rechargeInfo->f_order_form_status_id=2;
            $rechargeInfo->f_pay_type_id=$payType;
            $rechargeInfo->is_fixed="T";
            $rechargeInfo->pay_time=time();
            if ($rechargeInfo->save())
            {
                return true;
            }else
                {
                    return false;
                }
        }else
            {
                return false;
            }
    }
    //微信成功后的回调
    public function payWeixin(Application $application)
    {
        $response=$application->payment->handleNotify(function ($notify,$successful)
        {
            $user=new User();
            $recharge=new Recharge();
            $rechargeInfo=$recharge->where("no",$notify->out_trade_no)->first();
            if (!$rechargeInfo)
            {
                return 'Order not exist.';
            }
            if ($successful)
            {
                if ($this->success($user,$recharge,$notify->out_trade_no,2))
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
