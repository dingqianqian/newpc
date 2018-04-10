<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HotelRequest;
use App\Model\GoodsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    //酒店列表
    public function index(GoodsType $goodsType,Request $request)
    {
        $info['name']=$request->input("name")?$request->input("name"):"";
        //获取所有酒店列表
        $goodsTypeInfos=$goodsType::where("parent_id",56)->where("name","like","%{$info['name']}%")->paginate(15);
        $goodsTypeInfo=$goodsTypeInfos->toArray();
        return view("admin.hotel.index",compact("goodsTypeInfo","goodsTypeInfos","info"));
    }
    //添加酒店
    public function create()
    {
        return view("admin.hotel.create");
    }
    //添加酒店
    public function add(HotelRequest $request,GoodsType $goodsType)
    {
        $data=$request->except("_token","logo");
        $data['parent_id']=56;
        if ($request->file("logo"))
        {
            $data['image_url']=Storage::putFile("public/hotel",$request->file("logo"),"public");
            $data["image_url"]="storage".ltrim($data['image_url'],"public");
        }else
            {
                return back()->with(["msg"=>"请上传酒店图片"]);
            }
        if ($goodsType->create($data))
        {
            return redirect()->route("hotel.list")->with(["msg"=>"添加成功"]);
        }
    }
    //编辑酒店
    public function edit(GoodsType $goodsType,$id)
    {
        $goodsTypeInfo=$goodsType::find($id)->toArray();
        return view("admin.hotel.edit",compact("goodsTypeInfo"));
    }
    //编辑酒店
    public function update(GoodsType $goodsType,HotelRequest $request,$id)
    {
        $data=$request->except("_token","logo");
        $data['parent_id']=56;
        if ($request->file("logo"))
        {
            $data['image_url']=Storage::putFile("public/hotel",$request->file("logo"),"public");
            $data["image_url"]="storage".ltrim($data['image_url'],"public");
        }
        if ($goodsType::find($id)->update($data))
        {
            return redirect()->route("hotel.list")->with(["msg"=>"修改成功"]);
        }
    }
    //删除酒店
    public function delete(GoodsType $goodsType,$id)
    {
        if($goodsType::find($id)->delete())
        {
            return back()->with(["msg"=>"删除成功"]);
        }else
            {
                return back()->with(["msg"=>"删除失败"]);
            }
    }
}
