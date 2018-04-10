<?php

namespace App\Http\Controllers\Admin;

use App\Model\Area;
use App\Model\Coupon;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CouponController extends Controller
{
    //优惠券列表
    public function index(Coupon $coupon,Area $area,User $user,Request $request)
    {
        //搜索的值
        $info["f_area_id"] = $request->input("f_area_id")?$request->input("f_area_id"):0;
        $info["status"] = $request->input("status")?$request->input("status"):0;
        $info["signin_name"] = $request->input("signin_name")?$request->input("signin_name"):"";
        //过滤省份
        $ids = $area::select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->first()->toArray();
        $id = array_unique(explode(",",$ids["ids"]));
        //查询所有的市
        $areaInfo = $area::select("id","name")->whereNotIn("id",$id)->get()->toArray();
        //判断手机号
        $userId = [];
        if ($info['signin_name']) {
            $userIds = $user->where("signin_name", "like", "%{$info['signin_name']}%")->whereNotIn("signin_name", employeePhone())->select("id")->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        } else {
            $userIds = $user->select("id")->whereNotIn("signin_name",employeePhone())->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        }
        //数据库查询
        if($info["f_area_id"] == 0){
            if($info["status"] == 0){
                    $couponInfos = $coupon::with("user")->whereIn("f_user_id",$userId)->paginate(15);
            }elseif($info["status"] == 1){
                $couponInfos = $coupon::with("user")->where("use_time",0)->whereIn("f_user_id",$userId)->paginate(15);
            }else{
                $couponInfos = $coupon::with("user")->where("use_time",">",0)->whereIn("f_user_id",$userId)->paginate(15);
            }
        }else{
            if($info["status"] == 0){
                $couponInfos = $coupon::with("user")->where("f_area_id",$info["f_area_id"])->whereIn("f_user_id",$userId)->paginate(15);
            }elseif($info["status"] == 1){
                $couponInfos = $coupon::with("user")->where("f_area_id",$info["f_area_id"])->where("use_time",0)->whereIn("f_user_id",$userId)->paginate(15);
            }else{
                $couponInfos = $coupon::with("user")->where("f_area_id",$info["f_area_id"])->where("use_time",">",0)->whereIn("f_user_id",$userId)->paginate(15);
            }
        }
        $couponInfo = $couponInfos->toArray();
        return view("admin.coupon.index",compact("areaInfo","couponInfos","couponInfo","info"));
    }
    //优惠券列表导出
    public function export(Coupon $coupon,Area $area,User $user,Request $request)
    {
        //搜索的值
        $info["f_area_id"] = $request->input("f_area_id")?$request->input("f_area_id"):0;
        $info["status"] = $request->input("status")?$request->input("status"):0;
        $info["signin_name"] = $request->input("signin_name")?$request->input("signin_name"):"";
        //过滤省份
        $ids = $area->select(DB::raw("GROUP_CONCAT(parent_id) as ids"))->where("parent_id","!=",0)->first()->toArray();
        $id = array_unique(explode(",",$ids["ids"]));
        //查询所有的市
        $areaInfo = $area->select("id","name")->whereNotIn("id",$id)->get()->toArray();
        //过滤测试人员手机号
        $userId = [];
        if ($info["signin_name"])
        {
            $userIds = $user->where("signin_name","like",$info["signin_name"])->whereNotIn("signin_name",employeePhone())->select("id")->get()->toArray();
            foreach($userId as $k=>$v){
                $userId[] = $v["id"];
            }
        }else{
            $userIds = $user->whereNotIn("signin_name",employeePhone())->select("id")->get()->toArray();
            foreach ($userIds as $k=>$v){
                $userId[] = $v["id"];
            }
        }
        //数据库查询
        if($info["f_area_id"] == 0){
            if($info["status"] == 0){
                $couponInfos = $coupon::with("user")->whereIn("f_user_id",$userId)->get();
            }elseif($info["status"] == 1){
                $couponInfos = $coupon::with("user")->where("use_time",0)->whereIn("f_user_id",$userId)->get();
            }else{
                $couponInfos = $coupon::with("user")->where("use_time",">",0)->whereIn("f_user_id",$userId)->get();
            }
        }else{
            if($info["status"] == 0){
                $couponInfos = $coupon::with("user")->where("f_area_id",$info["f_area_id"])->whereIn("f_user_id",$userId)->get();
            }elseif($info["status"] == 1){
                $couponInfos = $coupon::with("user")->where("f_area_id",$info["f_area_id"])->where("use_time",0)->whereIn("f_user_id",$userId)->get();
            }else{
                $couponInfos = $coupon::with("user")->where("f_area_id",$info["f_area_id"])->where("use_time",">",0)->whereIn("f_user_id",$userId)->get();
            }
        }
        $couponInfo = $couponInfos->toArray();
        //整成一维数组
        $data[] = [
            "编号",
            "用户名",
            "手机号",
            "优惠券状态",
            "领取时间",
            "使用时间",
            "使用类型",
            "价值",
            "地区",
        ];
        foreach($couponInfo as $k=>$v){
            $temp["id"] = $v["id"];
            $temp["username"] = $v["user"]["username"];
            $temp["signin_name"] = $v["user"]["signin_name"];
            if($v["use_time"] == 0){
                $temp["status"] = "未使用";
            }else{
                $temp["status"] = "已使用";
            }
            $temp["create_time"] = date("Y-m-d",$v["create_time"]);
            if($v["use_time"] == 0){
                $temp["use_time"] = "暂无";
            }else{
                $temp["use_time"] = date("Y-m-d",$v["use_time"]);
            }
            $temp["use_type"] = $v["use_type"];
            $temp["use_value"] = $v["use_value"];
            if($v["f_area_id"] == 0){
                $temp["area"] = "全国";
            }
            foreach($areaInfo as $kk=>$vv){
                if($v["f_area_id"] == $vv["id"]){
                    $temp["area"] = $vv["name"];
                }
            }
            $data[] = $temp;
        }
        Excel::create("coupon",function($excel) use ($data){
            $excel->sheet("coupon",function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export("xls");
    }
}
