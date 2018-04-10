<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\PayCodeRequest;
use App\Model\User;
use EasyWeChat\Staff\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Mews\Captcha\Facades\Captcha;
use Yunpian\Sdk\YunpianClient;

class PayCodeController extends Controller
{
    //验证信息
    public function checkInfo(Request $request,User $user)
    {
        if ($request->isMethod('post'))
        {
            if ($request->input("type")==0)
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
                return redirect("safe/paycode/setPwd")->with(["flag"=>true]);
            }else
                {
                    $phone=$request->input("phone");
                    //验证中间手机号4位数
                    if(substr(session("userInfo")["signin_name"],3,4)==$phone)
                    {
                        return redirect("safe/paycode/setPwd")->with(["flag"=>true]);
                    }else
                        {
                            return back()->with(["msg"=>"手机号码中间4位错误"]);
                        }
                }

        }
        $index="safe";
        return view("home.paycode.stepOne",compact("index"));
    }
    //发送短信验证码
    public function sendMessage(User $user)
    {
        $phone=session("userInfo")["signin_name"];
        $userInfo=$user->where("signin_name",$phone)->first();
        if (!$userInfo)
        {
            return ["err"=>404,"msg"=>"用户不存在"];
        }
        $code=str_shuffle(mt_rand(1000,9999));
        $r=$this->YunPianCode($phone,1871872,$code,"paycode");
        if ($r==false)
        {
            return ["err"=>500,"msg"=>"120秒内仅能获取一次短信验证码,请稍后重试"];
        }
        if ($r->code()==0)
        {
            $userInfo->sms_code=json_encode(["code"=>$code,"timeout"=>time()+60*30]);
            if ($userInfo->save())
            {
                Storage::put("paycode/$phone.txt","$phone");
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
    public function setPwd(Request $request)
    {
        $index="safe";
        if (session("flag"))
        {
            $request->session()->flash('flag', true);
            return view("home.paycode.stepTwo",compact("index"));
        }else
            {
                return redirect("safe/paycode/checkInfo");
            }
    }
    //修改成功页面
    public function success(Request $request,User $user)
    {
        $index="safe";
        if (session("flag"))
        {
            if ($request->isMethod("post"))
            {
                $paycode=$request->input("paycode");
                $userInfo=$user::find(session("userInfo")["id"]);
                $userInfo->pay_code=md5($paycode);
                $userInfo->sms_code="";
                if ($userInfo->save())
                {
                    $phone=session("userInfo")['signin_name'];
                    Storage::delete("common/$phone.txt");
                    return view("home.paycode.stepThr",compact("index"));
                }else
                {
                    return back()->with(["msg"=>"修改支付密码失败"]);
                }
            }
            return view("home.paycode.stepThr");
        }else
            {
                abort(404);
            }
    }
}
