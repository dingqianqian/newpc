<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LoginRequest;
use App\Model\Access;
use App\Model\Employee;
use App\Model\EmployeeRole;
use App\Model\Role;
use App\Model\RoleAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mews\Captcha\Facades\Captcha;

class LoginController extends Controller
{
    /**
     * 后台登录控制器
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view("admin.login.login");
    }
    /*
     * 登录认证
     */
    public function checkLogin(LoginRequest $request,Employee $employee,Role $role,EmployeeRole $employeeRole,Access $access,RoleAccess $roleAccess)
    {
        $captcha=$request->input("captcha");
        $username=$request->input("username");
        $password=$request->input("password");
        //验证验证码是否正确
        if (!Captcha::check($captcha)){
            return back()->with(["msg"=>"验证码错误"]);
        }
        $userInfo=$employee->where("signin_name",$username)->first();
        if ($userInfo)
        {
            if ($userInfo->pwd==md5($password))
            {
                //登录成功后获取用户的角色信息
                $roleIds=$employeeRole->where("employee_id",$userInfo->id)->select('role_id')->get()->toArray();
                $roleId=[];
                foreach ($roleIds as $k=>$v)
                {
                    $roleId[]=$v["role_id"];
                }
                //通过角色去获取用户的权限
                $accessIds=$roleAccess->whereIn("role_id",$roleId)->select('access_id')->get()->toArray();
                $accessId=[];
                foreach ($accessIds as $k=>$v)
                {
                    $accessId[]=$v['access_id'];
                }
                $accessId=array_unique($accessId);
                //获取员工的所有权限
                $accessInfo=$access->whereIn("id",$accessId)->orderBy("sort")->get()->toArray();
                $accessMiddleware=[];
                foreach ($accessInfo as $k=>$v)
                {
                    $accessMiddleware[]=$v['route_name'];
                }
                $accessInfo=make_tree($accessInfo);
                $userInfo->access=$accessInfo;
                $userInfo->accessMiddleware=$accessMiddleware;
                session(["employeeInfo"=>$userInfo->toArray()]);
                foreach (session("employeeInfo")['access'] as $k=>$v){
                    $temp=[];
                    if (isset($v['child'])){
                        foreach ($v['child'] as $k1=>$v1){
                            $temp[]=$v1['route_name'];
                        }
                    }else{
                       $temp=[];
                    }
                    $id=$v['id'];
                    $arr[$id]=$temp;
                }
                session(["current_tags"=>$arr]);
                return redirect('admin/index');
            }else
                {
                    return back()->with(["msg"=>"密码错误"]);
                }
        }else
            {
                return back()->with(["msg"=>"用户名错误"]);
            }
    }
    /*
     * 退出按钮
     */
    public function logout()
    {
        session(["employeeInfo"=>null]);
        return redirect("admin/login");
    }
}
