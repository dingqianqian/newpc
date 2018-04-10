<?php

namespace App\Http\Controllers\Admin;

use App\Model\IntegralExchangeOrder;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IntegralController extends Controller
{
    //积分兑换列表
    public function index(Request $request,IntegralExchangeOrder $integralExchangeOrder,User $user)
    {
        //搜索的值
        $Info['id'] = $request->input('id')?[$request->input('id')]:"";   //id
        $Info['f_user_signin_name'] = $request->input('f_user_signin_name')?$request->input('f_user_signin_name'):"";     //用户账号
        $Info['status'] = $request->input('status')?$request->input('status'):0;  //状态
        //测试人员的id
        $userInfo = $user::select('id')->whereIn('signin_name',employeePhone())->get()->toArray();
        $userIds = [];
        foreach($userInfo as $k=>$v){
            $userIds[] = $v['id'];
        }
        //判断为空 id
        if (!$Info['id'])
        {
            $ids = $integralExchangeOrder::select("id")->get()->toArray();
            foreach ($ids as $k=>$v){
                $Info[] = $v['id'];
            }
            $Info['id'] = $Info;
        }
        //获取数据
        if ($Info['status']==0)
        {
            $integralInfos = $integralExchangeOrder::select('id','f_user_signin_name','use_integral','commit','recharge_tel','no','fixed_time','f_integral_goods_id','expressage')->whereIn('id',$Info['id'])->where('f_user_signin_name','like',"%{$Info['f_user_signin_name']}%")->whereNotIn("f_user_id",$userIds)->paginate(15);
        }elseif ($Info['status']==1)
        {
            $integralInfos = $integralExchangeOrder::select('id','f_user_signin_name','use_integral','commit','recharge_tel','no','fixed_time','f_integral_goods_id','expressage')->whereIn('id',$Info['id'])->where([['f_user_signin_name','like',"%{$Info['f_user_signin_name']}%"],['fixed_time',"!=",0]])->whereNotIn("f_user_id",$userIds)->paginate(15);
        }else{
            $integralInfos = $integralExchangeOrder::select('id','f_user_signin_name','use_integral','commit','recharge_tel','no','fixed_time','f_integral_goods_id','expressage')->whereIn('id',$Info['id'])->where([['f_user_signin_name','like',"%{$Info['f_user_signin_name']}%"],['fixed_time',0]])->whereNotIn("f_user_id",$userIds)->paginate(15);
        }

        $integralInfo = $integralInfos->toArray();
        //判断个数 id
        if (count($Info['id'])==1)
        {
            $Info['id']=$Info['id'][0];
        }else
        {
            $Info['id']="";
        }
        return view('admin.integral.index',compact("integralInfos","integralInfo","Info"));
    }
    //查看积分兑换详情
    public function info(IntegralExchangeOrder $integralExchangeOrder,$id)
    {
        $integralExchangeOrderInfos = $integralExchangeOrder::find($id)->toArray();
        return view('admin.integral.info',compact("integralExchangeOrderInfos"));
    }
    //处理单号
    public function doinfo(IntegralExchangeOrder $integralExchangeOrder,Request $request,$id)
    {
        $data = $request->input('name');  //第三方快递单号
        $time = time();  //处理时间 时间戳
        $Info = $integralExchangeOrder::find($id);
        $Info->expressage=$data;
        $Info->fixed_time=$time;
        $Info->save();
        return json(200,"标记成功");
    }
}
