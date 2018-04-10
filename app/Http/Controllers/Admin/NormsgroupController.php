<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NormsgroupRequest;
use App\Model\NormsGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NormsgroupController extends Controller
{
    //分组列表
    public function index(NormsGroup $normsGroup){
        $normsGroupInfos = $normsGroup::select('id','name')->paginate(15);
        $normsGroupInfo = $normsGroupInfos->toArray();
        return view('admin.normsgroup.index',compact('normsGroupInfo','normsGroupInfos'));
    }
    //添加分组
    public function create(){
        return view('admin.normsgroup.create');
    }
    //处理添加
    public function add(NormsgroupRequest $request,NormsGroup $normsGroup){
       $data = $request->except('_token');
       if($normsGroup->create($data)){
           return redirect()->route('normsgroup.list')->with(['msg'=>'添加成功']);
       }else{
           return back()->with(['msg'=>'添加失败']);
       }
    }
    //修改分组
    public function edit(NormsGroup $normsGroup,$id){
        $normsGroupInfo = $normsGroup::find($id)->toArray();   //修改者的信息
        return view('admin.normsgroup.edit',compact('normsGroupInfo'));
    }
    //处理修改
    public function update(NormsGroup $normsGroup,Request $request,$id){
        $data = $request->except('_token');
        if($normsGroup::find($id)->update($data)){
            return redirect()->route('normsgroup.list')->with(['msg'=>'编辑成功']);
        }else{
            return back()->with(['msg'=>'编辑失败']);
        }

    }
    //删除分组
    public function delete(NormsGroup $normsGroup,$id){
        if($normsGroup::find($id)->delete()){
            return json('200','删除成功');
        }else{
            return back()->with(['msg'=>'删除失败']);
        }
    }
}
