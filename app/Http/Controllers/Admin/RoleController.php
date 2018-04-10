<?php

namespace App\Http\Controllers\Admin;

use App\Model\Access;
use App\Model\EmployeeRole;
use App\Model\Role;
use App\Model\RoleAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //角色列表
    public function index(Role $role)
    {
        $roleInfo=$role->get()->toArray();
        return view("admin.role.index",compact("roleInfo"));
    }
    //添加角色
    public function create(Access $access)
    {
        $accessInfo=$access->get()->toArray();
        $accessInfo=make_tree($accessInfo);
        return view("admin.role.create",compact("accessInfo"));
    }
    //添加角色
    public function add(Request $request,Role $role,RoleAccess $roleAccess)
    {
        //添加角色
        $data['name']=$request->input("name");
        $data['description']=$request->input("description");
        $roleInfo=$role->create($data);
        //添加角色对应的权限
        $role_id=$request->input("role_id");
        if ($role_id)
        {
            foreach ($role_id as $k=>$v)
            {
                $info['role_id']=$roleInfo->id;
                $info['access_id']=$v;
                $roleAccess->create($info);
            }
        }
        return redirect("admin/role/index");
    }
    //编辑角色
    public function edit(Access $access,Role $role,RoleAccess $roleAccess,$id)
    {
        $accessInfo=$access->get()->toArray();
        $accessInfo=make_tree($accessInfo);
        //角色信息
        $roleInfo=$role::find($id)->toArray();
        //获取角色权限信息
        $accessId=$roleAccess->where("role_id",$roleInfo['id'])->select(DB::raw("GROUP_CONCAT(access_id) as access_id"))->first()->toArray();
        $accessId=explode(',',$accessId['access_id']);
        return view("admin.role.edit",compact("accessInfo","roleInfo","accessId"));
    }
    //编辑角色
    public function update(Request $request,Role $role,RoleAccess $roleAccess,$id)
    {
        //更新角色基本信息
        $roleInfo=$role::find($id);
        $data['name']=$request->input("name");
        $data['description']=$request->input("description");
        $roleInfo->update($data);
        //更新角色设计的权限
        $roleAccess->where("role_id",$id)->delete();
        $role_id=$request->input("role_id");
        if ($role_id)
        {
            foreach ($role_id as $k=>$v)
            {
                $info['role_id']=$id;
                $info['access_id']=$v;
                $roleAccess->create($info);
            }
        }
        return redirect("admin/role/index");
    }
    //删除角色
    public function delete(Role $role,RoleAccess $roleAccess,EmployeeRole $employeeRole,$id)
    {
        //删除角色
        $role->where("id",$id)->delete();
        $roleAccess->where("role_id",$id)->delete();
        $employeeRole->where("role_id",$id)->delete();
        return redirect("admin/role/index")->with(["msg"=>"删除成功"]);
    }
}
