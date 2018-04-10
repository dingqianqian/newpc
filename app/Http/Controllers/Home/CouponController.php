<?php

namespace App\Http\Controllers\Home;

use App\Model\Coupon;
use App\Model\CouponType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    //领取优惠卷
    public function create($userID,$couponID,$areaID=0,$flag=false)
    {
        $couponType=new CouponType();
        $coupon=new Coupon();
        $couponTypeData=$couponType->where("id",$couponID)->first()->toArray();
        $couponData = [
            'no' => make_rand_str('admix', 32),
            'create_time' => time(),
            'f_coupon_status_id' => 1,
            'use_type' => $couponTypeData['use_type'],
            'use_value' => $couponTypeData['use_value'],
            'start_price' => $couponTypeData['start_price'],
            'end_price' => $couponTypeData['end_price'],
            'expire_time_start' => time(),
            'expire_time_end' => $flag?time()+3600*24*30:$couponTypeData['expire_time_end'],
            'f_user_id' => $userID,
            'name' => $couponTypeData['name'],
            'f_coupon_type_id' => $couponTypeData['id'],
            'f_area_id'=>$areaID
        ];
        if($coupon->create($couponData))
        {
            return true;
        }else
            {
                return false;
            }
    }
    //优惠券首页
    public function index(Coupon $coupon)
    {
        //更新优惠券状态过期的为已过期
        $coupon->where([["f_user_id",session("userInfo")['id']],["expire_time_end","<",time()]])->update(["f_coupon_status_id"=>3]);
        $coupon->where([["f_user_id",session("userInfo")['id']],["expire_time_start",">",time()]])->update(["f_coupon_status_id"=>2]);
        $couponInfo=$coupon::with("couponType","area")->where([["f_user_id",session("userInfo")['id']],["is_delete",0]])->get()->toArray();
        $index="coupon";
        return view("home.coupon.index",compact("index","couponInfo"));
    }
    //删除优惠券
    public function delete(Coupon $coupon,$id)
    {
        $couponInfo=$coupon::where([["f_user_id",session("userInfo")['id']],["id",$id]])->update(["is_delete"=>1]);
        if ($couponInfo)
        {
            return json(200,"删除成功");
        }else{
            return json(404,"删除失败","fail");
        }
    }
}
