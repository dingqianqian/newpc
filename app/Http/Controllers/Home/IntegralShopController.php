<?php

namespace App\Http\Controllers\Home;

use App\Model\Integral;
use App\Model\IntegralShop;
use App\Model\TakeOver;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegralShopController extends Controller
{
    //积分商城首页
    public function index(IntegralShop $integralShop)
    {
        //获取商品列表
        $integralShopInfo=$integralShop->get()->toArray();
        return view("home.intergral.index",compact("integralShopInfo"));
    }
    //获取积分商品信息
    public function getInfo(TakeOver $takeOver,IntegralShop $integralShop,$id)
    {
        //获取用户收货地址
        $takeOverInfo=$takeOver->getAll(session("userInfo")['id']);
        //dd($takeOverInfo);
        //获取积分商品的信息
        $integralShopInfo=$integralShop::find($id)->toArray();
        $integralShopInfo["img_url"]=asset('home/images/integral_goods')."/".$integralShopInfo['id'].".png";
        $takeOverInfo[0]['addr']=$takeOverInfo[0]['province'].$takeOverInfo[0]['city'].$takeOverInfo[0]['town'].$takeOverInfo[0]['ex'];
        $data["default"]=$takeOverInfo[0];
        unset($takeOverInfo[0]);
        foreach ($takeOverInfo as $k=>$v)
        {
            $takeOverInfo[$k]['addr']=$v['province'].$v['city'].$v['town'].$v['ex'];
        }
        $data["takeOverInfo"]=$takeOverInfo;
        $data["integralShopInfo"]=$integralShopInfo;
        return json(200,$data,"success");
    }
    //我的积分
    public function person(User $user,Integral $integral)
    {
        //获取用户积分
        $integrals=$user::find(session("userInfo")['id'])->integral;
        //获取用户积分记录
        $integralInfo=$integral->where([["f_user_id",session("userInfo")['id']],["number","!=","+0"]])->orderBy("id","desc")->get()->toArray();
        $index="integral";
        return view("home.intergral.person",compact("index","integrals","integralInfo"));
    }
}
