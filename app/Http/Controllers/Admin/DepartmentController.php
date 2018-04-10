<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DepartmentRequest;
use App\Model\Area;
use App\Model\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    //部门列表
    public function index(Department $department, Area $area)
    {
        //获取所有部门 地区
        $departmentInfos = $department::select('id', 'name', 'f_area_id')->where('is_delete', '0')->paginate(15); //所有的分页
        $departmentInfo = $departmentInfos->toArray();   //转换为数组
        $areaInfo = $area::select('id', 'name')->get()->toArray();   //地区
        return view('admin.department.index', compact("departmentInfo", "departmentInfos", "areaInfo"));
    }

    //添加部门
    public function create(Area $area)
    {
        $areaInfo = $area::select('id', 'name')->get()->toArray();
        return view("admin.department.create", compact("areaInfo"));
    }

    //处理添加
    public function add(DepartmentRequest $request, Department $department)
    {
        $data = $request->except("_token");
        if ($department->create($data)) {
            return redirect()->route("department.list")->with(["msg" => "添加成功"]);
        } else {
            return back()->with(["msg" => "添加失败"]);
        }
    }

    //编辑部门
    public function edit(Department $department, Area $area, $id)
    {
        $departmentInfo = $department::find($id)->toArray();   //部门
        $areaInfo = $area::select('id', 'name')->get()->toArray();  //地区
        return view("admin.department.edit", compact("areaInfo", "departmentInfo"));
    }

    //处理编辑
    public function update(Department $department, Request $request, $id)
    {
        $data = $request->except('_token');
        if ($department::find($id)->update($data)) {
            return redirect()->route('department.list')->with(['msg' => '修改成功']);
        } else {
            return back()->with(['msg' => '修改失败']);
        }
    }

    //删除部门
    public function delete(Department $department, $id)
    {
        $departmentInfo = $department::find($id);
        $departmentInfo->is_delete = 1;
        $departmentInfo->save();
        return json(200, "删除成功");
    }
}
