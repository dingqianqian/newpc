<?php

namespace App\Http\Controllers\Admin;

use App\Model\CheckIns;
use App\Model\Order;
use App\Model\Recharge;
use App\Model\User;
use App\Model\UserRecharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    //会员列表
    public function index(User $user,Recharge $recharge,CheckIns $checkIns,UserRecharge $userRecharge,Request $request)
    {
        //查询条件封装
        //用户手机号
        $info['phone']=$request->input("phone")?$request->input("phone"):"";
        //酒店名称
        $info['hotel_name']=$request->input("hotel_name")?$request->input("hotel_name"):"";
        //钱宝金额
        $info['min_wallet']=$request->input("min_wallet")?intval($request->input("min_wallet")):0;
        $info['max_wallet']=$request->input("max_wallet")?intval($request->input("max_wallet")):10000000;
        //会员等级
        $info['level']=$request->input("level")?[$request->input("level")]:[1,2];
        $userInfos=$user->where([['signin_name',"like","%{$info['phone']}%"],['hotel_name','like',"%{$info['hotel_name']}%"],['wallet',">=",$info['min_wallet']],["wallet","<",$info['max_wallet']]])->whereIn("f_vip_level_id",$info['level'])->whereNotIn("signin_name",employeePhone())->orderBy("id","desc")->paginate(15);
        $userInfo=$userInfos->toArray();
        foreach ($userInfo['data'] as $k=>$v){
            //获取充值金额
            $userInfo['data'][$k]['recharge_price']=$recharge->where([["f_user_id",$v['id']],['f_order_form_status_id',2]])->sum("price");
            $userInfo['data'][$k]['recharge_price']+=$userRecharge->where("f_user_id",$v['id'])->sum("price");
            //返现金额
            $userInfo['data'][$k]['give_back']=$recharge->where([["f_user_id",$v['id']],['f_order_form_status_id',2]])->sum("give_back");
            $userInfo['data'][$k]['give_back']+=$userRecharge->where("f_user_id",$v['id'])->sum("give");
            //签到金额
            $userInfo['data'][$k]['check_price']=$checkIns->where("f_user_id",$v['id'])->sum("price");
        }
        if (count($info['level'])==1){
            $info['level']=$info['level'][0];
        }else{
            $info['level']=0;
        }
        //注册会员数
        $count['user']=$user->count();
        //钱包总余额
        $count['wallet']=$user->whereNotIn("signin_name",employeePhone())->sum("wallet");
        $count['user']=$user->count();
        //黄金会员数
        $count['user2']=$user->where("f_vip_level_id",2)->count();
        //普通会员数
        $count['user1']=$user->where("f_vip_level_id",1)->count();
        return view("admin.member.index",compact("userInfo","userInfos","info","count"));
    }
    //会员详情
    public function info(User $user,Recharge $recharge,UserRecharge $userRecharge,CheckIns $checkIns,Order $order,$id)
    {
        $userInfo=$user::with("employee")->find($id)->toArray();
        //获取充值金额
        $userInfo['recharge_price']=$recharge->where([["f_user_id",$id],['f_order_form_status_id',2]])->sum("price");
        $userInfo['recharge_price']+=$userRecharge->where("f_user_id",$id)->sum("price");
        //返现金额
        $userInfo['give_back']=$recharge->where([["f_user_id",$id],['f_order_form_status_id',2]])->sum("give_back");
        $userInfo['give_back']+=$userRecharge->where("f_user_id",$id)->sum("give");
        //签到金额
        $userInfo['check_price']=$checkIns->where("f_user_id",$id)->sum("price");
        //订单消费金额
        $userInfo['order_price']=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->sum("price");
        //钱包支付总金额
        $tempPrice1=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn('f_pay_type_id',[4,9,10])->sum("price");
        $tempPrice2=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn('f_pay_type_id',[14,15,16])->sum("discount_price");
        $userInfo['wallet_price']=$tempPrice1+$tempPrice2;
        //微信支付总金额
        $userInfo['weixin_price']=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn('f_pay_type_id',[2,5,7])->sum("price");
        //支付宝支付总净额
        $userInfo['ali_price']=$order->where('f_user_id',$id)->whereIn("f_order_form_status_id",[2,4,5,14,15])->whereIn('f_pay_type_id',[1,6,8])->sum("price");
        return view("admin.member.info",compact("userInfo"));
    }
}
