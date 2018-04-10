<?php

namespace App\Http\Controllers\Home;

use App\Model\Optinion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdviseController extends Controller
{
    //意见首页
    public function index()
    {
        $index="advise";
        return view("home.advise.index",compact("index"));
    }
    //添加意见反馈
    public function add(Optinion $optinion,Request $request)
    {
        if (!$request->input("commit"))
        {
            return back()->with(["msg"=>"请输入意见"]);
        }
        $data["create_time"]=time();
        $data["commit"]=$request->input("commit");
        $data["f_user_username"]=session("userInfo")["username"];
        $data["f_user_id"]=session("userInfo")["id"];
        $data["f_user_signin_name"]=session("userInfo")["signin_name"];
        if ($optinion->create($data))
        {
            return back()->with(["msg"=>"宜优速已经收到您的建议,谢谢您的反馈!"]);
        }
        return back()->with(["msg"=>"反馈失败,稍后重试"]);
    }
}
