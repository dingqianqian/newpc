<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\ByIdRequest;
use App\Http\Requests\TakeOverAddrRequest;
use App\Model\Area;
use App\Model\TakeOver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TakeOverController extends Controller
{
    //ajax删除收货地址
    public function delTakeOver(Request $request,TakeOver $takeOver)
    {
        $id=$request->input("id");
        $info=$takeOver->where([["id",$id],["f_user_id",session("userInfo")["id"]]])->delete();
        if ($info)
        {
            return ["err"=>200,"msg"=>"删除成功"];
        }else
            {
                return ["err"=>500,"msg"=>"删除失败"];
            }
    }
    //ajax添加收货地址
    public function addTakeOver(TakeOverAddrRequest $request,TakeOver $takeOver,Area $area)
    {
        $data=$request->all();
        $data["f_user_id"]=session("userInfo")["id"];
        $data["is_default"]=0;
        $city=mb_substr($data["city"],0,2);
        $f_area_id=$area->where("name","like","$city%")->first();
        $data["f_area_id"]=$f_area_id->id;
        if ($data['town']=="涠洲岛")
        {
            $data["f_area_id"]=372;
        }
        if($takeOverInfo=$takeOver::create($data)){
            return json(200,$takeOverInfo->toArray(),"添加收货地址成功");
        }else
            {
                return json(500,"添加收货地址失败");
            }
    }
    //ajax修改收货地址
    public function updateTakeOver(TakeOverAddrRequest $request,TakeOver $takeOver,Area $area,$id)
    {
        $data=$request->all();
        $city=mb_substr($data["city"],0,2);
        $f_area_id=$area->where("name","like","$city%")->first();
        $data["f_area_id"]=$f_area_id->id;
        if ($data['town']=="涠洲岛")
        {
            $data["f_area_id"]=372;
        }
        $info=$takeOver::where([['id',$id],["f_user_id",session("userInfo")["id"]]])->update($data);
        if ($info)
        {
            $info=$takeOver::find($id);
            return ["err"=>200,"data"=>$info->toArray(),"msg"=>"更新成功"];
        }else
            {
                return ["err"=>500,"msg"=>"更新失败"];
            }
    }
    //展示收货地址页面
    public function index(TakeOver $takeOver)
    {
        $takeOverInfo=$takeOver->where("f_user_id",session("userInfo")["id"])->get()->toArray();
        $index="takeover";
        return view("home.takeover.index",compact("index","takeOverInfo"));
    }
    //设置收货地址
    public function defaultTakeOver(ByIdRequest $request,TakeOver $takeOver)
    {
        $takeOverInfo = $takeOver->where([["id", $request->input("id")], ["f_user_id", session("userInfo")["id"]]])->first();
        if (!$takeOverInfo) {
            return ["err"=>404,"msg"=>"修改错误2"];
        }
        $takeOver->where("f_user_id", session("userInfo")["id"])->update(["is_default"=>0]);
        $takeOverInfo->is_default = 1;
        if ($takeOverInfo->save()) {
                return ["err" => 200, "修改成功"];
        }
        return ["err"=>500,"msg"=>"修改错误1"];
    }
}
