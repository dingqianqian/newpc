<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AccessRequest;
use App\Model\Access;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessController extends Controller
{
    //权限列表
    public function index(Access $access)
    {
        //获取所有的权限
        $accessInfo=$access->orderBy("sort")->get()->toArray();
        //数据整理
        $accessInfo=make_tree($accessInfo);
//        dd($accessInfo);
        return view("admin.access.index",compact("accessInfo"));
    }
    //添加权限
    public function create(Access $access)
    {
        //获取顶级权限
        $accessInfo=$access->where("parent_id","0")->get()->toArray();
        return view("admin.access.create",compact("accessInfo"));
    }
    //添加权限
    public function add(AccessRequest $request,Access $access)
    {
        $data['name']=$request->input("name");
        $data['route_name']=$request->input("route_name");
        $data['description']=$request->input("description");
        $data['sort']=$request->input("sort");
        $data['is_show']=$request->input("is_show");
        $data['parent_id']=$request->input("parent_id");
        $access->create($data);
        return redirect("admin/access/index");
    }
    //编辑权限
    public function edit(Request $request,Access $access,$id)
    {
        $accessInfos=$access->where("id",$id)->first()->toArray();
        $accessInfo=$access->where("parent_id","0")->get()->toArray();
        return view("admin.access.edit",compact("accessInfo","accessInfos"));
    }
    //编辑权限
    public function update(AccessRequest $request,Access $access,$id)
    {
        $accessInfo=$access::find($id);
        $data['name']=$request->input("name");
        $data['route_name']=$request->input("route_name");
        $data['description']=$request->input("description");
        $data['sort']=$request->input("sort");
        $data['is_show']=$request->input("is_show");
        $data['parent_id']=$request->input("parent_id");
        $accessInfo->update($data);
        return redirect("admin/access/index");
    }
    //删除权限
    public function delete(Access $access,$id)
    {
        $accessInfo=$access::find($id);
        if ($accessInfo->parent_id==0)
        {
            return redirect("admin/access/index")->with(["msg"=>"顶级权限不可以删除"]);
        }
        $accessInfo->delete();
        return redirect("admin/access/index")->with(["msg"=>"删除成功"]);
    }
    //ajax更新权限排序
    public function sortAjax(Request $request,Access $access)
    {
        $id=$request->input("id");
        $num=$request->input("num");
        $accessInfo=$access::find($id);
        $accessInfo->sort=$num;
        $accessInfo->save();
        return json(200,"成功");
    }
    //ajax更新是否显示
    public function showAjax(Request $request,Access $access)
    {
        $id=$request->input("id");
        $num=$request->input("num");
        $accessInfo=$access::find($id);
        $accessInfo->is_show=$num;
        $accessInfo->save();
        return json(200,"成功");
    }
    //意识无权限
    public function forbidden()
    {
        return view("admin.layout.403");
    }
}
