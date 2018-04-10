<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\LoginRequest;
use App\Model\CheckIns;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    //加载登录页面
    public function index()
    {
        if ((!session("next"))||(session("next")==url('/')."/")||(session("next")==url("forgetPasssowrd/index")))
        {
            session(["next"=>url()->previous()]);
        }
        return view("home.login.login");
    }
    //验证用户名密码
    public function check(Request $request,User $user,CheckIns $checkIns)
    {
        //判断用户名时候存在
        $userInfo=$user->where("signin_name",$request->input("username"))->first();
        if (!$userInfo)
        {
            return back()->with(["msg"=>"账户名与密码不匹配，请重新输入!"]);
        }
        if ($userInfo->pwd!=md5($request->input("password")))
        {
            return back()->with(["msg"=>"账户名与密码不匹配，请重新输入!"]);
        }
        $time=getLastTime();
        //判断用户昨天是否签到
        $info=$checkIns->isCheckIn($userInfo->id,$time["star"],$time["end"]);
        $now=getTime();
        //判断今天是否签到过
        $info2=$checkIns->isCheckIn($userInfo->id,$now["star"],$now["end"]);
        if ((!$info)&&(!$info2))
        {
            $userInfo->continuous_check_ins=0;
            $userInfo->save();
        }
        session(["userInfo"=>$userInfo->toArray()]);
        if ($userInfo->province)
        {
            session(["city"=>$userInfo->province]);
        }
        if (session("next"))
        {
            $url=session("next");
            if ($url==url("login")||$url==url('register')||$url==url('forgetPasssowrd/success')||$url==url('forgetPasssowrd/index')||$url==url('forgetPasssowrd/setPwd')){
                return redirect("/");
            }
            session(["next"=>null]);
            return redirect($url);
        }
        return redirect("/");
    }
    //用户退出
    public function logout()
    {
        session(["userInfo"=>null]);
        return redirect("/");
    }
}
