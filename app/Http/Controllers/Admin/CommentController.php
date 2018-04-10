<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsEvaluate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    //评论列表
    public function index(GoodsEvaluate $goodsEvaluate,Request $request)
    {
        $info['content']=$request->input("content")?$request->input("content"):"";
        $goodsEvaluateInfos=$goodsEvaluate::with("goods","user")->where("content","like","%{$info['content']}%")->paginate(15);
        $goodsEvaluateInfo=$goodsEvaluateInfos->toArray();
        return view("admin.comment.index",compact("goodsEvaluateInfo","goodsEvaluateInfos","info"));
    }
    //删除评论
    public function delete(GoodsEvaluate $goodsEvaluate,$id)
    {
        $goodsEvaluate::find($id)->delete();
        return back()->with(["msg"=>"删除成功"]);
    }
}
