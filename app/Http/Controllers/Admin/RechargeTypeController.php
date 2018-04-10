<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RechargeTypeRequest;
use App\Model\RechargeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RechargeTypeController extends Controller
{
    //充值类型列表
    public function index(RechargeType $rechargeType)
    {
        $rechargeTypeInfo=$rechargeType::orderBy("sort")->get()->toArray();
        return view("admin.rechargeType.index",compact("rechargeTypeInfo"));
    }
    //创建充值类型
    public function create()
    {
        return view("admin.rechargeType.create");
    }
    //添加充值类型
    public function add(RechargeTypeRequest $request,RechargeType $rechargeType)
    {
        $data=$request->only(["money","give_back","sort"]);
        $data['description']="充值 {$data['money']} 元-赠送 {$data['give_back']} 元";
        $data['url']=asset($this->uploadImage("recharge",$request->file("image"),"png"));
        $data['create_time']=time();
        $rechargeType->create($data);
        return redirect()->route("rechargeType.list")->with(["msg"=>"添加成功"]);
    }
    //编辑界面
    public function edit(RechargeType $rechargeType,$id)
    {
        $rechargeTypeInfo=$rechargeType::find($id);
        return view("admin.rechargeType.edit",compact("rechargeTypeInfo"));
    }
    //执行编辑
    public function update(Request $request,RechargeType $rechargeType,$id)
    {
        $rechargeTypeInfo=$rechargeType::find($id);
        $data=$request->only(["money","give_back","sort"]);
        $data['description']="充值 {$data['money']} 元-赠送 {$data['give_back']} 元";
        if ($request->file("image"))
        {
            $data['url']=asset($this->uploadImage("recharge",$request->file("image"),"png"));
        }
        $data['update_time']=time();
        if ($rechargeTypeInfo->update($data))
        {
            return redirect()->route("rechargeType.list")->with(["msg"=>"编辑成功"]);
        }
    }
    //执行删除
    public function delete(RechargeType $rechargeType,$id)
    {
        $rechargeType::destroy($id);
        return json(200,"删除成功");
    }
    //编辑排序
    public function sort(RechargeType $rechargeType,Request $request,$id)
    {
       $rechargeTypeInfo=$rechargeType::find($id);
       $rechargeTypeInfo->sort=$request->input("val");
       $rechargeTypeInfo->save();
       return json(200,"编辑成功");
    }
    //是否显示
    public function show(RechargeType $rechargeType,Request $request,$id)
    {
        $rechargeTypeInfo=$rechargeType::find($id);
        $rechargeTypeInfo->is_show=$request->input("num");
        $rechargeTypeInfo->save();
        return json(200,"编辑成功");
    }
}
