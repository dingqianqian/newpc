<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ForgetPasswordRequest;
use App\Model\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    //加载找回密码页面
    public function index()
    {
        return view("admin.password.index");
    }
    //判断用户是否能找回密码
    public function send(ForgetPasswordRequest $request,Employee $employee)
    {
       $username=$request->input("username");
       $email=$request->input("email");
       //判断用户是否存在
        $employeeInfo=$employee->where("signin_name","$username")->first();
        if ($employeeInfo)
        {
            if ($employeeInfo->email=="$email"){
                //验证成功发送邮件
                $employeeInfo->pwd=md5("123123");
                $employeeInfo->save();
                return back()->with(["msg"=>"员工密码已被重置为123123,请立即登录修改密码"]);
            }else{
                return back()->with(["msg"=>"员工邮箱不存在或未录入"]);
            }
        }else{
            return back()->with(["msg"=>"员工不存在"]);
        }
    }
    //修改密码
    public function change(Request $request,Employee $employee)
    {
        if ($request->isMethod("post"))
        {
            $employeeInfo=$employee::find(session("employeeInfo")['id']);
            if ($employeeInfo->pwd==md5($request->input("old_pwd")))
            {
                $employeeInfo->pwd=md5($request->input("pwd"));
                $employeeInfo->save();
                return redirect("admin/changePwdSuccess");
            }else
                {
                    return back()->with(["msg"=>"原密码错误"]);
                }
        }
       return view("admin.password.confirm");
    }
    //修改密码成功
    public function changePwdSuccess()
    {
        return view("admin.password.success");
    }
}
