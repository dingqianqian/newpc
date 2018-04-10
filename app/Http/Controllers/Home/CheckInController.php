<?php

namespace App\Http\Controllers\Home;

use App\Model\CheckIns;
use App\Model\User;
use App\Model\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckInController extends Controller
{
    //加载首页
    public function index(CheckIns $checkIns)
    {
        //获取签到的总金额
        $price=$checkIns->where("f_user_id",session("userInfo")["id"])->sum("price");
        //页面标识
        $index="checkin";
        //获取最近35天签到
        $date=$checkIns->where("f_user_id",session("userInfo")["id"])->orderBy("create_time","desc")->limit(35)->select("create_time")->get()->toArray();
        //判断今天是否签到
        $now=getTime();
        $info=$checkIns->isCheckIn(session("userInfo")["id"],$now["star"],$now["end"]);
        //传入今天签到的金额
        $flag=$info?$info->price:false;
        return view("home.checkin.index",compact("price","index","date","flag","userInfo"));
    }
    //签到
    public function create(CheckIns $checkIns,User $user,CouponController $couponController,Wallet $wallet)
    {
        $now=getTime();
        //判断今天是否签到过
        if ($checkIns->isCheckIn(session("userInfo")["id"],$now["star"],$now["end"]))
        {
            return ["err"=>403,"msg"=>"今天已经签到过"];
        }
        $data["price"]=number_format(mt_rand(10,200)/100,2);
        $data["create_time"]=time();
        $data["f_user_id"]=session("userInfo")["id"];
        if ($checkIns->create($data))
        {
            $time=getLastTime();
            //判断用户昨天是否签到
            if ($checkIns->isCheckIn(session("userInfo")["id"],$time["star"],$time["end"]))
            {
                //修改用户连续签到天数和钱包
                $userInfo=$user::find(session("userInfo")["id"]);
                $userInfo->continuous_check_ins=$userInfo->continuous_check_ins+1;
                $userInfo->wallet=$userInfo->wallet+$data["price"];
                $userInfo->save();
                //添加钱包记录
                $wallet->add(session("userInfo")["id"],"+{$data['price']}","签到");
                session(["userInfo"=>$userInfo->toArray()]);
                switch ($userInfo->continuous_check_ins%14)
                {
                    case 7:
                        //给用户发放10元优惠卷
                        $couponController->create(session("userInfo")["id"],34,true);
                        return ["err"=>200,"price"=>$data["price"],"info"=>7,"已经连续签到7天"];
                        break;
                    case 0:
                        $couponController->create(session("userInfo")["id"],28,true);
                        return ["err"=>200,"price"=>$data["price"],"info"=>14,"已经连续签到14天"];
                        break;
                    default:
                        return ["err"=>200,"price"=>$data["price"],"info"=>0,"签到成功"];
                        break;
                }

            }else
                {
                    //修改用户连续签到天数和钱包
                    $userInfo=$user::find(session("userInfo")["id"]);
                    $userInfo->continuous_check_ins=1;
                    $userInfo->wallet=$userInfo->wallet+$data["price"];
                    $userInfo->save();
                    //添加钱包记录
                    $wallet->add(session("userInfo")["id"],"+{$data['price']}","签到");
                    session(["userInfo"=>$userInfo->toArray()]);
                    return ["err"=>200,"price"=>$data["price"],"info"=>0,"签到成功"];
                }
        }else
            {
                return ["err"=>500,"msg"=>"签到失败"];
            }

    }
}
