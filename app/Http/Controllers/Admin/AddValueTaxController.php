<?php

namespace App\Http\Controllers\Admin;

use App\Model\AddValueTax;
use App\Model\Area;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AddValueTaxController extends Controller
{
    //审核列表
    public function index(AddValueTax $addValueTax,User $user,Request $request,Area $area)
    {
        $info['phone']=$request->input("phone")?$request->input("phone"):"";
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
        $userId=[];
        foreach ($userIds as $k=>$v)
        {
            $userId[]=$v['id'];
        }
        $info["min_time"]=$request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info["max_time"]=$request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info['status']=$request->input("status")?[$request->input("status")]:[1,2,3];
        $addValueTaxInfos=$addValueTax::with("user")->where([["create_time",">=",$info['min_time']],["create_time","<=",$info['max_time']]])->whereIn("f_user_id",$userId)->whereIn("status",$info['status'])->paginate(15);
        $addValueTaxInfo=$addValueTaxInfos->toArray();
        $info['min_time']=date("Y年m月d日",$info['min_time']);
        $info['max_time']=date("Y年m月d日",$info['max_time']);
        if (count($info['status'])!=1)
        {
            $info['status']=0;
        }else{
            $info['status']=$info['status'][0];
        }
        //dd($info);
        return view("admin.tax.index",compact("addValueTaxInfos","addValueTaxInfo","info"));
    }
    //详情页
    public function info(AddValueTax $addValueTax,$id)
    {
        $addValueTaxInfo=$addValueTax::find($id)->toArray();
        return view("admin.tax.info",compact("addValueTaxInfo"));
    }
    //修改审核状态
    public function status(AddValueTax $addValueTax,$id,$type)
    {
        $addValueTaxInfo=$addValueTax::find($id);
        if ($type==1)
        {
            $addValueTaxInfo->status=2;
            $msg="审核成功";
        }else
            {
                $addValueTaxInfo->status=3;
                $msg="驳回成功";
            }
            $addValueTaxInfo->save();
            return json(200,$msg);
    }

    //审核列表导出
    public function export(Request $request,User $user,AddValueTax $addValueTax)
    {
        $info["phone"] = $request->input("phone")?$request->input("phone"):"";
        $userIds = $user->where("signin_name","like","%{$info["phone"]}%")->whereNotIn("signin_name",employeePhone())->get()->toArray();
        $userId = [];
        foreach ($userIds as $k=>$v){
            $userId[] = $v["id"];
        }
        $info["min_time"] = $request->input("min_time")?strtotime(getTimeStamp($request->input("min_time"))):1420041600;
        $info["max_time"] = $request->input("max_time")?strtotime(getTimeStamp($request->input("max_time")))+3600*24-1:time();
        $info["status"] = $request->input("status")?[$request->input("status")]:[1,2,3];
        $addValueTaxInfo = $addValueTax::with("user")->where([["create_time",">=",$info["min_time"]],["create_time","<=",$info["max_time"]]])->whereIn("f_user_id",$userId)->whereIn("status",$info["status"])->get()->toArray();
        //整成一维数组
        $data[] = [
            '用户ID',
            '联系电话',
            '提交申请时间',
            '审核状态',
            '公司名称',
        ];
        foreach ($addValueTaxInfo as $k=>$v){
            $temp["id"] = $v["user"]["id"];
            $temp["signin_name"] = $v["user"]["signin_name"];
            $temp["create_time"] = date("Y-m-d H:i:s",$v["create_time"]);
            if ($v["status"] == 1){
                $temp["status"] = "待审核";
            }elseif($v["status"] == 2){
                $temp["status"] = "已通过";
            }else{
                $temp["status"] = "已驳回";
            }
            $temp["company_name"] = $v["company_name"];
            $data[] = $temp;
        }
        Excel::create("tax",function($excel) use($data){
            $excel->sheet("tax",function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export("xls");
    }
}
