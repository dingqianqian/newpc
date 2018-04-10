<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\RegisterRequest;
use App\Model\Area;
use App\Model\CounponType;
use App\Model\Coupon;
use App\Model\CouponType;
use App\Model\Employee;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yunpian\Sdk\YunpianClient;

class RegisterController extends Controller
{
    //注册页首页
    public function index()
    {
        return view("home.register.index");
    }
    //注册
    public function register(CouponController $couponController,RegisterRequest $request,User $user,Employee $employee,CouponType $couponType,Coupon $coupon,Area $area)
    {
        //验证短信验证码是否正确
        $code=$request->input("code");
        $phone=$request->input("signin_name");
        if (($code!=session("code"))||($phone!=session("phone")))
        {
            return back()->with(["msg"=>"验证码错误","info"=>$request->all()]);
        }
        if ($user->where("signin_name",$phone)->first())
        {
            return back()->with(["msg"=>"用户已存在","info"=>$request->all()]);
        }
        //
        $username=$request->input("username");
        if (!$request->input("username"))
        {
            $username="宜优速用户";
        }
        $employeeId=$request->input("f_employee_id");
        if (!$request->input("f_employee_id"))
        {
            $employeeId=1;
        }
        if (!$employee->where([["id",$request->input("f_employee_id")],["f_department_id",2]])->first())
        {
            $employeeId=1;
        }
        $data=$request->except(["pwd_confirmation","code","agree"]);
        $data["signin_name"]=$phone;
        $data["f_employee_id"]=$employeeId;
        $data["username"]=$username;
        $data["pwd"]=md5($request->input("pwd"));
        $data["create_time"]=time();
        $data["bind_employee_time"]=time();
        $data["android_device_token"]="";
        $data["ios_device_token"]="";
        $areaCity=mb_substr($data['take_over_city'],0,2);
        $data['f_area_id']=$area::where("name","like","%$areaCity%")->first()->id;
        $userInfo=$user->create($data);
        if($userInfo)
        {
            $userInfo=$user->where("signin_name",$phone)->first();
            session(["userInfo"=>$userInfo->toArray()]);
            session(["code"=>null]);
            session(["phone"=>null]);
            //如果发过优惠卷直接回首页
            if ($coupon->where([["f_user_id",$userInfo->id],["f_coupon_type_id",27]])->first())
            {
                return redirect("/");
            }
            //给用户发放优惠卷
            if ($userInfo['f_area_id']==256)
            {
                $couponController->create($userInfo->id,35,256);
            }else
                {
                    $couponController->create($userInfo->id,27);
                }
            return redirect("/");
        }else
            {
                return back()->with(["msg"=>"注册失败"]);
            }
    }
    //获取验证码
    public function code(Request $request,User $user)
    {
        $phone=$request->input("phone");
        $code=str_shuffle(mt_rand(1000,9999));
        $userInfo=$user->where("signin_name",$phone)->first();
        if ($userInfo)
        {
            return ["err"=>500,"msg"=>"对不起，该手机号已被注册"];
        }
        $r=$this->YunPianCode($phone,1572480,$code,"register");
        if ($r==false)
        {
            return ["err"=>500,"msg"=>"120秒内仅能获取一次短信验证码,请稍后重试"];
        }
        if ($r->code()==0)
        {
            session(["code"=>$code]);
            session(["phone"=>$phone]);
            Storage::put("register/$phone.txt","$phone");
            return ["err"=>200,"msg"=>"发送成功"];
        }else
        {
            return ["err"=>500,"msg"=>"验证码发送失败"];
        }
    }
}
