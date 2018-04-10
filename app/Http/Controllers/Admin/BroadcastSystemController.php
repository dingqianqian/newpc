<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BroadcastSystemRequest;
use App\Model\BroadcastSystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BroadcastSystemController extends Controller
{
    //广播列表
    public function index(BroadcastSystem $broadcastSystem,Request $request)
    {
        //接收 搜索的数据  分页
        $info['title'] = $request->input("title")?$request->input("title"):""; //标题
        $info['begin_time']=$request->input("begin_time")?strtotime(getTimeStamp($request->input("begin_time"))):1420041600;  //开始时间
        $info['end_time']=$request->input("end_time")?strtotime(getTimeStamp($request->input("end_time")))+3600*24-1:time();  //结束时间
        //从数据库获取数据
        $broadcastSystemInfos=$broadcastSystem::select("id","title","commit","img","create_time")->where("title","like","%{$info["title"]}%")->whereBetween("create_time",[$info['begin_time'],$info['end_time']])->paginate(15);
        $broadcastSystemInfo=$broadcastSystemInfos->toArray();
        $info['begin_time'] = date("Y年m月d日",$info['begin_time']);
        $info['end_time'] = date("Y年m月d日",$info['end_time']);
        return view("admin.broadcastSystem.index",compact("broadcastSystemInfo","broadcastSystemInfos","info"));
    }
    //添加广播
    public function create()
    {
        return view("admin.broadcastSystem.create");
    }
    //处理添加
    public function add(BroadcastSystemRequest $request,BroadcastSystem $broadcastSystem)
    {
        //接收数据
        $data = $request->only("title","commit","img");
        $data['create_time'] = time();  //当前时间戳
        $data["url"] = $request->input("url")?$request->input("url"):"";
        $data["android_url"] = $request->input("android_url")?$request->input("android_url"):"";
        $data["android_param"] = $request->input("android_param")?$request->input("android_param"):"";
        $data["ios_url"] = $request->input("ios_url")?$request->input("ios_url"):"web";
        $data["ios_vc_name"] = $request->input("ios_vc_name")?$request->input("ios_vc_name"):"";
        $data["ios_vc_property"] = $request->input("ios_vc_property")?$request->input("ios_vc_property"):"";
        //判断添加结果
        if ($broadcastSystem::create($data)){
            return redirect()->route("broadcastSystem.list")->with(["msg"=>"添加成功"]);
        }else{
            return back()->with(["msg"=>"添加失败"]);
        }
    }
    //修改广播
    public function edit(BroadcastSystem $broadcastSystem,$id)
    {
        $broadcastSystemInfo = $broadcastSystem::find($id)->toArray();
        return view("admin.broadcastSystem.edit",compact("broadcastSystemInfo"));
    }
    //处理修改
    public function update(BroadcastSystem $broadcastSystem,Request $request,$id)
    {
        $data = $request->only("title","commit","img");
        $data["url"] = $request->input("url")?$request->input("url"):"";
        $data["android_url"] = $request->input("android_url")?$request->input("android_url"):"";
        $data["android_param"] = $request->input("android_param")?$request->input("android_param"):"";
        $data["ios_url"] = $request->input("ios_url")?$request->input("ios_url"):"web";
        $data["ios_vc_name"] = $request->input("ios_vc_name")?$request->input("ios_vc_name"):"";
        $data["ios_vc_property"] = $request->input("ios_vc_property")?$request->input("ios_vc_property"):"";
        if ($broadcastSystem::find($id)->update($data)){
            return redirect()->route("broadcastSystem.list")->with(["msg"=>"修改成功"]);
        }else{
            return back()->with(["msg"=>"修改失败"]);
        }
    }
    //删除广播
    public function delete(BroadcastSystem $broadcastSystem,$id)
    {
        if($broadcastSystem::find($id)->delete()){
           return json(200,"删除成功");
        }else{
            return back()->with(["msg"=>"删除失败"]);
        }
    }
}
