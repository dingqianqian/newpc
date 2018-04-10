<?php

namespace App\Http\Controllers\Home;

use App\Model\AddValueTax;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddValueTaxController extends Controller
{
    //创建认证信息
    public function create(Request $request,AddValueTax $addValueTax)
    {
        $data=$request->all();
        //dd($data);
        if ($addValueTax->where("f_user_id",session("userInfo")["id"])->first())
        {
            return redirect("invoice/index#/start");
        }
        $data["f_user_id"]=session("userInfo")['id'];
        $data['create_time']=time();
        if ($addValueTax->create($data))
        {
            return redirect("invoice/index#/start");
        }else
            {
                return false;
            }
    }
    //修改认证信息
    public function update(AddValueTax $addValueTax,Request $request)
    {
        if ($request->isMethod("post"))
        {
            //更新信息
            $data=$request->all();
            $data['status']=1;
            $data["f_user_id"]=session("userInfo")['id'];
            $data['create_time']=time();
            unset($data['_token']);
            $addValueTax->where('f_user_id',session("userInfo")['id'])->update($data);
            return redirect("invoice/index#/detailMessage");
        }
        //获取认证信息
        return view("home.invoice.update");
    }
    //ajax获取发票信息
    public function ajaxInfo(AddValueTax $addValueTax)
    {
        $addValueTaxInfo=$addValueTax->where("f_user_id",session("userInfo")['id'])->first();
        if ($addValueTaxInfo){
            $addValueTaxInfo=$addValueTaxInfo->toArray();
        }else{
            $addValueTaxInfo=null;
        }
        return json(200,$addValueTaxInfo);
    }
    //删除认证信息
    public function ajaxdel(AddValueTax $addValueTax,$id)
    {
        if($addValueTax->where("id",$id)->delete())
        {
            return json(200,"删除成功");
        }else
            {
                return json(404,"删除失败","fail");
            }
    }
}
