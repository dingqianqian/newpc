<?php

namespace App\Http\Controllers\Home;

use App\Model\Order;
use App\Model\Resarch;
use App\Model\User;
use App\Model\UserResarch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonController extends Controller
{
    //首页
    public function index(Order $order,User $user)
    {
        $data[3]=$order->where([["f_user_id",session("userInfo")['id']],["f_order_form_status_id",3]])->count();
        $data[2]=$order->where([["f_user_id",session("userInfo")['id']],["f_order_form_status_id",2]])->count();
        $data[4]=$order->where([["f_user_id",session("userInfo")['id']]])->whereIn("f_order_form_status_id",[4,5])->count();
        $data[14]=$order->where([["f_user_id",session("userInfo")['id']]])->whereIn("f_order_form_status_id",[14,15])->count();
        $userInfo=$user::find(session("userInfo")["id"])->toArray();
        $index="person";
        return view("home.person.index",compact("index","data","userInfo"));
    }
    //修改信息
    public function update(Request $request,User $user,Resarch $resarch,UserResarch $userResarch)
    {

        if ($request->isMethod("post")){
             $userInfo=$user::find(session("userInfo")["id"]);
             $userInfo->username=$request->input("username");
             $userInfo->sex=$request->input("sex");
             $year=$request->input("year");
             $month=$request->input("month");
             $day=$request->input("day");
             $time=strtotime("$year-$month-$day");
             if ($time<0){
                 $time=0;
             }
             $userInfo->birthday=$time;
             $userInfo->save();
             session(["userInfo"=>$userInfo->toArray()]);
             if ($request->input("likes")){
                 $userResarch->where("f_user_id",session("userInfo")['id'])->delete();
                 foreach ($request->input("likes") as $k=>$v){
                     $data["f_user_id"]=session("userInfo")['id'];
                     $data['resarch_id']=$v;
                     $userResarch->create($data);
                 }
             }
                return redirect("person/index");
            }
        $userInfo=$user::find(session("userInfo")["id"])->toArray();
        $resarchInfo=$resarch->get()->toArray();
        $index="person";
        return view("home.person.update",compact("index","userInfo","resarchInfo"));
    }
}
