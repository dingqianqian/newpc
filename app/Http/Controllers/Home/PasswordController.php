<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\PasswordRequest;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yunpian\Sdk\YunpianClient;

class PasswordController extends Controller
{
    //忘记密码首页
    public function index()
    {
        return view("home.password.index");
    }
    //发送短信验证码
    public function sendMessage(Request $request,User $user)
    {
        $phone=$request->input("phone");
        $userInfo=$user->where("signin_name",$phone)->first();
        if (!$userInfo)
        {
            return ["err"=>404,"msg"=>"用户不存在"];
        }
        $code=str_shuffle(mt_rand(1000,9999));
        $r=$this->YunPianCode($phone,1825210,$code,"code");
        if ($r==false)
        {
            return ["err"=>500,"msg"=>"120秒内仅能获取一次短信验证码,请稍后重试"];
        }
        if ($r->code()==0)
        {
            $userInfo->sms_code=json_encode(["code"=>$code,"timeout"=>time()+60*30]);
            if ($userInfo->save())
            {
                Storage::put("code/$phone.txt","$phone");
                return ["err"=>200,"msg"=>"发送成功"];
            }else
                {
                    return ["err"=>500,"msg"=>"发送短信验证码失败"];
                }
        }else
            {
                return ["err"=>500,"msg"=>"发送短信验证码失败,请稍后重试"];
            }
    }
    //设置新密码
    public function setPwd(Request $request,User $user)
    {
        if (session("passwordFind"))
        {
            //dd(session("passwordFind"));
            return view("home.password.setPwd");
        }
        $username=$request->input("username");
        $code=$request->input("code");
        $userInfo=$user->where("signin_name",$username)->first();
        if (!$userInfo)
        {
            return back()->with(["userNameError"=>"用户名不存在","info"=>$request->all()]);
        }
        $codeInfo=json_decode($userInfo->sms_code,true);
        if (!$codeInfo)
        {
            return back()->with(["codeInfo"=>"短信验证码错误","info"=>$request->all()]);
        }
        if ($codeInfo["timeout"]<time())
        {
            return back()->with(["codeInfo"=>"短信验证码已过期","info"=>$request->all()]);
        }
        if ($codeInfo["code"]!=$code)
        {
            return back()->with(["codeInfo"=>"短信验证码错误","info"=>$request->all()]);
        }
        session(["passwordFind"=>$username]);
        return view("home.password.setPwd");
    }
    //修改密码成功页面
    public function success(PasswordRequest $request,User $user)
    {
        $password=$request->input("password");
        $phone=session("passwordFind");
        session(["passwordFind"=>null]);
        if (!$password||!$phone)
        {
            abort(404);
            return false;
        }
        $userInfo=$user->where("signin_name",$phone)->first();
        $userInfo->pwd=md5($password);
        $userInfo->sms_code="";
        if ($userInfo->save())
        {
            return view("home.password.success");
        }
    }
    //设置支付密码第一步
    public function stepOne()
    {
        $index="safe";
        return view("home.password.stepOne",compact("index"));
    }
    //发送短信验证码
    public function sendSms(User $user)
    {
        $phone=session("userInfo")["signin_name"];
        $userInfo=$user->where("signin_name",$phone)->first();
        if (!$userInfo)
        {
            return ["err"=>404,"msg"=>"用户不存在"];
        }
        $code=str_shuffle(mt_rand(1000,9999));
        $r=$this->YunPianCode($phone,1825210,$code,"common");
        if ($r==false)
        {
            return ["err"=>500,"msg"=>"120秒内仅能获取一次短信验证码,请稍后重试"];
        }
        if ($r->code()==0)
        {
            $userInfo->sms_code=json_encode(["code"=>$code,"timeout"=>time()+60*30]);
            if ($userInfo->save())
            {
                Storage::put("common/$phone.txt","$phone");
                return ["err"=>200,"msg"=>"发送成功"];
            }else
            {
                return ["err"=>500,"msg"=>"发送短信验证码失败"];
            }
        }else
        {
            return ["err"=>500,"msg"=>"发送短信验证码失败,请稍后重试"];
        }
    }
    //设置支付密码第二步
    public function stepTwo(User $user,Request $request)
    {
        //验证短信验证码
        $code=$request->input("code");
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
        $index="safe";
        session(["flagPassword"=>true]);
        return view("home.password.stepTwo",compact("index"));
    }
    //设置支付密码第三步
    public function stepThr(PasswordRequest $request,User $user)
    {
        $index="safe";
        if (session("flagPassword"))
        {
            if ($request->isMethod("post"))
            {
                $paycode=$request->input("password");
                $userInfo=$user::find(session("userInfo")["id"]);
                $userInfo->pwd=md5($paycode);
                $userInfo->sms_code="";
                if ($userInfo->save())
                {
                    session(["flagPassword"=>null]);
                    $phone=$userInfo->signin_name;
                    Storage::delete("common/$phone.txt");
                    return view("home.password.stepThr",compact("index"));
                }else
                {
                    return back()->with(["msg"=>"修改支付密码失败"]);
                }
            }
            return view("home.password.stepThr");
        }else
        {
            abort(404);
        }
    }
}
