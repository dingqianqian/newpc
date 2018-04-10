<?php

namespace App\Http\Controllers\Admin;

use App\Model\Area;
use App\Model\PayType;
use App\Model\Recharge;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RechargeController extends Controller
{
    //充值列表
    public function index(Recharge $recharge,Request $request,User $user,PayType $payType,Area $area)
    {
        //查询条件
        $info['phone']=$request->input("phone")?$request->input("phone"):"";
        //查询用户的ID
        if (session("employeeInfo")['f_area_id']!=1)
        {
            $areaIds=[];
            $areaInfo=$area->where("id",session("employeeInfo")['f_area_id'])->orWhere("parent_id",session("employeeInfo")['f_area_id'])->select('id')->get()->toArray();
            foreach ($areaInfo as $k=>$v)
            {
                $areaIds[]=$v['id'];
            }
            $userIds=$user->where("signin_name","like","%{$info['phone']}%")->whereNotIn("signin_name",employeePhone())->whereIn("f_area_id",$areaIds)->get()->toArray();
        }else
        {
            $userIds=$user->where("signin_name","like","%{$info['phone']}%")->whereNotIn("signin_name",employeePhone())->get()->toArray();
        }
        //dd($ids);
        $id=[];
        foreach ($userIds as $k=>$v)
        {
            $id[]=$v['id'];
        }
        $info['no']=$request->input("no")?$request->input("no"):"";
        $info['min_time']=$request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info['max_time']=$request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info['pay_type']=$request->input("pay_type")?[$request->input("pay_type")]:[1,2,3,4,5,6,7,8,9,10,11];
        //获取充值信息
        $rechargeInfos=$recharge::with("payType","user")->where([["f_order_form_status_id",2],['no',"like","%{$info['no']}%"],['create_time','>',"{$info['min_time']}"],['create_time','<',"{$info['max_time']}"]])->whereIn('f_pay_type_id',$info['pay_type'])->whereIn('f_user_id',$id)->orderBy('id',"desc")->paginate(15);
        $rechargeInfo=$rechargeInfos->toArray();
        //获取支付类型
        $payTypeInfo=$payType->get()->toArray();
        //统计信息
        //充值订单量
        $count['order']=$recharge::where([["f_order_form_status_id",2],['no',"like","%{$info['no']}%"],['create_time','>',"{$info['min_time']}"],['create_time','<',"{$info['max_time']}"]])->whereIn('f_pay_type_id',$info['pay_type'])->whereIn('f_user_id',$id)->count();
        //充值金额
        $count['price']=$recharge::where([["f_order_form_status_id",2],['no',"like","%{$info['no']}%"],['create_time','>',"{$info['min_time']}"],['create_time','<',"{$info['max_time']}"]])->whereIn('f_pay_type_id',$info['pay_type'])->whereIn('f_user_id',$id)->sum("price");
        //返现金额
        $count['give']=$recharge::where([["f_order_form_status_id",2],['no',"like","%{$info['no']}%"],['create_time','>',"{$info['min_time']}"],['create_time','<',"{$info['max_time']}"]])->whereIn('f_pay_type_id',$info['pay_type'])->whereIn('f_user_id',$id)->sum("give_back");
        if (count($info['pay_type'])==1){
            $info['pay_type']=$info['pay_type'][0];
        }else{
            $info['pay_type']=0;
        }
        $info['min_time']=date("Y年m月d日",$info['min_time']);
        $info['max_time']=date("Y年m月d日",$info['max_time']);
        return view("admin.recharge.index",compact("rechargeInfo","rechargeInfos","count","payTypeInfo","info"));
    }
    //充值详细信息
    public function info(Recharge $recharge,$id)
    {
        $rechargeInfo=$recharge::with("payType","user")->find($id)->toArray();
        return view("admin.recharge.info",compact("rechargeInfo"));
    }
    //充值列表导出
    public function export(Recharge $recharge,Request $request,User $user,PayType $payType)
    {
        //查询条件
        $info['phone']=$request->input("phone")?$request->input("phone"):"";
        //查询用户的ID
        $ids=$user::where("signin_name","like","%{$info['phone']}%")->whereNotIn("signin_name",employeePhone())->get()->toArray();
        //dd($ids);
        $id=[];
        foreach ($ids as $k=>$v)
        {
            $id[]=$v['id'];
        }
        $info['no']=$request->input("no")?$request->input("no"):"";
        $info['min_time']=$request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info['max_time']=$request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info['pay_type']=$request->input("pay_type")?[$request->input("pay_type")]:[1,2,3,4,5,6,7,8,9,10,11];
        //获取充值信息
        $rechargeInfo=$recharge::with("payType","user")->where([["f_order_form_status_id",2],['no',"like","%{$info['no']}%"],['create_time','>',"{$info['min_time']}"],['create_time','<',"{$info['max_time']}"]])->whereIn('f_pay_type_id',$info['pay_type'])->whereIn('f_user_id',$id)->orderBy('id',"desc")->get()->toArray();
        $data[]=[
            '用户名',
            '订单号',
            '充值金额',
            '返现金额',
            '支付方式',
            '创建时间',
            '支付时间',
            '酒店名称',
        ];
//        dd($rechargeInfo);
        foreach ($rechargeInfo as $k=>$v)
        {
            $temp['signin_name']=$v['user']['signin_name'];
            $temp['no']=$v['no']."|";
            $temp['price']=number_format($v['price'],2,".","");
            $temp['give_back']=number_format($v['give_back'],2,".","");
            $temp['pay_type']=$v['pay_type']['name'];
            $temp['create_time']=date("Y-m-d H:i:s",$v['create_time']);
            $temp['pay_time']=date("Y-m-d H:i:s",$v['pay_time']);
            $temp['hotel_name']=$v['user']['hotel_name'];
            $data[]=$temp;
        }
        Excel::create('recharge',function($excel) use ($data){
            $excel->sheet('recharge', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
    }
}
