<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdate;
use App\Model\Area;
use App\Model\Department;
use App\Model\Employee;
use App\Model\EmployeeRole;
use App\Model\EmployeeStatus;
use App\Model\EmployeeType;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //管理员列表
    public function index(Area $area,Employee $employee,Request $request,EmployeeStatus $employeeStatus,Department $department)
    {
        //获取所有状态
        $employeeStatusInfo=$employeeStatus->get()->toArray();
        //获取所有部门
        $departmentInfo=$department->get()->toArray();
        //获取所有的地区
        $areaInfo=$area->get()->toArray();

        $info['name']=$request->input("name")?$request->input("name"):"";
        $info['phone']=$request->input("phone")?$request->input("phone"):"";
        $info['department']=$request->input("department")?$request->input("department"):"%";
        $info['status']=$request->input("status")?$request->input("status"):"%";
        $info['areas']=$request->input("area")?$request->input("area"):"%";
        $employeeInfos=$employee::with("department","employeeStatus","area")->where([["username","like","%{$info['name']}%"],["signin_name","like","%{$info['phone']}%"],["f_department_id","like","{$info['department']}"],["f_employee_status_id","like","{$info['status']}"],["f_area_id","like","{$info['areas']}"]])->paginate(15);
        //dd($employeeInfos->toArray());
        $employeeInfo=$employeeInfos->toArray();
        return view("admin.employee.index",compact("employeeInfos","employeeInfo","employeeStatusInfo","departmentInfo","areaInfo","info"));
    }
    //添加管理员
    public function create(Department $department,EmployeeStatus $employeeStatus,Area $area,EmployeeType $employeeType)
    {
        //获取所有部门
        $departmentInfo=$department->get()->toArray();
        //获取所有状态
        $employeeStatusInfo=$employeeStatus->get()->toArray();
        //获取所有的地区
        $areaInfo=$area->get()->toArray();
        //获取所有员工类型
        $employeeTypeInfo=$employeeType->get()->toArray();
        return view("admin.employee.create",compact('departmentInfo','employeeStatusInfo','areaInfo',"employeeTypeInfo"));
    }
    //添加管理员post
    public function add(EmployeeRequest $request,Employee $employee)
    {
        $data=$request->all();
        $data['join_time']=time();
        $data['tel_no']=$data['signin_name'];
        $data["birthday_time"]=strtotime(getTimeStamp($data['birthday_time']));
        $data['pwd']=md5($data['pwd']);
        unset($data["_token"]);
        unset($data['pwd_confirmation']);
        $employee->create($data);
        return redirect("admin/employee/index");
    }
    //编辑管理员
    public function edit(Department $department,EmployeeStatus $employeeStatus,Area $area,EmployeeType $employeeType,Employee $employee,$id)
    {
        //获取所有部门
        $departmentInfo=$department->get()->toArray();
        //获取所有状态
        $employeeStatusInfo=$employeeStatus->get()->toArray();
        //获取所有的地区
        $areaInfo=$area->get()->toArray();
        //获取所有员工类型
        $employeeTypeInfo=$employeeType->get()->toArray();
        //获取员工的信息
        $employeeInfo=$employee::find($id)->toArray();
        return view("admin.employee.edit",compact('departmentInfo','employeeStatusInfo','areaInfo',"employeeTypeInfo","employeeInfo"));
    }
    //更新管理员
    public function update(EmployeeUpdate $request,Employee $employee,$id)
    {
        $employeeInfo=$employee::find($id);
        $data=$request->all();
        $data['tel_no']=$data['signin_name'];
        $data["birthday_time"]=strtotime(getTimeStamp($data['birthday_time']));
        unset($data["_token"]);
        unset($data['id']);
        $employeeInfo->update($data);
        return redirect("admin/employee/index");
    }
    //删除管理员
    public function delete(Employee $employee,$id)
    {
        $employee::find($id)->delete();
        return redirect("admin/employee/index")->with(["msg"=>"删除管理员成功"]);
    }
    //分配角色
    public function role(Role $role,EmployeeRole $employeeRole,$id)
    {
        $roleInfo=$role->get()->toArray();
        //获取员工的绑定角色
        $roleId=$employeeRole->where("employee_id",$id)->select(DB::raw("GROUP_CONCAT(role_id) as role_id"))->first()->toArray();
        $roleId=explode(',',$roleId['role_id']);
        return view("admin.employee.role",compact("roleInfo","id","roleId"));
    }
    //分配角色
    public function distributeRole(Role $role,EmployeeRole $employeeRole,Request $request,$id)
    {
       //删除所有角色
        $employeeRole->where("employee_id",$id)->delete();
        //分配角色
        if ($request->input("role_id"))
        {
            foreach ($request->input("role_id") as $k=>$v)
            {
                $data['employee_id']=$id;
                $data['role_id']=$v;
                $employeeRole->create($data);
            }
        }
        return redirect("admin/employee/index");
    }
}
