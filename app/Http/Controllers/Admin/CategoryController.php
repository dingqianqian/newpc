<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Model\GoodsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //商品分类列表
    public function index(GoodsType $goodsType)
    {
        //获取所有商品分类
        $goodsTypeInfo=$goodsType->where("index","0")->get()->toArray();
        $goodsTypeInfo=make_tree($goodsTypeInfo);
        return view("admin.category.index",compact("goodsTypeInfo"));
    }
    //添加分类
    public function create(GoodsType $goodsType)
    {
        //获取所有的顶级分类
        $goodsTypeInfo=$goodsType->where("parent_id","0")->get()->toArray();
        return view("admin.category.create",compact("goodsTypeInfo"));
    }
    //添加分类
    public function add(CategoryRequest $request,GoodsType $goodsType)
    {
        $data=$request->all();
        unset($data["_token"]);
        $goodsType->create($data);
        return redirect("admin/category/index");
    }
    //删除分类
    public function delete(GoodsType $goodsType,$id)
    {
        $goodsTypeInfo=$goodsType::find($id);
        if ($goodsTypeInfo->parent_id==0)
        {
            return back()->with(["msg"=>"顶级分类不可以删除"]);
        }
        $goodsTypeInfo->delete();
        return back()->with(["msg"=>"删除成功"]);
    }
    //编辑分类
    public function edit(GoodsType $goodsType,$id)
    {
        $goodsTypeInfoOne=$goodsType::find($id)->toArray();
        $goodsTypeInfo=$goodsType->where("parent_id","0")->get()->toArray();
        return view("admin.category.edit",compact("goodsTypeInfo","goodsTypeInfoOne"));
    }
    //编辑分类
    public function update(Request $request,GoodsType $goodsType,$id)
    {
        $data=$request->all();
        unset($data["_token"]);
        $goodsType::find($id)->update($data);
        return redirect("admin/category/index")->with(["msg"=>"更新成功"]);
    }
    //ajax更新权限排序
    public function sortAjax(Request $request,GoodsType $goodsType)
    {
        $id=$request->input("id");
        $num=$request->input("num");
        $goodsTypeInfo=$goodsType::find($id);
        $goodsTypeInfo->sort=$num;
        $goodsTypeInfo->save();
        return json(200,"成功");
    }
    //ajax更新是否显示
    public function showAjax(Request $request,GoodsType $goodsType)
    {
        $id=$request->input("id");
        $num=$request->input("num");
        $goodsTypeInfo=$goodsType::find($id);
        $goodsTypeInfo->is_show=$num;
        $goodsTypeInfo->save();
        return json(200,"成功");
    }
}
