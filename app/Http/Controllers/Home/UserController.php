<?php

namespace App\Http\Controllers\Home;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //修改绑定手机第一步
    public function stepOne()
    {
        $index="safe";
        return view("home.user.stepOne",compact("index"));
    }
    //修改绑定手机第二步
    public function stepTwo(Request $request,User $user)
    {
            $index="safe";
            $code=$request->input("code")?$request->input("code"):session("codeUserCheck");
            session(["codeUserCheck"=>$code]);
            $userInfo=$user::find(session("userInfo")["id"]);
            if (!$userInfo)
            {
                return back()->with(["msg"=>"用户名不存在"]);
            }
            $codeInfo=json_decode($userInfo->sms_code,true);
            if (!$codeInfo)
            {
                return back()->with(["msg"=>"短信验证码错误"]);
            }
            if ($codeInfo["timeout"]<time())
            {
                return back()->with(["msg"=>"短信验证码已过期"]);
            }
            if ($codeInfo["code"]!=$code)
            {
                return back()->with(["msg"=>"短信验证码错误"]);
            }
            return view("home.user.stepTwo",compact('index'));
    }
    //修改绑定手机第三步
    public function stepThr(Request $request,User $user)
    {
        //验证短信验证码是否正确
        $code=$request->input("code");
        $phone=$request->input("phone");
        if (($code!=session("codes"))||($phone!=session("phones")))
        {
            return back()->with(["msg"=>"验证码错误","info"=>$request->all()]);
        }
        if ($user->where("signin_name",$phone)->first())
        {
            return back()->with(["msg"=>"用户已存在","info"=>$request->all()]);
        }
        $userInfo=$user::find(session("userInfo")['id']);
        $userInfo->signin_name=$phone;
        $userInfo->sms_code="";
        if ($userInfos=$userInfo->save())
        {
            session(["userInfo"=>$userInfos]);
            session(["codes"=>null]);
            session(["phones"=>null]);
            Storage::delete("common/$phone.txt");
            $index="safe";
            return view("home.user.stepThr",compact("index"));
        }
        return back()->with(["msg"=>"未知错误"]);
    }
    //发送验证码
    public function code(Request $request,User $user)
    {
        $phone=$request->input("phone");
        $code=str_shuffle(mt_rand(1000,9999));
        $userInfo=$user->where("signin_name",$phone)->first();
        if ($userInfo)
        {
            return ["err"=>500,"msg"=>"对不起，该手机号已被注册"];
        }
        $r=$this->YunPianCode($phone,1572480,$code,"change");
        if ($r==false)
        {
            return ["err"=>500,"msg"=>"120秒内仅能获取一次短信验证码,请稍后重试"];
        }
        if ($r->code()==0)
        {
            session(["codes"=>$code]);
            session(["phones"=>$phone]);
            Storage::put("change/$phone.txt","$phone");
            return ["err"=>200,"msg"=>"发送成功"];
        }else
        {
            return ["err"=>500,"msg"=>"验证码发送错误"];
        }
    }
}
