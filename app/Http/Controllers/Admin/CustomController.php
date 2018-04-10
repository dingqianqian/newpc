<?php

namespace App\Http\Controllers\Admin;

use App\Model\Custom;
use App\Model\NormsCombo;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomController extends Controller
{
    //订制信息列表
    public function index(Custom $custom,Request $request,NormsCombo $normsCombo,User $user)
    {
        $info["hotel_name"] = $request->input("hotel_name")?$request->input("hotel_name"):"";
        $info["signin_name"] = $request->input("signin_name")?$request->input("signin_name"):"";
        $info["is_delete"] = $request->input("is_delete");
        if($info["is_delete"] === null||$info["is_delete"]==2)
        {
            $info["is_delete"] = [0,1];
        }else{
            $info["is_delete"] = [$request->input("is_delete")];
        }
        $userId = [];
        if ($info['signin_name']) {
            $userIds = $user->where("signin_name", "like", "%{$info['signin_name']}%")->whereNotIn("signin_name", employeePhone())->select("id")->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        } else {
            $userIds = $user->select("id")->whereNotIn("signin_name", employeePhone())->get()->toArray();
            foreach ($userIds as $k => $v) {
                $userId[] = $v['id'];
            }
        }
        $customInfos = $custom::with("user")->where("hotel_name","like","%{$info["hotel_name"]}%")->whereIn("f_user_id",$userId)->whereIn("is_delete",$info["is_delete"])->paginate(15);
        $customInfo = $customInfos->toArray();
        foreach ($customInfo["data"] as $k=>$v)
        {
            $customInfo["data"][$k]["logo_url"] = "http://".$normsCombo->setCache($v["logo"]);
        }
        if(count($info["is_delete"]) == 1)
        {
            $info["is_delete"] = $request->input("is_delete");
        }else{
            $info["is_delete"] = 2;
        }
        return view("admin.custom.index",compact("customInfos","customInfo","info"));
    }
}
